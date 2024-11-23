<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class ZoomController extends Controller
{
    /**
     * Redirect to Zoom OAuth provider.
     */
    public function redirectToProvider(Request $request)
    {
        $token = $request->query('token'); // Get the token from query string

        if (!$token) {
            return response()->json(['error' => 'Token is missing'], 401);
        }

        // Validate token
        $user = User::where('id', $token)->first();

        if (!$user) {
            return response()->json(['error' => 'Invalid token'], 401);
        }

        Auth::login($user); // Log in the user to the Laravel session

        $url = 'https://marketplace.zoom.us/authorize?' . http_build_query([
            'response_type' => 'code',
            'client_id' => 'TmuEla_jRR2Hbq6fz4jA',
            'redirect_uri' =>'http://localhost:8004/api/v1/zoom/callback',
            'state' => $token,
        ]);

        return redirect($url); // Redirect to Zoom OAuth
    }

    /**
     * Handle Zoom OAuth callback.
     */
    public function handleProviderCallback(Request $request)
    {
        // Get the token from query string
        $frontendToken = $request->query('state');

        if (!$frontendToken) {
            return redirect()->route('zoom.redirect')->with('error', 'User token is missing.');
        }

        // Validate token
        $user = User::where('id', $frontendToken)->first();

        if (!$user) {
            return redirect()->route('zoom.redirect')->with('error', 'Invalid or expired token.');
        }

        Auth::login($user); // Log in the user to the Laravel session

        // Check if authorization code exists
        if (!$request->has('code')) {
            return redirect()->route('zoom.redirect')->with('error', 'Authorization code not found.');
        }

        // Exchange authorization code for access token
        $response = Http::asForm()->post('https://zoom.us/oauth/token', [
            'grant_type' => 'authorization_code',
            'code' => $request->code,
            'redirect_uri' =>'http://localhost:8004/api/v1/zoom/callback',
            'client_id' => 'TmuEla_jRR2Hbq6fz4jA',
            'client_secret' => 'cOkzrVhdBWzWO3tgsXNUDOnZRZHaXpSh',
        ]);

        if ($response->successful()) {
            $data = $response->json();
            $accessToken = $data['access_token'];
            $refreshToken = $data['refresh_token'];
            Log::info($data);

            // Fetch the user's Zoom User ID
            $userResponse = Http::withToken($accessToken)->get('https://api.zoom.us/v2/users/me');
            if ($userResponse->successful()) {
                $userData = $userResponse->json();
                $zoomUserId = $userData['id'];
                $user->update([
                    'zoom_user_id' => $zoomUserId,
                    'zoom_access_token' => $accessToken,
                    'zoom_refresh_token' => $refreshToken,
                    'zoom_token_expires_at' => now()->addSeconds($data['expires_in']),
                ]);
            }

            return redirect('http://127.0.0.1:8000/meeting/create');
        } else {
            Log::error('Failed to obtain access token: ' . $response->body());
            return redirect()->route('zoom.redirect')->with('error', 'Failed to authorize Zoom account.');
        }
    }

    /**
     * Refresh Zoom token if expired.
     */
    public function refreshToken()
    {
        $user = Auth::user();
    
        if (!$user) {
            Log::error('User not authenticated during token refresh.');
            return null;
        }
    
        if ($user->zoom_token_expires_at && now()->greaterThanOrEqualTo($user->zoom_token_expires_at)) {
            // Token has expired, request a new one
            $response = Http::asForm()->post('https://zoom.us/oauth/token', [
                'grant_type' => 'refresh_token',
                'refresh_token' => $user->zoom_refresh_token,
                'client_id' => 'TmuEla_jRR2Hbq6fz4jA',
                'client_secret' => 'cOkzrVhdBWzWO3tgsXNUDOnZRZHaXpSh',
            ]);
    
            if ($response->successful()) {
                $data = $response->json();
    
                try {
                    if (method_exists($user, 'update')) {
                        $user->update([
                            'zoom_access_token' => $data['access_token'],
                            'zoom_refresh_token' => $data['refresh_token'],
                            'zoom_token_expires_at' => now()->addSeconds($data['expires_in']),
                        ]);
                    } else {
                        DB::table('users')->where('id', $user->id)->update([
                            'zoom_access_token' => $data['access_token'],
                            'zoom_refresh_token' => $data['refresh_token'],
                            'zoom_token_expires_at' => now()->addSeconds($data['expires_in']),
                        ]);
                    }
    
                    return $data['access_token'];
                } catch (\Exception $e) {
                    Log::error('Error updating user tokens: ' . $e->getMessage());
                    return null;
                }
            } else {
                Log::error('Failed to refresh Zoom access token: ' . $response->body());
                return null;
            }
        }
    
        return $user->zoom_access_token; // Return current token if still valid
    }
    

    /**
     * Make an authenticated request to Zoom API.
     */
    public function makeZoomRequest()
    {
        $accessToken = $this->refreshToken();

        if ($accessToken) {
            $response = Http::withToken($accessToken)->get('https://api.zoom.us/v2/users/me');

            if ($response->successful()) {
                return $response->json();
            } else {
                Log::error('Failed to make Zoom API request: ' . $response->body());
                return response()->json(['error' => 'Failed to fetch Zoom user details'], 500);
            }
        }

        return redirect()->route('zoom.redirect')->with('error', 'Please authorize Zoom again.');
    }

    /**
     * Check if a token is expired.
     */
    public function isTokenExpired($expiresAt)
    {
        return now()->greaterThanOrEqualTo($expiresAt);
    }
}
