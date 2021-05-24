<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use App\Models\Course;
use App\Models\Lecture;
use Illuminate\Support\Facades\Auth;

class LectureController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function create(Course $course)
    {
        return view('lectures.create', ['course' => $course]);
    }

    public function store(Request $request, Course $course)
    {
        $validatedData = $request->validate([
            'title' => 'required|max:50',
            'url' => 'required|max:50',
        ]);

        $lecture = new Lecture;
        $lecture->title = $validatedData['title'];
        $lecture->url = $validatedData['url'];
        $lecture->course_id = $course->id;
        $lecture->save();

        return redirect()->route('show.course', ['course' => $course]);
    }

    public function show(Lecture $lecture)
    {
        return view('lectures.show', ['lecture' => $lecture]);
    }
}
