<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Schedule</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body {
            background-color: #f4f7f6;
        }

        .timetable-grid-container {
            overflow-x: auto;
            /* Enable horizontal scrolling on small screens */
        }

        .timetable-grid {
            display: grid;
            grid-template-columns: 120px repeat(5, 1fr);
            /* Time slot column + 5 days */
            gap: 5px;
            min-width: 700px;
            /* Ensure grid has a minimum width */
        }

        .grid-header,
        .grid-cell,
        .time-slot {
            padding: 1rem;
            border-radius: 8px;
            text-align: center;
        }

        .grid-header {
            background-color: #198754;
            color: white;
            font-weight: bold;
        }

        .time-slot {
            background-color: #6c757d;
            color: white;
            font-weight: bold;
        }

        .grid-cell {
            background-color: #fff;
            min-height: 120px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
        }

        .class-entry {
            font-size: 0.9rem;
            padding: 0.5rem;
            margin-bottom: 4px;
            border-radius: 6px;
            background-color: #e2e3e5;
            border-left: 5px solid #198754;
            text-align: left;
        }
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="#">
                <i class="bi bi-calendar-check-fill"></i>
                Smart Scheduler
            </a>
            <ul class="navbar-nav ms-auto">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="bi bi-person-circle"></i> {{ Auth::user()->name }}
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                        <li><a class="dropdown-item" href="{{ route('profile.change-password.form') }}"><i
                                    class="bi bi-key-fill"></i> Change Password</a></li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li>
                            <a class="dropdown-item" href="{{ route('logout') }}"
                                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                <i class="bi bi-box-arrow-right"></i> Logout
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </nav>

    <div class="container mt-4">
        <h1 class="mb-4">My Weekly Schedule</h1>

        <div class="card shadow-sm">
            <div class="card-body">
                <div class="timetable-grid-container">
                    @php
                        $timeSlots = [
                            '09:00:00',
                            '10:00:00',
                            '11:00:00',
                            '12:00:00',
                            '13:00:00',
                            '14:00:00',
                            '15:00:00',
                            '16:00:00',
                        ];
                        $days = [
                            '1' => 'Monday',
                            '2' => 'Tuesday',
                            '3' => 'Wednesday',
                            '4' => 'Thursday',
                            '5' => 'Friday',
                        ];
                    @endphp
                    <div class="timetable-grid">
                        <div class="grid-header">Time</div>
                        @foreach ($days as $day)
                            <div class="grid-header">{{ $day }}</div>
                        @endforeach

                        @foreach ($timeSlots as $time)
                            <div class="time-slot">{{ \Carbon\Carbon::parse($time)->format('h:i A') }}</div>
                            @foreach ($days as $dayKey => $dayName)
                                <div class="grid-cell">
                                    @if (isset($timetables[$dayKey][$time]))
                                        @foreach ($timetables[$dayKey][$time] as $entry)
                                            <div class="class-entry">
                                                <strong>{{ $entry->subject->name }}</strong><br>
                                                <small class="text-muted">
                                                    <i class="bi bi-people-fill"></i>
                                                    @if ($entry->student_group_id)
                                                        {{ $entry->section->name }} ({{ $entry->studentGroup->name }})
                                                    @else
                                                        {{ $entry->section->name }}
                                                    @endif
                                                    <br>
                                                    <i class="bi bi-geo-alt-fill"></i>
                                                    {{ $entry->classroom->room_number }}
                                                    ({{ $entry->classroom->building->name }})
                                                </small>
                                            </div>
                                        @endforeach
                                    @else
                                        <span class="text-muted fst-italic">Free</span>
                                    @endif
                                </div>
                            @endforeach
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
