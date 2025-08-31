<?php
// includes/admin_header.php
// Template header untuk halaman admin

// Pastikan hanya admin yang bisa akses
// if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
//     header('Location: ../login.php');
//     exit();
// }

$current_page = basename($_SERVER['PHP_SELF'], '.php');
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($page_title) ? $page_title : 'Admin'; ?> - Hotel System</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">

    <!-- DataTables CSS (untuk tabel yang sortable) -->
    <link href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css" rel="stylesheet">

    <!-- Sweet Alert (untuk konfirmasi delete) -->
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">

    <!-- Custom Admin CSS -->
    <style>
        :root {
            --primary-color: #2c3e50;
            --secondary-color: #3498db;
            --success-color: #27ae60;
            --warning-color: #f39c12;
            --danger-color: #e74c3c;
            --sidebar-width: 260px;
        }

        body {
            background-color: #f8f9fa;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        /* Sidebar Styles */
        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
            width: var(--sidebar-width);
            background: linear-gradient(180deg, var(--primary-color) 0%, var(--secondary-color) 100%);
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
            color: var(--primary-color);
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
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
            color: white;
            padding: 1.25rem 1.5rem;
            border: none;
        }

        .card-body-custom {
            padding: 0.2rem;
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
            box-shadow: 0 5px 15px rgba(52, 152, 219, 0.3);
        }

        /* Status Badges */
        .status-badge {
            padding: 0.4rem 0.8rem;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 500;
        }

        .status-available {
            background: #d4edda;
            color: #155724;
        }

        .status-occupied {
            background: #f8d7da;
            color: #721c24;
        }

        .status-booked {
            background: #fff3cd;
            color: #856404;
        }

        .status-maintenance {
            background: #d1ecf1;
            color: #0c5460;
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
            color: var(--primary-color);
            padding: 1rem;
        }

        .table-custom tbody td {
            padding: 0.75rem 1rem;
            border-color: #e9ecef;
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

        /* Toggle Button */
        .sidebar-toggle {
            position: fixed;
            top: 1rem;
            left: 1rem;
            z-index: 1001;
            background: var(--primary-color);
            color: white;
            border: none;
            width: 40px;
            height: 40px;
            border-radius: 8px;
            display: none;
        }

        @media (max-width: 768px) {
            .sidebar-toggle {
                display: block;
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
    <!-- Sidebar Toggle Button (Mobile) -->
    <!-- Sidebar -->
    <nav class="sidebar" id="sidebar">
        <div class="sidebar-header">
            <div class="logo">
                <i class="fas fa-hotel"></i>
                <div class="logo-text">
                    <h5 class="text-white mb-0">Hotel System</h5>
                    <small class="text-light opacity-75"><?php echo ucfirst($_SESSION['role']); ?> Panel</small>
                </div>
            </div>
        </div>

        <div class="sidebar-menu">
            <div class="menu-item">
                <a href="dashboard.php" class="menu-link <?php echo $current_page == 'dashboard' ? 'active' : ''; ?>">
                    <i class="fas fa-tachometer-alt"></i>
                    <span class="menu-text">Dashboard</span>
                </a>
            </div>

            <div class="menu-item">
                <a href="reservations.php" class="menu-link <?php echo $current_page == 'reservations' ? 'active' : ''; ?>">
                    <i class="fas fa-calendar-check"></i>
                    <span class="menu-text">Reservasi</span>
                </a>
            </div>

            <div class="menu-item">
                <a href="tamu.php" class="menu-link <?php echo $current_page == 'tamu' ? 'active' : ''; ?>">
                    <i class="fas fa-users"></i>
                    <span class="menu-text">Data Tamu</span>
                </a>
            </div>

            <?php // Menu khusus untuk Admin 
            ?>
            <?php if ($_SESSION['role'] === 'admin'): ?>
                <div class="menu-item">
                    <a href="manage_rooms.php" class="menu-link <?php echo $current_page == 'manage_rooms' ? 'active' : ''; ?>">
                        <i class="fas fa-bed"></i>
                        <span class="menu-text">Kelola Kamar</span>
                    </a>
                </div>

                <div class="menu-item">
                    <a href="manage_guest_users.php" class="menu-link <?php echo $current_page == 'manage_guest_users' ? 'active' : ''; ?>">
                        <i class="fas fa-user-check"></i>
                        <span class="menu-text">User Tamu</span>
                    </a>
                </div>

                <div class="menu-item">
                    <a href="manage_staff.php" class="menu-link <?php echo $current_page == 'manage_staff' ? 'active' : ''; ?>">
                        <i class="fas fa-user-tie"></i>
                        <span class="menu-text">Kelola Staff</span>
                    </a>
                </div>

                <div class="menu-item">
                    <a href="users.php" class="menu-link <?php echo $current_page == 'users' ? 'active' : ''; ?>">
                        <i class="fas fa-users-cog"></i>
                        <span class="menu-text">Data Users</span>
                    </a>
                </div>

                <div class="menu-item">
                    <a href="reports.php" class="menu-link <?php echo $current_page == 'reports' ? 'active' : ''; ?>">
                        <i class="fas fa-chart-bar"></i>
                        <span class="menu-text">Laporan</span>
                    </a>
                </div>
            <?php endif; ?>

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
                        <?php echo isset($page_title) ? $page_title : 'Dashboard'; ?>
                    </h4>
                </div>

                <div class="d-flex align-items-center">
                    <div class="dropdown mx-5">
                        <button class="btn dropdown-toggle text-decoration-none" type="button"
                            id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-user-circle me-2"></i>
                            <span><?php echo $_SESSION['nama']; ?></span>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                            <li>
                                <a class="dropdown-item text-danger" href="../logout.php" id="logout-link-admin">
                                    <i class="fas fa-sign-out-alt me-0"></i>Logout
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </nav>

        <!-- Page Content -->
        <div class="container-fluid px-4"><?php
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