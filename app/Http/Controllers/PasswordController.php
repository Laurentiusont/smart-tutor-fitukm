<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Symfony\Component\HttpFoundation\Session\Session;


class PasswordController extends Controller
{
    public function emailOTP()
    {
        return view('auth.passwords.forgot-password');
    }
    public function inputReset()
    {
        return view('auth.passwords.reset');
    }
    public function changePassword()
    {
        $session = new Session();
        $token = $session->get('access_token');
        $id = $session->get('id');
        return view('profile.change-password', compact('token', 'session'));
    }
}
