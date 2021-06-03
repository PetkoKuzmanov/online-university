<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
    ];

    public function fileable()
    {
      return $this->morphsTo();
    }

    public function lecture()
    {
        return $this->belongsTo(Lecture::class);
    }

    public function assignment()
    {
        return $this->belongsTo(Assignment::class);
    }
}
