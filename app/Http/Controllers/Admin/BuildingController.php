<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Building;
use Illuminate\Http\Request;

class BuildingController extends Controller
{
    public function index()
    {
        $buildings = Building::all();
        return view('admin.buildings.index', compact('buildings'));
    }

    public function create()
    {
        return view('admin.buildings.create');
    }

    public function store(Request $request)
    {
        $request->validate(['name' => 'required|string|max:255', 'number' => 'required|string|unique:buildings']);
        Building::create($request->all());
        return redirect()->route('admin.buildings.index')->with('success', 'Building created successfully.');
    }

    public function edit(Building $building)
    {
        return view('admin.buildings.edit', compact('building'));
    }

    public function update(Request $request, Building $building)
    {
        $request->validate(['name' => 'required|string|max:255', 'number' => 'required|string|unique:buildings,number,' . $building->id]);
        $building->update($request->all());
        return redirect()->route('admin.buildings.index')->with('success', 'Building updated successfully.');
    }

    public function destroy(Building $building)
    {
        $building->delete();
        return redirect()->route('admin.buildings.index')->with('success', 'Building deleted successfully.');
    }
}
