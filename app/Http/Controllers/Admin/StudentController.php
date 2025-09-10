<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Models\User;
use App\Models\Course;
use App\Models\Section;
use App\Models\StudentGroup;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $students = Student::with(['user', 'course', 'section'])->get();
        return view('admin.students.index', compact('students'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $courses = Course::all();
        $sections = Section::all();
        $studentGroups = StudentGroup::all();
        return view('admin.students.create', compact('courses', 'sections', 'studentGroups'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'roll_number' => ['required', 'string', 'max:255', 'unique:students'],
            'course_id' => ['required', 'exists:courses,id'],
            'section_id' => ['required', 'exists:sections,id'],
            'student_group_id' => ['nullable', 'exists:student_groups,id'],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'student',
        ]);

        $user->student()->create([
            'roll_number' => $request->roll_number,
            'course_id' => $request->course_id,
            'section_id' => $request->section_id,
            'student_group_id' => $request->student_group_id,
        ]);

        return redirect()->route('admin.students.index')
                         ->with('success', 'Student created successfully.');
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Student $student)
    {
        $courses = Course::all();
        $sections = Section::all();
        $studentGroups = StudentGroup::all();
        return view('admin.students.edit', compact('student', 'courses', 'sections', 'studentGroups'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Student $student)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $student->user_id],
            'password' => ['nullable', 'confirmed', Rules\Password::defaults()],
            'roll_number' => ['required', 'string', 'max:255', 'unique:students,roll_number,' . $student->id],
            'course_id' => ['required', 'exists:courses,id'],
            'section_id' => ['required', 'exists:sections,id'],
            'student_group_id' => ['nullable', 'exists:student_groups,id'],
        ]);

        $student->user->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        if ($request->filled('password')) {
            $student->user->update([
                'password' => Hash::make($request->password),
            ]);
        }
        
        $student->update([
            'roll_number' => $request->roll_number,
            'course_id' => $request->course_id,
            'section_id' => $request->section_id,
            'student_group_id' => $request->student_group_id,
        ]);

        return redirect()->route('admin.students.index')
                         ->with('success', 'Student updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Student $student)
    {
        // Delete the associated User account, which will cascade delete the student record
        $student->user->delete();

        return redirect()->route('admin.students.index')
                         ->with('success', 'Student deleted successfully.');
    }
}
