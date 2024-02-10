<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SessionController;
use App\Http\Controllers\SoalController;
use App\Models\Soal;
use Illuminate\Support\Facades\Route;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;

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
});

Route::group([
    'middleware' => 'auth.token',
], function ($router) {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/question', [SoalController::class, 'index'])->name('question');
    Route::get('/soal', [SoalController::class, 'listSoal'])->name('soal');
});
