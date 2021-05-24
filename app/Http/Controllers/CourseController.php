<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use App\Models\Course;
use Illuminate\Support\Facades\Auth;

class CourseController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function create()
    {
        return view('courses.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'code' => 'required|max:8',
            'title' => 'required|max:100',
        ]);

        $course = new Course;
        $course->code = $validatedData['code'];
        $course->title = $validatedData['title'];
        $course->lecturer_id = Auth::id();
        $course->save();

        return redirect()->route('lecturer.index');
    }
}
