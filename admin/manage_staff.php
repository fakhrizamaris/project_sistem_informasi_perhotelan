<?php
// admin/manage_staff.php
session_start();

// Izinkan admin ATAU resepsionis
if ($_SESSION['role'] !== 'admin' && $_SESSION['role'] !== 'resepsionis') {
    header('Location: ../login.php?error=Access denied');
    exit;
}

// Memanggil controller staff
require_once 'controllers/StaffController.php';
