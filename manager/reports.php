<?php
// manajer/reports.php
session_start();
require_once __DIR__ . '/../includes/auth.php';

// Hanya manajer yang bisa akses
if ($_SESSION['role'] !== 'manajer') {
    header('Location: ../login.php?error=Access denied');
    exit;
}

// Memanggil controller laporan
require_once __DIR__ . '/controllers/ReportController.php';
