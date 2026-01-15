<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Logistics Management System')</title>
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    
    <style>
        :root {
            --primary-dark: #4B5563;
            --secondary-gray: #6B7280;
            --dark-bg: #1F2937;
            --light-bg: #F0F4F8;
        }

        body {
            background-color: var(--light-bg);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .sidebar {
            background-color: var(--dark-bg);
            min-height: 100vh;
            padding: 0;
            position: fixed;
            left: 0;
            top: 0;
            width: 250px;
            z-index: 1000;
            transition: all 0.3s;
        }

        .sidebar .nav-link {
            color: #E5E7EB;
            padding: 12px 20px;
            border-left: 3px solid transparent;
            transition: all 0.3s;
        }

        .sidebar .nav-link:hover,
        .sidebar .nav-link.active {
            background-color: rgba(255, 255, 255, 0.1);
            border-left-color: #60A5FA;
            color: #FFFFFF;
        }

        .sidebar .nav-link i {
            width: 20px;
            margin-right: 10px;
        }

        .main-content {
            margin-left: 250px;
            padding: 20px;
            min-height: 100vh;
        }

        .navbar {
            background-color: var(--dark-bg);
            color: #FFFFFF;
            padding: 15px 20px;
            margin-bottom: 20px;
            border-radius: 8px;
        }

        .card {
            border: none;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            margin-bottom: 20px;
        }

        .card-header {
            background-color: var(--primary-dark);
            color: #FFFFFF;
            border-radius: 8px 8px 0 0 !important;
            padding: 15px 20px;
        }

        .btn-primary {
            background-color: var(--primary-dark);
            border-color: var(--primary-dark);
        }

        .btn-primary:hover {
            background-color: #374151;
            border-color: #374151;
        }

        .table {
            background-color: #FFFFFF;
        }

        .badge {
            padding: 6px 12px;
            font-weight: 500;
        }

        .stat-card {
            background: linear-gradient(135deg, var(--primary-dark) 0%, #374151 100%);
            color: #FFFFFF;
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 20px;
        }

        .stat-card h3 {
            font-size: 2rem;
            font-weight: bold;
            margin: 0;
        }

        .stat-card p {
            margin: 5px 0 0 0;
            opacity: 0.9;
        }

        @media (max-width: 768px) {
            .sidebar {
                margin-left: -250px;
            }

            .sidebar.show {
                margin-left: 0;
            }

            .main-content {
                margin-left: 0;
            }
        }
    </style>
    
    @stack('styles')
</head>
<body>
    @auth
    <div class="sidebar">
        <div class="p-3 text-white">
            <h4 class="mb-0"><i class="bi bi-truck"></i> Logistics</h4>
            <small>Management System</small>
        </div>
        <nav class="nav flex-column">
            <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">
                <i class="bi bi-speedometer2"></i> Dashboard
            </a>
            
            @if(auth()->user()->isAdmin() || auth()->user()->isStaff())
            <a class="nav-link {{ request()->routeIs('users.*') ? 'active' : '' }}" href="{{ route('users.index') }}">
                <i class="bi bi-people"></i> Users
            </a>
            <a class="nav-link {{ request()->routeIs('employees.*') ? 'active' : '' }}" href="{{ route('employees.index') }}">
                <i class="bi bi-person-badge"></i> Employees
            </a>
            <a class="nav-link {{ request()->routeIs('payrolls.*') ? 'active' : '' }}" href="{{ route('payrolls.index') }}">
                <i class="bi bi-cash-stack"></i> Payroll
            </a>
            @endif
            
            <a class="nav-link {{ request()->routeIs('customers.*') ? 'active' : '' }}" href="{{ route('customers.index') }}">
                <i class="bi bi-person"></i> Customers
            </a>
            <a class="nav-link {{ request()->routeIs('vendors.*') ? 'active' : '' }}" href="{{ route('vendors.index') }}">
                <i class="bi bi-building"></i> Vendors
            </a>
            <a class="nav-link {{ request()->routeIs('shipments.*') ? 'active' : '' }}" href="{{ route('shipments.index') }}">
                <i class="bi bi-box-seam"></i> Shipments
            </a>
            <a class="nav-link {{ request()->routeIs('vehicles.*') ? 'active' : '' }}" href="{{ route('vehicles.index') }}">
                <i class="bi bi-truck"></i> Vehicles
            </a>
            <a class="nav-link {{ request()->routeIs('drivers.*') ? 'active' : '' }}" href="{{ route('drivers.index') }}">
                <i class="bi bi-person-workspace"></i> Drivers
            </a>
            
            @if(auth()->user()->isAdmin() || auth()->user()->isStaff())
            <a class="nav-link {{ request()->routeIs('invoices.*') ? 'active' : '' }}" href="{{ route('invoices.index') }}">
                <i class="bi bi-receipt"></i> Invoices
            </a>
            <a class="nav-link {{ request()->routeIs('payments.*') ? 'active' : '' }}" href="{{ route('payments.index') }}">
                <i class="bi bi-credit-card"></i> Payments
            </a>
            <a class="nav-link {{ request()->routeIs('reports.*') ? 'active' : '' }}" href="{{ route('reports.index') }}">
                <i class="bi bi-graph-up"></i> Reports
            </a>
            @endif
            
            <hr class="text-white-50 my-2">
            <a class="nav-link" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                <i class="bi bi-box-arrow-right"></i> Logout
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
        </nav>
    </div>
    @endauth

    <div class="main-content">
        @auth
        <div class="navbar d-flex justify-content-between align-items-center">
            <div>
                <h5 class="mb-0">@yield('page-title', 'Dashboard')</h5>
            </div>
            <div class="d-flex align-items-center">
                <span class="me-3"><i class="bi bi-person-circle"></i> {{ auth()->user()->name }}</span>
                <span class="badge bg-secondary">{{ ucfirst(auth()->user()->role) }}</span>
            </div>
        </div>
        @endauth

        @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        @endif

        @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        @endif

        @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        @endif

        @yield('content')
    </div>

    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    @stack('scripts')
</body>
</html>


