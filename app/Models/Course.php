<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;

    protected $fillable = ['code','title'];

    public function lecturer()
    {
        return $this->belongsTo(Lecturer::class);
    }

    public function lectures()
    {
        return $this->hasMany(Lecture::class);
    }

    public function assignments()
    {
        return $this->hasMany(Assignment::class);
    }

    public function students()
    {
        return $this->belongsToMany(Student::class);
    }
}
