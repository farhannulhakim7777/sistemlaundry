<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Sistem Laundry Modern') - FreshWash Laundry</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600;700;800&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- FontAwesome 6 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Bootstrap 5 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">

    <style>
        :root {
            --primary: #4f46e5;
            --primary-hover: #4338ca;
            --primary-light: #e0e7ff;
            --secondary: #06b6d4;
            --accent: #10b981;
            --dark-bg: #0f172a;
            --card-bg: #ffffff;
            --text-main: #1e293b;
            --text-muted: #64748b;
            --border-color: #e2e8f0;
            --radius-lg: 16px;
            --radius-md: 12px;
            --shadow-sm: 0 2px 8px rgba(0,0,0,0.04);
            --shadow-md: 0 10px 25px -5px rgba(79,70,229,0.08), 0 8px 10px -6px rgba(0,0,0,0.04);
            --shadow-hover: 0 20px 30px -10px rgba(79,70,229,0.15);
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #f8fafc;
            color: var(--text-main);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        h1, h2, h3, h4, h5, h6 {
            font-family: 'Outfit', sans-serif;
        }

        /* Navbar */
        .navbar-custom {
            background: rgba(255,255,255,0.95);
            backdrop-filter: blur(12px);
            border-bottom: 1px solid rgba(226,232,240,0.8);
            padding: 0.8rem 0;
            position: sticky;
            top: 0;
            z-index: 1030;
        }

        .navbar-brand {
            font-size: 1.35rem;
            font-weight: 800;
            color: var(--primary) !important;
            display: flex;
            align-items: center;
            gap: 0.6rem;
        }

        .brand-icon {
            width: 38px;
            height: 38px;
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            color: white;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.1rem;
            box-shadow: 0 4px 12px rgba(79,70,229,0.3);
        }

        .nav-link {
            font-weight: 600;
            color: var(--text-main) !important;
            padding: 0.5rem 1rem !important;
            border-radius: 8px;
            transition: all 0.2s ease;
        }

        .nav-link:hover, .nav-link.active {
            color: var(--primary) !important;
            background-color: var(--primary-light);
        }

        .btn-theme-primary {
            background: linear-gradient(135deg, var(--primary), #6366f1);
            color: white !important;
            border: none;
            font-weight: 600;
            padding: 0.6rem 1.4rem;
            border-radius: var(--radius-md);
            box-shadow: 0 4px 14px rgba(79,70,229,0.3);
            transition: all 0.2s ease;
            text-decoration: none;
        }

        .btn-theme-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(79,70,229,0.4);
            color: white !important;
        }

        .btn-theme-outline {
            border: 2px solid var(--border-color);
            background: white;
            color: var(--text-main);
            font-weight: 600;
            padding: 0.55rem 1.2rem;
            border-radius: var(--radius-md);
            transition: all 0.2s ease;
            text-decoration: none;
        }

        .btn-theme-outline:hover {
            border-color: var(--primary);
            color: var(--primary);
            background: var(--primary-light);
        }

        /* Cards */
        .card-custom {
            background: var(--card-bg);
            border: 1px solid var(--border-color);
            border-radius: var(--radius-lg);
            box-shadow: var(--shadow-md);
            transition: all 0.3s ease;
            overflow: hidden;
        }

        .card-custom-hover:hover {
            transform: translateY(-4px);
            box-shadow: var(--shadow-hover);
        }

        /* Status Badges */
        .status-pill {
            padding: 0.35rem 0.85rem;
            border-radius: 50px;
            font-weight: 700;
            font-size: 0.78rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
        }

        .status-baru    { background:#dbeafe; color:#1e40af; }
        .status-diproses{ background:#fef3c7; color:#92400e; }
        .status-selesai { background:#d1fae5; color:#065f46; }
        .status-diambil { background:#f3e8ff; color:#6b21a8; }

        main { flex: 1; }

        /* Footer */
        footer {
            background: white;
            border-top: 1px solid var(--border-color);
            padding: 1.5rem 0;
            color: var(--text-muted);
            font-size: 0.9rem;
        }

        .fs-7 { font-size: 0.85rem; }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-custom">
    <div class="container">
        <a class="navbar-brand" href="{{ route('home') }}">
            <div class="brand-icon">
                <i class="fa-solid fa-soap"></i>
            </div>
            <span>FreshWash Laundry</span>
        </a>

        <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMain">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarMain">
            <ul class="navbar-nav ms-auto align-items-center gap-1 mt-3 mt-lg-0">
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">
                        <i class="fa-solid fa-house me-1"></i> Beranda
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('order.track') ? 'active' : '' }}" href="{{ route('order.track') }}">
                        <i class="fa-solid fa-magnifying-glass me-1"></i> Cek Status
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}">
                        <i class="fa-solid fa-gauge me-1"></i> Dashboard Admin
                    </a>
                </li>
                @if(session()->has('admin_id'))
                <li class="nav-item ms-lg-1">
                    <form action="{{ route('admin.logout') }}" method="POST" class="d-inline" id="logout-form">
                        @csrf
                        <button type="submit" class="nav-link border-0 bg-transparent text-danger fw-semibold px-3 py-2 w-100 text-start" title="Keluar">
                            <i class="fa-solid fa-right-from-bracket me-1"></i> Keluar
                        </button>
                    </form>
                </li>
                @endif
                <li class="nav-item ms-2">
                    <a class="btn-theme-primary btn px-4 py-2" href="{{ route('order.create') }}">
                        <i class="fa-solid fa-plus me-1"></i> Pesan Laundry
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<main class="py-4">
    <div class="container">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show rounded-4 border-0 shadow-sm mb-4" role="alert">
                <i class="fa-solid fa-circle-check me-2"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show rounded-4 border-0 shadow-sm mb-4" role="alert">
                <i class="fa-solid fa-triangle-exclamation me-2"></i> {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @yield('content')
    </div>
</main>

<footer>
    <div class="container">
        <div class="d-flex flex-column flex-sm-row justify-content-between align-items-center gap-2">
            <div class="fw-semibold text-dark">
                <i class="fa-solid fa-shirt text-primary me-1"></i> FreshWash Laundry System
            </div>
            <div>&copy; {{ date('Y') }} FreshWash Laundry. Semua hak cipta dilindungi.</div>
        </div>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
@stack('scripts')
</body>
</html>
