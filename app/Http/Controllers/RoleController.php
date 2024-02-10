<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Session\Session;

class RoleController extends Controller
{
    public function index()
    {
        $session = new Session();
        $token = $session->get('access_token');
        return view('role.index', compact('token', 'session'));
    }

    public function insertData(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'role_name' => 'required|string|max:40',
        ], MessagesController::messages());

        if ($validator->fails()) {
            return ResponseController::getResponse(null, 422, $validator->errors()->first());
        }
        $data = Role::create([
            'role_name' => $request['role_name'],
        ]);

        return ResponseController::getResponse($data, 200, 'Success');
    }

    public function showData()
    {
        $data = Role::all();

        return ResponseController::getResponse($data, 200, 'Success');
    }
    public function getData($guid)
    {
        $data = Role::where('guid', '=', $guid)->first();

        return ResponseController::getResponse($data, 200, 'Success');
    }
    public function updateData(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'guid' => 'required|string|max:36',
            'role_name' => 'required|string|max:40',
        ], MessagesController::messages());

        if ($validator->fails()) {
            return ResponseController::getResponse(null, 422, $validator->errors()->first());
        }

        $data = Role::where('guid', '=', $request['guid'])->first();

        if (!isset($data)) {
            return ResponseController::getResponse(null, 400, "Data not found");
        }
        /// UPDATE DATA
        $data->role_name = $request['role_name'];
        $data->save();

        return ResponseController::getResponse($data, 200, 'Success');
    }
    public function deleteData($guid)
    {
        $data = Role::where('guid', '=', $guid)->first();

        if (!isset($data)) {
            return ResponseController::getResponse(null, 400, "Data not found");
        }

        $data->delete();

        return ResponseController::getResponse(null, 200, 'Success');
    }
}
