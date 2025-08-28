<?php
// admin/reports.php
session_start();

// Menambahkan nama default agar tidak error (untuk preview)
// Izinkan admin ATAU resepsionis
if ($_SESSION['role'] !== 'admin' && $_SESSION['role'] !== 'resepsionis') {
    header('Location: ../login.php?error=Access denied');
    exit;
}

// Memanggil controller laporan
require_once 'controllers/ReportController.php';
