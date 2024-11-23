<?php

namespace App\Http\Controllers;

use Symfony\Component\HttpFoundation\Session\Session;
use Yajra\DataTables\Facades\DataTables;

class MeetingController extends Controller
{
    public function index()
    {
        $session = new Session();
        $token = $session->get('access_token');
        $id = $session->get('id');
        $role = $session->get('role_name');

        return view('meeting.index', compact('token', 'id','role', 'session'));
    }
    public function list()
    {
        $session = new Session();
        $token = $session->get('access_token');
        $id = $session->get('id');
        $email = $session->get('email');
        $role = $session->get('role_name');
        return view('meeting.list', compact('token', 'id','role','email', 'session'));
    }
    public function masuk()
    {
        $session = new Session();
        $token = $session->get('access_token');
        $id = $session->get('id');
        $email = $session->get('email');
        $role = $session->get('role_name');
        return view('meeting.join', compact('token', 'id','role','email', 'session'));
    }
}
