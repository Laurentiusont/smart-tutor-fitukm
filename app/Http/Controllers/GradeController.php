<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use Illuminate\Support\Facades\Http;


class GradeController extends Controller
{
    public function index($code, $guid)
    {
        $session = new Session();
        $token = $session->get('access_token');
        $responseTopic = Http::withHeaders([
            'Authorization' => "Bearer " . $token,
            'Content-Type' => "application/json"
        ])->get(env("URL_API", "http://example.com") . '/api/v1/topic/' . $guid);
        $topic = json_decode($responseTopic, true);
        $name = $topic['data']['name'];
        return view('grade.index', compact('token', 'name', 'code', 'guid', 'session'));
    }
}
