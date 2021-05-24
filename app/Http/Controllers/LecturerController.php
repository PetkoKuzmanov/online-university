<?php

namespace App\Http\Controllers;

use App\Models\Lecturer;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth;

class LecturerController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function index()
    {
        $lecturer = Lecturer::all()->get(Auth::id() - 1);
        $courses = $lecturer->courses;

        return view('lecturer', ['courses' => $courses]);
    }
}
