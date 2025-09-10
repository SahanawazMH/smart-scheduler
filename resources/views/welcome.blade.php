<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Smart Timetable Scheduler - Intelligent Scheduling, Simplified</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            color: #333;
        }

        .navbar {
            padding: 1rem 0;
            transition: all 0.3s ease;
        }

        .navbar-brand {
            font-weight: 700;
            font-size: 1.5rem;
        }

        .hero {
            background: linear-gradient(rgba(248, 249, 250, 0.8), rgba(248, 249, 250, 0.8)), url('https://images.unsplash.com/photo-1522202176988-66273c2fd55f?q=80&w=2071&auto=format&fit=crop') no-repeat center center;
            background-size: cover;
            padding: 8rem 0;
            text-align: center;
        }

        .hero h1 {
            font-size: 3.5rem;
            font-weight: 700;
            color: #212529;
        }

        .hero p {
            font-size: 1.25rem;
            color: #495057;
            max-width: 600px;
            margin: 1rem auto;
        }

        .btn-primary {
            background-color: #0d6efd;
            border-color: #0d6efd;
            padding: 0.75rem 1.5rem;
            font-weight: 600;
            border-radius: 0.5rem;
        }

        .section {
            padding: 5rem 0;
        }

        .section-title {
            text-align: center;
            margin-bottom: 3rem;
            font-weight: 700;
            font-size: 2.5rem;
        }

        .feature-card {
            border: none;
            border-radius: 1rem;
            padding: 2rem;
            text-align: center;
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.08);
            transition: transform 0.3s ease;
            background-color: #fff;
            height: 100%;
        }

        .feature-card:hover {
            transform: translateY(-10px);
        }

        .feature-icon {
            font-size: 3rem;
            color: #0d6efd;
            margin-bottom: 1.5rem;
        }

        .cta-section {
            background-color: #0d6efd;
            color: #fff;
            padding: 5rem 0;
            text-align: center;
        }

        .cta-section h2 {
            font-weight: 700;
        }

        .footer {
            background-color: #343a40;
            color: #fff;
            padding: 2rem 0;
            text-align: center;
        }
    </style>
</head>

<body>

    <!-- Navigation Bar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light sticky-top">
        <div class="container">
            <a class="navbar-brand" href="#">Scheduler</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="#features">Features</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#benefits">Benefits</a>
                    </li>
                    <li class="nav-item ms-lg-2">
                        @auth
                            <a class="btn btn-outline-primary" href="{{ route('logout') }}"
                                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                Logout
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                            <a class="btn-sm btn btn-primary" href="{{ route('dashboard') }}">Dashboard</a>
                        @else
                            <a class="btn btn-outline-primary" href="{{ route('login') }}">Login</a>
                        @endauth
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <header class="hero">
        <div class="container">
            <h1>Intelligent Scheduling, Simplified.</h1>
            <p>Our powerful algorithm automates timetable creation, eliminates conflicts, and optimizes resource use for
                your entire institution.</p>
        </div>
    </header>

    <!-- Features Section -->
    <section id="features" class="section bg-light">
        <div class="container">
            <h2 class="section-title">Why Choose Smart Scheduler?</h2>
            <div class="row g-4">
                <div class="col-lg-4 d-flex align-items-stretch">
                    <div class="feature-card">
                        <div class="feature-icon">⚙️</div>
                        <h3>Automated Engine</h3>
                        <p>Generate multiple, optimized, and conflict-free timetable options in minutes, not weeks. Our
                            heuristic algorithm finds the best possible schedule for you.</p>
                    </div>
                </div>
                <div class="col-lg-4 d-flex align-items-stretch">
                    <div class="feature-card">
                        <div class="feature-icon">📊</div>
                        <h3>Granular Control</h3>
                        <p>Easily manage complex scenarios like parallel lab sessions with our Course → Section →
                            Student Group hierarchy, ensuring every class is perfectly placed.</p>
                    </div>
                </div>
                <div class="col-lg-4 d-flex align-items-stretch">
                    <div class="feature-card">
                        <div class="feature-icon">👥</div>
                        <h3>Role-Based Dashboards</h3>
                        <p>Provide dedicated, clutter-free dashboards for Admins, Teachers, and Students with
                            role-specific features and views, improving everyone's experience.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Benefits Section -->
    <section id="benefits" class="section">
        <div class="container">
            <h2 class="section-title">Benefits for Everyone</h2>
            <div class="row text-center g-4">
                <div class="col-md-4">
                    <h4>For Administrators</h4>
                    <p class="lead">Drastically reduce administrative workload and gain data-driven insights for
                        better resource planning.</p>
                </div>
                <div class="col-md-4">
                    <h4>For Teachers</h4>
                    <p class="lead">Receive a clear, fair, and balanced schedule that reduces stress and lets you
                        focus on teaching.</p>
                </div>
                <div class="col-md-4">
                    <h4>For Students</h4>
                    <p class="lead">Access a stable, predictable, and easy-to-understand timetable, improving the
                        overall learning experience.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Call to Action Section -->
    <section class="cta-section">
        <div class="container">
            <h2 class="mb-4">Ready to Revolutionize Your Timetabling?</h2>
            <p class="lead mb-4">Join hundreds of institutions already saving time and reducing stress.</p>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <p>&copy; 2025 Smart Timetable Scheduler. All Rights Reserved.</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
