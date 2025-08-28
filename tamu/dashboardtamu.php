<?php
// tamu/dashboardtamu.php
session_start();
require_once __DIR__ . '/includes/auth_tamu.php'; // Kita akan buat file otentikasi khusus tamu

// Memanggil controller dashboard untuk memproses dan menampilkan halaman
require_once __DIR__ . '/controllers/DashboardController.php';
