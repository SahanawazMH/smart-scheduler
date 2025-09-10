<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\TimetableService;
use App\Models\Timetable;
use App\Models\Section;
use App\Models\Teacher;
use App\Models\Classroom;
use Illuminate\Http\Request;

class TimetableController extends Controller
{
    /**
     * Show the page for generating the timetable.
     */
    public function generator()
    {
        return view('admin.timetable.generator');
    }

    /**
     * Run the timetable generation service.
     */
    public function generate(TimetableService $timetableService)
    {
        try {
            $result = $timetableService->generate();

            return redirect()->route('admin.timetable.generator')
                             ->with('success', 'Timetable generated successfully!')
                             ->with('generationResult', $result);

        } catch (\Exception $e) {
            return redirect()->route('admin.timetable.generator')
                             ->with('error', 'An error occurred during generation: ' . $e->getMessage());
        }
    }

    /**
     * Show the view for displaying the final timetable with filters.
     */
    public function view(Request $request)
    {
        $sections = Section::with('course')->get();
        $teachers = Teacher::with('user')->get();
        $classrooms = Classroom::with('building')->get();

        $timetables = Timetable::with(['teacher.user', 'subject', 'classroom', 'section', 'studentGroup'])
            ->when($request->section_id, function ($query) use ($request) {
                return $query->where('section_id', $request->section_id);
            })
            ->when($request->teacher_id, function ($query) use ($request) {
                return $query->where('teacher_id', $request->teacher_id);
            })
            ->when($request->classroom_id, function ($query) use ($request) {
                return $query->where('classroom_id', $request->classroom_id);
            })
            ->get()
            ->groupBy(['day_of_week', 'start_time']);

        return view('admin.timetable.view', compact('sections', 'teachers', 'classrooms', 'timetables'));
    }
}

