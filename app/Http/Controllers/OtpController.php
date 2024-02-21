<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Controllers\MessagesController;
use App\Http\Controllers\ResponseController;
use App\Models\Otp;
use App\Models\User;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Mailjet\Client;
use Mailjet\Resources;

class OtpController extends Controller
{
    public function generateOtp(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
        ], MessagesController::messages());

        if ($validator->fails()) {
            return ResponseController::getResponse(null, 422, $validator->errors()->first());
        }

        $user = User::where('email', $request->get('email'))
            ->first();

        if ($user === null) {
            return ResponseController::getResponse(null, 404, 'User Not Found');
        }

        try {
            $otp = random_int(100000, 999999);
        } catch (Exception $e) {
            return ResponseController::getResponse($e->getMessage(), 500, 'Internal Server Error');
        }
        /// INSERT DATA TO DB
        $data = Otp::create([
            'user_id' => $user->id,
            'otp' => $otp,
        ]);

        $firstname = strtok($user->name, " ");
        $mj = new Client(
            env('MAILJET_API_KEY'),
            env('MAILJET_SECRET_KEY'),
            true,
            ['version' => 'v3.1']
        );
        $body = [
            'Messages' => [
                [
                    'From' => [
                        'Email' => '2172028@maranatha.ac.id',
                        'Name' => 'SMART TUTOR'
                    ],
                    'To' => [
                        [
                            'Email' => $user->email,
                            'Name' => $user->name
                        ]
                    ],
                    'TemplateID' => 5706872,
                    'TemplateLanguage' => true,
                    'Subject' => 'OTP Reset Password',
                    'Variables' => json_decode('{
                        "title": "OTP Reset Password",
                        "firstname": "' . $firstname . '",
                        "content": "Kode OTP untuk reset password anda adalah : ' . $otp . '"
                      }', true)
                ]
            ]
        ];
        $response = $mj->post(Resources::$Email, ['body' => $body]);

        if (!$response->success()) {
            return ResponseController::getResponse($response->getData(), $response->getStatus(), $response->getReasonPhrase());
        }

        return ResponseController::getResponse($data, 200, 'Success');
    }


    public function validateOtp(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'otp' => 'required|string|min:6',
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

        return ResponseController::getResponse(null, 200, 'Success');
    }
}
