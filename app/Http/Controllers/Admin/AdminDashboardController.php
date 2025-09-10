<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Classroom;
use App\Models\Course;
use App\Models\Student;
use App\Models\Teacher;
use Illuminate\Http\Request;

class AdminDashboardController extends Controller
{
    /**
     * Display the admin dashboard with key statistics.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $stats = [
            'courses' => Course::count(),
            'teachers' => Teacher::count(),
            'students' => Student::count(),
            'classrooms' => Classroom::count(),
        ];

        return view('admin.dashboard', compact('stats'));
    }
}
