@extends('layouts.admin')

@section('content')
<div class="container">
    <h1>Assign Subjects to: {{ $teacher?->user?->name }}</h1>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('admin.teachers.storeAssignedSubjects', $teacher->id) }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label class="form-label">Select Subjects</label>
                    <p class="text-muted">Choose all subjects this teacher is qualified to teach.</p>
                    
                    <div class="row">
                        @foreach($subjects as $subject)
                            <div class="col-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" 
                                           type="checkbox" 
                                           name="subjects[]" 
                                           value="{{ $subject->id }}" 
                                           id="subject-{{ $subject->id }}"
                                           {{ in_array($subject->id, $assignedSubjectIds) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="subject-{{ $subject->id }}">
                                        {{ $subject->name }} ({{ $subject->code }})
                                    </label>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <button type="submit" class="btn btn-primary">Save Assignments</button>
                <a href="{{ route('admin.teachers.index') }}" class="btn btn-secondary">Cancel</a>
            </form>
        </div>
    </div>
</div>
@endsection
