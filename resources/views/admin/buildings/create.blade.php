@extends('layouts.admin')

@section('content')
<div class="container">
    <h1>Add New Building</h1>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('admin.buildings.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="name" class="form-label">Building Name</label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}">
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="number" class="form-label">Building Number</label>
                    <input type="text" class="form-control @error('number') is-invalid @enderror" id="number" name="number" value="{{ old('number') }}">
                    @error('number')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <button type="submit" class="btn btn-primary">Save Building</button>
                <a href="{{ route('admin.buildings.index') }}" class="btn btn-secondary">Cancel</a>
            </form>
        </div>
    </div>
</div>
@endsection
