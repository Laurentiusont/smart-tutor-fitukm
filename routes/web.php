<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\MeetingController;
use App\Http\Controllers\ZoomController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

// Route untuk halaman utama
Route::get('/', function () {
    return view('welcome');
});

// Rute untuk autentikasi menggunakan Auth::routes()
Auth::routes();

// Rute untuk home setelah login
Route::get('/home', [HomeController::class, 'index'])->name('home');

// Rute untuk lecturer (hanya dapat mengakses dengan role 'lecturer')
Route::middleware(['auth', 'role:lecturer'])->group(function () {
    Route::get('/meetings/create', [MeetingController::class, 'create'])->name('meetings.create'); // GET untuk menampilkan formulir
    Route::post('/meetings', [MeetingController::class, 'store'])->name('meetings.store'); // POST untuk menyimpan meeting
    Route::get('/meetings', [MeetingController::class, 'index'])->name('meetings.index'); // GET untuk melihat daftar meeting
});

// Rute untuk join meeting (dapat diakses oleh semua yang terautentikasi)
Route::middleware(['auth'])->group(function () {
    Route::get('/student/meetings', [MeetingController::class, 'studentIndex'])->name('student.meetings.index'); // Route for student meetings
    Route::get('/meetings/join/{meetingId}', [MeetingController::class, 'join'])->name('meetings.join');
    Route::post('/meetings/join', [MeetingController::class, 'joinMeeting'])->name('meetings.join.submit');
});

// Rute untuk mengarahkan ke halaman otorisasi Zoom
Route::get('/zoom/redirect', [ZoomController::class, 'redirectToProvider'])->name('zoom.redirect');

// Rute untuk menangani callback dari Zoom setelah otorisasi
Route::get('/callback', [ZoomController::class, 'handleProviderCallback'])->name('zoom.callback');

Route::post('/meeting/signature', [MeetingController::class, 'generateSignature']);
