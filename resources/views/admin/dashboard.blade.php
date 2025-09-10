@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">Admin Dashboard</h1>

    <!-- Statistics Cards Row -->
    <div class="row">

        <!-- Courses Card -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-start-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col">
                            <div class="text-xs fw-bold text-primary text-uppercase mb-1">Courses</div>
                            <div class="h5 mb-0 fw-bold text-gray-800">{{ $stats['courses'] }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="bi bi-journal-bookmark-fill h2 text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Teachers Card -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-start-success shadow h-100 py-2">
                <div class="card-body">
                     <div class="row align-items-center">
                        <div class="col">
                            <div class="text-xs fw-bold text-success text-uppercase mb-1">Teachers</div>
                            <div class="h5 mb-0 fw-bold text-gray-800">{{ $stats['teachers'] }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="bi bi-person-video3 h2 text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Students Card -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-start-info shadow h-100 py-2">
                <div class="card-body">
                     <div class="row align-items-center">
                        <div class="col">
                            <div class="text-xs fw-bold text-info text-uppercase mb-1">Students</div>
                            <div class="h5 mb-0 fw-bold text-gray-800">{{ $stats['students'] }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="bi bi-people-fill h2 text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Classrooms Card -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-start-warning shadow h-100 py-2">
                <div class="card-body">
                     <div class="row align-items-center">
                        <div class="col">
                            <div class="text-xs fw-bold text-warning text-uppercase mb-1">Classrooms</div>
                            <div class="h5 mb-0 fw-bold text-gray-800">{{ $stats['classrooms'] }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="bi bi-door-open-fill h2 text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <hr>

    <!-- Quick Actions -->
    <div class="row">
        <div class="col-lg-6">
            <h3>Quick Actions</h3>
            <div class="list-group">
                <a href="{{ route('admin.timetable.generator') }}" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                    Generate New Timetable
                    <i class="bi bi-gear-wide-connected"></i>
                </a>
                <a href="{{ route('admin.courses.create') }}" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                    Add a New Course
                    <i class="bi bi-plus-circle-fill"></i>
                </a>
                <a href="{{ route('admin.teachers.create') }}" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                    Add a New Teacher
                    <i class="bi bi-plus-circle-fill"></i>
                </a>
                 <a href="{{ route('admin.timetable.view') }}" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                    View Current Timetable
                    <i class="bi bi-table"></i>
                </a>
            </div>
        </div>
    </div>
</div>
@endsection

