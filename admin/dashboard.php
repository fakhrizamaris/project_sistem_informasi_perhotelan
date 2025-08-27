<?php
// admin/dashboard.php

// Memastikan pengguna sudah login dan memulai session
session_start();

/*
// =======================================================
// PENGECEKAN SESI SEMENTARA DINONAKTIFKAN UNTUK PREVIEW
// =======================================================
if (!isset($_SESSION['user_id'])) {
    header('Location: ../login.php');
    exit();
}
*/

// Menambahkan nama default agar tidak error saat menampilkan di view
$_SESSION['nama'] = $_SESSION['nama'] ?? 'Guest (Preview)';


// Memanggil controller dashboard untuk memproses dan menampilkan halaman
require_once 'controllers/dashboard_controller.php';
