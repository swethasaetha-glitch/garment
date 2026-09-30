<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Track Tech Solutions') - Garment Production Management</title>
    <!-- Google Fonts: Inter & JetBrains Mono -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=JetBrains+Mono:wght@500;600&display=swap" rel="stylesheet">
    <!-- Bootstrap 5 CSS & Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <!-- ApexCharts CDN -->
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <!-- Vite Assets -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        :root {
            --sidebar-width: 250px;
            --brand-primary: #1d4ed8;
            --brand-primary-hover: #1e40af;
            --text-main: #0f172a;
            --text-muted: #64748b;
            --bg-canvas: #f8fafc;
            --border-color: #e2e8f0;
            --radius-sm: 6px;
            --radius-md: 8px;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            background-color: var(--bg-canvas);
            color: var(--text-main);
            min-height: 100vh;
            font-size: 0.875rem;
            line-height: 1.5;
            -webkit-font-smoothing: antialiased;
        }

        .sidebar {
            width: var(--sidebar-width);
            background-color: #0f172a;
            height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            z-index: 1000;
            display: flex;
            flex-direction: column;
            border-right: 1px solid #1e293b;
        }

        .brand-header {
            padding: 1.15rem 1.25rem;
            border-bottom: 1px solid #1e293b;
            background: #0f172a;
        }

        .brand-title {
            font-size: 1.05rem;
            font-weight: 800;
            color: #ffffff;
            letter-spacing: -0.01em;
            margin: 0;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .brand-icon {
            width: 26px;
            height: 26px;
            background: var(--brand-primary);
            color: #ffffff;
            border-radius: var(--radius-sm);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 0.85rem;
            font-weight: 800;
        }

        .brand-sub {
            font-size: 0.65rem;
            font-weight: 700;
            color: #f59e0b;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            margin-top: 2px;
        }

        .sidebar-user-card {
            padding: 0.75rem 1rem;
            border-bottom: 1px solid #1e293b;
            background: #0b1120;
        }

        .sidebar-scroll {
            flex: 1;
            overflow-y: auto;
            padding: 0.75rem 0.5rem;
        }

        .sidebar-scroll::-webkit-scrollbar {
            width: 4px;
        }
        .sidebar-scroll::-webkit-scrollbar-thumb {
            background: #334155;
            border-radius: 9999px;
        }

        .nav-section-title {
            font-size: 0.65rem;
            font-weight: 800;
            color: #64748b;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            padding: 0.85rem 0.75rem 0.35rem 0.75rem;
        }

        .sidebar .nav-link {
            color: #94a3b8;
            font-weight: 500;
            font-size: 0.825rem;
            padding: 0.48rem 0.75rem;
            border-radius: var(--radius-sm);
            display: flex;
            align-items: center;
            gap: 9px;
            transition: all 0.12s ease-in-out;
            margin-bottom: 2px;
            border-left: 3px solid transparent;
        }

        .sidebar .nav-link i {
            font-size: 0.95rem;
            color: #64748b;
        }

        .sidebar .nav-link:hover {
            color: #ffffff;
            background-color: #1e293b;
        }

        .sidebar .nav-link:hover i {
            color: #38bdf8;
        }

        .sidebar .nav-link.active {
            color: #ffffff;
            background-color: #1e293b;
            font-weight: 600;
            border-left-color: var(--brand-primary);
        }

        .sidebar .nav-link.active i {
            color: #60a5fa;
        }

        .sidebar-user {
            padding: 0.85rem 1rem;
            border-top: 1px solid #1e293b;
            background: #0f172a;
        }

        .main-wrapper {
            margin-left: var(--sidebar-width);
            padding: 1.5rem 2rem;
            min-height: 100vh;
        }

        .top-navbar {
            background: #ffffff;
            border: 1px solid var(--border-color);
            border-radius: var(--radius-md);
            padding: 0.85rem 1.25rem;
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .breadcrumb-label {
            font-size: 0.7rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.06em;
            color: #64748b;
            margin-bottom: 2px;
        }

        .top-page-header-title {
            font-size: 1.25rem;
            font-weight: 700;
            color: var(--text-main);
            letter-spacing: -0.015em;
            margin: 0;
        }

        .top-page-header-subtitle {
            font-size: 0.8rem;
            color: var(--text-muted);
            margin: 0;
        }

        .card-ent {
            background: #ffffff;
            border: 1px solid var(--border-color);
            border-radius: var(--radius-md);
            box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.03);
        }

        .card-ent-body { padding: 1.25rem; }

        .badge-ent {
            font-size: 0.7rem;
            font-weight: 600;
            padding: 2px 8px;
            border-radius: var(--radius-sm);
            display: inline-flex;
            align-items: center;
            gap: 4px;
            line-height: 1.4;
            white-space: nowrap;
        }

        .badge-ent-emerald { background: #f0fdf4; color: #15803d; border: 1px solid #bbf7d0; }
        .badge-ent-blue { background: #eff6ff; color: #1d4ed8; border: 1px solid #bfdbfe; }
        .badge-ent-amber { background: #fffbeb; color: #b45309; border: 1px solid #fde68a; }
        .badge-ent-rose { background: #fff1f2; color: #be123c; border: 1px solid #fecdd3; }
        .badge-ent-slate { background: #f8fafc; color: #334155; border: 1px solid #e2e8f0; }

        .btn-ent-primary {
            background-color: var(--brand-primary);
            color: #ffffff;
            font-weight: 600;
            font-size: 0.8125rem;
            padding: 0.45rem 0.95rem;
            border-radius: var(--radius-sm);
            border: 1px solid var(--brand-primary);
            display: inline-flex;
            align-items: center;
            gap: 6px;
            text-decoration: none;
            transition: background-color 0.15s ease;
        }

        .btn-ent-primary:hover {
            background-color: var(--brand-primary-hover);
            border-color: var(--brand-primary-hover);
            color: #ffffff;
        }

        .btn-ent-outline {
            background-color: #ffffff;
            border: 1px solid var(--border-color);
            color: var(--text-main);
            font-weight: 600;
            font-size: 0.8125rem;
            padding: 0.45rem 0.95rem;
            border-radius: var(--radius-sm);
            display: inline-flex;
            align-items: center;
            gap: 6px;
            text-decoration: none;
            transition: all 0.15s ease;
        }

        .btn-ent-outline:hover {
            background-color: #f8fafc;
            border-color: #cbd5e1;
            color: var(--text-main);
        }

        .form-control-ent, .form-select-ent {
            border: 1px solid var(--border-color);
            border-radius: var(--radius-sm);
            padding: 0.45rem 0.75rem;
            font-size: 0.8125rem;
            font-weight: 400;
            color: var(--text-main);
            background-color: #ffffff;
        }

        .form-control-ent:focus, .form-select-ent:focus {
            border-color: var(--brand-primary);
            box-shadow: 0 0 0 2px rgba(29, 78, 216, 0.12);
        }

        .font-mono-num {
            font-family: 'JetBrains Mono', monospace;
        }

        @media (max-width: 992px) {
            .sidebar {
                position: relative;
                width: 100%;
                height: auto;
            }
            .main-wrapper {
                margin-left: 0;
                padding: 1rem;
            }
        }
    </style>
    @stack('styles')
</head>
<body>

    @auth
    <!-- Sidebar Matching Complete Production Sequence -->
    <aside class="sidebar">
        <!-- Brand Header -->
        <div class="brand-header">
            <h1 class="brand-title">
                <span class="brand-icon">T</span> Track Tech Solutions
            </h1>
            <div class="brand-sub">Digital Intelligence ERP</div>
        </div>

        <!-- Scrollable Navigation -->
        <div class="sidebar-scroll">
            <div class="nav-section-title">Overview</div>
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">
                        <i class="bi bi-grid-1x2-fill"></i> Dashboard
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('production.bundles') ? 'active' : '' }}" href="{{ route('production.bundles') }}">
                        <i class="bi bi-qr-code"></i> Bundle / QR Tracking
                    </a>
                </li>
            </ul>

            <div class="nav-section-title">Orders & Planning</div>
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('buyer-orders.*') || request()->routeIs('sales-orders.*') ? 'active' : '' }}" href="{{ route('sales-orders.index') }}">
                        <i class="bi bi-receipt"></i> Orders (PO & ERP)
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('production-plans.*') ? 'active' : '' }}" href="{{ route('production-plans.index') }}">
                        <i class="bi bi-calendar3"></i> Production Planning
                    </a>
                </li>
            </ul>

            <div class="nav-section-title">Fabric ERP & Store</div>
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('fabric-pos.*') ? 'active' : '' }}" href="{{ route('fabric-pos.index') }}">
                        <i class="bi bi-bag-plus"></i> Material Receiving
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('fabric-grns.*') ? 'active' : '' }}" href="{{ route('fabric-grns.index') }}">
                        <i class="bi bi-box-arrow-in-down"></i> GRN
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('fabric-inspections.*') ? 'active' : '' }}" href="{{ route('fabric-inspections.index') }}">
                        <i class="bi bi-patch-check"></i> Inspection
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('fabrics.*') ? 'active' : '' }}" href="{{ route('fabrics.index') }}">
                        <i class="bi bi-aspect-ratio"></i> Fabric Store
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('fabric-relaxations.*') ? 'active' : '' }}" href="{{ route('fabric-relaxations.index') }}">
                        <i class="bi bi-hourglass-split"></i> Relaxation
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('fabric-reservations.*') ? 'active' : '' }}" href="{{ route('fabric-reservations.index') }}">
                        <i class="bi bi-bookmark-check"></i> Reservation
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('fabric-groups.*') ? 'active' : '' }}" href="{{ route('fabric-groups.index') }}">
                        <i class="bi bi-collection"></i> Fabric Grouping
                    </a>
                </li>
            </ul>

            <div class="nav-section-title">Cut Room & CAD</div>
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('cut-planning.*') ? 'active' : '' }}" href="{{ route('cut-planning.index') }}">
                        <i class="bi bi-rulers"></i> Pattern / CAD
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('lay-models.*') ? 'active' : '' }}" href="{{ route('lay-models.index') }}">
                        <i class="bi bi-bounding-box"></i> Lay Models
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('lay-slips.*') ? 'active' : '' }}" href="{{ route('lay-slips.index') }}">
                        <i class="bi bi-grid-3x3-gap"></i> Marker (Lay Slips)
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('production.cutting') ? 'active' : '' }}" href="{{ route('production.cutting') }}">
                        <i class="bi bi-scissors"></i> Cutting
                    </a>
                </li>
            </ul>

            <div class="nav-section-title">Production Sections</div>
            <ul class="nav flex-column mb-3">
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('production.sewing') ? 'active' : '' }}" href="{{ route('production.sewing') }}">
                        <i class="bi bi-gear-wide-connected"></i> Sewing / Production
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('production.quality') ? 'active' : '' }}" href="{{ route('production.quality') }}">
                        <i class="bi bi-shield-check"></i> Quality Control
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('production.washing') ? 'active' : '' }}" href="{{ route('production.washing') }}">
                        <i class="bi bi-droplet-fill"></i> Washing / Laser
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('production.packing') ? 'active' : '' }}" href="{{ route('production.packing') }}">
                        <i class="bi bi-box-seam"></i> Finishing (Packing)
                    </a>
                </li>
            </ul>
        </div>

        <!-- User Profile Footer -->
        <div class="sidebar-user">
            <div class="d-flex align-items-center justify-content-between">
                <div class="d-flex align-items-center gap-2 overflow-hidden" style="max-width: 145px;">
                    <div class="bg-primary text-white rounded d-flex align-items-center justify-content-center font-bold" style="width: 28px; height: 28px; min-width: 28px; font-size: 0.75rem; background-color: var(--brand-primary) !important;">
                        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                    </div>
                    <div class="text-truncate">
                        <div class="fw-semibold text-slate-900 small text-truncate" style="line-height: 1.2;">{{ Auth::user()->name }}</div>
                        <div class="text-muted small" style="font-size: 0.68rem;">{{ Auth::user()->role }}</div>
                    </div>
                </div>

                <form action="{{ route('logout') }}" method="POST" class="m-0">
                    @csrf
                    <button type="submit" class="btn btn-sm btn-outline-secondary rounded px-2 py-0.5 fw-semibold" style="font-size: 0.7rem;" title="Logout">
                        Logout
                    </button>
                </form>
            </div>
        </div>
    </aside>
    @endauth

    <!-- Main Workspace -->
    <main class="{{ Auth::check() ? 'main-wrapper' : 'container py-5' }}">
        @auth
        <!-- Header Bar -->
        <div class="top-navbar">
            <div>
                <div class="breadcrumb-label">TRACK TECH SOLUTIONS / {{ Request::segment(1) ? strtoupper(Request::segment(1)) : 'DASHBOARD' }}</div>
                <h2 class="top-page-header-title">@yield('page_header_title', 'Production Management')</h2>
                <p class="top-page-header-subtitle">@yield('page_header_subtitle', 'Digital Intelligence & Shopfloor Operational Control')</p>
            </div>
            <div class="d-flex align-items-center gap-2">
                <div class="badge-ent badge-ent-emerald">
                    <span style="width:6px; height:6px; background:#16a34a; border-radius:50%;"></span> SYSTEM ONLINE
                </div>
                @yield('top_header_action')
            </div>
        </div>
        @endauth

        <!-- Session Notifications -->
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show rounded-2 shadow-xs border-0 mb-3" role="alert">
                <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show rounded-2 shadow-xs border-0 mb-3" role="alert">
                <i class="bi bi-exclamation-triangle-fill me-2"></i> {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show rounded-2 shadow-xs border-0 mb-3" role="alert">
                <div class="fw-bold mb-1"><i class="bi bi-x-circle-fill me-2"></i> Validation Errors:</div>
                <ul class="mb-0 ps-3">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @yield('content')
    </main>

    <!-- Bootstrap 5 Bundle JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>
