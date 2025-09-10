<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Timetable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TeacherDashboardController extends Controller
{
    /**
     * Display the teacher's personal timetable.
     */
    public function index()
    {
        $teacher = Auth::user()->teacher;

        if (!$teacher) {
            return redirect('/')->with('error', 'Your teacher profile is not configured.');
        }

        $timetables = Timetable::with(['subject', 'classroom.building', 'section.course', 'studentGroup'])
            ->where('teacher_id', $teacher->id)
            ->get()
            ->groupBy(['day_of_week', 'start_time']);

        return view('teacher.dashboard', compact('timetables'));
    }
}

