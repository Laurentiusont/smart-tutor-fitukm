<?php

namespace App\Http\Controllers;

use App\Models\UserCourse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Session\Session;

class UserCourseController extends Controller
{

    public function insertData(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|string|max:20',
            'course_code' => 'required|string|max:10',
        ], MessagesController::messages());

        if ($validator->fails()) {
            return ResponseController::getResponse(null, 422, $validator->errors()->first());
        }
        $data = UserCourse::create([
            'user_id' => $request['user_id'],
            'course_code' => $request['course_code'],
        ]);

        return ResponseController::getResponse($data, 200, 'Success');
    }

    public function getDataByUser()
    {
        $data = UserCourse::with('user', 'course')->get();

        return ResponseController::getResponse($data, 200, 'Success');
    }
    public function deleteData($guid)
    {
        $data = UserCourse::where('guid', '=', $guid)->first();
        $data->delete();

        return ResponseController::getResponse(null, 200, 'Success');
    }
}
