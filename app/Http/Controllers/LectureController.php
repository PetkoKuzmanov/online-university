<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use App\Models\Course;
use App\Models\Lecture;
use App\Models\File;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

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
            'files' => 'required',
        ]);

        $lecture = new Lecture;
        $lecture->title = $validatedData['title'];
        $lecture->course_id = $course->id;
        $lecture->save();

        foreach ($request->file('files') as $index => $file) {
            $fileModel = new File;
            $fileName = time() . $index . '.' . $file->extension();
            $fileModel->name = $fileName;

            $lecture->files()->save($fileModel);
            $file->move(public_path('files'), $fileName);
        }

        return redirect()->route('show.course', ['course' => $course]);
    }

    public function show(Course $course, Lecture $lecture)
    {
        return view('lectures.show', ['lecture' => $lecture]);
    }

    public function index(Course $course)
    {
        return view('lectures.index', ['course' => $course]);
    }
}
