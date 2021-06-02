<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use App\Models\Course;
use Illuminate\Support\Facades\Auth;

class AssignmentController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function create()
    {
        return view('assignments.create');
    }

    public function store(Request $request)
    {
        // $validatedData = $request->validate([
        //     'code' => 'required|max:8',
        //     'title' => 'required|max:100',
        // ]);

        // $course = new Course;
        // $course->code = $validatedData['code'];
        // $course->title = $validatedData['title'];
        // $course->lecturer_id = Auth::id();
        // $course->save();

        // return redirect()->route('lecturer.index');
    }

    public function show(Course $course)
    {
        return view('assignments.show', ['course' => $course]);
    }

    public function index(Course $course)
    {
        return view('assignments.index', ['course' => $course]);
    }
}
