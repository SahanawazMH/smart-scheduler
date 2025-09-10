<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Teacher;
use App\Models\TeacherSubject;
use App\Models\User;
use App\Models\Subject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class TeacherController extends Controller
{

    public function index()
    {
        $teachers = Teacher::with('user')->get();
        return view('admin.teachers.index', compact('teachers'));
    }

    public function create()
    {
        return view('admin.teachers.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);


        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'teacher',
        ]);


        $user->teacher()->create();

        return redirect()->route('admin.teachers.index')->with('success', 'Teacher created successfully.');
    }

    public function edit(Teacher $teacher)
    {
        return view('admin.teachers.edit', compact('teacher'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Teacher $teacher)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $teacher->user_id],
            'password' => ['nullable', 'confirmed', 'min: 8'],
        ]);

        $teacher->user->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        if ($request->filled('password')) {
            $teacher->user->update([
                'password' => Hash::make($request->password),
            ]);
        }

        return redirect()->route('admin.teachers.index')
            ->with('success', 'Teacher updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Teacher $teacher)
    {
        // Delete the associated User account, which will cascade and delete the teacher record.
        $teacher->user->delete();

        return redirect()->route('admin.teachers.index')
            ->with('success', 'Teacher deleted successfully.');
    }

    // --- Logic for Assigning Subjects to a Teacher ---

    /**
     * Show the form to assign subjects to a specific teacher.
     */
    public function assignSubjectsForm(Teacher $teacher)
    {
        $subjects = Subject::all();

        // $assignedSubjectIds = $teacher->subjects()->pluck('subjects.id')->toArray();

        $assignedSubjectIds = TeacherSubject::where('teacher_id', $teacher->id)->pluck('subject_id')->toArray();

        return view('admin.teachers.assign-subjects', compact('teacher', 'subjects', 'assignedSubjectIds'));
    }

    /**
     * Store the assigned subjects in the database.
     */
    public function storeAssignedSubjects(Request $request, Teacher $teacher)
    {
        $request->validate([
            'subjects' => 'array',
            'subjects.*' => 'exists:subjects,id',
        ]);

        $teacher->subjects()->sync($request->subjects);

        return redirect()->route('admin.teachers.index')->with('success', 'Subjects assigned successfully to ' . $teacher->user->name);
    }
}
