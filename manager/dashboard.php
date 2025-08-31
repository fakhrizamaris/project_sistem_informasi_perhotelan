<?php
// manajer/dashboard.php
session_start();
require_once __DIR__ . '/../includes/auth.php';

// Hanya manajer yang bisa akses
if ($_SESSION['role'] !== 'manajer') {
    header('Location: ../login.php?error=Access denied');
    exit;
}

// Memanggil controller dashboard
require_once __DIR__ . '/controllers/DashboardController.php';
