@extends('layouts.admin')

@section('title', 'View Timetable')

@section('content')
<style>
    .timetable-grid {
        display: grid;
        grid-template-columns: 100px repeat(5, 1fr);
        gap: 2px;
    }
    .grid-header, .grid-cell, .time-slot {
        padding: 8px;
        background-color: #f8f9fa;
        border: 1px solid #dee2e6;
        text-align: center;
        min-height: 80px;
    }
    .grid-header { background-color: #e9ecef; font-weight: bold; }
    .time-slot { font-weight: bold; }
    .grid-cell { background-color: #fff; }
    .class-entry {
        font-size: 0.8rem;
        padding: 4px;
        margin-bottom: 2px;
        border-radius: 4px;
        background-color: #cfe2ff;
        border: 1px solid #9ec5fe;
    }
</style>

<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">View Timetable</h1>

    <div class="card shadow mb-4">
        <div class="card-header">
            <h6 class="m-0 font-weight-bold text-primary">Filter Timetable</h6>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.timetable.view') }}" method="GET" class="row g-3 align-items-end">
                <div class="col-md-3">
                    <label for="section_id" class="form-label">View by Section</label>
                    <select name="section_id" id="section_id" class="form-select">
                        <option value="">Select Section</option>
                        @foreach ($sections as $section)
                            <option value="{{ $section->id }}" {{ request('section_id') == $section->id ? 'selected' : '' }}>
                                {{ $section->name }} ({{ $section->course->name }})
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <label for="teacher_id" class="form-label">View by Teacher</label>
                    <select name="teacher_id" id="teacher_id" class="form-select">
                        <option value="">Select Teacher</option>
                        @foreach ($teachers as $teacher)
                            <option value="{{ $teacher->id }}" {{ request('teacher_id') == $teacher->id ? 'selected' : '' }}>
                                {{ $teacher->user->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <label for="classroom_id" class="form-label">View by Classroom</label>
                    <select name="classroom_id" id="classroom_id" class="form-select">
                        <option value="">Select Classroom</option>
                        @foreach ($classrooms as $classroom)
                            <option value="{{ $classroom->id }}" {{ request('classroom_id') == $classroom->id ? 'selected' : '' }}>
                                {{ $classroom->room_number }} ({{ $classroom->building->name }})
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <button type="submit" class="btn btn-primary w-100">Filter</button>
                </div>
            </form>
        </div>
    </div>

    <div class="card shadow mb-4">
        <div class="card-body">
            @php
                $timeSlots = ['09:00:00', '10:00:00', '11:00:00', '12:00:00', '13:00:00', '14:00:00', '15:00:00', '16:00:00'];
                $days = ['1' => 'Monday', '2' => 'Tuesday', '3' => 'Wednesday', '4' => 'Thursday', '5' => 'Friday'];
            @endphp
            <div class="timetable-grid">
                <div class="grid-header">Time</div>
                @foreach ($days as $day)
                    <div class="grid-header">{{ $day }}</div>
                @endforeach

                @foreach ($timeSlots as $time)
                    <div class="time-slot">{{ \Carbon\Carbon::parse($time)->format('h:i A') }}</div>
                    @foreach ($days as $dayKey => $dayName)
                        <div class="grid-cell">
                            @if(isset($timetables[$dayKey][$time]))
                                @foreach($timetables[$dayKey][$time] as $entry)
                                    <div class="class-entry">
                                        <strong>{{ $entry->subject->name }}</strong><br>
                                        <small>
                                            {{ $entry->teacher->user->name }}<br>
                                            {{ $entry->section->name }} | {{ $entry->studentGroup?->name }} | {{ $entry->classroom->room_number }} | {{ $entry->classroom->building->name }}
                                        </small>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                    @endforeach
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection
