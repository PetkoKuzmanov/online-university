<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use App\Models\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Response;

class FileController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function download(File $file)
    {
        $filePath = public_path() . "/files//" .$file->name;
        return response()->download($filePath);
    }
}
