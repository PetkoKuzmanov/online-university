<?php

namespace App\Http\Controllers;

use App\Models\Lecturer;
use App\Models\Student;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\CreatesNewUsers;
use Laravel\Jetstream\Jetstream;
use Illuminate\Routing\Controller as BaseController;

class RegisterController extends BaseController
{

    public function __construct()
        {
            $this->middleware('guest');
            $this->middleware('guest:lecturer');
            $this->middleware('guest:student');
        }

        public function showLecturerRegisterForm()
        {
            return view('auth.register', ['url' => 'lecturer']);
        }
        
        public function showStudentRegisterForm()
        {
            return view('auth.register', ['url' => 'student']);
        }

        protected function createLecturer(Request $request)
    {
        $this->validator($request->all())->validate();
        $lecturer = Lecturer::create([
            'name' => $request['name'],
            'email' => $request['email'],
            'password' => Hash::make($request['password']),
        ]);
        return redirect()->intended('login/lecturer');
    }

    protected function createStudent(Request $request)
    {
        $this->validator($request->all())->validate();
        $student = Student::create([
            'name' => $request['name'],
            'email' => $request['email'],
            'password' => Hash::make($request['password']),
        ]);
        return redirect()->intended('login/student');
    }
}
