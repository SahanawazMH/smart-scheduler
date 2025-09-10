@extends('layouts.admin')

@section('title', 'Manage Unavailability for ' . $teacher->user->name)

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800">Manage Unavailability</h1>
            <p class="mb-0 text-muted">For Teacher: <strong>{{ $teacher->user->name }}</strong></p>
        </div>
        <a href="{{ route('admin.teachers.index') }}" class="btn btn-sm btn-primary shadow-sm"><i class="bi bi-arrow-left me-2"></i>Back to Teachers</a>
    </div>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="row">
        <!-- Add New Unavailability Form -->
        <div class="col-lg-5">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Add New Unavailability Slot</h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.teachers.unavailability.store', $teacher->id) }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="day_of_week" class="form-label">Day of the Week</label>
                            <select name="day_of_week" id="day_of_week" class="form-select" required>
                                <option value="">Select a day...</option>
                                <option value="1">Monday</option>
                                <option value="2">Tuesday</option>
                                <option value="3">Wednesday</option>
                                <option value="4">Thursday</option>
                                <option value="5">Friday</option>
                                <option value="6">Saturday</option>
                                <option value="7">Sunday</option>
                            </select>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="start_time" class="form-label">Start Time</label>
                                <input type="time" name="start_time" id="start_time" class="form-control" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="end_time" class="form-label">End Time</label>
                                <input type="time" name="end_time" id="end_time" class="form-control" required>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Add Slot</button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Existing Unavailability List -->
        <div class="col-lg-7">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Current Unavailability</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Day</th>
                                    <th>Start Time</th>
                                    <th>End Time</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($teacher->unavailabilities as $slot)
                                <tr>
                                    <td>{{ ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'][$slot->day_of_week - 1] }}</td>
                                    <td>{{ \Carbon\Carbon::parse($slot->start_time)->format('h:i A') }}</td>
                                    <td>{{ \Carbon\Carbon::parse($slot->end_time)->format('h:i A') }}</td>
                                    <td>
                                        <form action="{{ route('admin.teachers.unavailability.destroy', $slot->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')"><i class="bi bi-trash"></i></button>
                                        </form>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="text-center">No unavailability slots have been set.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
