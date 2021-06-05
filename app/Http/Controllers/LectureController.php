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
use Illuminate\Support\Facades\File as FacadesFile;

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

        return redirect()->route('index.lecture', ['course' => $course]);
    }

    public function show(Course $course, Lecture $lecture)
    {
        return view('lectures.show', ['lecture' => $lecture]);
    }

    public function index(Course $course)
    {
        return view('lectures.index', ['course' => $course]);
    }

    public function delete(Course $course, Lecture $lecture)
    {
        foreach ($lecture->files()->get() as $file) {
            $fileName = $file->name;
            FacadesFile::delete('files/' . $fileName);
        }
        $lecture->delete();

        return view('lectures.index', ['course' => $course]);
    }

    public function edit(Course $course, Lecture $lecture)
    {
        return view('lectures.edit', ['course' => $course], ['lecture' => $lecture]);
    }

    public function update(Request $request, Course $course, Lecture $lecture)
    {
        $validatedData = $request->validate([
            'title' => 'required|max:100',
            'files' => 'nullable',
        ]);

        //Create the assignment
        $lecture->title = $validatedData['title'];
        $lecture->course_id = $course->id;
        $lecture->save();

        if ($request->file('files') != null) {
            //Delete the old files
            foreach ($lecture->files()->get() as $file) {
                $fileName = $file->name;
                FacadesFile::delete('files/' . $fileName);
            }

            $lecture->files()->delete();

            //Add the new files
            foreach ($request->file('files') as $index => $file) {
                $fileModel = new File;
                $fileName = time() . $index . '.' . $file->extension();
                $fileModel->name = $fileName;
    
                $lecture->files()->save($fileModel);
                $file->move(public_path('files'), $fileName);
            }
    
        }

        return redirect()->route('show.lecture', ['course' => $course, 'lecture' => $lecture]);
    }
}
