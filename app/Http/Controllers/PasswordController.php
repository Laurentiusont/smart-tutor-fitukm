<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;


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
}
