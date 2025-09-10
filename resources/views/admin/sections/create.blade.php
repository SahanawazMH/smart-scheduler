@extends('layouts.admin')

@section('content')
<div class="container">
    <h1>Add New Section</h1>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('admin.sections.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="name" class="form-label">Section Name</label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" placeholder="e.g., Section A">
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="course_id" class="form-label">Course</label>
                    <select class="form-control @error('course_id') is-invalid @enderror" id="course_id" name="course_id">
                        <option value="">Select a Course</option>
                        @foreach($courses as $course)
                            <option value="{{ $course->id }}" {{ old('course_id') == $course->id ? 'selected' : '' }}>{{ $course->name }}</option>
                        @endforeach
                    </select>
                    @error('course_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <button type="submit" class="btn btn-primary">Save Section</button>
                <a href="{{ route('admin.sections.index') }}" class="btn btn-secondary">Cancel</a>
            </form>
        </div>
    </div>
</div>
@endsection
