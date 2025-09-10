@extends('layouts.admin')

@section('content')
    <div class="container">
        <h1>Edit Subject</h1>

        <div class="card">
            <div class="card-body">
                <form action="{{ route('admin.subjects.update', $subject->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label for="name" class="form-label">Subject Name</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                            name="name" value="{{ old('name', $subject->name) }}">
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="code" class="form-label">Subject Code</label>
                        <input type="text" class="form-control @error('code') is-invalid @enderror" id="code"
                            name="code" value="{{ old('code', $subject->code) }}">
                        @error('code')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="course_id" class="form-label">Course</label>
                        <select class="form-control @error('course_id') is-invalid @enderror" id="course_id"
                            name="course_id">
                            <option value="">Select a Course</option>
                            @foreach ($courses as $course)
                                <option value="{{ $course->id }}"
                                    {{ old('course_id', $subject->course_id) == $course->id ? 'selected' : '' }}>
                                    {{ $course->name }} ({{ $course->code }})</option>
                            @endforeach
                        </select>
                        @error('course_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="type">Subject Type</label>
                        <select name="type" class="form-control" required>
                            <option value="lecture"
                                {{ isset($subject) && $subject->type == 'lecture' ? 'selected' : '' }}>Lecture (for whole
                                section)</option>
                            <option value="lab" {{ isset($subject) && $subject->type == 'lab' ? 'selected' : '' }}>Lab
                                / Practical (for student groups)</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="weekly_hours" class="form-label">Weekly Hours</label>
                        <input type="number" class="form-control @error('weekly_hours') is-invalid @enderror"
                            id="weekly_hours" name="weekly_hours"
                            value="{{ old('weekly_hours', $subject->weekly_hours) }}">
                        @error('weekly_hours')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-primary">Update Subject</button>
                    <a href="{{ route('admin.subjects.index') }}" class="btn btn-secondary">Cancel</a>
                </form>
            </div>
        </div>
    </div>
@endsection
