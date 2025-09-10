<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Teacher;
use App\Models\TeacherUnavailability;
use Illuminate\Http\Request;

class TeacherUnavailabilityController extends Controller
{
    /**
     * Display a listing of the resource for a specific teacher.
     */
    public function index(Teacher $teacher)
    {
        // Eager load the user information and the unavailability slots
        $teacher->load('user', 'unavailabilities');
        return view('admin.teachers.unavailability', compact('teacher'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Teacher $teacher)
    {
        $request->validate([
            'day_of_week' => 'required|integer|between:1,7',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
        ]);

        $teacher->unavailabilities()->create($request->all());

        return redirect()->route('admin.teachers.unavailability.index', $teacher)
                         ->with('success', 'Unavailability slot added successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TeacherUnavailability $unavailability)
    {
        $teacherId = $unavailability->teacher_id;
        $unavailability->delete();

        return redirect()->route('admin.teachers.unavailability.index', $teacherId)
                         ->with('success', 'Unavailability slot deleted successfully.');
    }
}
