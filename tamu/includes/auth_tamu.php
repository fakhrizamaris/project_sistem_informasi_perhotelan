<?php
// includes/auth_tamu.php

// Pastikan session sudah dimulai
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Cek apakah user sudah login dan role-nya adalah 'tamu'
if (!isset($_SESSION['user_id']) || !isset($_SESSION['role']) || $_SESSION['role'] !== 'tamu') {
    // Jika tidak, arahkan ke halaman login dengan pesan error
    header('Location: ../login.php?error=Akses ditolak. Silakan login sebagai tamu.');
    exit();
}
