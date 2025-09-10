@extends('layouts.admin')
@section('title', 'Add Student Group')
@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Add New Student Group</h1>
        <a href="{{ route('admin.student-groups.index') }}" class="btn btn-sm btn-primary shadow-sm"><i class="fas fa-arrow-left fa-sm text-white-50"></i> Back</a>
    </div>
    <div class="card shadow mb-4">
        <div class="card-body">
            <form action="{{ route('admin.student-groups.store') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="name">Group Name (e.g., P1, Lab Group A)</label>
                    <input type="text" name="name" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="section_id">Parent Section</label>
                    <select name="section_id" class="form-control" required>
                        <option value="">Select Section</option>
                        @foreach ($sections as $section)
                            <option value="{{ $section->id }}">{{ $section->name }} ({{ $section->course->name }})</option>
                        @endforeach
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">Save Group</button>
            </form>
        </div>
    </div>
</div>
@endsection
