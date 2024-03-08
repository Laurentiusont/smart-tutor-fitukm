<?php

namespace App\Http\Controllers;

use App\Models\Assistant;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;


class AssistantController extends Controller
{
    public function getData($code)
    {
        /// GET DATA
        $data = Assistant::with('user')
            ->where('course_code', '=', $code)
            ->get();

        if (!isset($data)) {
            return ResponseController::getResponse(null, 400, "Data not found");
        }

        $dataTable = DataTables::of($data)
            ->addIndexColumn()
            ->make(true);

        return $dataTable;
    }
    public function checkData(Request $request)
    {
        /// GET DATA
        $data = Assistant::where('user_id', '=', $request['user_id'])
            ->where('course_code', '=', $request['course_code'])
            ->get();

        if ($data->count() > 0) {
            $response = true;
        } else {
            $response = false;
        }


        return ResponseController::getResponse($response, 200, 'Success');
    }

    public function insertData(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'course_code' => 'required|string|max:10',
        ], MessagesController::messages());

        if ($validator->fails()) {
            return ResponseController::getResponse(null, 422, $validator->errors()->first());
        }

        //USER
        $users = json_decode("[]", true);
        $user = null;
        if (!empty($request['user'])) {
            foreach ($request['user'] as $key => $value) {
                array_push($users, $value);
            }

            $user = User::find($users);
            if (count($request['user']) != count($user)) {
                return ResponseController::getResponse(null, 400, "Invalid author parameter");
            }
        }

        foreach ($users as $user) {
            $data = Assistant::create([
                'user_id' => $user,
                'course_code' => $request['course_code'],
            ]);
        }

        return ResponseController::getResponse($data, 200, 'Success');
    }
    public function deleteData($guid)
    {
        $data = Assistant::where('guid', '=', $guid)->first();
        $data->delete();

        return ResponseController::getResponse(null, 200, 'Success');
    }
}
