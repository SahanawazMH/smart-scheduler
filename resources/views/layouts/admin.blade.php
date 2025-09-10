<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - Smart Timetable Scheduler</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body {
            display: flex;
            min-height: 100vh;
            background-color: #f8f9fa;
        }

        .sidebar {
            width: 280px;
            background: #343a40;
            color: #fff;
            position: fixed;
            top: 0;
            bottom: 0;
            left: 0;
            padding-top: 1rem;
            overflow-y: auto;
            z-index: 999;
        }

        .sidebar .nav-link {
            color: #adb5bd;
            font-size: 1rem;
            padding: 0.75rem 1.5rem;
        }

        .sidebar .nav-link:hover,
        .sidebar .nav-link.active {
            color: #fff;
            background-color: #495057;
        }

        .sidebar .nav-link .bi {
            margin-right: 10px;
        }

        .main-content {
            margin-left: 280px;
            padding: 2rem;
            width: calc(100% - 280px);
        }

        .sidebar-header {
            padding: 0 1.5rem 1rem;
            border-bottom: 1px solid #495057;
            margin-bottom: 1rem;
        }

        .d-sm-none-sm {
            display: none;
        }

        @media (max-width: 768px) {
            .sidebar {
                left: -280px;
                transition: left 0.3s ease;
            }

            .sidebar.active {
                left: 0;
            }

            .main-content {
                margin-left: 0;
                width: 100%;
            }

            .topbar {
                display: flex;
            }

            .d-sm-none-sm {
                display: block;
            }
        }
    </style>
</head>

<body>

    <!-- Sidebar -->
    <div class="sidebar" id="sidebar">
        <div class="sidebar-header d-flex align-items-center justify-content-between">
            <h4>Admin Panel</h4>
            <div class="d-sm-none-sm" id="sidebarToggleBtn2">
                <i class="bi bi-x-lg"></i>
            </div>
        </div>
        <ul class="nav flex-column">
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}"
                    href="{{ route('admin.dashboard') }}">
                    <i class="bi bi-grid-fill"></i> Dashboard
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('admin.buildings.*') ? 'active' : '' }}"
                    href="{{ route('admin.buildings.index') }}">
                    <i class="bi bi-building"></i> Manage Buildings
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('admin.classrooms.*') ? 'active' : '' }}"
                    href="{{ route('admin.classrooms.index') }}">
                    <i class="bi bi-door-open-fill"></i> Manage Classrooms
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('admin.courses.*') ? 'active' : '' }}"
                    href="{{ route('admin.courses.index') }}">
                    <i class="bi bi-journal-bookmark-fill"></i> Manage Courses
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('admin.sections.*') ? 'active' : '' }}"
                    href="{{ route('admin.sections.index') }}">
                    <i class="bi bi-stack"></i>
                    <span>Sections</span></a>
            </li>
            <li class="nav-item {{ request()->routeIs('admin.student-groups.*') ? 'active' : '' }}"
                href="{{ route('admin.student-groups.index') }}">
                <a class="nav-link" href="{{ route('admin.student-groups.index') }}">
                    <i class="bi bi-people"></i>
                    <span>Student Groups</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('admin.subjects.*') ? 'active' : '' }}"
                    href="{{ route('admin.subjects.index') }}">
                    <i class="bi bi-book-fill"></i> Manage Subjects
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('admin.teachers.*') ? 'active' : '' }}"
                    href="{{ route('admin.teachers.index') }}">
                    <i class="bi bi-person-video3"></i> Manage Teachers
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('admin.students.*') ? 'active' : '' }}"
                    href="{{ route('admin.students.index') }}">
                    <i class="bi bi-people-fill"></i> Manage Students
                </a>
            </li>
            <li class="nav-item mt-3 pt-3 border-top border-secondary">
                <a class="nav-link {{ request()->routeIs('admin.timetable.generator') ? 'active' : '' }}"
                    href="{{ route('admin.timetable.generator') }}">
                    <i class="bi bi-gear-wide-connected"></i> Generate Timetable
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('admin.timetable.view') ? 'active' : '' }}"
                    href="{{ route('admin.timetable.view') }}">
                    <i class="bi bi-table"></i> View Timetable
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('admin.timetable.view') ? 'active' : '' }}"
                    href="{{ route('profile.change-password.form') }}">
                    <i class="bi bi-key-fill"></i> Change Password
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('logout') }}"
                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class="bi bi-box-arrow-right"></i> Logout
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
            </li>
        </ul>
    </div>

    <!-- Main Content -->
    <main class="main-content">
        <!-- Topbar for mobile -->
        <nav class="navbar navbar-light bg-light mb-4 d-md-none">
            <div class="container-fluid">
                <button class="navbar-toggler" type="button" id="sidebarToggleBtn">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <span class="navbar-brand mb-0 h1">Admin Menu</span>

            </div>
        </nav>
        @yield('content')
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Basic sidebar toggle for mobile
        document.getElementById('sidebarToggleBtn').addEventListener('click', function() {
            document.getElementById('sidebar').classList.toggle('active');
        });
        // Basic sidebar toggle for mobile
        document.getElementById('sidebarToggleBtn2').addEventListener('click', function() {
            document.getElementById('sidebar').classList.toggle('active');
        });
    </script>
    @stack('scripts')
</body>

</html>
