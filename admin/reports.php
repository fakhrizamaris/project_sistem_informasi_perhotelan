<?php
// admin/reports.php
session_start();

// Menambahkan nama default agar tidak error (untuk preview)
$_SESSION['nama'] = $_SESSION['nama'] ?? 'Guest (Preview)';
$_SESSION['username'] = $_SESSION['username'] ?? 'Admin';

// Memanggil controller laporan
require_once 'controllers/ReportController.php';
