@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Manage Teachers</h1>
        <a href="{{ route('admin.teachers.create') }}" class="btn btn-primary">Add New Teacher</a>
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
                        <th>Email</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($teachers as $teacher)
                    <tr>
                        <td>{{ $teacher->id }}</td>
                        <td>{{ $teacher->user->name }}</td>
                        <td>{{ $teacher->user->email }}</td>
                        <td>
                            <a href="{{ route('admin.teachers.assign-subjects.form', $teacher->id) }}" class="btn btn-sm btn-info">Assign Subjects</a>
                            <a href="{{ route('admin.teachers.unavailability.index', $teacher->id) }}" class="btn btn-sm btn-primary">Unavailability</a>
                            <a href="{{ route('admin.teachers.edit', $teacher->id) }}" class="btn btn-sm btn-warning">Edit</a>
                            <form action="{{ route('admin.teachers.destroy', $teacher->id) }}" method="POST" style="display:inline-block;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure? This will delete the associated user account.')">Delete</button>
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
