<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use Illuminate\Support\Facades\Http;

class AnswerController extends Controller
{
    public function index($code, $guid, $id)
    {
        $session = new Session();
        $token = $session->get('access_token');
        $responseTopic = Http::withHeaders([
            'Authorization' => "Bearer " . $token,
            'Content-Type' => "application/json"
        ])->get(env("URL_API", "http://example.com") . '/api/v1/topic/' . $guid);
        $topic = json_decode($responseTopic, true);
        $name = $topic['data']['name'];
        return view('answer.answer-detail', compact('token', 'code', 'name', 'id', 'guid', 'session'));
    }
    public function fill($guid)
    {
        $session = new Session();
        $token = $session->get('access_token');
        $id = $session->get('id');
        $responseTopic = Http::withHeaders([
            'Authorization' => "Bearer " . $token,
            'Content-Type' => "application/json"
        ])->get(env("URL_API", "http://example.com") . '/api/v1/topic/' . $guid);
        $topic = json_decode($responseTopic, true);
        $name = $topic['data']['name'];
        $code = $topic['data']['course_code'];
        return view('answer.user-answer', compact('token', 'guid', 'name', 'id', 'code', 'session'));
    }
}
