<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Classroom;
use App\Models\Building;
use Illuminate\Http\Request;

class ClassroomController extends Controller
{
    public function index()
    {
        $classrooms = Classroom::with('building')->get();
        return view('admin.classrooms.index', compact('classrooms'));
    }

    public function create()
    {
        $buildings = Building::all();
        return view('admin.classrooms.create', compact('buildings'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'room_number' => 'required|string|max:255',
            'capacity' => 'required|integer',
            'type' => 'required|in:lab,classroom',
            'building_id' => 'required|exists:buildings,id',
        ]);
        Classroom::create($request->all());
        return redirect()->route('admin.classrooms.index')->with('success', 'Classroom created successfully.');
    }

    public function edit(Classroom $classroom)
    {
        $buildings = Building::all();
        return view('admin.classrooms.edit', compact('classroom', 'buildings'));
    }

    public function update(Request $request, Classroom $classroom)
    {
        $request->validate([
            'room_number' => 'required|string|max:255',
            'capacity' => 'required|integer',
            'type' => 'required|in:lab,classroom',
            'building_id' => 'required|exists:buildings,id',
        ]);
        $classroom->update($request->all());
        return redirect()->route('admin.classrooms.index')->with('success', 'Classroom updated successfully.');
    }

    public function destroy(Classroom $classroom)
    {
        $classroom->delete();
        return redirect()->route('admin.classrooms.index')->with('success', 'Classroom deleted successfully.');
    }
}
