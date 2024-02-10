<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\SoalController;
use App\Http\Controllers\UserController;
use App\Models\Soal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();

// });

$version = "v1/";
$url = $version;

Route::group([
    'prefix' => $url . 'auth',
    'middleware' => 'api',
], function ($router) {
    $router->post('/login', [AuthController::class, 'login'])->name('login');
});

Route::group([
    'prefix' => $url . 'auth',
    'middleware' => 'jwt.verify',
], function ($router) {
    $router->post('/logout', [AuthController::class, 'logout']);
});

/**
 * PROFILE
 */
Route::group([
    'prefix' => $url . 'user',
    'middleware' => 'jwt.verify'
], function ($router) {
    $router->get('/self', [UserController::class, 'index']);
    // $router->put('/update', [ProfileController::class, 'updateUser']);
    // $router->put('/change-password', [PasswordController::class, 'changePassword']);
    // $router->put('/update-fcm-token', [FcmController::class, 'updateFcmToken']);
});

/**
 * QUESTION
 */
Route::group([
    'prefix' => $url . 'question',
    'middleware' => 'jwt.verify'
], function ($router) {
    $router->get('/generate', [SoalController::class, 'generateData']);
    $router->post('/save', [SoalController::class, 'insertData']);
});
