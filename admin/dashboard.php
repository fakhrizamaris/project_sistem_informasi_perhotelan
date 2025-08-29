<?php
// admin/dashboard.php
session_start();
require_once __DIR__ . '/../includes/auth.php';

// Izinkan admin ATAU resepsionis
if ($_SESSION['role'] !== 'admin' && $_SESSION['role'] !== 'resepsionis') {
    header('Location: ../login.php?error=Access denied');
    exit;
}

// Memanggil controller dashboard untuk memproses dan menampilkan halaman
require_once __DIR__ . '/controllers/dashboard_controller.php';
?>