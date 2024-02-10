<?php

namespace App\Http\Controllers;

use App\Models\Soal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Process;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Yajra\DataTables\Facades\DataTables;

// use Symfony\Component\Process\Process;

class SoalController extends Controller
{
    /**
     * Display a listing of the resource.
     */
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
        // return $request->get('question');
        $process = Process::forever()->run(
            ['C:\Users\ontos\AppData\Local\Programs\Python\Python311\python.exe', 'D:\Smart Tutor\main.py', $request->get('question')]
        );
        // $process = Process::forever()->run(
        //     ['C:\Users\ontos\AppData\Local\Programs\Python\Python311\python.exe', 'D:\Smart Tutor\main.py', 'Unsupervised Learning, Reinforcement Learning, Deep Learning, Natural Language Processing (NLP)']
        // );
        // $process->run();

        // if (!$process->output()) {
        //     throw new ProcessFailedException($process);
        // }

        $data = $process->output();
        // dd($data);
        // $data = $data['pertanyaan'];
        $data = json_decode($data, true);
        return ResponseController::getResponse($data['pertanyaan'], 200, 'Success');
        // $dataTable = DataTables::of($data)
        //     ->addIndexColumn()
        //     ->make(true);

        // return $dataTable;
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

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Soal $soal)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Soal $soal)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Soal $soal)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Soal $soal)
    {
        //
    }
}
