<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Timetable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StudentDashboardController extends Controller
{
    /**
     * Display the student's personal timetable.
     */
    public function index()
    {
        $student = Auth::user()->student;

        if (!$student) {
            return redirect('/')->with('error', 'Your student profile is not configured.');
        }

        $timetables = Timetable::with(['teacher.user', 'subject', 'classroom.building'])
            ->where('section_id', $student->section_id)
            ->where(function ($query) use ($student) {
                $query->whereNull('student_group_id')
                      ->orWhere('student_group_id', $student->student_group_id);
            })
            ->get()
            ->groupBy(['day_of_week', 'start_time']);

        return view('student.dashboard', compact('timetables'));
    }
}

