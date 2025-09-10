<?php

use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\BuildingController;
use App\Http\Controllers\Admin\ClassroomController;
use App\Http\Controllers\Admin\CourseController;
use App\Http\Controllers\Admin\SectionController;
use App\Http\Controllers\Admin\StudentController;
use App\Http\Controllers\Admin\StudentGroupController;
use App\Http\Controllers\Admin\SubjectController;
use App\Http\Controllers\Admin\TeacherController;
use App\Http\Controllers\Admin\TeacherUnavailabilityController;
use App\Http\Controllers\Admin\TimetableController;
use App\Http\Controllers\Api\DependentDropdownController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Student\StudentDashboardController;
use App\Http\Controllers\Teacher\TeacherDashboardController;
use App\Models\Teacher;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    $user = auth()->user();
    $userRole = $user->role;
    return redirect("/{$userRole}/dashboard");

})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.change-password.form');
    Route::post('/profile', [ProfileController::class, 'updatePassword'])->name('profile.change-password.update');
});

// Admin Routes Group
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {

    // Main Admin Dashboard
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

    // CRUD for Core Data Management
    Route::resource('buildings', BuildingController::class);
    Route::resource('classrooms', ClassroomController::class);
    Route::resource('courses', CourseController::class);
    Route::resource('sections', SectionController::class);
    Route::resource('student-groups', StudentGroupController::class);
    Route::resource('subjects', SubjectController::class);

    // User Management
    Route::resource('teachers', TeacherController::class);
    Route::resource('students', StudentController::class);

    // Teacher Constraints Management
    // Route::get('teachers/{teacher}/assign-subjects', [TeacherController::class, 'assignSubjectsForm'])->name('teachers.assignSubjectsForm');
    Route::post('teachers/{teacher}/assign-subjects', [TeacherController::class, 'storeAssignedSubjects'])->name('teachers.storeAssignedSubjects');
    Route::get('teachers/{teacher}/assign-subjects', [TeacherController::class, 'assignSubjectsForm'])->name('teachers.assign-subjects.form');
    // Route::post('teachers/{teacher}/assign-subjects', [TeacherController::class, 'assignSubjects'])->name('teachers.assign-subjects');

    Route::get('teachers/{teacher}/unavailability', [TeacherUnavailabilityController::class, 'index'])->name('teachers.unavailability.index');
    Route::post('teachers/{teacher}/unavailability', [TeacherUnavailabilityController::class, 'store'])->name('teachers.unavailability.store');
    Route::delete('unavailability/{unavailability}', [TeacherUnavailabilityController::class, 'destroy'])->name('teachers.unavailability.destroy');

    // You would add similar routes for unavailability

    // Timetable Generation & Management
    Route::get('timetable/generator', [TimetableController::class, 'generator'])->name('timetable.generator');
    Route::post('timetable/generate', [TimetableController::class, 'generate'])->name('timetable.generate');
    Route::get('timetable/view', [TimetableController::class, 'view'])->name('timetable.view');

    // API Routes
    Route::get('/api/courses/{course}/sections', [DependentDropdownController::class, 'getSections'])->name('api.sections.by.course');
        Route::get('/api/sections/{section}/student-groups', [DependentDropdownController::class, 'getStudentGroups'])->name('api.student-groups.by.section');

});

Route::prefix('student')->name('student.')->middleware('role:student')->group(function () {
    Route::get('dashboard', [StudentDashboardController::class, 'index'])->name('dashboard');
});

Route::prefix('teacher')->name('teacher.')->middleware('role:teacher')->group(function () {
    Route::get('dashboard', [TeacherDashboardController::class, 'index'])->name('dashboard');
});


require __DIR__ . '/auth.php';
