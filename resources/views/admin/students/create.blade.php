@extends('layouts.admin')

@section('title', 'Add New Student')

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Add New Student</h1>
        <a href="{{ route('admin.students.index') }}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="bi bi-arrow-left me-2"></i>Back to Students</a>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">New Student Form</h6>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.students.store') }}" method="POST">
                @csrf
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="name" class="form-label">Full Name</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" required>
                        @error('name')<span class="invalid-feedback"><strong>{{ $message }}</strong></span>@enderror
                    </div>
                    <div class="col-md-6">
                        <label for="email" class="form-label">Email Address</label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}" required>
                        @error('email')<span class="invalid-feedback"><strong>{{ $message }}</strong></span>@enderror
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" required>
                        @error('password')<span class="invalid-feedback"><strong>{{ $message }}</strong></span>@enderror
                    </div>
                    <div class="col-md-6">
                        <label for="password-confirm" class="form-label">Confirm Password</label>
                        <input type="password" class="form-control" id="password-confirm" name="password_confirmation" required>
                    </div>
                </div>

                <hr>

                <div class="row mb-3">
                     <div class="col-md-6">
                        <label for="roll_number" class="form-label">Roll Number</label>
                        <input type="text" class="form-control @error('roll_number') is-invalid @enderror" id="roll_number" name="roll_number" value="{{ old('roll_number') }}" required>
                        @error('roll_number')<span class="invalid-feedback"><strong>{{ $message }}</strong></span>@enderror
                    </div>
                    <div class="col-md-6">
                        <label for="course_id" class="form-label">Course</label>
                        <select class="form-select @error('course_id') is-invalid @enderror" id="course_id" name="course_id" required>
                            <option value="">Select a Course</option>
                            @foreach ($courses as $course)
                                <option value="{{ $course->id }}" {{ old('course_id') == $course->id ? 'selected' : '' }}>{{ $course->name }}</option>
                            @endforeach
                        </select>
                        @error('course_id')<span class="invalid-feedback"><strong>{{ $message }}</strong></span>@enderror
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="section_id" class="form-label">Section</label>
                        <select class="form-select @error('section_id') is-invalid @enderror" id="section_id" name="section_id" required disabled>
                            <option value="">Select a Course First</option>
                        </select>
                        @error('section_id')<span class="invalid-feedback"><strong>{{ $message }}</strong></span>@enderror
                    </div>
                    <div class="col-md-6">
                        <label for="student_group_id" class="form-label">Student Group (Optional)</label>
                        <select class="form-select @error('student_group_id') is-invalid @enderror" id="student_group_id" name="student_group_id" disabled>
                             <option value="">Select a Section First</option>
                        </select>
                        @error('student_group_id')<span class="invalid-feedback"><strong>{{ $message }}</strong></span>@enderror
                    </div>
                </div>

                <button type="submit" class="btn btn-primary w-100">
                    Create Student
                </button>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const courseSelect = document.getElementById('course_id');
    const sectionSelect = document.getElementById('section_id');
    const groupSelect = document.getElementById('student_group_id');

    courseSelect.addEventListener('change', function () {
        const courseId = this.value;
        sectionSelect.innerHTML = '<option value="">Loading...</option>';
        sectionSelect.disabled = true;
        groupSelect.innerHTML = '<option value="">Select a Section First</option>';
        groupSelect.disabled = true;

        if (courseId) {
            fetch(`/admin/api/courses/${courseId}/sections`)
                .then(response => {
                    if (!response.ok) { throw new Error('Network response was not ok'); }
                    return response.json();
                })
                .then(data => {
                    sectionSelect.innerHTML = '<option value="">Select a Section</option>';
                    data.forEach(section => {
                        sectionSelect.innerHTML += `<option value="${section.id}">${section.name}</option>`;
                    });
                    sectionSelect.disabled = false;
                })
                .catch(error => {
                    console.error('Error fetching sections:', error);
                    sectionSelect.innerHTML = '<option value="">Could not load sections</option>';
                });
        } else {
            sectionSelect.innerHTML = '<option value="">Select a Course First</option>';
        }
    });

    sectionSelect.addEventListener('change', function () {
        const sectionId = this.value;
        groupSelect.innerHTML = '<option value="">Loading...</option>';
        groupSelect.disabled = true;

        if (sectionId) {
            fetch(`/admin/api/sections/${sectionId}/student-groups`)
                .then(response => {
                    if (!response.ok) { throw new Error('Network response was not ok'); }
                    return response.json();
                })
                .then(data => {
                    groupSelect.innerHTML = '<option value="">None</option>';
                    data.forEach(group => {
                        groupSelect.innerHTML += `<option value="${group.id}">${group.name}</option>`;
                    });
                    groupSelect.disabled = false;
                })
                .catch(error => {
                    console.error('Error fetching student groups:', error);
                    groupSelect.innerHTML = '<option value="">Could not load groups</option>';
                });
        } else {
            groupSelect.innerHTML = '<option value="">Select a Section First</option>';
        }
    });
});
</script>
@endpush

