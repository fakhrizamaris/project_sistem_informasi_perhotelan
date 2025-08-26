<?php
// admin/includes/sidebar.php

// Dapatkan halaman yang sedang aktif untuk memberikan class 'active'
$current_page = basename($_SERVER['PHP_SELF']);
?>

<div class="d-flex flex-column flex-shrink-0 p-3 text-white bg-dark sidebar" style="width: 280px;">
    <a href="dashboard.php" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-white text-decoration-none">
        <i class="fas fa-hotel me-3"></i>
        <span class="fs-4">Admin Panel</span>
    </a>
    <hr>
    <ul class="nav nav-pills flex-column mb-auto">
        <li class="nav-item">
            <a href="dashboard.php" class="nav-link text-white <?php echo ($current_page == 'dashboard.php') ? 'active' : ''; ?>">
                <i class="fas fa-tachometer-alt me-2"></i>
                Dashboard
            </a>
        </li>

        <li class="nav-header text-secondary small text-uppercase ps-3 pt-2">Manajemen Hotel</li>

        <li>
            <a href="reservations.php" class="nav-link text-white <?php echo ($current_page == 'reservations.php') ? 'active' : ''; ?>">
                <i class="fas fa-calendar-check me-2"></i>
                Reservasi
            </a>
        </li>
        <li>
            <a href="manage_rooms.php" class="nav-link text-white <?php echo ($current_page == 'manage_rooms.php') ? 'active' : ''; ?>">
                <i class="fas fa-bed me-2"></i>
                Kelola Kamar
            </a>
        </li>
        <li>
            <a href="guests.php" class="nav-link text-white <?php echo ($current_page == 'guests.php') ? 'active' : ''; ?>">
                <i class="fas fa-users me-2"></i>
                Data Tamu
            </a>
        </li>

        <li class="nav-header text-secondary small text-uppercase ps-3 pt-2">Administrasi</li>

        <li>
            <a href="manage_staff.php" class="nav-link text-white <?php echo ($current_page == 'manage_staff.php') ? 'active' : ''; ?>">
                <i class="fas fa-user-tie me-2"></i>
                Kelola Staff
            </a>
        </li>
        <li>
            <a href="reports.php" class="nav-link text-white <?php echo ($current_page == 'reports.php') ? 'active' : ''; ?>">
                <i class="fas fa-chart-bar me-2"></i>
                Laporan
            </a>
        </li>
        <li>
            <a href="settings.php" class="nav-link text-white <?php echo ($current_page == 'settings.php') ? 'active' : ''; ?>">
                <i class="fas fa-cog me-2"></i>
                Pengaturan
            </a>
        </li>
    </ul>
    <hr>
    <div class="dropdown">
        <a href="#" class="d-flex align-items-center text-white text-decoration-none dropdown-toggle" id="dropdownUser1" data-bs-toggle="dropdown" aria-expanded="false">
            <i class="fas fa-user-circle me-2"></i>
            <strong><?php echo htmlspecialchars($_SESSION['username']); ?></strong>
        </a>
        <ul class="dropdown-menu dropdown-menu-dark text-small shadow" aria-labelledby="dropdownUser1">
            <li><a class="dropdown-item" href="#">Profil</a></li>
            <li>
                <hr class="dropdown-divider">
            </li>
            <li><a class="dropdown-item" href="../logout.php">Sign out</a></li>
        </ul>
    </div>
</div>