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
    // return view('welcome');
    return view('startpage');
});

Route::get('/auth/lecturer', function () {
    // return view('welcome');
    return view('authLecturer');
})->name('auth.lecturer');

Route::get('/auth/student', function () {
    // return view('welcome');
    return view('authStudent');
})->name('auth.student');

//auth::sanctum
Route::middleware(['auth', 'verified'])->get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');


Route::get('/login/lecturer', [LoginController::class, 'showLecturerLoginForm'])->name('login.lecturer');
Route::get('/login/student', [LoginController::class, 'showStudentLoginForm'])->name('login.student');
Route::get('/register/lecturer', [RegisterController::class, 'showLecturerRegisterForm'])->name('register.lecturer');
Route::get('/register/student', [RegisterController::class, 'showStudentRegisterForm'])->name('register.student');
    
    
Route::post('/login/lecturer', [LoginController::class, 'lecturerLogin']);
Route::post('/login/student', [LoginController::class, 'studentLogin']);
Route::post('/register/lecturer', [RegisterController::class, 'createLecturer']);
Route::post('/register/student', [RegisterController::class, 'createStudent']);
    
Route::view('/home', 'home')->middleware('auth');
Route::view('/lecturer', 'lecturer');
Route::view('/student', 'student');