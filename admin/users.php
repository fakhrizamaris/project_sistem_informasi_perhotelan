<?php
// admin/users.php
session_start();
require_once __DIR__ . '/../includes/auth.php';

// Hanya user dengan role 'admin' yang bisa akses halaman ini
if ($_SESSION['role'] !== 'admin') {
    header('Location: ../login.php?error=Access denied');
    exit;
}

// Memanggil controller users untuk memproses dan menampilkan halaman
require_once __DIR__ . '/controllers/UsersController.php';
