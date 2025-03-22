<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Symfony\Component\HttpFoundation\Session\Session;

class ZoomController extends Controller
{
    public function index()
    {
        $session = new Session();
        $token = $session->get('access_token');
        $id = $session->get('id');
        return view('zoom.index', compact('token', 'id', 'session'));
    }
}
