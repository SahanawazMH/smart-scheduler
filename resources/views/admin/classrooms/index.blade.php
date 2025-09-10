@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Manage Classrooms</h1>
        <a href="{{ route('admin.classrooms.create') }}" class="btn btn-primary">Add New Classroom</a>
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
                        <th>Room Number</th>
                        <th>Building</th>
                        <th>Capacity</th>
                        <th>Type</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($classrooms as $classroom)
                    <tr>
                        <td>{{ $classroom->id }}</td>
                        <td>{{ $classroom->room_number }}</td>
                        <td>{{ $classroom->building->name }}</td>
                        <td>{{ $classroom->capacity }}</td>
                        <td>{{ ucfirst($classroom->type) }}</td>
                        <td>
                            <a href="{{ route('admin.classrooms.edit', $classroom->id) }}" class="btn btn-sm btn-warning">Edit</a>
                            <form action="{{ route('admin.classrooms.destroy', $classroom->id) }}" method="POST" style="display:inline-block;">
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
