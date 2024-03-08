<?php

namespace App\Http\Controllers;

use App\Models\Question;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Process;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\URL;
use Symfony\Component\HttpFoundation\Session\Session;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Http;

class QuestionController extends Controller
{

    public function uploadFile(Request $request)
    {
        $path = 'public/file/';
        $pathUrl = 'file/';
        $file = $request->file('pdf');
        $name = $file->hashName();
        $file->storeAs($path, $name);
        return ResponseController::getResponse(['path' => $path, 'name' => $name], 200, 'Success');
    }

    public function generateData(Request $request)
    {

        if ($request->get('path') != "") {

            $process = Process::forever()->run(
                ['C:\Users\ontos\AppData\Local\Programs\Python\Python311\python.exe', 'D:\Smart Tutor\runPDF.py', 'D:\\laravel\\smart-tutor-backend\\storage\\app\\public\\file\\' . $request->get('name')]
            );
            Storage::delete($request->get('path') . $request->get('name'));
        } else if ($request->get('noun') != "") {
            $process = Process::forever()->run(
                ['C:\Users\ontos\AppData\Local\Programs\Python\Python311\python.exe', 'D:\Smart Tutor\main.py', $request->get('noun')]
            );
        }

        if (!isset($process)) {
            return ResponseController::getResponse(null, 400, "Failed to Execute Process");
        }

        $data = $process->output();
        $data = json_decode($data, true);
        $dataTable = DataTables::of($data['pertanyaan'])
            ->addIndexColumn()
            ->make(true);

        return $dataTable;
    }

    public function insertData(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'question' => 'required|string',
            'answer' => 'required|string',
            'category' => 'required|string|max:40',
            'topic_guid' => 'required|string|max:40',
        ], MessagesController::messages());

        if ($validator->fails()) {
            return ResponseController::getResponse(null, 422, $validator->errors()->first());
        }
        $data = Question::create([
            'question' => $request['question'],
            'answer' => $request['answer'],
            'category' => $request['category'],
            'topic_guid' => $request['topic_guid'],
        ]);

        return ResponseController::getResponse($data, 200, 'Success');
    }

    public function showData($guid, Request $request)
    {
        if ($request['user_id']) {
            $userId = $request['user_id'];
            $data = Question::with(['user_answer' => function ($query) use ($userId) {
                $query->where('user_id', '=', $userId);
            }])->where('topic_guid', '=', $guid)->get();
        } else {
            $data = Question::where('topic_guid', '=', $guid)->get();
        }

        if (!isset($data)) {
            return ResponseController::getResponse(null, 400, "Data not found");
        }
        $dataTable = DataTables::of($data)
            ->addIndexColumn()
            ->make(true);

        return $dataTable;
    }
    public function getData($guid)
    {
        $data = Question::where('guid', '=', $guid)->first();

        return ResponseController::getResponse($data, 200, 'Success');
    }
    public function updateData(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'guid' => 'required|string|max:36',
            'question' => 'required|string',
            'answer' => 'required|string',
            'category' => 'required|string|max:40',
            'topic_guid' => 'required|string|max:40',
        ], MessagesController::messages());

        if ($validator->fails()) {
            return ResponseController::getResponse(null, 422, $validator->errors()->first());
        }
        /// GET DATA
        $data = Question::where('guid', '=', $request['guid'])->first();

        if (!isset($data)) {
            return ResponseController::getResponse(null, 400, "Data not found");
        }
        /// UPDATE DATA
        $data->question = $request['question'];
        $data->answer = $request['answer'];
        $data->category = $request['category'];
        $data->topic_guid = $request['topic_guid'];
        $data->save();

        return ResponseController::getResponse($data, 200, 'Success');
    }
    public function deleteData($guid)
    {
        $data = Question::where('guid', '=', $guid)->first();

        if (!isset($data)) {
            return ResponseController::getResponse(null, 400, "Data not found");
        }

        $data->delete();

        return ResponseController::getResponse(null, 200, 'Success');
    }
}
