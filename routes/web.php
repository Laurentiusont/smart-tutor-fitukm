<?php

use App\Http\Controllers\AnswerController;
use App\Http\Controllers\AssistantController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ChatbotController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\GradeController;
use App\Http\Controllers\MeetingController;
use App\Http\Controllers\PasswordController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\SessionController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\TopicController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', function () {
//     return view('dashboard');
// });
// Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
// Route::get('/question', [SoalController::class, 'index'])->name('question');
Route::get('/', function () {
    return redirect()->route('login');
});

Route::post('/set-session', [SessionController::class, 'setLogin'])->name('session.login');
Route::get('/clear-session', [App\Http\Controllers\SessionController::class, 'clearSession'])->name('session.clear');

Route::group([
    'middleware' => 'auth.guest',
], function ($router) {
    Route::get('/login', [App\Http\Controllers\AuthController::class, 'index'])->name('login');
    Route::get('password/reset/email', [App\Http\Controllers\PasswordController::class, 'emailOTP'])->name('password.request');
    Route::get('password/reset/password', [App\Http\Controllers\PasswordController::class, 'inputReset'])->name('password.update');
    Route::get('/auth/google', [AuthController::class, 'redirect'])->name('google-auth');
    Route::get('/auth/google/call-back', [AuthController::class, 'callbackGoogle']);
});

Route::group([
    'middleware' => 'auth.token',
], function ($router) {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/question', [QuestionController::class, 'generate'])->name('question-generate')->middleware('role:admin,lecturer');
    Route::get('/course', [CourseController::class, 'index'])->name('course');
    Route::get('/chatbot', [ChatbotController::class, 'index'])->name('chatbot');
    Route::get('/topic/{code}', [TopicController::class, 'index'])->name('topic');
    Route::get('/student/{code}', [StudentController::class, 'index'])->name('student')->middleware('role:admin,lecturer,assistant');
    Route::get('/assistant/{code}', [AssistantController::class, 'index'])->name('assistant')->middleware('role:admin,lecturer');
    Route::get('/question/{code}/{guid}', [QuestionController::class, 'index'])->name('question')->middleware('role:admin,lecturer,assistant');
    Route::get('/grade/{code}/{guid}', [GradeController::class, 'index'])->name('grade')->middleware('role:admin,lecturer,assistant');
    Route::get('/answer/detail/{code}/{guid}/{id}', [AnswerController::class, 'index'])->name('answer')->middleware('role:admin,lecturer,assistant');
    Route::get('/user', [UserController::class, 'index'])->name('index-user')->middleware('role:admin,lecturer');
    Route::get('/user/create', [UserController::class, 'create'])->name('create-user')->middleware('role:admin,lecturer');
    Route::get('/user/create-csv', [UserController::class, 'createCSV'])->name('create-user-csv')->middleware('role:admin,lecturer');
    Route::get('/user/edit/{id}', [UserController::class, 'edit'])->name('edit-user')->middleware('role:admin,lecturer');
    Route::get('/user/answer/{guid}', [AnswerController::class, 'fill'])->name('user-answer')->middleware('role:student');
    Route::get('/user/answer/result/{guid}', [AnswerController::class, 'answerResult'])->name('user-answer-result')->middleware('role:student');
    Route::get('/user/profile', [UserController::class, 'profile'])->name('user-profile');
    Route::get('/password/change', [PasswordController::class, 'changePassword'])->name('change-password');
    Route::get('/meeting/create', [MeetingController::class, 'index'])->name('create-user-meeting')->middleware('role:admin,lecturer');
    Route::get('/meeting/list', [MeetingController::class, 'list'])->name('list-user-meeting');
    Route::get('/join', [MeetingController::class, 'masuk'])->name('join-meeting');
});
