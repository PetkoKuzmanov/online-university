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
use Illuminate\Support\Facades\File as FacadesFile;

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

        return redirect()->route('index.assignment', ['course' => $course]);
    }

    public function show(Course $course, Assignment $assignment)
    {
        return view('assignments.show', ['assignment' => $assignment]);
    }

    public function index(Course $course)
    {
        return view('assignments.index', ['course' => $course]);
    }

    public function delete(Course $course, Assignment $assignment)
    {
        foreach ($assignment->files()->get() as $file) {
            $fileName = $file->name;
            FacadesFile::delete('files/' . $fileName);
        }
        $assignment->delete();

        return view('assignments.index', ['course' => $course]);
    }

    public function edit(Course $course, Assignment $assignment)
    {
        return view('assignments.edit', ['course' => $course], ['assignment' => $assignment]);
    }

    public function update(Request $request, Course $course, Assignment $assignment)
    {
        $validatedData = $request->validate([
            'title' => 'required|max:100',
            'files' => 'nullable',
        ]);

        //Create the assignment
        $assignment->title = $validatedData['title'];
        $assignment->course_id = $course->id;
        $assignment->save();

        if ($request->file('files') != null) {
            //Delete the old files
            foreach ($assignment->files()->get() as $file) {
                $fileName = $file->name;
                FacadesFile::delete('files/' . $fileName);
            }

            $assignment->files()->delete();

            //Add the new files
            foreach ($request->file('files') as $index => $file) {
                $fileModel = new File;
                $fileName = time() . $index . '.' . $file->extension();
                $fileModel->name = $fileName;
    
                $assignment->files()->save($fileModel);
                $file->move(public_path('files'), $fileName);
            }
    
        }

        return redirect()->route('show.assignment', ['course' => $course, 'assignment' => $assignment]);
    }
}
