<?php
// admin/manage_rooms.php
session_start();
require_once __DIR__ . '/../includes/auth.php';

// Izinkan admin ATAU resepsionis
if ($_SESSION['role'] !== 'admin' && $_SESSION['role'] !== 'resepsionis') {
    header('Location: ../login.php?error=Access denied');
    exit;
}

// Memanggil controller kamar untuk memproses dan menampilkan halaman
require_once __DIR__ . '/controllers/RoomController.php';
?>