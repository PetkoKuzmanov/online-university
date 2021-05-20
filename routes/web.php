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



Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');


    Route::get('/login/lecturer', 'Auth\LoginController@showLecturerLoginForm');
    // Route::get('/login/student', 'Auth\LoginController@showStudentLoginForm');
    Route::get('/login/student', [LoginController::class, 'showStudentLoginForm']);
    Route::get('/register/lecturer', 'Auth\RegisterController@showLecturerRegisterForm');
    Route::get('/register/student', 'Auth\RegisterController@showStudentRegisterForm');
    
    Route::post('/login/lecturer', 'Auth\LoginController@lecturerLogin');
    Route::post('/login/student', 'Auth\LoginController@studentLogin');
    Route::post('/register/lecturer', 'Auth\RegisterController@createLecturer');
    Route::post('/register/student', 'Auth\RegisterController@createStudent');
    
    Route::view('/home', 'home')->middleware('auth');
    Route::view('/lecturer', 'lecturer');
    Route::view('/student', 'student');