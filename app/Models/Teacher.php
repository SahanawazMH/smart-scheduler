<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function subjects()
    {
        return $this->belongsToMany(Subject::class, 'teacher_subjects');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function unavailabilities()
    {
        return $this->hasMany(TeacherUnavailability::class);
    }
}
