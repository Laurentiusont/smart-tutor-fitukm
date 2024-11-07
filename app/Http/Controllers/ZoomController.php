<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Models\User; // Import the User model

class ZoomController extends Controller
{
    public function redirectToProvider()
    {
        


        $url = 'https://marketplace.zoom.us/authorize?' . http_build_query([
            'response_type' => 'code',
            'client_id' =>'TmuEla_jRR2Hbq6fz4jA',
            'redirect_uri' => 'http://localhost:8000/callback',
        ]);

        return redirect($url); // Redirect to Zoom's OAuth authorization page
    }

    public function handleProviderCallback(Request $request)
    {
        // Exchange the authorization code for an access token
        $response = Http::asForm()->post('https://zoom.us/oauth/token', [
            'grant_type' => 'authorization_code',
            'code' => $request->code,
            'redirect_uri' => 'http://localhost:8000/callback',
            'client_id' =>'TmuEla_jRR2Hbq6fz4jA',
            'client_secret' => 'cOkzrVhdBWzWO3tgsXNUDOnZRZHaXpSh',
        ]);
    
        if ($response->successful()) {
            $data = $response->json();
            $accessToken = $data['access_token'];
            $refreshToken = $data['refresh_token'];
            $expiresIn = $data['expires_in']; // Expiry time in seconds
        
            // Calculate expiration timestamp
            $expiresAt = now()->addSeconds($expiresIn);
        
            // Fetch the user's Zoom User ID
            $userResponse = Http::withToken($accessToken)->get('https://api.zoom.us/v2/users/me');
        
            if ($userResponse->successful()) {
                $userData = $userResponse->json();
                $zoomUserId = $userData['id'];
        
                $user = Auth::user();
        
                if ($user) {
                    User::where('id', $user->id)->update([
                        'zoom_user_id' => $zoomUserId,
                        'zoom_access_token' => $accessToken,
                        'zoom_refresh_token' => $refreshToken,
                        'zoom_token_expires_at' => $expiresAt,
                    ]);
        
                    return redirect()->route('meetings.create')->with('message', 'Successfully authorized Zoom account.');
                } else {
                    return redirect()->back()->with('error', 'User is not authenticated.');
                }
            } else {
                Log::error('Failed to fetch Zoom user details: ' . $userResponse->body());
                return redirect()->back()->with('error', 'Failed to fetch Zoom user details.');
            }
        } else {
            Log::error('Failed to obtain access token: ' . $response->body());
            return redirect()->back()->with('error', 'Failed to authorize Zoom account.');
        }
    }

    public function refreshToken()
    {
        $user = Auth::user();
    
        if ($user && $user->zoom_token_expires_at && now()->greaterThanOrEqualTo($user->zoom_token_expires_at)) {
            // Token has expired or is about to expire, request a new one
            $response = Http::asForm()->post('https://zoom.us/oauth/token', [
                'grant_type' => 'refresh_token',
                'refresh_token' => $user->zoom_refresh_token,
                'client_id' => 'TmuEla_jRR2Hbq6fz4jA',
                'client_secret' => 'cOkzrVhdBWzWO3tgsXNUDOnZRZHaXpSh',
            ]);
    
            if ($response->successful()) {
                $data = $response->json();
                $accessToken = $data['access_token'];
                $refreshToken = $data['refresh_token'];
                $expiresAt = now()->addSeconds($data['expires_in']);
    
                // Update user's tokens and expiry time using the User model
                User::where('id', $user->id)->update([
                    'zoom_access_token' => $accessToken,
                    'zoom_refresh_token' => $refreshToken,
                    'zoom_token_expires_at' => $expiresAt,
                ]);
    
                return $accessToken;
            } else {
                Log::error('Failed to refresh Zoom access token: ' . $response->body());
                return null;
            }
        }
    
        return $user->zoom_access_token; // Return current token if still valid
    }
    
    public function makeZoomRequest()
    {
        $accessToken = $this->refreshToken();

        if ($accessToken) {
            $response = Http::withToken($accessToken)->get('https://api.zoom.us/v2/users/me');
            
            if ($response->successful()) {
                return $response->json();
            } else {
                Log::error('Failed to make Zoom API request: ' . $response->body());
                return null;
            }
        } else {
            return redirect()->route('zoom.auth')->with('error', 'Please authorize Zoom again.');
        }
    }

    public function isTokenExpired($expiresAt)
    {
        // Check if the token is expired based on the expiration time
        return now()->greaterThanOrEqualTo($expiresAt);
    }


}
