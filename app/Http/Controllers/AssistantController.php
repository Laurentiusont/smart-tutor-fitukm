<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Session\Session;

class AssistantController extends Controller
{
    public function index($code)
    {
        $session = new Session();
        $token = $session->get('access_token');
        return view('assistant.index', compact('token', 'code', 'session'));
    }
}
