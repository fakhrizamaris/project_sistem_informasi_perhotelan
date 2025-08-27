<?php
// admin/manage_rooms.php
session_start();
require_once __DIR__ . '/../includes/auth.php';

// Hanya user dengan role 'admin' yang bisa akses halaman ini
Auth::requireRole('admin');

// Memanggil controller kamar untuk memproses dan menampilkan halaman
require_once __DIR__ . '/controllers/RoomController.php';
?>