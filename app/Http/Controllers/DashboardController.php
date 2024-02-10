<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Session\Session;

class DashboardController extends Controller
{
    public function index()
    {
        $session = new Session();
        $token = $session->get('access_token');
        return view('dashboard', compact('token', 'session'));
    }
}
