<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - Dashboard</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        :root {
            --primary: #7C3AED;
            --primary-dark: #6D28D9;
            --primary-light: #8B5CF6;
            --success: #10B981;
            --danger: #EF4444;
            --warning: #F59E0B;
            --info: #3B82F6;
            --gray-50: #F9FAFB;
            --gray-100: #F3F4F6;
            --gray-200: #E5E7EB;
            --gray-300: #D1D5DB;
            --gray-400: #9CA3AF;
            --gray-500: #6B7280;
            --gray-600: #4B5563;
            --gray-700: #374151;
            --gray-800: #1F2937;
            --gray-900: #111827;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: var(--gray-50);
        }

        .dashboard-container {
            display: flex;
            min-height: 100vh;
        }

        /* Sidebar */
        .sidebar {
            width: 280px;
            background: white;
            border-right: 1px solid var(--gray-200);
            padding: 1.5rem;
            position: fixed;
            height: 100vh;
            overflow-y: auto;
        }

        .sidebar-logo {
            color: var(--primary);
            font-size: 1.5rem;
            font-weight: 700;
            margin-bottom: 2rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .nav-item {
            display: flex;
            align-items: center;
            padding: 0.75rem 1rem;
            color: var(--gray-600);
            text-decoration: none;
            border-radius: 0.5rem;
            margin-bottom: 0.5rem;
            transition: all 0.2s;
        }

        .nav-item i {
            width: 1.5rem;
            margin-right: 0.75rem;
        }

        .nav-item:hover, .nav-item.active {
            background: var(--primary);
            color: white;
        }

        /* Main Content */
        .main-content {
            flex: 1;
            margin-left: 280px;
            min-height: 100vh;
        }

        /* Top Bar */
        .top-bar {
            background: white;
            padding: 1rem 2rem;
            border-bottom: 1px solid var(--gray-200);
            display: flex;
            justify-content: flex-end;
            align-items: center;
            position: sticky;
            top: 0;
            z-index: 10;
        }

        .user-menu {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .user-menu img {
            width: 2.5rem;
            height: 2.5rem;
            border-radius: 50%;
            object-fit: cover;
        }

        .logout-btn {
            padding: 0.5rem 1rem;
            background: var(--danger);
            color: white;
            border: none;
            border-radius: 0.375rem;
            cursor: pointer;
            transition: all 0.2s;
        }

        .logout-btn:hover {
            background: #DC2626;
        }

        /* Content Area */
        .content-area {
            padding: 2rem;
        }

        @media (max-width: 768px) {
            .sidebar {
                width: 5rem;
                padding: 1rem;
            }

            .sidebar-logo span, .nav-item span {
                display: none;
            }

            .main-content {
                margin-left: 5rem;
            }
        }

        /* Common Dashboard Styles */
        .content-wrapper {
            padding: 2rem;
        }

        .page-header {
            margin-bottom: 2rem;
        }

        .page-header h1 {
            font-size: 1.875rem;
            font-weight: 600;
            color: #111827;
            margin-bottom: 0.5rem;
        }

        .text-subtitle {
            color: #6B7280;
            font-size: 0.95rem;
        }

        /* Stats Cards */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }

        .stat-card {
            background: white;
            border-radius: 1rem;
            padding: 1.5rem;
            display: flex;
            align-items: center;
            gap: 1rem;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
            transition: transform 0.2s;
        }

        .stat-card:hover {
            transform: translateY(-2px);
        }

        /* Tables */
        .table-container {
            background: white;
            border-radius: 1rem;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
            overflow: hidden;
            margin-bottom: 2rem;
        }

        .table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
        }

        .table th {
            background: #f8fafc;
            padding: 1rem 1.5rem;
            font-size: 0.75rem;
            font-weight: 600;
            letter-spacing: 0.05em;
            color: #64748b;
            text-transform: uppercase;
            border-bottom: 1px solid #e2e8f0;
        }

        .table td {
            padding: 1rem 1.5rem;
            color: #334155;
            border-bottom: 1px solid #f1f5f9;
        }

        .table tr:hover {
            background: #f8fafc;
        }

        /* Badges */
        .status-badge {
            display: inline-flex;
            align-items: center;
            padding: 0.375rem 0.75rem;
            border-radius: 9999px;
            font-size: 0.75rem;
            font-weight: 500;
        }

        .status-badge.active {
            background: #f0fdf4;
            color: #166534;
        }

        .status-badge.inactive {
            background: #fef2f2;
            color: #991b1b;
        }

        /* Buttons */
        .btn-action {
            width: 2rem;
            height: 2rem;
            border: none;
            border-radius: 6px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.2s;
        }

        .btn-action.edit {
            background: #f0f9ff;
            color: #0369a1;
        }

        .btn-action.delete {
            background: #fef2f2;
            color: #991b1b;
        }

        .btn-action:hover {
            transform: translateY(-2px);
        }

        .btn-add {
            position: fixed;
            bottom: 2rem;
            right: 2rem;
            background: var(--primary);
            color: white;
            border: none;
            padding: 0.75rem 1.5rem;
            border-radius: 9999px;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-weight: 500;
            cursor: pointer;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
        }

        .btn-add:hover {
            transform: translateY(-2px);
            background: var(--primary-dark);
        }

        /* Responsive */
        @media (max-width: 1024px) {
            .content-wrapper {
                padding: 1rem;
            }
            
            .stats-grid {
                grid-template-columns: 1fr;
            }
            
            .table {
                min-width: 800px;
            }
        }

        @media (max-width: 640px) {
            .page-header h1 {
                font-size: 1.5rem;
            }
            
            .btn-add {
                bottom: 1rem;
                right: 1rem;
                padding: 0.5rem 1rem;
            }
        }

        /* Add these to your existing styles */
        .stat-icon.professors {
            background: var(--primary);
        }

        .stat-icon.courses {
            background: var(--success);
        }

        .stat-icon.classes {
            background: var(--warning);
        }

        .stat-icon.subjects {
            background: var(--info);
        }

        /* Common Header Styles */
        .header-wrapper {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
            padding-bottom: 1.5rem;
            border-bottom: 1px solid var(--gray-200);
        }

        .header-content h1 {
            font-size: 2rem;
            font-weight: 700;
            color: var(--gray-900);
            margin-bottom: 0.5rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .header-content h1::before {
            content: '';
            display: block;
            width: 4px;
            height: 24px;
            background: var(--primary);
            border-radius: 2px;
        }

        .text-subtitle {
            color: var(--gray-500);
            font-size: 1rem;
            margin-left: 1.25rem;
        }

        .header-actions {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .btn-primary {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            background: var(--primary);
            color: white;
            padding: 0.75rem 1.5rem;
            border-radius: 0.5rem;
            font-weight: 500;
            text-decoration: none;
            transition: all 0.2s;
        }

        .btn-primary:hover {
            background: var(--primary-dark);
            transform: translateY(-1px);
        }

        @media (max-width: 768px) {
            .header-wrapper {
                flex-direction: column;
                gap: 1rem;
                align-items: flex-start;
            }

            .header-content h1 {
                font-size: 1.5rem;
            }

            .header-actions {
                width: 100%;
            }

            .btn-primary {
                width: 100%;
                justify-content: center;
            }
        }
    </style>
    @stack('styles')
</head>
<body>
    <div class="dashboard-container">
        <!-- For professors, we'll create a simplified sidebar -->
        @if(Auth::guard('professor')->check())
            <aside class="sidebar">
                <div class="sidebar-logo">
                    <i class="fas fa-graduation-cap"></i>
                    <span>Espace Professeur</span>
                </div>
                <nav>
                    <a href="{{ route('professor.dashboard') }}" class="nav-item {{ request()->routeIs('professor.dashboard') ? 'active' : '' }}">
                        <i class="fas fa-home"></i>
                        <span>Tableau de bord</span>
                    </a>
                    <a href="{{ route('professor.cahier-texte') }}" class="nav-item {{ request()->routeIs('professor.cahier-texte') ? 'active' : '' }}">
                        <i class="fas fa-book"></i>
                        <span>Cahier de texte</span>
                    </a>
                    <a href="{{ route('professor.courses.index') }}" class="nav-item {{ request()->routeIs('professor.courses.*') ? 'active' : '' }}">
                        <i class="fas fa-book"></i>
                        <span>Mes Cours</span>
                    </a>
                </nav>
            </aside>
        @else
            <!-- Original sidebar for admin -->
            <aside class="sidebar">
                <div class="sidebar-logo">
                    <i class="fas fa-graduation-cap"></i>
                    <span>Dashboard</span>
                </div>
                <nav>
                    <a href="{{ route('dashboard') }}" class="nav-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                        <i class="fas fa-home"></i>
                        <span>Accueil</span>
                    </a>
                    <a href="{{ route('classes.index') }}" class="nav-item {{ request()->routeIs('classes.*') ? 'active' : '' }}">
                        <i class="fas fa-chalkboard"></i>
                        <span>Classes</span>
                    </a>
                    <a href="{{ route('professors.index') }}" class="nav-item {{ request()->routeIs('professors.*') ? 'active' : '' }}">
                        <i class="fas fa-user-tie"></i>
                        <span>Professeurs</span>
                    </a>
                    <a href="{{ route('subjects.index') }}" class="nav-item {{ request()->routeIs('subjects.*') ? 'active' : '' }}">
                        <i class="fas fa-book"></i>
                        <span>Matières</span>
                    </a>
                    <a href="{{ route('courses.index') }}" class="nav-item {{ request()->routeIs('courses.*') ? 'active' : '' }}">
                        <i class="fas fa-graduation-cap"></i>
                        <span>Cours</span>
                    </a>
                    <a href="{{ route('analytics.index') }}" class="nav-item {{ request()->routeIs('analytics.*') ? 'active' : '' }}">
                        <i class="fas fa-chart-line"></i>
                        <span>Analytics</span>
                    </a>
                    <a href="{{ route('settings') }}" class="nav-item {{ request()->routeIs('settings') ? 'active' : '' }}">
                        <i class="fas fa-cog"></i>
                        <span>Paramètres</span>
                    </a>
                </nav>
            </aside>
        @endif

        <!-- Main Content -->
        <main class="main-content">
            <div class="top-bar">
                <div class="user-menu">
                    <img src="https://ui-avatars.com/api/?name={{ auth()->user()->name }}" alt="Profile">
                    <span>{{ auth()->user()->name }}</span>
                    <form action="{{ route('logout') }}" method="POST" class="d-inline">
                        @csrf
                        <button type="submit" class="logout-btn">
                            <i class="fas fa-sign-out-alt"></i>
                            Déconnexion
                        </button>
                    </form>
                </div>
            </div>
            
            <div class="content-area">
                @yield('content')
            </div>
        </main>
    </div>
    @stack('scripts')
</body>
</html> 