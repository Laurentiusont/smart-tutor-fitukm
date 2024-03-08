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
        $id = $session->get('id');
        return view('topic.index', compact('token', 'code', 'id', 'session'));
    }
}
