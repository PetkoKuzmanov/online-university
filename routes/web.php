<?php

use App\Http\Controllers\CourseController;
use App\Http\Controllers\LecturerController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\LectureController;
use App\Http\Controllers\FileController;
use App\Http\Controllers\AssignmentController;

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

//Authentication
Route::get('/auth/lecturer', function () {
    return view('authLecturer');
})->name('auth.lecturer');

Route::get('/auth/student', function () {
    return view('authStudent');
})->name('auth.student');

Route::middleware(['auth', 'verified'])->get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');

//Home
Route::view('/home', 'home')->middleware('auth');


//Login
Route::get('/login/lecturer', [LoginController::class, 'showLecturerLoginForm'])->name('login.lecturer');
Route::get('/login/student', [LoginController::class, 'showStudentLoginForm'])->name('login.student');

Route::post('/login/lecturer', [LoginController::class, 'lecturerLogin']);
Route::post('/login/student', [LoginController::class, 'studentLogin']);


//Register
Route::get('/register/lecturer', [RegisterController::class, 'showLecturerRegisterForm'])->name('register.lecturer');
Route::get('/register/student', [RegisterController::class, 'showStudentRegisterForm'])->name('register.student');

Route::post('/register/lecturer', [RegisterController::class, 'createLecturer']);
Route::post('/register/student', [RegisterController::class, 'createStudent']);
    

//Lecturer
Route::get('lecturer', [LecturerController::class, 'index'])->name('lecturer.index');


//Student
Route::view('/student', 'student');


//Course
Route::get('courses/create', [CourseController::class, 'create'])->name('create.course');
Route::post('courses/create', [CourseController::class, 'store'])->name('store.course');
Route::get('courses/{course}', [CourseController::class, 'show'])->name('show.course');
Route::delete('courses/{course}', [CourseController::class, 'delete'])->name('delete.course');


//Lecture
Route::get('courses/{course}/lectures/create', [LectureController::class, 'create'])->name('create.lecture');
Route::post('courses/{course}/lectures/create', [LectureController::class, 'store'])->name('store.lecture');
Route::get('courses/{course}/lectures', [LectureController::class, 'index'])->name('index.lecture');
Route::get('courses/{course}/lectures/{lecture}', [LectureController::class, 'show'])->name('show.lecture');
Route::delete('courses/{course}/lectures/{lecture}', [LectureController::class, 'delete'])->name('delete.lecture');


//Assignment
Route::get('courses/{course}/assignments/create', [AssignmentController::class, 'create'])->name('create.assignment');
Route::post('courses/{course}/assignments/create', [AssignmentController::class, 'store'])->name('store.assignment');
Route::get('courses/{course}/assignments', [AssignmentController::class, 'index'])->name('index.assignment');
Route::get('courses/{course}/assignments/{assignment}', [AssignmentController::class, 'show'])->name('show.assignment');
Route::delete('courses/{course}/assignments/{assignment}', [AssignmentController::class, 'delete'])->name('delete.assignment');
Route::put('courses/{course}/assignments/edit/{assignment}', [AssignmentController::class, 'edit'])->name('edit.assignment');
Route::put('courses/{course}/assignments/update/{assignment}', [AssignmentController::class, 'update'])->name('update.assignment');


//File
Route::get('files/{file}', [FileController::class, 'download'])->name('download.file');