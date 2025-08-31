<?php
// tamu/includes/header.php
// Template header untuk halaman tamu

$current_page = basename($_SERVER['PHP_SELF'], '.php');
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($page_title) ? $page_title : 'Dashboard Tamu'; ?> - Hotel System</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">

    <!-- DataTables CSS -->
    <link href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css" rel="stylesheet">

    <!-- Sweet Alert -->
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">

    <!-- Custom CSS untuk Tamu -->
    <style>
        :root {
            --primary-color: #1e88e5;
            --secondary-color: #42a5f5;
            --success-color: #4caf50;
            --warning-color: #ff9800;
            --danger-color: #f44336;
            --sidebar-width: 220px;
        }

        body {
            background-color: #f5f7fa;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        /* Sidebar Styles */
        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
            width: var(--sidebar-width);
            background: linear-gradient(180deg, #6e4040ff 0%, #482525ff 100%);
            transition: all 0.3s ease;
            z-index: 1000;
            overflow-y: auto;
        }

        .sidebar.collapsed {
            width: 70px;
        }

        .sidebar-header {
            padding: 1.5rem 1rem;
            text-align: center;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .sidebar-header .logo {
            color: white;
            font-size: 1.5rem;
            margin-bottom: 0.5rem;
            transition: all 0.3s ease;
        }

        .sidebar.collapsed .sidebar-header .logo-text {
            display: none;
        }

        .sidebar-menu {
            padding: 1rem 0;
        }

        .menu-item {
            margin: 0.2rem 1rem;
        }

        .menu-link {
            display: flex;
            align-items: center;
            padding: 0.75rem 1rem;
            color: rgba(255, 255, 255, 0.8);
            text-decoration: none;
            border-radius: 8px;
            transition: all 0.3s ease;
            position: relative;
        }

        .menu-link:hover {
            background: rgba(255, 255, 255, 0.1);
            color: white;
            transform: translateX(5px);
        }

        .menu-link.active {
            background: rgba(255, 255, 255, 0.15);
            color: white;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .menu-link i {
            width: 20px;
            margin-right: 0.75rem;
            font-size: 1.1rem;
        }

        .sidebar.collapsed .menu-link .menu-text {
            display: none;
        }

        /* Main Content */
        .main-content {
            margin-left: var(--sidebar-width);
            transition: all 0.3s ease;
        }

        .main-content.expanded {
            margin-left: 70px;
        }

        /* Top Navigation */
        .top-navbar {
            background: white;
            padding: 1rem 1.5rem;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            margin-bottom: 2rem;
            border-radius: 10px;
            margin: 1rem;
        }

        .navbar-brand {
            font-weight: 600;
            color: black;
        }

        /* Content Cards */
        .content-card {
            background: white;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
            margin-bottom: 2rem;
            overflow: hidden;
        }

        .card-header-custom {
            background: linear-gradient(135deg, #201818ff 0%, #971a1aff 100%);
            color: white;
            padding: 1.25rem 1.5rem;
            border: none;
        }

        .card-body-custom {
            padding: 1.5rem;
        }

        /* Stats Cards */
        .stat-card {
            border: none;
            border-radius: 15px;
            overflow: hidden;
            transition: all 0.3s ease;
        }

        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        }

        .stat-card.info {
            background: linear-gradient(135deg, #42a5f5 0%, #1e88e5 100%);
            color: white;
        }

        .stat-card.success {
            background: linear-gradient(135deg, #66bb6a 0%, #4caf50 100%);
            color: white;
        }

        .stat-card.warning {
            background: linear-gradient(135deg, #ffca28 0%, #ff9800 100%);
            color: white;
        }

        .stat-card.danger {
            background: linear-gradient(135deg, #ef5350 0%, #f44336 100%);
            color: white;
        }

        /* Buttons */
        .btn-primary-custom {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
            border: none;
            padding: 0.5rem 1.5rem;
            border-radius: 8px;
            transition: all 0.3s ease;
        }

        .btn-primary-custom:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(30, 136, 229, 0.3);
        }

        /* Status Badges */
        .status-badge {
            padding: 0.4rem 0.8rem;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 500;
        }

        /* Table Styles */
        .table-custom {
            background: white;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.05);
        }

        .table-custom thead th {
            background: #f8f9fa;
            border: none;
            font-weight: 600;
            color: black;
            padding: 1rem;
        }

        .table-custom tbody td {
            padding: 0.75rem 1rem;
            border-color: #e9ecef;
        }

        /* Welcome Section */
        .welcome-card {
            background: #fff;
            color: black;
            border-radius: 15px;
            padding: 2rem;
            box-shadow: inset;
            margin-bottom: 2rem;
        }

        .welcome-card h3 {
            margin-bottom: 0.5rem;
        }

        .welcome-card p {
            opacity: 0.9;
            margin-bottom: 0;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
            }

            .sidebar.show {
                transform: translateX(0);
            }

            .main-content {
                margin-left: 0;
            }
        }
    </style>

    <?php if (isset($additional_css)): ?>
        <style>
            <?php echo $additional_css; ?>
        </style>
    <?php endif; ?>
</head>

<body>
    <!-- Sidebar -->
    <nav class="sidebar" id="sidebar">
        <div class="sidebar-header">
            <div class="logo">
                <i class="fas fa-hotel"></i>
                <div class="logo-text">
                    <h5 class="text-white mb-0">Hotel System</h5>
                    <small class="text-light opacity-75">Portal Tamu</small>
                </div>
            </div>
        </div>

        <div class="sidebar-menu">
            <div class="menu-item">
                <a href="dashboardtamu.php" class="menu-link <?php echo $current_page == 'dashboard' ? 'active' : ''; ?>">
                    <i class="fas fa-tachometer-alt"></i>
                    <span class="menu-text">Dashboard</span>
                </a>
            </div>

            <div class="menu-item">
                <a href="booking.php" class="menu-link <?php echo $current_page == 'booking' ? 'active' : ''; ?>">
                    <i class="fas fa-plus-circle"></i>
                    <span class="menu-text">Booking Kamar</span>
                </a>
            </div>

            <div class="menu-item">
                <a href="reservasi.php" class="menu-link <?php echo $current_page == 'reservasi' ? 'active' : ''; ?>">
                    <i class="fas fa-calendar-check"></i>
                    <span class="menu-text">Reservasi Saya</span>
                </a>
            </div>

            <div class="menu-item">
                <a href="profile.php" class="menu-link <?php echo $current_page == 'profile' ? 'active' : ''; ?>">
                    <i class="fas fa-user"></i>
                    <span class="menu-text">Profil Saya</span>
                </a>
            </div>

            <hr class="my-3" style="border-color: rgba(255, 255, 255, 0.2);">

            <div class="menu-item">
                <a href="../logout.php" class="menu-link text-warning" onclick="return confirm('Yakin ingin logout?')">
                    <i class="fas fa-sign-out-alt"></i>
                    <span class="menu-text">Logout</span>
                </a>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="main-content" id="mainContent">
        <!-- Top Navigation -->
        <nav class="top-navbar">
            <div class="d-flex justify-content-between align-items-center">
                <div class="d-flex align-items-center">
                    <button class="btn btn-link d-md-none me-2" id="mobileSidebarToggle">
                        <i class="fas fa-bars"></i>
                    </button>
                    <h4 class="navbar-brand mb-0">
                        <?php echo isset($page_title) ? $page_title : 'Dashboard Tamu'; ?>
                    </h4>
                </div>

                <div class="d-flex align-items-center">
                    <div class="dropdown">
                        <button class="btn dropdown-toggle text-decoration-none" type="button"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-user-circle me-2"></i>
                            <span><?php echo $_SESSION['nama']; ?></span>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li>
                                <a class="dropdown-item" href="profile.php">
                                    <i class="fas fa-user me-2"></i>Profil
                                </a>
                            </li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li>
                                <a class="dropdown-item text-danger" href="../logout.php"
                                    onclick="return confirm('Yakin ingin logout?')">
                                    <i class="fas fa-sign-out-alt me-2"></i>Logout
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </nav>

        <!-- Page Content -->
        <div class="container-fluid px-4">
            <?php
            // Tampilkan alert jika ada
            if (isset($_SESSION['alert'])):
                $alert = $_SESSION['alert'];
                unset($_SESSION['alert']);
            ?>
                <div class="alert alert-<?php echo $alert['type']; ?> alert-dismissible fade show" role="alert">
                    <i class="fas <?php echo $alert['type'] == 'success' ? 'fa-check-circle' : 'fa-exclamation-triangle'; ?> me-2"></i>
                    <?php echo $alert['message']; ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>