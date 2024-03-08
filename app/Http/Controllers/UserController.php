<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use Illuminate\Support\Facades\Http;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $session = new Session();
        $token = $session->get('access_token');
        return view('user.index', compact('token', 'session'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $session = new Session();
        $token = $session->get('access_token');
        return view('user.insert', compact('token', 'session'));
    }
    public function edit($id)
    {
        $session = new Session();
        $token = $session->get('access_token');
        $response = Http::withHeaders([
            'Authorization' => "Bearer " . $token,
            'Content-Type' => "application/json"
        ])->get(env("URL_API", "http://example.com") . '/api/v1/user/' . $id);

        $data = json_decode($response, true);
        return view('user.edit', compact('token', 'session', 'data'));
    }
}
