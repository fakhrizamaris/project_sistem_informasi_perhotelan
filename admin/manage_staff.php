<?php
// admin/manage_staff.php
session_start();

$_SESSION['nama'] = $_SESSION['nama'] ?? 'Guest (Preview)';

// Memanggil controller staff
require_once 'controllers/StaffController.php';
