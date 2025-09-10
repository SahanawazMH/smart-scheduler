@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Manage Buildings</h1>
        <a href="{{ route('admin.buildings.create') }}" class="btn btn-primary">Add New Building</a>
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
                        <th>Number</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($buildings as $building)
                    <tr>
                        <td>{{ $building->id }}</td>
                        <td>{{ $building->name }}</td>
                        <td>{{ $building->number }}</td>
                        <td>
                            <a href="{{ route('admin.buildings.edit', $building->id) }}" class="btn btn-sm btn-warning">Edit</a>
                            <form action="{{ route('admin.buildings.destroy', $building->id) }}" method="POST" style="display:inline-block;">
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
