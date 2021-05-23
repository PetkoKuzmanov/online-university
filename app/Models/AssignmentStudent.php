<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\Pivot;

class AssignmentStudent extends Pivot
{
    use HasFactory;

    protected $fillable = ['conetentUploaded','grade'];

}
