<?php

namespace App\Http\Controllers;

use Symfony\Component\HttpFoundation\Session\Session;
use Yajra\DataTables\Facades\DataTables;

class TopicController extends Controller
{
    public function index($code)
    {
        $session = new Session();
        $token = $session->get('access_token');
        return view('topic.index', compact('token', 'code', 'session'));
    }
}
