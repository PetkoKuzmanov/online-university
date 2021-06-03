<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use App\Models\Course;
use App\Models\Assignment;
use App\Models\File;
use App\Models\Lecture;
use Illuminate\Support\Facades\Auth;

class AssignmentController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function create(Course $course)
    {
        return view('assignments.create', ['course' => $course]);
    }

    public function store(Request $request, Course $course)
    {
        $validatedData = $request->validate([
            'title' => 'required|max:100',
            'files' => 'required',
        ]);

        $assignment = new Assignment;
        $assignment->title = $validatedData['title'];
        $assignment->course_id = $course->id;
        $assignment->save();

        foreach ($request->file('files') as $index => $file) {
            $fileModel = new File;
            $fileName = time() . $index . '.' . $file->extension();
            $fileModel->name = $fileName;

            $assignment->files()->save($fileModel);
            $file->move(public_path('files'), $fileName);
        }

        return redirect()->route('show.course', ['course' => $course]);
    }

    public function show(Course $course, Assignment $assignment)
    {
        return view('assignments.show', ['assignment' => $assignment]);
    }

    public function index(Course $course)
    {
        return view('assignments.index', ['course' => $course]);
    }
}
