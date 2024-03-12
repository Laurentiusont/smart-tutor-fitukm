<?php

namespace App\Http\Controllers;

use App\Models\Grade;
use App\Models\Role;
use App\Models\UserCourse;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;



class GradeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function getData(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'topic_guid' => 'required|string|max:50',
            'user_id' => 'required|string|max:10',
        ], MessagesController::messages());

        if ($validator->fails()) {
            return ResponseController::getResponse(null, 422, $validator->errors()->first());
        }
        $data = Grade::where('topic_guid', '=', $request['topic_guid'])->where('user_id', '=', $request['user_id'])->first();

        return ResponseController::getResponse($data, 200, 'Success');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function getDataByTopic($code, $guid)
    {
        $role = Role::where('role_name', '=', 'student')->pluck('guid');
        $data = UserCourse::whereHas('user', function ($query) use ($guid, $role) {
            $query->where('role_guid', '=', $role);
        })
            ->with(['user' => function ($query) use ($guid) {
                $query->with(['grade' => function ($query) use ($guid) {
                    $query->where('topic_guid', '=', $guid);
                }]);
            }])
            ->where('course_code', '=', $code)->get();
        if (!isset($data)) {
            return ResponseController::getResponse(null, 400, "Data not found");
        }
        $dataTable = DataTables::of($data)
            ->addIndexColumn()
            ->make(true);

        return $dataTable;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function updateData(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'topic_guid' => 'required|string|max:50',
            'grade' => 'required|integer',
            'user_id' => 'required|string|max:10',
        ], MessagesController::messages());

        if ($validator->fails()) {
            return ResponseController::getResponse(null, 422, $validator->errors()->first());
        }

        $data = Grade::where('topic_guid', '=', $request['topic_guid'])->where('user_id', '=', $request['user_id'])->first();
        if (isset($data)) {
            $data->grade = $request['grade'];
            $data->save();
        } else {
            $data = Grade::create([
                'topic_guid' => $request['topic_guid'],
                'user_id' => $request['user_id'],
                'grade' => $request['grade'],
            ]);
        }
        return ResponseController::getResponse($data, 200, 'Success');
    }
    public function insertData(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'topic_guid' => 'required|string|max:50',
            'user_id' => 'required|string|max:10',
        ], MessagesController::messages());

        if ($validator->fails()) {
            return ResponseController::getResponse(null, 422, $validator->errors()->first());
        }

        $data = Grade::create([
            'topic_guid' => $request['topic_guid'],
            'user_id' => $request['user_id'],
        ]);
        return ResponseController::getResponse($data, 200, 'Success');
    }
}
