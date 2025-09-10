<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\Section;

class DependentDropdownController extends Controller
{
    public function getSections(Course $course)
    {
        $sections = $course->sections()->select('id', 'name')->get();
        return response()->json($sections);
    }

    public function getStudentGroups(Section $section)
    {
        $studentGroups = $section->studentGroups()->select('id', 'name')->get();
        return response()->json($studentGroups);
    }
}
