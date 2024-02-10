<?php

namespace App\Http\Controllers;

use App\Models\Soal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Process;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Session\Session;

class SoalController extends Controller
{

    public function index()
    {
        $session = new Session();
        $token = $session->get('access_token');
        return view('question.index', compact('token', 'session'));
    }
    public function listSoal()
    {
        $session = new Session();
        $token = $session->get('access_token');
        return view('question.list', compact('token', 'session'));
    }
    public function generateData(Request $request)
    {
        $process = Process::forever()->run(
            ['C:\Users\ontos\AppData\Local\Programs\Python\Python311\python.exe', 'D:\Smart Tutor\main.py', $request->get('question')]
        );

        $data = $process->output();
        $data = json_decode($data, true);
        return ResponseController::getResponse($data['pertanyaan'], 200, 'Success');
    }

    public function insertData(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'pertanyaan' => 'required|string',
            'jawaban' => 'required|string',
            'kategori' => 'required|string|max:40',
        ], MessagesController::messages());

        if ($validator->fails()) {
            return ResponseController::getResponse(null, 422, $validator->errors()->first());
        }
        $data = Soal::create([
            'pertanyaan' => $request['pertanyaan'],
            'jawaban' => $request['jawaban'],
            'kategori' => $request['kategori'],
        ]);

        return ResponseController::getResponse($data, 200, 'Success');
    }

    public function showData()
    {
        $data = Soal::all();

        return ResponseController::getResponse($data, 200, 'Success');
    }
    public function getData($guid)
    {
        $data = Soal::where('guid', '=', $guid)->first();

        return ResponseController::getResponse($data, 200, 'Success');
    }
    public function updateData(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'guid' => 'required|string|max:36',
            'jawaban' => 'required|string',
            'kategori' => 'required|string|max:40',
        ], MessagesController::messages());

        if ($validator->fails()) {
            return ResponseController::getResponse(null, 422, $validator->errors()->first());
        }
        /// GET DATA
        $data = Soal::where('guid', '=', $request['guid'])->first();

        if (!isset($data)) {
            return ResponseController::getResponse(null, 400, "Data not found");
        }
        /// UPDATE DATA
        $data->pertanyaan = $request['pertanyaan'];
        $data->jawaban = $request['jawaban'];
        $data->kategori = $request['kategori'];
        $data->save();

        return ResponseController::getResponse($data, 200, 'Success');
    }
    public function deleteData($guid)
    {
        $data = Soal::where('guid', '=', $guid)->first();

        if (!isset($data)) {
            return ResponseController::getResponse(null, 400, "Data not found");
        }

        $data->delete();

        return ResponseController::getResponse(null, 200, 'Success');
    }
}
