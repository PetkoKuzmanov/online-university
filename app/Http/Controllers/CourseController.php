<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use App\Models\Course;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File as FacadesFile;

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

    public function show(Course $course)
    {
        return view('courses.show', ['course' => $course]);
    }

    public function delete(Course $course)
    {
        //Delete the course's lectures
        foreach ($course->lectures()->get() as $lecture) {
            foreach ($lecture->files()->get() as $file) {
                $fileName = $file->name;
                FacadesFile::delete('files/' . $fileName);
            }
            $lecture->delete();
        }

        //Delete the course's assignments
        foreach ($course->assignments()->get() as $assignment) {
            foreach ($assignment->files()->get() as $file) {
                $fileName = $file->name;
                FacadesFile::delete('files/' . $fileName);
            }
            $assignment->delete();
        }

        $course->delete();
        
        return redirect()->route('lecturer.index');
    }
}
