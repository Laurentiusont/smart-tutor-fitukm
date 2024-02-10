<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Session\Session;

class SessionController extends Controller
{
    public function setLogin(Request $request)
    {
        $session = new Session();
        $session->set('access_token', $request->access_token);
        $session->set('name', $request->name);

        return $request->name;
    }

    public function clearSession()
    {
        $session = new Session();
        $session->clear();

        return true;
    }
}
