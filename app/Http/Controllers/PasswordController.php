<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Controllers\MessagesController;
use App\Http\Controllers\ResponseController;
use App\Models\Otp;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class PasswordController extends Controller
{

    public function changePassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'old_password' => 'required|string|min:6',
            'new_password' => 'required|string|min:6|confirmed',
        ], MessagesController::messages());

        if ($validator->fails()) {
            return ResponseController::getResponse(null, 422, $validator->errors()->first());
        }

        $user = User::where('id', auth('api')->user()->id)
            ->first();

        if (!Hash::check($request->get('old_password'), $user->password)) {
            return ResponseController::getResponse(null, 400, 'Wrong old password');
        }

        $user->password = Hash::make($request->get('new_password'));
        $user->save();

        return ResponseController::getResponse(null, 200, 'Change password success');
    }

    public function resetPassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'otp' => 'required|string|min:6',
            'new_password' => 'required|string|min:6',
        ], MessagesController::messages());

        if ($validator->fails()) {
            return ResponseController::getResponse(null, 422, $validator->errors()->first());
        }

        $user = User::where('email', $request->get('email'))
            ->first();

        if ($user === null) {
            return ResponseController::getResponse(null, 404, 'User Not Found');
        }

        $otp = Otp::where('user_id', $user->id)
            ->where('otp', $request->get('otp'))
            ->first();

        if ($otp === null) {
            return ResponseController::getResponse(null, 404, 'Wrong OTP');
        }

        $user->password = Hash::make($request->get('new_password'));
        $user->save();

        return ResponseController::getResponse(null, 200, 'Success');
    }
}
