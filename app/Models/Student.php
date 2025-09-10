<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function studentGroup()
    {
        return $this->belongsTo(StudentGroup::class);
    }
    public function section()
    {
        return $this->belongsTo(Section::class);
    }
    public function course()
    {
        return $this->belongsTo(Course::class);
    }
}
