@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Manage Subjects</h1>
        <a href="{{ route('admin.subjects.create') }}" class="btn btn-primary">Add New Subject</a>
    </div>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="card">
        <div class="card-body">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Code</th>
                        <th>Course</th>
                        <th>Type</th>
                        <th>Weekly Hours</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($subjects as $subject)
                    <tr>
                        <td>{{ $subject->id }}</td>
                        <td>{{ $subject->name }}</td>
                        <td>{{ $subject->code }}</td>
                        <td>{{ $subject->course->name ?? 'N/A' }}</td>
                        <td>{{ $subject->type }}</td>
                        <td>{{ $subject->weekly_hours }}</td>
                        <td>
                            <a href="{{ route('admin.subjects.edit', $subject->id) }}" class="btn btn-sm btn-warning">Edit</a>
                            <form action="{{ route('admin.subjects.destroy', $subject->id) }}" method="POST" style="display:inline-block;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
