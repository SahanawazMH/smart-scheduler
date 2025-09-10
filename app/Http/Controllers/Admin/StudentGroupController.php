<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\StudentGroup;
use App\Models\Section;
use Illuminate\Http\Request;

class StudentGroupController extends Controller
{
    public function index()
    {
        $studentGroups = StudentGroup::with('section.course')->get();
        return view('admin.student-groups.index', compact('studentGroups'));
    }

    public function create()
    {
        $sections = Section::with('course')->get();
        return view('admin.student-groups.create', compact('sections'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'section_id' => 'required|exists:sections,id',
        ]);

        StudentGroup::create($request->all());

        return redirect()->route('admin.student-groups.index')
                         ->with('success', 'Student Group created successfully.');
    }

    public function edit(StudentGroup $studentGroup)
    {
        $sections = Section::with('course')->get();
        return view('admin.student-groups.edit', compact('studentGroup', 'sections'));
    }

    public function update(Request $request, StudentGroup $studentGroup)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'section_id' => 'required|exists:sections,id',
        ]);

        $studentGroup->update($request->all());

        return redirect()->route('admin.student-groups.index')
                         ->with('success', 'Student Group updated successfully.');
    }

    public function destroy(StudentGroup $studentGroup)
    {
        $studentGroup->delete();
        return redirect()->route('admin.student-groups.index')
                         ->with('success', 'Student Group deleted successfully.');
    }
}
