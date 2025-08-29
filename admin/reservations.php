<?php
// admin/reservations.php
session_start();
require_once __DIR__ . '/../includes/auth.php';

// Hanya user dengan role 'admin' yang bisa akses halaman ini
// Izinkan admin ATAU resepsionis
if ($_SESSION['role'] !== 'admin' && $_SESSION['role'] !== 'resepsionis') {
    header('Location: ../login.php?error=Access denied');
    exit;
}

// Memanggil controller reservasi untuk memproses dan menampilkan halaman
require_once __DIR__ . '/controllers/ReservationController.php';
