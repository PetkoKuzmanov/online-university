<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});


//auth::sanctum
Route::middleware(['auth', 'verified'])->get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');


    Route::get('/login/lecturer', [LoginController::class, 'showLecturerLoginForm']);
    Route::get('/login/student', [LoginController::class, 'showStudentLoginForm']);
    Route::get('/register/lecturer', [RegisterController::class, 'showLecturerRegisterForm']);
    Route::get('/register/student', [RegisterController::class, 'showStudentRegisterForm']);
    
    Route::post('/login/lecturer', [LoginController::class, 'lecturerLogin']);
    Route::post('/login/student', [LoginController::class, 'studentLogin']);
    Route::post('/register/lecturer', [RegisterController::class, 'createLecturer']);
    Route::post('/register/student', [RegisterController::class, 'createStudent']);
    
    Route::view('/home', 'home')->middleware('auth');
    Route::view('/lecturer', 'lecturer');
    Route::view('/student', 'student');