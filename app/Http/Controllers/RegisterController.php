<?php

namespace App\Http\Controllers;

use App\Models\Lecturer;
use App\Models\Student;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\CreatesNewUsers;
use Illuminate\Foundation\Auth\RegistersUsers;
use Laravel\Jetstream\Jetstream;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Actions\Fortify\PasswordValidationRules;


class RegisterController extends BaseController
{
    use PasswordValidationRules;

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
        // $this->validator($request->all())->validate();

        Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:lecturers'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ])->validate();

        $lecturer = Lecturer::create([
            'name' => $request['name'],
            'email' => $request['email'],
            'password' => Hash::make($request['password']),
        ]);
        
        return redirect()->intended('login/lecturer');
    }

    protected function createStudent(Request $request)
    {
        // $this->validator($request->all())->validate();
        $student = Student::create([
            'name' => $request['name'],
            'email' => $request['email'],
            'password' => Hash::make($request['password']),
        ]);
        return redirect()->intended('login/student');
    }
}
