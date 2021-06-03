<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lecture extends Model
{
    use HasFactory;

    protected $fillable = ['title'];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function files()
    {
      return $this->morphMany(File::class, 'file');
    }
}
