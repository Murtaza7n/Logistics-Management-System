<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0, user-scalable=yes">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Logistics Management System')</title>
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        :root {
            /* Brand Colors - Orange Header Theme */
            --orange-primary: #FF6B35; /* Main orange */
            --orange-light: #FF8C61; /* Lighter orange for hover */
            --orange-dark: #E55A2B; /* Darker orange for active */
            --orange-gradient-start: #FF6B35;
            --orange-gradient-end: #FF8C61;
            
            --metallic-silver: #A7A9AC;
            --charcoal-gray: #231F20;
            --clean-white: #FFFFFF;
            --deep-navy-blue: #1B365D;
            --black: #000000;
            
            /* Alert Colors */
            --success-green: #28a745;
            --error-red: #dc3545;
            --warning-yellow: #ffc107;
            --info-blue: #17a2b8;
            
            /* Social Media Brand Colors */
            --facebook-blue: #1877F2;
            --twitter-blue: #1DA1F2;
            --linkedin-blue: #0077B5;
            --instagram-purple: #E4405F;
            --youtube-red: #FF0000;
            
            /* Theme Mapping */
            --header-bg: var(--orange-primary);
            --header-text: var(--clean-white);
            --button-bg: var(--metallic-silver);
            --button-text: var(--black);
            --button-hover: #8a8d90;
            --button-active: #7a7d80;
            --link-color: var(--black);
            --link-hover: var(--orange-primary);
            --form-bg: var(--charcoal-gray);
            --form-text: var(--clean-white);
            --form-border: var(--charcoal-gray);
            --form-focus: var(--orange-primary);
            --bg-primary: var(--clean-white);
            --bg-secondary: #f8fafc;
            --bg-tertiary: #f1f5f9;
            --bg-dark: var(--charcoal-gray);
            --footer-bg: var(--deep-navy-blue);
            --footer-text: var(--clean-white);
            --text-primary: var(--black);
            --text-secondary: #4a4a4a;
            --border-color: #e2e8f0;
            
            /* Legacy support */
            --primary-color: var(--orange-primary);
            --primary-dark: var(--orange-dark);
            --primary-light: var(--orange-light);
            --secondary-color: var(--metallic-silver);
            --success-color: var(--success-green);
            --warning-color: var(--warning-yellow);
            --danger-color: var(--error-red);
            --info-color: var(--info-blue);
            
            /* Shadow */
            --shadow-sm: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
            --shadow-md: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            --shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        html {
            height: 100%;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
            background-color: var(--bg-secondary);
            color: var(--text-primary);
            line-height: 1.6;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            margin: 0;
            padding: 0;
        }

        /* Top Navigation Bar */
        .top-navbar {
            background: linear-gradient(135deg, var(--orange-gradient-start) 0%, var(--orange-gradient-end) 100%);
            box-shadow: var(--shadow-md);
            position: sticky;
            top: 0;
            z-index: 1000;
            padding: 0;
            min-height: 70px;
        }

        .navbar-brand {
            font-weight: 700;
            font-size: 1.5rem;
            color: var(--clean-white) !important;
            padding: 0.75rem 1.5rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            text-decoration: none;
        }

        .navbar-brand .logo-icon {
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 0.75rem;
            flex-shrink: 0;
        }
        
        .navbar-brand .logo-icon svg {
            width: 30px;
            height: 30px;
        }

        .navbar-brand .logo-text {
            display: flex;
            flex-direction: column;
            line-height: 1.2;
        }

        .navbar-brand .logo-text .company-name {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--clean-white);
            letter-spacing: 0.5px;
        }

        .navbar-brand .logo-text .tagline {
            font-size: 0.7rem;
            color: var(--clean-white);
            font-weight: 400;
            margin-top: 2px;
            letter-spacing: 0.3px;
        }
        
        /* Show logo text if image fails to load */
        .navbar-brand:has(img[style*="display: none"]) .logo-text,
        .navbar-brand img:not([src]) ~ .logo-text {
            display: flex !important;
        }

        .navbar-brand i {
            font-size: 1.75rem;
        }

        .top-menu {
            display: flex;
            align-items: center;
            flex: 1;
            padding: 0 1rem;
            flex-wrap: nowrap;
            gap: 0;
            min-width: 0;
            overflow-x: auto;
            overflow-y: hidden;
        }
        
        .top-menu::-webkit-scrollbar {
            height: 4px;
        }
        
        .top-menu::-webkit-scrollbar-track {
            background: rgba(255, 255, 255, 0.1);
        }
        
        .top-menu::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, 0.3);
            border-radius: 2px;
        }

        .top-menu-item {
            position: relative;
            flex-shrink: 0;
            white-space: nowrap;
            z-index: 100;
        }
        
        .top-menu-item.dropdown {
            z-index: 1000;
        }

        .top-menu-link {
            color: rgba(255, 255, 255, 0.9) !important;
            padding: 1rem 1.25rem;
            text-decoration: none;
            font-weight: 500;
            font-size: 0.95rem;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            border-bottom: 3px solid transparent;
            cursor: pointer;
            pointer-events: auto;
            position: relative;
            z-index: 10;
        }

        .top-menu-link:hover {
            color: var(--clean-white) !important;
            background-color: rgba(255, 255, 255, 0.1);
            border-bottom-color: var(--secondary-color);
        }

        .top-menu-link.active {
            color: var(--clean-white) !important;
            background-color: rgba(255, 255, 255, 0.15);
            border-bottom-color: var(--clean-white);
        }

        .top-menu-link i {
            font-size: 1.1rem;
        }

        /* Dropdown Menu */
        .dropdown-menu {
            border: none;
            box-shadow: var(--shadow-lg);
            border-radius: 8px;
            padding: 0.5rem 0;
            margin-top: 0.5rem;
            max-height: 400px;
            overflow-y: auto;
            overflow-x: hidden;
            z-index: 1050;
            position: absolute;
        }
        
        /* Custom scrollbar for dropdown menus */
        .dropdown-menu::-webkit-scrollbar {
            width: 8px;
        }
        
        .dropdown-menu::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 4px;
        }
        
        .dropdown-menu::-webkit-scrollbar-thumb {
            background: var(--metallic-silver);
            border-radius: 4px;
        }
        
        .dropdown-menu::-webkit-scrollbar-thumb:hover {
            background: #8a8d90;
        }

        .dropdown-item {
            padding: 0.75rem 1.5rem;
            font-weight: 500;
            color: var(--text-primary);
            transition: all 0.2s ease;
        }

        .dropdown-item:hover {
            background-color: var(--bg-tertiary);
            color: var(--primary-color);
        }

        .dropdown-item i {
            width: 20px;
            margin-right: 0.75rem;
            color: var(--secondary-color);
        }

        /* Nested Dropdown (Sub-menu) */
        .dropdown-submenu {
            position: relative;
        }

        .dropdown-submenu > .dropdown-menu {
            top: 0;
            left: 100%;
            margin-top: -0.5rem;
            margin-left: 0.125rem;
            min-width: 200px;
        }

        .dropdown-submenu:hover > .dropdown-menu {
            display: block;
        }

        .dropdown-submenu > .dropdown-item::after {
            content: "\f285";
            font-family: "bootstrap-icons";
            float: right;
            margin-left: 0.5rem;
            font-size: 0.875rem;
        }

        @media (max-width: 991px) {
            .dropdown-submenu > .dropdown-menu {
                position: static;
                float: none;
                margin-left: 1rem;
                margin-top: 0.25rem;
            }
        }

        /* City Selector */
        .city-selector {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0 1rem;
            border-left: 1px solid rgba(255, 255, 255, 0.2);
        }

        .city-selector select {
            background: rgba(255, 255, 255, 0.2);
            border: 1px solid rgba(255, 255, 255, 0.3);
            color: var(--clean-white);
            padding: 0.5rem 1rem;
            border-radius: 6px;
            font-size: 0.9rem;
            font-weight: 500;
            min-width: 150px;
        }

        .city-selector select:focus {
            background: rgba(255, 255, 255, 0.3);
            border-color: rgba(255, 255, 255, 0.5);
            outline: none;
        }

        .city-selector select option {
            background: var(--orange-primary);
            color: var(--clean-white);
        }

        .city-selector label {
            color: rgba(255, 255, 255, 0.9);
            font-size: 0.85rem;
            font-weight: 500;
            margin: 0;
        }

        /* User Info Section */
        .user-section {
            display: flex;
            align-items: center;
            gap: 1rem;
            padding: 0 1.5rem;
            border-left: 1px solid rgba(255, 255, 255, 0.2);
            position: relative;
            z-index: 1;
            min-width: fit-content;
        }
        
        .user-section > div {
            display: flex;
            align-items: center;
        }

        .user-info {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            color: var(--clean-white);
            white-space: nowrap;
        }

        .user-avatar {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.2);
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            color: var(--clean-white);
            font-size: 0.9rem;
            flex-shrink: 0;
        }

        .user-name {
            font-weight: 500;
            font-size: 0.9rem;
            color: var(--clean-white);
            line-height: 1.2;
        }

        .user-role {
            font-size: 0.75rem;
            opacity: 0.9;
            color: var(--clean-white);
            line-height: 1.2;
        }

        /* Main Content Area */
        .main-content {
            padding: 2rem;
            max-width: 1400px;
            margin: 0 auto;
            flex: 1 0 auto;
            width: 100%;
            min-height: calc(100vh - 200px); /* Ensure minimum height for content */
            padding-bottom: 6rem; /* Extra padding to prevent footer overlap */
            margin-bottom: 2rem;
        }

        /* Page Header */
        .page-header {
            background: var(--bg-primary);
            border-radius: 12px;
            padding: 1.5rem 2rem;
            margin-bottom: 1.5rem;
            box-shadow: var(--shadow-sm);
            border: 1px solid var(--border-color);
        }

        .page-title {
            font-size: 1.75rem;
            font-weight: 700;
            color: var(--black);
            margin: 0;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .page-title i {
            color: var(--orange-primary);
        }

        .page-subtitle {
            color: var(--text-secondary);
            font-size: 0.95rem;
            margin-top: 0.25rem;
        }

        /* Links - Black with Orange Hover */
        a {
            color: var(--black);
            text-decoration: none;
            transition: color 0.2s ease;
        }

        a:hover {
            color: var(--orange-primary);
            text-decoration: underline;
        }

        .dropdown-item {
            color: var(--black);
        }

        .dropdown-item:hover {
            background-color: rgba(255, 107, 53, 0.1);
            color: var(--orange-primary);
        }

        /* Cards */
        .card {
            border: 1px solid var(--border-color);
            border-radius: 12px;
            box-shadow: var(--shadow-sm);
            background: var(--bg-primary);
            margin-bottom: 1.5rem;
            overflow: hidden;
            transition: all 0.3s ease;
        }

        .card:hover {
            box-shadow: var(--shadow-md);
        }

        .card-header {
            background: linear-gradient(135deg, var(--orange-gradient-start) 0%, var(--orange-gradient-end) 100%);
            color: var(--clean-white);
            padding: 1.25rem 1.5rem;
            border-bottom: none;
            font-weight: 600;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .card-header h5 {
            margin: 0;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .card-body {
            padding: 1.5rem;
        }

        /* Buttons */
        .btn {
            border-radius: 8px;
            font-weight: 500;
            padding: 0.625rem 1.25rem;
            transition: all 0.3s ease;
            border: none;
        }

        /* Buttons - Metallic Silver */
        .btn-primary,
        .btn-success,
        .btn-info {
            background-color: var(--metallic-silver);
            border-color: var(--metallic-silver);
            color: var(--black);
            font-weight: 500;
            padding: 0.75rem 1.5rem;
            border-radius: 8px;
            transition: all 0.3s ease;
        }
        
        .btn-primary:hover,
        .btn-success:hover,
        .btn-info:hover {
            background-color: var(--button-hover);
            border-color: var(--button-hover);
            color: var(--black);
            transform: translateY(-1px);
            box-shadow: var(--shadow-md);
        }

        .btn-primary:active,
        .btn-success:active,
        .btn-info:active,
        .btn-primary:focus,
        .btn-success:focus,
        .btn-info:focus {
            background-color: var(--button-active);
            border-color: var(--button-active);
            color: var(--black);
            box-shadow: 0 0 0 0.2rem rgba(167, 169, 172, 0.5);
        }

        .btn-secondary {
            background-color: var(--metallic-silver);
            border-color: var(--metallic-silver);
            color: var(--black);
        }
        
        .btn-secondary:hover {
            background-color: var(--button-hover);
            border-color: var(--button-hover);
            color: var(--black);
        }

        .btn-warning {
            background-color: var(--warning-yellow);
            border-color: var(--warning-yellow);
            color: var(--black);
        }
        
        .btn-warning:hover {
            background-color: #e0a800;
            border-color: #d39e00;
            color: var(--black);
        }

        .btn-danger {
            background-color: var(--error-red);
            border-color: var(--error-red);
            color: var(--clean-white);
        }
        
        .btn-danger:hover {
            background-color: #c82333;
            border-color: #bd2130;
            color: var(--clean-white);
        }

        .btn-outline-primary,
        .btn-outline-success,
        .btn-outline-info {
            border-color: var(--metallic-silver);
            color: var(--metallic-silver);
            background-color: transparent;
        }

        .btn-outline-primary:hover,
        .btn-outline-success:hover,
        .btn-outline-info:hover {
            background-color: var(--metallic-silver);
            border-color: var(--metallic-silver);
            color: var(--black);
        }

        /* Forms */
        .form-label {
            font-weight: 500;
            color: var(--text-primary);
            margin-bottom: 0.5rem;
            font-size: 0.9rem;
        }

        .form-control,
        .form-select {
            border: 1px solid var(--border-color);
            border-radius: 8px;
            padding: 0.75rem;
            transition: all 0.3s ease;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
        }

        /* Tables */
        .table {
            background: var(--bg-primary);
        }

        .table thead {
            background: var(--bg-tertiary);
        }

        .table thead th {
            font-weight: 600;
            color: var(--text-primary);
            border-bottom: 2px solid var(--border-color);
            padding: 1rem;
        }

        .table tbody td {
            padding: 1rem;
            vertical-align: middle;
        }

        .table-hover tbody tr:hover {
            background-color: var(--bg-secondary);
        }

        /* Badges */
        .badge {
            padding: 0.5rem 0.75rem;
            border-radius: 6px;
            font-weight: 500;
            font-size: 0.85rem;
        }
        
        .badge-primary,
        .badge.bg-primary {
            background-color: var(--orange-primary) !important;
            color: var(--clean-white) !important;
        }
        
        .badge-secondary,
        .badge.bg-secondary {
            background-color: var(--metallic-silver) !important;
            color: var(--black) !important;
        }
        
        .badge-dark,
        .badge.bg-dark {
            background-color: var(--charcoal-gray) !important;
            color: var(--clean-white) !important;
        }
        
        .badge.bg-success {
            background-color: var(--success-green) !important;
            color: var(--clean-white) !important;
        }
        
        .badge.bg-danger {
            background-color: var(--error-red) !important;
            color: var(--clean-white) !important;
        }
        
        .badge.bg-warning {
            background-color: var(--warning-yellow) !important;
            color: var(--black) !important;
        }
        
        .badge.bg-info {
            background-color: var(--info-blue) !important;
            color: var(--clean-white) !important;
        }

        /* Alerts - Green for Success, Red for Errors */
        .alert {
            border-radius: 10px;
            border: none;
            padding: 1rem 1.5rem;
            margin-bottom: 1.5rem;
        }

        .alert-success {
            background-color: #d4edda;
            color: #155724;
            border-left: 4px solid var(--success-green);
        }

        .alert-danger,
        .alert-error {
            background-color: #f8d7da;
            color: #721c24;
            border-left: 4px solid var(--error-red);
        }

        .alert-warning {
            background-color: #fff3cd;
            color: #856404;
            border-left: 4px solid var(--warning-yellow);
        }

        .alert-info {
            background-color: #d1ecf1;
            color: #0c5460;
            border-left: 4px solid var(--info-blue);
        }

        /* Stat Cards */
        .stat-card {
            background: linear-gradient(135deg, var(--metallic-silver) 0%, #8a8d90 100%);
            color: var(--black);
            border-radius: 12px;
            padding: 1.5rem;
            box-shadow: var(--shadow-md);
            transition: all 0.3s ease;
        }
        
        .stat-card:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-lg);
        }
        
        .stat-card-silver {
            background: linear-gradient(135deg, var(--metallic-silver) 0%, #8a8d90 100%);
            color: var(--black);
        }
        
        .stat-card-dark {
            background: linear-gradient(135deg, var(--metallic-silver) 0%, #8a8d90 100%);
            color: var(--black);
        }

        .stat-card:hover {
            transform: translateY(-4px);
            box-shadow: var(--shadow-lg);
        }

        .stat-card h3 {
            font-size: 2.5rem;
            font-weight: 700;
            margin: 0;
            color: var(--black);
        }

        .stat-card p {
            margin: 0.5rem 0 0 0;
            opacity: 0.9;
            font-size: 0.95rem;
            color: var(--black);
        }
        
        .stat-card .text-white-50 {
            color: rgba(0, 0, 0, 0.6) !important;
        }

        /* Hamburger Menu Icon */
        .navbar-toggler {
            border: 2px solid rgba(255, 255, 255, 0.5);
            border-radius: 6px;
            padding: 0.5rem 0.75rem;
            background: rgba(255, 255, 255, 0.1);
            margin-right: 1rem;
        }

        .navbar-toggler:focus {
            box-shadow: 0 0 0 0.2rem rgba(255, 255, 255, 0.25);
        }

        .navbar-toggler-icon {
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 30 30'%3e%3cpath stroke='rgba%28255, 255, 255, 0.9%29' stroke-linecap='round' stroke-miterlimit='10' stroke-width='2' d='M4 7h22M4 15h22M4 23h22'/%3e%3c/svg%3e");
        }

        /* Navbar Right Section */
        .navbar-right-section {
            display: flex;
            align-items: center;
            gap: 1rem;
            position: relative;
            z-index: 1;
            flex-shrink: 0;
            margin-left: auto;
        }

        /* Responsive Tables */
        .table-responsive {
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
        }

        .table-responsive table {
            min-width: 600px;
        }

        /* Responsive Cards */
        .stat-card {
            margin-bottom: 1rem;
        }

        /* Responsive Forms */
        .form-row {
            display: flex;
            flex-wrap: wrap;
            margin-right: -5px;
            margin-left: -5px;
        }

        .form-row > .col,
        .form-row > [class*="col-"] {
            padding-right: 5px;
            padding-left: 5px;
        }

        /* Responsive Images */
        img {
            max-width: 100%;
            height: auto;
        }

        /* Responsive Buttons */
        .btn {
            white-space: nowrap;
        }

        /* Large Desktop (1200px - 1919px) */
        @media (max-width: 1200px) {
            .main-content {
                padding: 1.5rem;
            }

            .page-header {
                padding: 1.25rem 1.5rem;
            }

            .page-title {
                font-size: 1.5rem;
            }
        }

        /* Tablet & Small Desktop (992px - 1199px) */
        @media (max-width: 992px) {
            .top-menu {
                flex-direction: column;
                width: 100%;
                padding: 0;
            }

            .top-menu-item {
                width: 100%;
                border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            }

            .top-menu-link {
                width: 100%;
                padding: 1rem;
                border-bottom: none;
            }

            .dropdown-menu {
                position: static !important;
                transform: none !important;
                box-shadow: none;
                background: rgba(0, 0, 0, 0.2);
                margin: 0;
                border-radius: 0;
                max-height: 400px;
                overflow-y: auto;
                overflow-x: hidden;
            }

            .navbar-right-section {
                flex-direction: column;
                width: 100%;
                padding: 1rem;
                border-top: 1px solid rgba(255, 255, 255, 0.1);
            }

            .city-selector {
                width: 100%;
                border-left: none;
                border-bottom: 1px solid rgba(255, 255, 255, 0.1);
                padding: 1rem 0;
            }

            .user-section {
                width: 100%;
                border-left: none;
                padding: 1rem 0;
                justify-content: space-between;
            }

            .navbar-brand .logo-text .tagline {
                display: none;
            }

            .main-content {
                padding: 1rem;
            }

            .page-header {
                padding: 1rem 1.5rem;
            }

            .page-header .d-flex {
                flex-direction: column;
                gap: 1rem;
            }

            .page-header .d-flex > div:last-child {
                width: 100%;
            }

            .page-header .d-flex > div:last-child .btn {
                width: 100%;
                margin-bottom: 0.5rem;
            }
        }

        /* Tablet Portrait & Mobile Landscape (768px - 991px) */
        @media (max-width: 768px) {
            .top-menu-link {
                padding: 0.75rem 1rem;
                font-size: 0.85rem;
            }

            .main-content {
                padding: 1rem;
            }

            .page-header {
                padding: 1rem;
                margin-bottom: 1rem;
            }

            .page-title {
                font-size: 1.25rem;
            }

            .page-subtitle {
                font-size: 0.85rem;
            }

            .card {
                margin-bottom: 1rem;
            }

            .card-body {
                padding: 1rem;
            }

            .card-header {
                padding: 0.75rem 1rem;
            }

            .stat-card {
                margin-bottom: 1rem;
            }

            .stat-card h3 {
                font-size: 1.75rem;
            }

            .stat-card p {
                font-size: 0.9rem;
            }

            .navbar-brand {
                font-size: 1.25rem;
                padding: 0.5rem 1rem;
            }

            .navbar-brand .logo-text .company-name {
                font-size: 1.25rem;
            }

            .btn {
                padding: 0.5rem 1rem;
                font-size: 0.9rem;
            }

            .form-control,
            .form-select {
                font-size: 0.9rem;
            }

            .table {
                font-size: 0.85rem;
            }

            .table th,
            .table td {
                padding: 0.5rem;
            }

            .footer {
                padding: 1.5rem 0;
                margin-top: 2rem;
            }

            .footer .col-md-6 {
                text-align: center !important;
                margin-bottom: 1rem;
            }

            .footer .col-md-6:last-child {
                margin-bottom: 0;
            }

            .user-section {
                padding: 0 1rem;
            }

            .user-name,
            .user-role {
                display: none;
            }
        }

        /* Mobile Portrait (up to 567px) */
        @media (max-width: 567px) {
            .main-content {
                padding: 0.75rem;
            }

            .page-header {
                padding: 0.75rem;
            }

            .page-title {
                font-size: 1.1rem;
            }

            .navbar-brand {
                font-size: 1rem;
                padding: 0.5rem;
            }

            .navbar-brand .logo-icon svg {
                width: 24px;
                height: 24px;
            }

            .navbar-brand .logo-text .company-name {
                font-size: 1rem;
            }

            .btn {
                padding: 0.4rem 0.75rem;
                font-size: 0.85rem;
            }

            .btn-sm {
                padding: 0.25rem 0.5rem;
                font-size: 0.75rem;
            }

            .card-header h5 {
                font-size: 1rem;
            }

            .table {
                font-size: 0.75rem;
            }

            .table th,
            .table td {
                padding: 0.4rem;
            }

            .form-label {
                font-size: 0.85rem;
            }

            .form-control,
            .form-select {
                font-size: 0.85rem;
                padding: 0.5rem;
            }

            .dropdown-menu {
                font-size: 0.85rem;
            }

            .user-info {
                flex-direction: column;
                align-items: flex-start;
                gap: 0.5rem;
            }

            .user-name,
            .user-role {
                font-size: 0.85rem;
            }

            .city-selector {
                flex-direction: column;
                align-items: flex-start;
                gap: 0.5rem;
            }

            .city-selector select {
                width: 100%;
                min-width: auto;
            }

            .footer {
                padding: 1rem 0;
                font-size: 0.85rem;
                margin-top: 2rem;
            }

            .footer a {
                font-size: 1.25rem;
            }

            .section-header {
                padding: 0.75rem 1rem;
                font-size: 0.9rem;
            }

            .alert {
                font-size: 0.85rem;
                padding: 0.75rem;
            }

            .row.g-2 > [class*="col-"],
            .row.g-3 > [class*="col-"],
            .row.g-4 > [class*="col-"] {
                margin-bottom: 0.5rem;
            }
        }

        /* Large Desktop (1920px and above) */
        @media (min-width: 1920px) {
            .main-content {
                max-width: 1600px;
            }
        }

        /* Extra Large Desktop (2560px and above) */
        @media (min-width: 2560px) {
            .main-content {
                max-width: 2000px;
            }
        }

        /* Print Styles */
        @media print {
            .top-navbar,
            .footer,
            .btn,
            .navbar-toggler {
                display: none !important;
            }

            .main-content {
                padding: 0;
                max-width: 100%;
            }

            .card {
                border: 1px solid #ddd;
                page-break-inside: avoid;
            }
        }

        /* Section Headers - Orange */
        .section-header {
            background: linear-gradient(135deg, var(--orange-gradient-start) 0%, var(--orange-gradient-end) 100%);
            color: var(--clean-white);
            padding: 1rem 1.5rem;
            border-radius: 8px 8px 0 0;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .section-header.info {
            background: linear-gradient(135deg, var(--metallic-silver) 0%, #8a8d90 100%);
            color: var(--black);
        }

        .section-header.warning {
            background: linear-gradient(135deg, var(--charcoal-gray) 0%, #1a1617 100%);
            color: var(--clean-white);
        }

        /* Loading States */
        .loading {
            opacity: 0.6;
            pointer-events: none;
        }

        /* Custom Scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
            height: 8px;
        }

        ::-webkit-scrollbar-track {
            background: var(--bg-tertiary);
        }

        ::-webkit-scrollbar-thumb {
            background: var(--secondary-color);
            border-radius: 4px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: var(--primary-color);
        }
    </style>
    
    @stack('styles')
</head>
<body>
    @auth
    <!-- Top Navigation Bar -->
    <nav class="navbar navbar-expand-lg top-navbar">
        <div class="container-fluid px-0">
            <!-- Brand -->
            <a class="navbar-brand" href="{{ route('dashboard') }}">
                <div class="logo-icon">
                    <svg width="30" height="30" viewBox="0 0 30 30" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <circle cx="15" cy="15" r="12" stroke="#FFFFFF" stroke-width="2" opacity="0.9"/>
                        <circle cx="15" cy="15" r="8" stroke="#A7A9AC" stroke-width="1.5" opacity="0.7"/>
                        <path d="M 7 23 L 20 10 L 17 10 L 17 4 L 23 4 L 23 10 L 20 10 Z" fill="#FFFFFF" opacity="0.9"/>
                    </svg>
                </div>
                <div class="logo-text">
                    <span class="company-name">S2E LOGISTICS</span>
                    <span class="tagline">Delivering Trust, Start to End</span>
                </div>
            </a>

            <!-- Hamburger Menu Button (Mobile) -->
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <!-- Main Menu -->
            <div class="collapse navbar-collapse" id="navbarNav">
            <div class="top-menu">
                @php
                    $user = auth()->user();
                    $menuService = \App\Services\MenuPermissionService::class;
                    // Check dynamic permissions for main menus
                    $hasLogistics = $user->isAdmin() || $menuService::userHasPermission($user, 'dashboard', 'view') || $menuService::userHasPermission($user, 'shipments.index', 'view');
                    $hasLogisticsReports = $user->isAdmin() || $menuService::userHasPermission($user, 'reports.cn-detail', 'view');
                    $hasFinance = $user->isAdmin() || $menuService::userHasPermission($user, 'invoices.index', 'view') || $menuService::userHasPermission($user, 'payments.index', 'view');
                    $hasFinanceReports = $user->isAdmin() || $menuService::userHasPermission($user, 'reports.list-of-invoices', 'view') || $menuService::userHasPermission($user, 'reports.list-of-pending-invoices', 'view');
                    $hasPurchases = $user->isAdmin() || $menuService::userHasPermission($user, 'purchases.index', 'view');
                    $hasPayroll = $user->isAdmin() || $menuService::userHasPermission($user, 'payroll.departments', 'view');
                    $hasPayrollReports = $user->isAdmin() || $menuService::userHasPermission($user, 'reports.list-of-employees', 'view');
                    $hasSystem = $user->isAdmin() || $menuService::userHasPermission($user, 'system.change-password', 'view');
                    $hasAdmin = $user->isAdmin() || $menuService::userHasPermission($user, 'users.index', 'view') || $menuService::userHasPermission($user, 'employees.index', 'view');
                @endphp
                
                <!-- S2E Logistics Module -->
                @if($hasLogistics)
                <div class="top-menu-item dropdown">
                    <a class="top-menu-link dropdown-toggle {{ request()->routeIs('dashboard') || request()->routeIs('logistics.*') || request()->routeIs('shipments.*') || request()->routeIs('bookings.*') || request()->routeIs('vehicle-load-plans.*') || request()->routeIs('delivery-sheets.*') || request()->routeIs('pickup-sheets.*') || request()->routeIs('customers.*') || request()->routeIs('vendors.*') || request()->routeIs('vehicles.*') || request()->routeIs('drivers.*') ? 'active' : '' }}" 
                       href="#" 
                       role="button" 
                       data-bs-toggle="dropdown"
                       aria-expanded="false"
                       id="dropdownS2ELogistics">
                        <span>S2E Logistics</span>
                    </a>
                    <ul class="dropdown-menu">
                        <!-- Initial Setup with Sub-menu -->
                        <li class="dropdown-submenu">
                            <a class="dropdown-item dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                Initial Setup
                            </a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="{{ route('master-data.item-codes') }}">Item Codes</a></li>
                                <li><a class="dropdown-item" href="{{ route('master-data.invoice-charges') }}">Invoice Charges</a></li>
                                <li><a class="dropdown-item" href="{{ route('master-data.cargo-officers') }}">SPO / Cargo Officers</a></li>
                                <li><a class="dropdown-item" href="{{ route('master-data.cargo-officer-stock-issue') }}">Cargo Office-wise CN Stock Issue</a></li>
                                <li><a class="dropdown-item" href="{{ route('reports.list-of-city-codes') }}">City Codes</a></li>
                                <li><a class="dropdown-item" href="{{ route('master-data.zone-codes') }}">Zone Codes</a></li>
                                <li><a class="dropdown-item" href="{{ route('master-data.party-area-rates') }}">Party or Area-wise Rate</a></li>
                            </ul>
                        </li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="{{ route('shipments.index') }}">C/N Entry</a></li>
                        <li><a class="dropdown-item" href="{{ route('vehicle-load-plans.index') }}">Vehicle Load Plan</a></li>
                        <li><a class="dropdown-item" href="{{ route('delivery-sheets.index') }}">Delivery Sheet</a></li>
                        <li><a class="dropdown-item" href="{{ route('pickup-sheets.index') }}">Pickup Sheet</a></li>
                        <li><a class="dropdown-item" href="{{ route('invoices.index') }}">Invoices</a></li>
                        <li><a class="dropdown-item" href="{{ route('logistics.party-fuel-rates') }}">Party Fuel Rates for CN</a></li>
                    </ul>
                </div>
                @endif

                <!-- Logistics Reports -->
                @if($hasLogisticsReports)
                <div class="top-menu-item dropdown">
                    <a class="top-menu-link dropdown-toggle {{ request()->routeIs('reports.*') ? 'active' : '' }}" 
                       href="#" 
                       role="button" 
                       data-bs-toggle="dropdown"
                       aria-expanded="false"
                       id="dropdownLogisticsReports">
                        <span>Logistics Reports</span>
                    </a>
                    <ul class="dropdown-menu">
                        <!-- Sales Reports Sub-menu -->
                        <li class="dropdown-submenu">
                            <a class="dropdown-item dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                Sales Reports
                            </a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="{{ route('reports.cn-detail') }}">CN Detail</a></li>
                                <li><a class="dropdown-item" href="{{ route('reports.list-of-invoices') }}">List of Invoices</a></li>
                                <li><a class="dropdown-item" href="{{ route('reports.cn-status') }}">CN Status</a></li>
                                <li><a class="dropdown-item" href="{{ route('reports.cn-profit-loss') }}">CN Profit / Loss</a></li>
                                <li><a class="dropdown-item" href="{{ route('reports.city-wise-profit-loss') }}">City-wise Profit / Loss</a></li>
                                <li><a class="dropdown-item" href="{{ route('reports.shipper-wise-profit-loss') }}">Shipper-wise Profit / Loss</a></li>
                                <li><a class="dropdown-item" href="{{ route('reports.hub-wise-profit-loss') }}">Hub-wise Profit / Loss</a></li>
                                <li><a class="dropdown-item" href="{{ route('reports.spo-wise-profit-loss') }}">SPO-wise Profit / Loss</a></li>
                                <li><a class="dropdown-item" href="{{ route('reports.hub-wise-cn-detail') }}">Hub-wise CN Detail</a></li>
                                <li><a class="dropdown-item" href="{{ route('reports.transporter-wise-documents-detail') }}">Transporter-wise Documents Detail</a></li>
                                <li><a class="dropdown-item" href="{{ route('reports.zone-wise-profit-loss') }}">Zone-wise Profit / Loss</a></li>
                            </ul>
                        </li>
                        <li><hr class="dropdown-divider"></li>
                        <!-- Edit Lists Sub-menu -->
                        <li class="dropdown-submenu">
                            <a class="dropdown-item dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                Edit Lists
                            </a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="{{ route('master-data.cargo-officer-stock-issue') }}">SPO-wise CN Stock Issue List</a></li>
                                <li><a class="dropdown-item" href="{{ route('reports.list-of-missing-sn-numbers') }}">List of Missing SN Numbers</a></li>
                                <li><a class="dropdown-item" href="{{ route('reports.list-of-pending-invoices') }}">List of Pending Invoices</a></li>
                                <li><a class="dropdown-item" href="{{ route('master-data.item-codes') }}">List of Item Codes</a></li>
                                <li><a class="dropdown-item" href="{{ route('reports.list-of-city-codes') }}">List of City Codes</a></li>
                                <li><a class="dropdown-item" href="{{ route('reports.city-code-hub-wise-list') }}">City Code Hub-wise List</a></li>
                                <li><a class="dropdown-item" href="{{ route('reports.list-of-vehicle-types') }}">List of Vehicle Types</a></li>
                                <li><a class="dropdown-item" href="{{ route('master-data.cargo-officers') }}">List of SPO / Cargo Officers</a></li>
                                <li><a class="dropdown-item" href="{{ route('reports.list-of-rates') }}">List of Rates</a></li>
                                <li><a class="dropdown-item" href="{{ route('reports.party-wise-fuel-rate-list') }}">Party-wise Fuel Rate List</a></li>
                            </ul>
                        </li>
                        <li><hr class="dropdown-divider"></li>
                        <!-- Other Reports Sub-menu -->
                        <li class="dropdown-submenu">
                            <a class="dropdown-item dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                Other Reports
                            </a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="{{ route('reports.delivery-cn-detail') }}">Delivery CN Detail</a></li>
                                <li><a class="dropdown-item" href="{{ route('reports.group-party-outstanding') }}">Group / Party Outstanding with Sales Tax</a></li>
                                <li><a class="dropdown-item" href="{{ route('reports.list-of-invoices-sales-tax') }}">List of Invoices (Sales Tax Invoice)</a></li>
                                <li><a class="dropdown-item" href="{{ route('reports.cn-detail-account-cod') }}">CN Detail Account (COD)</a></li>
                                <li><a class="dropdown-item" href="{{ route('reports.delivery-sheet-cod-detail') }}">Delivery Sheet COD Detail</a></li>
                                <li><a class="dropdown-item" href="{{ route('reports.cn-detail-account-cod-status') }}">CN Detail Account COD Status</a></li>
                                <li><a class="dropdown-item" href="{{ route('reports.stock-in-transit') }}">Stock In Transit</a></li>
                                <li><a class="dropdown-item" href="{{ route('reports.cn-in-stock') }}">CN In Stock</a></li>
                                <li><a class="dropdown-item" href="{{ route('reports.non-service-charges-on-cn') }}">Non-Service Charges on CN</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
                @endif

                <!-- Finance -->
                @if($hasFinance)
                <div class="top-menu-item dropdown">
                    <a class="top-menu-link dropdown-toggle {{ request()->routeIs('finance.*') || request()->routeIs('vouchers.*') || request()->routeIs('chart-of-accounts.*') || request()->routeIs('invoices.*') || request()->routeIs('payments.*') ? 'active' : '' }}" 
                       href="#" 
                       role="button" 
                       data-bs-toggle="dropdown"
                       aria-expanded="false"
                       id="dropdownFinance">
                        <span>Finance</span>
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="{{ route('finance.group-codes') }}">Group Codes</a></li>
                        <li><a class="dropdown-item" href="{{ route('finance.control-codes') }}">Control Codes</a></li>
                        <li><a class="dropdown-item" href="{{ route('chart-of-accounts.index') }}">Chart of Accounts</a></li>
                        <li><a class="dropdown-item" href="{{ route('finance.account-grouping') }}">Account Grouping</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="{{ route('vouchers.create', 'bpv') }}">BPV – Bank Payment Voucher</a></li>
                        <li><a class="dropdown-item" href="{{ route('vouchers.create', 'brv') }}">BRV – Bank Receipt Voucher</a></li>
                        <li><a class="dropdown-item" href="{{ route('vouchers.create', 'cpv') }}">CPV – Cash Payment Voucher</a></li>
                        <li><a class="dropdown-item" href="{{ route('vouchers.create', 'crv') }}">CRV – Cash Receipt Voucher</a></li>
                        <li><a class="dropdown-item" href="{{ route('vouchers.create', 'jvr') }}">JVR – Journal Voucher</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="{{ route('finance.balance-sheet') }}">Balance Sheet</a></li>
                        <li><a class="dropdown-item" href="{{ route('finance.profit-loss') }}">Profit & Loss</a></li>
                        <li><a class="dropdown-item" href="{{ route('finance.change-voucher-date') }}">Change Voucher Date</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="{{ route('finance.list-of-chart-of-accounts') }}">List of Chart of Accounts</a></li>
                        <li><a class="dropdown-item" href="{{ route('vouchers.index') }}">List of Vouchers</a></li>
                        <li><a class="dropdown-item" href="{{ route('finance.cn-wise-expenses-detail') }}">CN-wise Expenses Detail</a></li>
                        <li><a class="dropdown-item" href="{{ route('finance.trial-balance') }}">Trial Balance</a></li>
                        <li><a class="dropdown-item" href="{{ route('finance.master-schedule') }}">Master Schedule</a></li>
                        <li><a class="dropdown-item" href="{{ route('finance.accounts-ledger') }}">Accounts Ledger</a></li>
                        <li><a class="dropdown-item" href="{{ route('finance.profit-loss-comparative') }}">Profit & Loss (Comparative)</a></li>
                        <li><a class="dropdown-item" href="{{ route('finance.month-wise-closing-balance-breakup') }}">Month-wise Closing Balance Break-up</a></li>
                        <li><a class="dropdown-item" href="{{ route('finance.group-outstanding-detail') }}">Group Outstanding Detail</a></li>
                        <li><a class="dropdown-item" href="{{ route('finance.group-ledger') }}">Group Ledger</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="{{ route('finance.trial-balance-console') }}">Trial Balance (Console)</a></li>
                        <li><a class="dropdown-item" href="{{ route('finance.master-schedule-console') }}">Master Schedule (Console)</a></li>
                        <li><a class="dropdown-item" href="{{ route('finance.accounts-ledger-console') }}">Accounts Ledger (Console)</a></li>
                        <li><a class="dropdown-item" href="{{ route('finance.pl-comparative-console') }}">P/L Comparative (Console)</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="{{ route('finance.account-grouping-detail') }}">Account Grouping Detail</a></li>
                        <li><a class="dropdown-item" href="{{ route('finance.sales-tax-register-invoice-wise') }}">Sales Tax Register (Invoice-wise)</a></li>
                        <li><a class="dropdown-item" href="{{ route('finance.sales-tax-register-customer-wise') }}">Sales Tax Register (Customer-wise)</a></li>
                        <li><a class="dropdown-item" href="{{ route('finance.party-wise-outstanding-detailed') }}">Party-wise Outstanding Detailed</a></li>
                        <li><a class="dropdown-item" href="{{ route('finance.party-wise-outstanding-aging') }}">Party-wise Outstanding (Aging)</a></li>
                        <li><a class="dropdown-item" href="{{ route('finance.party-wise-cleared-outstanding-detail') }}">Party-wise Cleared & Outstanding Detail</a></li>
                    </ul>
                </div>
                @endif

                <!-- Finance Reports -->
                @if($hasFinanceReports)
                <div class="top-menu-item dropdown">
                    <a class="top-menu-link dropdown-toggle {{ request()->routeIs('reports.list-of-*') || request()->routeIs('reports.group-party-*') ? 'active' : '' }}" 
                       href="#" 
                       role="button" 
                       data-bs-toggle="dropdown"
                       aria-expanded="false"
                       id="dropdownFinanceReports">
                        <span>Finance Reports</span>
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="{{ route('reports.list-of-invoices') }}">List of Invoices</a></li>
                        <li><a class="dropdown-item" href="{{ route('reports.list-of-pending-invoices') }}">List of Pending Invoices</a></li>
                        <li><a class="dropdown-item" href="{{ route('reports.list-of-missing-cn-nos') }}">List of Missing C/N Nos.</a></li>
                        <li><a class="dropdown-item" href="{{ route('reports.group-party-outstanding') }}">Group/Party Outstanding with S/Tax</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><h6 class="dropdown-header">Master Lists</h6></li>
                        <li><a class="dropdown-item" href="{{ route('reports.list-of-city-codes') }}">List of City Codes</a></li>
                        <li><a class="dropdown-item" href="{{ route('reports.list-of-vehicle-types') }}">List of Vehicle Types</a></li>
                    </ul>
                </div>
                @endif

                <!-- Purchases -->
                @if($hasPurchases)
                <div class="top-menu-item dropdown">
                    <a class="top-menu-link dropdown-toggle {{ request()->routeIs('purchases.*') ? 'active' : '' }}" 
                       href="#" 
                       role="button" 
                       data-bs-toggle="dropdown"
                       aria-expanded="false"
                       id="dropdownPurchases">
                        <span>Purchases</span>
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="{{ route('purchases.index') }}">Purchases List</a></li>
                        <li><a class="dropdown-item" href="{{ route('purchases.create') }}">Add Purchase</a></li>
                    </ul>
                </div>
                @endif

                <!-- Payroll Section -->
                @if(($user->isAdmin() || $user->isStaff()) && ($hasPayroll || $hasPayrollReports))
                <div class="top-menu-item dropdown">
                    <a class="top-menu-link dropdown-toggle {{ request()->routeIs('payroll.*') || request()->routeIs('reports.list-of-employees') || request()->routeIs('reports.list-of-monthly-deduction-allowances') || request()->routeIs('reports.employees-*') || request()->routeIs('reports.department-wise-monthly-payroll-register') || request()->routeIs('payrolls.*') ? 'active' : '' }}" 
                       href="#" 
                       role="button" 
                       data-bs-toggle="dropdown"
                       aria-expanded="false"
                       id="dropdownPayrollSection">
                        <span>Payroll Section</span>
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="{{ route('payroll.departments') }}">Department Codes</a></li>
                        <li><a class="dropdown-item" href="{{ route('payroll.designations') }}">Designation Codes</a></li>
                        <li><a class="dropdown-item" href="{{ route('payroll.employee-master') }}">Employee Master File</a></li>
                        <li><a class="dropdown-item" href="{{ route('payroll.loans') }}">Loan Master File</a></li>
                        <li><a class="dropdown-item" href="{{ route('payroll.deductions-allowances') }}">Monthly Deduction / Allowances</a></li>
                        <li><a class="dropdown-item" href="{{ route('payroll.authorized-leaves') }}">Authorized Leaves</a></li>
                        <li><a class="dropdown-item" href="{{ route('payroll.monthly-payroll-processing') }}">Monthly Payroll Processing</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="{{ route('reports.list-of-employees') }}">List of Employees</a></li>
                        <li><a class="dropdown-item" href="{{ route('reports.list-of-monthly-payroll') }}">List of Monthly Payroll</a></li>
                        <li><a class="dropdown-item" href="{{ route('reports.list-of-monthly-deduction-allowances') }}">Deduction / Allowances List</a></li>
                        <li><a class="dropdown-item" href="{{ route('reports.employees-authorized-leaves-detail') }}">Employee Authorized Leaves Detail</a></li>
                        <li><a class="dropdown-item" href="{{ route('reports.employees-leaves-status') }}">Employee Leave Status</a></li>
                        <li><a class="dropdown-item" href="{{ route('reports.department-wise-monthly-payroll-register') }}">Department-wise Monthly Payroll Register</a></li>
                    </ul>
                </div>
                @endif
                
                <!-- Administration -->
                @if($hasAdmin)
                <div class="top-menu-item dropdown">
                    <a class="top-menu-link dropdown-toggle" 
                       href="#" 
                       role="button" 
                       data-bs-toggle="dropdown"
                       aria-expanded="false"
                       id="dropdownAdmin">
                        <span>Admin</span>
                    </a>
                    <ul class="dropdown-menu">
                        @if($user->isAdmin() || $menuService::userHasPermission($user, 'users.index', 'view'))
                        <li><a class="dropdown-item" href="{{ route('users.index') }}">Users</a></li>
                        @endif
                        @if($user->isAdmin() || $menuService::userHasPermission($user, 'employees.index', 'view'))
                        <li><a class="dropdown-item" href="{{ route('employees.index') }}">Employees</a></li>
                        @endif
                    </ul>
                </div>
                @endif
                
                <!-- Settings -->
                @if($hasSystem)
                <div class="top-menu-item dropdown">
                    <a class="top-menu-link dropdown-toggle {{ request()->routeIs('system.*') || request()->routeIs('users.*') ? 'active' : '' }}" 
                       href="#" 
                       role="button" 
                       data-bs-toggle="dropdown"
                       aria-expanded="false"
                       id="dropdownSettings">
                        <span>Settings</span>
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item {{ request()->routeIs('users.*') ? 'active' : '' }}" href="{{ route('users.index') }}">Users</a></li>
                        @if($user->isAdmin())
                        <li><a class="dropdown-item {{ request()->routeIs('system.user-roles') ? 'active' : '' }}" href="{{ route('system.user-roles') }}">User Roles</a></li>
                        @endif
                        <li><a class="dropdown-item {{ request()->routeIs('system.change-password') ? 'active' : '' }}" href="{{ route('system.change-password') }}">Change Password</a></li>
                        @if(auth()->user()->isAdmin())
                        <li><a class="dropdown-item {{ request()->routeIs('system.change-year') ? 'active' : '' }}" href="{{ route('system.change-year') }}">Change Year</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item {{ request()->routeIs('system.initialize-data') ? 'active' : '' }}" href="{{ route('system.initialize-data') }}">Initialize Data for Re-processing</a></li>
                        <li><a class="dropdown-item {{ request()->routeIs('system.data-processing') ? 'active' : '' }}" href="{{ route('system.data-processing') }}">Data Processing</a></li>
                        <li><a class="dropdown-item {{ request()->routeIs('system.payroll-processing-final') ? 'active' : '' }}" href="{{ route('system.payroll-processing-final') }}">Payroll Processing (FINAL)</a></li>
                        <li><a class="dropdown-item {{ request()->routeIs('system.optimization') ? 'active' : '' }}" href="{{ route('system.optimization') }}">System Optimization</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item {{ request()->routeIs('system.unvoid-cn') ? 'active' : '' }}" href="{{ route('system.unvoid-cn') }}">Un-Void CN</a></li>
                        <li><a class="dropdown-item {{ request()->routeIs('system.email-settings') ? 'active' : '' }}" href="{{ route('system.email-settings') }}">Email Settings</a></li>
                        <li><a class="dropdown-item {{ request()->routeIs('system.inter-branches-jv') ? 'active' : '' }}" href="{{ route('system.inter-branches-jv') }}">Inter Branches J.V Code</a></li>
                        <li><a class="dropdown-item {{ request()->routeIs('system.unpost-data') ? 'active' : '' }}" href="{{ route('system.unpost-data') }}">Un-Post Data with Date Range</a></li>
                        @endif
                    </ul>
                </div>
                @endif
            </div>

            <!-- User Section & City Selector (Desktop) -->
            <div class="navbar-right-section">
            <!-- City Selector -->
            @php
                $user = auth()->user();
                $accessibleCities = $user ? $user->accessibleCities() : collect();
                $selectedCityId = session('selected_city_id');
                $selectedCity = $selectedCityId ? \App\Models\City::find($selectedCityId) : null;
            @endphp
            @if($accessibleCities->count() > 0)
            <div class="city-selector">
                <label for="city-select" class="me-2">
                    City:
                </label>
                <form action="{{ route('cities.switch') }}" method="POST" id="city-switch-form" style="display: inline;">
                    @csrf
                    <select name="city_id" id="city-select" class="form-select form-select-sm" onchange="this.form.submit()">
                        @foreach($accessibleCities as $city)
                            <option value="{{ $city->city_id }}" {{ $selectedCityId == $city->city_id ? 'selected' : '' }}>
                                {{ $city->name }}@if($city->code) ({{ $city->code }})@endif
                            </option>
                        @endforeach
                    </select>
                </form>
            </div>
            @endif

            <div class="user-section">
                <div class="user-info">
                    <div class="user-avatar">
                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                    </div>
                    <div>
                        <div class="user-name">{{ auth()->user()->name }}</div>
                        <div class="user-role">{{ ucfirst(auth()->user()->role) }}</div>
                    </div>
                </div>
                <a href="{{ route('logout') }}" 
                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                   class="btn btn-sm btn-outline-light"
                   title="Logout">
                    Logout
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            </div>
            </div>
            </div>
        </div>
    </nav>
    @endauth

    <!-- Main Content -->
    <div class="main-content">
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
            <strong>Please fix the following errors:</strong>
            <ul class="mb-0 mt-2">
                @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        @endif

        @yield('content')
    </div>

    <!-- jQuery (Load First) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <!-- Bootstrap 5 JS Bundle (includes Popper) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
    
    <!-- Footer - Deep Navy Blue (Static Footer - Consistent on All Pages) -->
    <footer class="footer py-4" style="background-color: var(--deep-navy-blue); color: var(--clean-white); flex-shrink: 0; width: 100%; margin-top: 2rem; position: relative; z-index: 1;">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <p class="mb-0">© 2024 Logistics Management System. All rights reserved.</p>
                </div>
                <div class="col-md-6 text-end">
                    <!-- Social Media Icons with Official Colors -->
                    <a href="#" class="me-3" style="color: var(--facebook-blue) !important; font-size: 1.5rem;" title="Facebook">
                        <i class="bi bi-facebook"></i>
                    </a>
                    <a href="#" class="me-3" style="color: var(--twitter-blue) !important; font-size: 1.5rem;" title="Twitter">
                        <i class="bi bi-twitter"></i>
                    </a>
                    <a href="#" class="me-3" style="color: var(--linkedin-blue) !important; font-size: 1.5rem;" title="LinkedIn">
                        <i class="bi bi-linkedin"></i>
                    </a>
                    <a href="#" class="me-3" style="color: var(--instagram-purple) !important; font-size: 1.5rem;" title="Instagram">
                        <i class="bi bi-instagram"></i>
                    </a>
                    <a href="#" style="color: var(--youtube-red) !important; font-size: 1.5rem;" title="YouTube">
                        <i class="bi bi-youtube"></i>
                    </a>
                </div>
            </div>
        </div>
    </footer>

    <!-- Initialize Bootstrap Dropdowns - COMPLETE FIX -->
    <script>
        (function() {
            'use strict';
            
            function initAllDropdowns() {
                // Check if Bootstrap is loaded
                if (typeof bootstrap === 'undefined' || typeof bootstrap.Dropdown === 'undefined') {
                    console.warn('Bootstrap not loaded yet, retrying...');
                    setTimeout(initAllDropdowns, 200);
                    return;
                }
                
                console.log('Initializing dropdowns...');
                
                // Initialize all dropdowns with data-bs-toggle="dropdown"
                var dropdownElements = document.querySelectorAll('[data-bs-toggle="dropdown"]');
                var dropdownInstances = [];
                
                dropdownElements.forEach(function(element) {
                    try {
                        // Dispose existing instance if any
                        var existing = bootstrap.Dropdown.getInstance(element);
                        if (existing) {
                            existing.dispose();
                        }
                        
                        // Create new dropdown instance
                        var dropdown = new bootstrap.Dropdown(element, {
                            boundary: 'viewport',
                            offset: [0, 2]
                        });
                        
                        dropdownInstances.push({
                            element: element,
                            instance: dropdown
                        });
                        
                        // Add click handler to prevent default navigation
                        element.addEventListener('click', function(e) {
                            var href = this.getAttribute('href');
                            if (href === '#' || href === '' || !href) {
                                e.preventDefault();
                            }
                        });
                        
                    } catch (error) {
                        console.error('Error initializing dropdown:', error, element);
                    }
                });
                
                // Handle nested dropdowns (submenus) - Manual toggle
                document.querySelectorAll('.dropdown-submenu > .dropdown-item.dropdown-toggle').forEach(function(element) {
                    element.addEventListener('click', function(e) {
                        e.preventDefault();
                        e.stopPropagation();
                        
                        var parent = this.closest('.dropdown-submenu');
                        var submenu = this.nextElementSibling;
                        
                        if (!parent || !submenu) return;
                        
                        var isOpen = parent.classList.contains('show');
                        
                        // Close all other submenus
                        document.querySelectorAll('.dropdown-submenu').forEach(function(item) {
                            if (item !== parent) {
                                item.classList.remove('show');
                                var menu = item.querySelector('.dropdown-menu');
                                if (menu) menu.classList.remove('show');
                            }
                        });
                        
                        // Toggle current submenu
                        if (isOpen) {
                            parent.classList.remove('show');
                            submenu.classList.remove('show');
                        } else {
                            parent.classList.add('show');
                            submenu.classList.add('show');
                        }
                    });
                });
                
                // Close dropdowns when clicking outside
                document.addEventListener('click', function(e) {
                    var clickedDropdown = e.target.closest('.dropdown');
                    
                    if (!clickedDropdown) {
                        // Clicked outside, close all dropdowns
                        dropdownInstances.forEach(function(item) {
                            try {
                                if (item.instance && item.instance._isShown()) {
                                    item.instance.hide();
                                }
                            } catch (err) {
                                // Ignore errors
                            }
                        });
                        
                        // Close all submenus
                        document.querySelectorAll('.dropdown-submenu.show').forEach(function(item) {
                            item.classList.remove('show');
                            var menu = item.querySelector('.dropdown-menu');
                            if (menu) menu.classList.remove('show');
                        });
                    }
                });
                
                console.log('✅ Dropdowns initialized successfully. Total:', dropdownInstances.length);
            }
            
            // Initialize when ready
            if (document.readyState === 'loading') {
                document.addEventListener('DOMContentLoaded', function() {
                    setTimeout(initAllDropdowns, 100);
                });
            } else {
                setTimeout(initAllDropdowns, 100);
            }
        })();
    </script>

    @stack('scripts')
</body>
</html>
