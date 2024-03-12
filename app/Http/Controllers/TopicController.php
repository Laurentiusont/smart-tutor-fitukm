<?php

namespace App\Http\Controllers;

use App\Models\Grade;
use App\Models\Topic;
use App\Models\UserCourse;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Session\Session;
use Yajra\DataTables\Facades\DataTables;

class TopicController extends Controller
{

    public function insertData(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:100',
            'description' => 'required|string',
            'course_code' => 'required|string|max:10',
            'time_start' => 'required|date_format:Y-m-d\TH:i|after_or_equal:' . date(DATE_ATOM),
            'time_end' => 'required|date_format:Y-m-d\TH:i|after:' . $request['time_start'],
        ], MessagesController::messages());

        if ($validator->fails()) {
            return ResponseController::getResponse(null, 422, $validator->errors()->first());
        }
        $data = Topic::create([
            'name' => $request['name'],
            'description' => $request['description'],
            'course_code' => $request['course_code'],
            'time_start' => $request['time_start'],
            'time_end' => $request['time_end'],
        ]);

        return ResponseController::getResponse($data, 200, 'Success');
    }

    public function showData()
    {
        $data = Topic::all();
        if (!isset($data)) {
            return ResponseController::getResponse(null, 400, "Data not found");
        }
        $dataTable = DataTables::of($data)
            ->addIndexColumn()
            ->make(true);

        return $dataTable;
    }
    public function topicByCourse(Request $request)
    {
        $topic = Topic::where('course_code', '=', $request['code'])
            ->with('course')
            ->with(['grade' => function ($query) use ($request) {
                $query->where('user_id', '=', $request['user_id']);
            }])
            ->get();
        $dataTable = DataTables::of($topic)
            ->addIndexColumn()
            ->make(true);

        return $dataTable;
    }
    public function topicByDeadline(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|string|max:10',
        ], MessagesController::messages());
        if ($validator->fails()) {
            return ResponseController::getResponse(null, 422, $validator->errors()->first());
        }
        $id = $request['id'];
        $course = UserCourse::where('user_id', '=', $id)->pluck('course_code');
        $currentDateTime = Carbon::now('Asia/Jakarta');
        $topic = Topic::with('course')
            ->where('time_end', '>', $currentDateTime)
            ->whereIn("course_code", $course)
            ->get();
        $dataTable = DataTables::of($topic)
            ->addIndexColumn()
            ->make(true);

        return $dataTable;
    }
    public function checkSubmit(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'user_id' => 'required|string|max:10',
            'topic_guid' => 'required|string|max:36',

        ], MessagesController::messages());
        if ($validator->fails()) {
            return ResponseController::getResponse(null, 422, $validator->errors()->first());
        }
        $data = Grade::where('user_id', '=', $request['user_id'])
            ->where('topic_guid', '=', $request['topic_guid'])
            ->first();

        if ($data->count() > 0) {
            $response = true;
        }
        $response = false;

        return ResponseController::getResponse($response, 200, 'Success');
    }
    public function getData($guid)
    {
        $data = Topic::where('guid', '=', $guid)->first();
        $currentDateTime = Carbon::now('Asia/Jakarta');
        if ($data->time_end < $currentDateTime) {
            $data = false;
        }
        return ResponseController::getResponse($data, 200, 'Success');
    }
    public function updateData(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:100',
            'guid' => 'required|string|max:36',
            'description' => 'required|string',
            'course_code' => 'required|string|max:10',
            'time_start' => 'required|date_format:Y-m-d\TH:i',
            'time_end' => 'required|date_format:Y-m-d\TH:i|after:' . $request['time_start'],
        ], MessagesController::messages());

        if ($validator->fails()) {
            return ResponseController::getResponse(null, 422, $validator->errors()->first());
        }

        $data = Topic::where('guid', '=', $request['guid'])->first();

        if (!isset($data)) {
            return ResponseController::getResponse(null, 400, "Data not found");
        }
        /// UPDATE DATA
        $data->name = $request['name'];
        $data->description = $request['description'];
        $data->course_code = $request['course_code'];
        $data->time_start = $request['time_start'];
        $data->time_end = $request['time_end'];
        $data->save();

        return ResponseController::getResponse($data, 200, 'Success');
    }
    public function deleteData($guid)
    {
        $data = Topic::where('guid', '=', $guid)->first();

        if (!isset($data)) {
            return ResponseController::getResponse(null, 400, "Data not found");
        }

        $data->delete();

        return ResponseController::getResponse(null, 200, 'Success');
    }
}
