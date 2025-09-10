<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Subject;
use App\Models\Course;
use Illuminate\Http\Request;

class SubjectController extends Controller
{
    public function index()
    {
        $subjects = Subject::with('course')->get();
        return view('admin.subjects.index', compact('subjects'));
    }

    public function create()
    {
        $courses = Course::all();
        return view('admin.subjects.create', compact('courses'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|unique:subjects,code',
            'weekly_hours' => 'required|integer|min:1',
            'type' => 'required|in:lecture,lab',
            'course_id' => 'required|exists:courses,id',
        ]);
        Subject::create($request->all());
        return redirect()->route('admin.subjects.index')->with('success', 'Subject created successfully.');
    }

    public function edit(Subject $subject)
    {
        $courses = Course::all();
        return view('admin.subjects.edit', compact('subject', 'courses'));
    }

    public function update(Request $request, Subject $subject)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|unique:subjects,code,' . $subject->id,
            'weekly_hours' => 'required|integer|min:1',
            'type' => 'required|in:lecture,lab',
            'course_id' => 'required|exists:courses,id',
        ]);
        $subject->update($request->all());
        return redirect()->route('admin.subjects.index')->with('success', 'Subject updated successfully.');
    }

    public function destroy(Subject $subject)
    {
        $subject->delete();
        return redirect()->route('admin.subjects.index')->with('success', 'Subject deleted successfully.');
    }
}
