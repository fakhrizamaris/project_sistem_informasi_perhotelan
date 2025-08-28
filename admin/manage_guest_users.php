<?php
// admin/manage_guest_users.php
session_start();
require_once __DIR__ . '/../includes/auth.php';

Auth::requireRole('admin');

// Memanggil controller untuk memproses halaman
require_once __DIR__ . '/controllers/GuestUserController.php';
