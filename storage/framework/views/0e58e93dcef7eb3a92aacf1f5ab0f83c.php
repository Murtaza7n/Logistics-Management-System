<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0, user-scalable=yes">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <title><?php echo $__env->yieldContent('title', 'Logistics Management System'); ?></title>
    
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
        }

        .top-menu-item {
            position: relative;
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
        }

        .user-info {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            color: var(--clean-white);
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
        }

        .user-name {
            font-weight: 500;
            font-size: 0.9rem;
        }

        .user-role {
            font-size: 0.75rem;
            opacity: 0.8;
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
    
    <?php echo $__env->yieldPushContent('styles'); ?>
</head>
<body>
    <?php if(auth()->guard()->check()): ?>
    <!-- Top Navigation Bar -->
    <nav class="navbar navbar-expand-lg top-navbar">
        <div class="container-fluid px-0">
            <!-- Brand -->
            <a class="navbar-brand" href="<?php echo e(route('dashboard')); ?>">
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
                <?php
                    $user = auth()->user();
                    $menuService = \App\Services\MenuPermissionService::class;
                    // Check dynamic permissions for main menus
                    $hasLogistics = $user->isAdmin() || $menuService::userHasPermission($user, 'dashboard', 'view') || $menuService::userHasPermission($user, 'shipments.index', 'view');
                    $hasLogisticsReports = $user->isAdmin() || $menuService::userHasPermission($user, 'reports.cn-detail', 'view');
                    $hasFinance = $user->isAdmin() || $menuService::userHasPermission($user, 'invoices.index', 'view') || $menuService::userHasPermission($user, 'payments.index', 'view');
                    $hasFinanceReports = $user->isAdmin() || $menuService::userHasPermission($user, 'reports.list-of-invoices', 'view');
                    $hasPayroll = $user->isAdmin() || $menuService::userHasPermission($user, 'payroll.departments', 'view');
                    $hasPayrollReports = $user->isAdmin() || $menuService::userHasPermission($user, 'reports.list-of-employees', 'view');
                    $hasSystem = $user->isAdmin() || $menuService::userHasPermission($user, 'system.change-password', 'view');
                    $hasAdmin = $user->isAdmin() || $menuService::userHasPermission($user, 'users.index', 'view') || $menuService::userHasPermission($user, 'employees.index', 'view');
                ?>
                
                <!-- S2E Logistics Module -->
                <?php if($hasLogistics): ?>
                <div class="top-menu-item">
                    <a href="<?php echo e(route('dashboard')); ?>" 
                       class="top-menu-link <?php echo e(request()->routeIs('dashboard') || request()->routeIs('shipments.*') || request()->routeIs('customers.*') || request()->routeIs('vendors.*') || request()->routeIs('vehicles.*') || request()->routeIs('drivers.*') ? 'active' : ''); ?>">
                        <span>S2E Logistics</span>
                    </a>
                </div>
                <?php endif; ?>

                <!-- Logistics Reports -->
                <?php if($hasLogisticsReports): ?>
                <div class="top-menu-item dropdown">
                    <a class="top-menu-link dropdown-toggle <?php echo e(request()->routeIs('reports.*') ? 'active' : ''); ?>" 
                       href="#" 
                       role="button" 
                       data-bs-toggle="dropdown">
                        <span>Logistics Reports</span>
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="<?php echo e(route('reports.cn-detail')); ?>">C/Ns Detail</a></li>
                        <li><a class="dropdown-item" href="<?php echo e(route('reports.list-of-invoices')); ?>">List of Invoices</a></li>
                        <li><a class="dropdown-item" href="<?php echo e(route('reports.cn-status')); ?>">C/N Status (Detail)</a></li>
                        <li><a class="dropdown-item" href="<?php echo e(route('reports.cn-status')); ?>">C/N Status</a></li>
                        <li><a class="dropdown-item" href="<?php echo e(route('reports.cn-profit-loss')); ?>">C/N Profit Loss</a></li>
                        <li><a class="dropdown-item" href="<?php echo e(route('reports.city-wise-profit-loss')); ?>">City-wise Profit Loss</a></li>
                        <li><a class="dropdown-item" href="<?php echo e(route('reports.shipper-wise-profit-loss')); ?>">Shipper-wise Profit Loss</a></li>
                        <li><a class="dropdown-item" href="<?php echo e(route('reports.delivery-cn-detail')); ?>">Delivery CN Detail</a></li>
                        <li><a class="dropdown-item" href="<?php echo e(route('reports.stock-in-transit')); ?>">Stock in Transit</a></li>
                        <li><a class="dropdown-item" href="<?php echo e(route('reports.cn-in-stock')); ?>">C/N In-Stock</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="<?php echo e(route('reports.vehicle-usage')); ?>">Vehicle Usage</a></li>
                        <li><a class="dropdown-item" href="<?php echo e(route('reports.driver-performance')); ?>">Driver Performance</a></li>
                    </ul>
                </div>
                <?php endif; ?>

                <!-- Finance -->
                <?php if($hasFinance): ?>
                <div class="top-menu-item dropdown">
                    <a class="top-menu-link dropdown-toggle <?php echo e(request()->routeIs('invoices.*') || request()->routeIs('payments.*') || request()->routeIs('reports.list-of-*') || request()->routeIs('reports.group-party-*') ? 'active' : ''); ?>" 
                       href="#" 
                       role="button" 
                       data-bs-toggle="dropdown">
                        <span>Finance</span>
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="<?php echo e(route('invoices.index')); ?>">Invoices</a></li>
                        <li><a class="dropdown-item" href="<?php echo e(route('payments.index')); ?>">Payments</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><h6 class="dropdown-header">Finance Reports</h6></li>
                        <li><a class="dropdown-item" href="<?php echo e(route('reports.list-of-invoices')); ?>">List of Invoices</a></li>
                        <li><a class="dropdown-item" href="<?php echo e(route('reports.list-of-pending-invoices')); ?>">List of Pending Invoices</a></li>
                        <li><a class="dropdown-item" href="<?php echo e(route('reports.list-of-missing-cn-nos')); ?>">List of Missing C/N Nos.</a></li>
                        <li><a class="dropdown-item" href="<?php echo e(route('reports.group-party-outstanding')); ?>">Group/Party Outstanding with S/Tax</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><h6 class="dropdown-header">Master Lists</h6></li>
                        <li><a class="dropdown-item" href="<?php echo e(route('reports.list-of-city-codes')); ?>">List of City Codes</a></li>
                        <li><a class="dropdown-item" href="<?php echo e(route('reports.list-of-vehicle-types')); ?>">List of Vehicle Types</a></li>
                    </ul>
                </div>
                <?php endif; ?>

                <!-- Payroll (Merged with Payroll Reports) -->
                <?php if(($user->isAdmin() || $user->isStaff()) && ($hasPayroll || $hasPayrollReports)): ?>
                <div class="top-menu-item dropdown">
                    <a class="top-menu-link dropdown-toggle <?php echo e(request()->routeIs('payroll.*') || request()->routeIs('reports.list-of-employees') || request()->routeIs('reports.list-of-monthly-deduction-allowances') || request()->routeIs('reports.employees-*') || request()->routeIs('reports.department-wise-monthly-payroll-register') || request()->routeIs('payrolls.*') ? 'active' : ''); ?>" href="#" role="button" data-bs-toggle="dropdown">
                        <span>Payroll</span>
                    </a>
                    <ul class="dropdown-menu">
                        <?php if($hasPayroll): ?>
                        <li><a class="dropdown-item" href="<?php echo e(route('payroll.departments')); ?>">Department Codes</a></li>
                        <li><a class="dropdown-item" href="<?php echo e(route('payroll.designations')); ?>">Designation Codes</a></li>
                        <li><a class="dropdown-item" href="<?php echo e(route('payroll.employee-master')); ?>">Employee Master File</a></li>
                        <li><a class="dropdown-item" href="<?php echo e(route('payroll.loans')); ?>">Loan Master File</a></li>
                        <li><a class="dropdown-item" href="<?php echo e(route('payroll.deductions-allowances')); ?>">Monthly Deduction/Allowances</a></li>
                        <li><a class="dropdown-item" href="<?php echo e(route('payroll.authorized-leaves')); ?>">Authorized Leaves</a></li>
                        <li><a class="dropdown-item" href="<?php echo e(route('payroll.monthly-payroll-processing')); ?>">Monthly Payroll Processing</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="<?php echo e(route('payrolls.index')); ?>">Payroll Records</a></li>
                        <?php endif; ?>
                        <?php if($hasPayrollReports): ?>
                        <li><hr class="dropdown-divider"></li>
                        <li><h6 class="dropdown-header">Payroll Reports</h6></li>
                        <li><a class="dropdown-item" href="<?php echo e(route('reports.list-of-employees')); ?>">List of Employees</a></li>
                        <li><a class="dropdown-item" href="<?php echo e(route('reports.list-of-monthly-deduction-allowances')); ?>">List of Monthly Deduction/Allowances</a></li>
                        <li><a class="dropdown-item" href="<?php echo e(route('reports.employees-authorized-leaves-detail')); ?>">Employee's Authorized Leaves Detail</a></li>
                        <li><a class="dropdown-item" href="<?php echo e(route('reports.employees-leaves-status')); ?>">Employee's Leaves Status</a></li>
                        <li><a class="dropdown-item" href="<?php echo e(route('reports.department-wise-monthly-payroll-register')); ?>">Department-wise Monthly Payroll Register</a></li>
                        <?php endif; ?>
                    </ul>
                </div>
                <?php endif; ?>
                
                <!-- Administration -->
                <?php if($hasAdmin): ?>
                <div class="top-menu-item dropdown">
                    <a class="top-menu-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                        <span>Admin</span>
                    </a>
                    <ul class="dropdown-menu">
                        <?php if($user->isAdmin() || $menuService::userHasPermission($user, 'users.index', 'view')): ?>
                        <li><a class="dropdown-item" href="<?php echo e(route('users.index')); ?>">Users</a></li>
                        <?php endif; ?>
                        <?php if($user->isAdmin() || $menuService::userHasPermission($user, 'employees.index', 'view')): ?>
                        <li><a class="dropdown-item" href="<?php echo e(route('employees.index')); ?>">Employees</a></li>
                        <?php endif; ?>
                    </ul>
                </div>
                <?php endif; ?>
                
                <!-- System -->
                <?php if($hasSystem): ?>
                <div class="top-menu-item dropdown">
                    <a class="top-menu-link dropdown-toggle <?php echo e(request()->routeIs('system.*') ? 'active' : ''); ?>" href="#" role="button" data-bs-toggle="dropdown">
                        <span>System</span>
                    </a>
                    <ul class="dropdown-menu">
                        <?php if($user->isAdmin() || $user->isStaff()): ?>
                        <li><a class="dropdown-item <?php echo e(request()->routeIs('users.*') ? 'active' : ''); ?>" href="<?php echo e(route('users.index')); ?>">
                            Users
                        </a></li>
                        <?php endif; ?>
                        <?php if($user->isAdmin()): ?>
                        <li><a class="dropdown-item <?php echo e(request()->routeIs('system.user-roles') ? 'active' : ''); ?>" href="<?php echo e(route('system.user-roles')); ?>">
                            User Roles
                        </a></li>
                        <?php endif; ?>
                        <li><a class="dropdown-item <?php echo e(request()->routeIs('system.change-password') ? 'active' : ''); ?>" href="<?php echo e(route('system.change-password')); ?>">
                            Change Password
                        </a></li>
                        <?php if(auth()->user()->isAdmin()): ?>
                        <li><a class="dropdown-item <?php echo e(request()->routeIs('system.change-year') ? 'active' : ''); ?>" href="<?php echo e(route('system.change-year')); ?>">
                            Change Year
                        </a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item <?php echo e(request()->routeIs('system.initialize-data') ? 'active' : ''); ?>" href="<?php echo e(route('system.initialize-data')); ?>">
                            Initialize Data for re-processing
                        </a></li>
                        <li><a class="dropdown-item <?php echo e(request()->routeIs('system.data-processing') ? 'active' : ''); ?>" href="<?php echo e(route('system.data-processing')); ?>">
                            Data Processing
                        </a></li>
                        <li><a class="dropdown-item <?php echo e(request()->routeIs('system.payroll-processing-final') ? 'active' : ''); ?>" href="<?php echo e(route('system.payroll-processing-final')); ?>">
                            Payroll Processing - (FINAL)
                        </a></li>
                        <li><a class="dropdown-item <?php echo e(request()->routeIs('system.optimization') ? 'active' : ''); ?>" href="<?php echo e(route('system.optimization')); ?>">
                            System Optimization
                        </a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item <?php echo e(request()->routeIs('system.unvoid-cn') ? 'active' : ''); ?>" href="<?php echo e(route('system.unvoid-cn')); ?>">
                            Un-Void C/N
                        </a></li>
                        <li><a class="dropdown-item <?php echo e(request()->routeIs('system.email-settings') ? 'active' : ''); ?>" href="<?php echo e(route('system.email-settings')); ?>">
                            E-mail Setting
                        </a></li>
                        <li><a class="dropdown-item <?php echo e(request()->routeIs('system.inter-branches-jv') ? 'active' : ''); ?>" href="<?php echo e(route('system.inter-branches-jv')); ?>">
                            Inter Branches J.V Code
                        </a></li>
                        <li><a class="dropdown-item <?php echo e(request()->routeIs('system.unpost-data') ? 'active' : ''); ?>" href="<?php echo e(route('system.unpost-data')); ?>">
                            Un-Post Data with Date Range
                        </a></li>
                        <?php endif; ?>
                    </ul>
                </div>
                <?php endif; ?>
            </div>

            <!-- User Section & City Selector (Desktop) -->
            <div class="navbar-right-section">
            <!-- City Selector -->
            <?php
                $user = auth()->user();
                $accessibleCities = $user ? $user->accessibleCities() : collect();
                $selectedCityId = session('selected_city_id');
                $selectedCity = $selectedCityId ? \App\Models\City::find($selectedCityId) : null;
            ?>
            <?php if($accessibleCities->count() > 0): ?>
            <div class="city-selector">
                <label for="city-select" class="me-2">
                    City:
                </label>
                <form action="<?php echo e(route('cities.switch')); ?>" method="POST" id="city-switch-form" style="display: inline;">
                    <?php echo csrf_field(); ?>
                    <select name="city_id" id="city-select" class="form-select form-select-sm" onchange="this.form.submit()">
                        <?php $__currentLoopData = $accessibleCities; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $city): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($city->city_id); ?>" <?php echo e($selectedCityId == $city->city_id ? 'selected' : ''); ?>>
                                <?php echo e($city->name); ?><?php if($city->code): ?> (<?php echo e($city->code); ?>)<?php endif; ?>
                            </option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </form>
            </div>
            <?php endif; ?>

            <div class="user-section">
                <div class="user-info">
                    <div class="user-avatar">
                        <?php echo e(strtoupper(substr(auth()->user()->name, 0, 1))); ?>

                    </div>
                    <div>
                        <div class="user-name"><?php echo e(auth()->user()->name); ?></div>
                        <div class="user-role"><?php echo e(ucfirst(auth()->user()->role)); ?></div>
                    </div>
                </div>
                <a href="<?php echo e(route('logout')); ?>" 
                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                   class="btn btn-sm btn-outline-light"
                   title="Logout">
                    Logout
                </a>
                <form id="logout-form" action="<?php echo e(route('logout')); ?>" method="POST" style="display: none;">
                    <?php echo csrf_field(); ?>
                </form>
            </div>
            </div>
            </div>
        </div>
    </nav>
    <?php endif; ?>

    <!-- Main Content -->
    <div class="main-content">
        <?php if(session('success')): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?php echo e(session('success')); ?>

            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        <?php endif; ?>

        <?php if(session('error')): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <?php echo e(session('error')); ?>

            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        <?php endif; ?>

        <?php if($errors->any()): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Please fix the following errors:</strong>
            <ul class="mb-0 mt-2">
                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <li><?php echo e($error); ?></li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        <?php endif; ?>

        <?php echo $__env->yieldContent('content'); ?>
    </div>

    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
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

    <?php echo $__env->yieldPushContent('scripts'); ?>
</body>
</html>
<?php /**PATH /var/www/Logistics-Management-System/resources/views/layouts/app.blade.php ENDPATH**/ ?>