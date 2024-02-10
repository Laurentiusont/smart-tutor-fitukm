<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\JawabanController;
use App\Http\Controllers\MataKuliahController;
use App\Http\Controllers\MateriController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SoalController;
use App\Http\Controllers\UserController;
use App\Models\Jawaban;
use App\Models\MataKuliah;
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
    $router->get('/', [SoalController::class, 'showData']);
    $router->put('/', [SoalController::class, 'updateData']);
    $router->get('/{guid}', [SoalController::class, 'getData']);
    $router->delete('/{guid}', [SoalController::class, 'deleteData']);
    $router->get('/generate', [SoalController::class, 'generateData']);
    $router->post('/', [SoalController::class, 'insertData']);
});

/**
 * ROLE
 */
Route::group([
    'prefix' => $url . 'role',
    'middleware' => 'jwt.verify'
], function ($router) {
    $router->get('/', [RoleController::class, 'showData']);
    $router->put('/', [RoleController::class, 'updateData']);
    $router->get('/{guid}', [RoleController::class, 'getData']);
    $router->delete('/{guid}', [RoleController::class, 'deleteData']);
    $router->post('/', [RoleController::class, 'insertData']);
});

/**
 * JAWABAN
 */
Route::group([
    'prefix' => $url . 'jawaban',
    'middleware' => 'jwt.verify'
], function ($router) {
    $router->get('/', [JawabanController::class, 'showData']);
    $router->put('/', [JawabanController::class, 'updateData']);
    $router->get('/{guid}', [JawabanController::class, 'getData']);
    $router->delete('/{guid}', [JawabanController::class, 'deleteData']);
    $router->post('/', [JawabanController::class, 'insertData']);
});

/**
 * MATERI
 */
Route::group([
    'prefix' => $url . 'materi',
    'middleware' => 'jwt.verify'
], function ($router) {
    $router->get('/', [MateriController::class, 'showData']);
    $router->put('/', [MateriController::class, 'updateData']);
    $router->get('/{guid}', [MateriController::class, 'getData']);
    $router->delete('/{guid}', [MateriController::class, 'deleteData']);
    $router->post('/', [MateriController::class, 'insertData']);
});

/**
 * MATA KULIAH
 */
Route::group([
    'prefix' => $url . 'mata-kuliah',
    'middleware' => 'jwt.verify'
], function ($router) {
    $router->get('/', [MataKuliahController::class, 'showData']);
    $router->put('/', [MataKuliahController::class, 'updateData']);
    $router->get('/{kode}', [MataKuliahController::class, 'getData']);
    $router->delete('/{kode}', [MataKuliahController::class, 'deleteData']);
    $router->post('/', [MataKuliahController::class, 'insertData']);
});
