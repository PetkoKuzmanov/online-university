<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Fortify\Http\Controllers\AuthenticatedSessionController;
use Laravel\Fortify\Http\Requests\LoginRequest;


class LoginController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function __construct()
        {
            $this->middleware('guest')->except('logout');
            $this->middleware('guest:lecturer')->except('logout');
            $this->middleware('guest:student')->except('logout');
        }

    public function showLecturerLoginForm()
    {
        return view('auth.login', ['url' => 'lecturer']);
    }

    public function lecturerLogin(Request $request)
    {
        $this->validate($request, [
            'email'   => 'required|email',
            'password' => 'required|min:6'
        ]);
    
        if (Auth::guard('lecturer')->attempt(['email' => $request->email, 'password' => $request->password], $request->get('remember'))) {
            return redirect()->intended('/lecturer');
        }
        return back()->withInput($request->only('email', 'remember'));
    }

    public function showStudentLoginForm()
    {
        return view('auth.login', ['url' => 'student']);
    }
    
    public function studentLogin(Request $request)
    {
        $this->validate($request, [
            'email'   => 'required|email',
            'password' => 'required|min:6'
        ]);
    
        if (Auth::guard('student')->attempt(['email' => $request->email, 'password' => $request->password], $request->get('remember'))) {
            return redirect()->intended('/student');
        }
        return back()->withInput($request->only('email', 'remember'));
    }

    // protected function guard() {
    //     $user = Auth::guard('lecturer')->getLastAttempted();
    //         Auth::guard('lecturer')->login($user);
    //     return Auth::guard('lecturer');
    // }
}
