@extends('layouts.admin')
@section('title', 'Edit Student Group')
@section('content')
<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">Edit Student Group</h1>
    <div class="card shadow mb-4">
        <div class="card-body">
            <form action="{{ route('admin.student-groups.update', $studentGroup->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label for="name">Group Name</label>
                    <input type="text" name="name" class="form-control" value="{{ $studentGroup->name }}" required>
                </div>
                <div class="form-group">
                    <label for="section_id">Parent Section</label>
                    <select name="section_id" class="form-control" required>
                        <option value="">Select Section</option>
                        @foreach ($sections as $section)
                            <option value="{{ $section->id }}" {{ $studentGroup->section_id == $section->id ? 'selected' : '' }}>
                                {{ $section->name }} ({{ $section->course->name }})
                            </option>
                        @endforeach
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">Update Group</button>
            </form>
        </div>
    </div>
</div>
@endsection
