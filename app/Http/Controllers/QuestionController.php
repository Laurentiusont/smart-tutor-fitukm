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
        $page = Http::attach('pdf', file_get_contents('D:\\laravel\\smart-tutor-backend\\storage\\app\\public\\file\\' . $name), 'file.pdf', ['Content-Type' => 'pdf'])
            ->post(
                'http://91.108.110.58/count-page'
            );
        $page = json_decode($page, true);
        return ResponseController::getResponse(['path' => $path, 'name' => $name, 'page' => $page], 200, 'Success');
    }

    public function checkCossine(Request $request)
    {
        $Rawdata = Http::timeout(300)->post(
            'http://127.0.0.1:5000/cossine_similarity',
            [
                'question' => $request->get('question'),
                'answer' => $request->get('answer')
            ]
        );
        $data = json_encode($Rawdata[0][0], true);
        if (isset($data)) {
            $floatValue = floatval($data);
            $formattedValue = number_format($floatValue * 100, 2);
            return $formattedValue;
        } else {
            return false;
        }
    }
    public function generateData(Request $request)
    {

        if ($request->get('path') != "") {

            $Rawdata = Http::timeout(300)
                ->attach('pdf', file_get_contents('D:\\laravel\\smart-tutor-backend\\storage\\app\\public\\file\\' . $request->get('name')), 'file.pdf', ['Content-Type' => 'pdf'])
                ->post(
                    'http://91.108.110.58/generate',
                    [
                        'language' => $request->get('language'),
                        'page' => $request->get('page')
                    ]
                );
            $data = json_decode($Rawdata, true);
            if (isset($data['pertanyaan'])) {
                return $data['pertanyaan'];
            } else {
                return false;
            }
            // Storage::delete($request->get('path') . $request->get('name'));
        } else if ($request->get('noun') != "") {

            $data = Http::withHeaders([
                'Content-Type' => "application/json"
            ])->post(
                "http://91.108.110.58/generate",
                [
                    'topic' => $request->get('noun'),
                    'language' => $request->get('language'),
                ]
            );
        }

        $data = json_decode($data, true);
        $dataTable = DataTables::of($data['pertanyaan'])
            ->addIndexColumn()
            ->make(true);

        return $dataTable;
    }
    public function convertDatatable(Request $request)
    {
        $dataTable = DataTables::of($request->get('data'))
            ->addIndexColumn()
            ->make(true);
        Storage::delete($request['path'] . $request['name']);
        return $dataTable;
    }


    public function insertData(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'question_ai' => 'required|string',
            'answer_ai' => 'required|string',
            'question_fix' => 'required|string',
            'answer_fix' => 'required|string',
            'weight' => 'required|numeric',
            'category' => 'required|string|max:40',
            'cossine_similarity' => 'required|numeric',
            'page' => 'nullable|string',
            'topic_guid' => 'required|string|max:40',
        ], MessagesController::messages());

        if ($validator->fails()) {
            return ResponseController::getResponse(null, 422, $validator->errors()->first());
        }
        $data = Question::create([
            'question_ai' => $request['question_ai'],
            'answer_ai' => $request['answer_ai'],
            'question_fix' => $request['question_fix'],
            'answer_fix' => $request['answer_fix'],
            'category' => $request['category'],
            'weight' => $request['weight'],
            'topic_guid' => $request['topic_guid'],
            'cossine_similarity' => $request['cossine_similarity'],
            'page' => $request['page']
        ]);
        if ($request['page']) {
            $data->page = $request['page'];
        }

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
            'question_fix' => 'required|string',
            'answer_fix' => 'required|string',
            'weight' => 'required|numeric',
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
        $data->question_fix = $request['question_fix'];
        $data->answer_fix = $request['answer_fix'];
        $data->weight = $request['weight'];
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
