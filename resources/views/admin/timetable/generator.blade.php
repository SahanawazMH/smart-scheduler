@extends('layouts.admin')

@section('title', 'Generate Timetable')

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Timetable Generator</h1>
    </div>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if (session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <div class="row">
        <div class="col-lg-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Generate New Timetable</h6>
                </div>
                <div class="card-body">
                    <p>Click the button below to run the intelligent scheduling algorithm. This will delete the old timetable and generate a new, optimized schedule based on all the current data and constraints.</p>
                    <p class="text-warning small"><strong>Warning:</strong> This process can take a few moments to complete. Please do not close this window after starting.</p>
                    <form action="{{ route('admin.timetable.generate') }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-primary btn-lg w-100">
                            <i class="bi bi-gear-wide-connected me-2"></i> Generate Timetable Now
                        </button>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
             @if (session('generationResult'))
                @php $result = session('generationResult'); @endphp
                <div class="card shadow mb-4">
                    <div class="card-header py-3 bg-danger">
                        <h6 class="m-0 font-weight-bold text-white">Conflict Report</h6>
                    </div>
                    <div class="card-body">
                        <p>The following classes could not be scheduled:</p>
                        @if (empty($result['conflict_report']))
                            <div class="alert alert-success"><strong>Excellent!</strong> All classes were scheduled successfully.</div>
                        @else
                            <ul class="list-group">
                                @foreach ($result['conflict_report'] as $conflict)
                                    <li class="list-group-item">
                                        <strong>Subject:</strong> {{ $conflict['subject']->name }} for
                                        <strong>Section:</strong> {{ $conflict['section']->name }}
                                        <br>
                                        <small class="text-danger">Reason: {{ $conflict['reason'] ?? 'Could not find a valid slot due to teacher, room, or section conflicts.' }}</small>
                                    </li>
                                @endforeach
                            </ul>
                        @endif
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
