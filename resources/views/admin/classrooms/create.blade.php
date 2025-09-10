@extends('layouts.admin')

@section('content')
<div class="container">
    <h1>Add New Classroom</h1>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('admin.classrooms.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="room_number" class="form-label">Room Number</label>
                    <input type="text" class="form-control @error('room_number') is-invalid @enderror" id="room_number" name="room_number" value="{{ old('room_number') }}" placeholder="e.g., 301A">
                    @error('room_number')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="building_id" class="form-label">Building</label>
                    <select class="form-control @error('building_id') is-invalid @enderror" id="building_id" name="building_id">
                        <option value="">Select a Building</option>
                        @foreach($buildings as $building)
                            <option value="{{ $building->id }}" {{ old('building_id') == $building->id ? 'selected' : '' }}>{{ $building->name }}</option>
                        @endforeach
                    </select>
                    @error('building_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="capacity" class="form-label">Capacity</label>
                    <input type="number" class="form-control @error('capacity') is-invalid @enderror" id="capacity" name="capacity" value="{{ old('capacity') }}">
                    @error('capacity')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="type" class="form-label">Room Type</label>
                    <select class="form-control @error('type') is-invalid @enderror" id="type" name="type">
                        <option value="classroom" {{ old('type') == 'classroom' ? 'selected' : '' }}>Classroom</option>
                        <option value="lab" {{ old('type') == 'lab' ? 'selected' : '' }}>Lab</option>
                    </select>
                    @error('type')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary">Save Classroom</button>
                <a href="{{ route('admin.classrooms.index') }}" class="btn btn-secondary">Cancel</a>
            </form>
        </div>
    </div>
</div>
@endsection
