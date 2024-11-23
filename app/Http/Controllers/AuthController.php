<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Symfony\Component\HttpFoundation\Session\Session;
use Laravel\Socialite\Facades\Socialite;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['index', 'login', 'register', 'redirect', 'callbackGoogle']]);
    }

    public function index()
    {
        return view('auth.login');
    }

    public function redirect()
    {
        return Socialite::driver('google')->redirect();
    }

    public function callbackGoogle()
    {
        try {
            // dd("aa");
            $google_user = Socialite::driver('google')->user();
            // $session = new Session();
            // $token = $session->get('access_token');

            // Step 1: Check if user exists in external API
            $googleUserResponse = Http::withHeaders([
                // 'Authorization' => "Bearer " . $token,
                'Content-Type' => "application/json"
            ])->post(env("URL_API", "http://example.com") . '/api/v1/auth/google', [
                'name' => $google_user->getName(),
                'email' => $google_user->getEmail(),
                'id' => $google_user->getId()
            ]);

            $googleUserResponse = $googleUserResponse->json();
            // Step 3: Fetch user details
            // dd($googleUserResponse);
            $userResponse = $this->fetchUserSelf($googleUserResponse['data']['token']);
            $userData = $userResponse->json();
            // Step 4: Save session via POST to route
            $this->storeSessionViaRoute($googleUserResponse['data']['token'], $userData);

            return redirect()->to('/dashboard');
        } catch (\Throwable $th) {
            return response()->json(['status' => 'error', 'message' => 'Something went wrong: ' . $th->getMessage()], 500);
        }
    }

    private function fetchUserSelf($accessToken)
    {
        return Http::withHeaders([
            'Authorization' => "Bearer " . $accessToken,
            'Content-Type' => "application/json"
        ])->get(env("URL_API", "http://example.com") . '/api/v1/user/self');
    }

    private function storeSessionViaRoute($accessToken, $userData)
    {
        $session = new Session();
        $session->set('access_token', $accessToken);
        $session->set('name', $userData['data']['name']);
        $session->set('id', $userData['data']['id']);
        $session->set('role_name', $userData['data']['role']['role_name']);
        $session->set('email', $userData['data']['email']);
    }
}
