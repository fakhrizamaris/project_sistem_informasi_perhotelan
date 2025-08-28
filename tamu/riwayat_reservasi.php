<?php
// tamu/riwayat_reservasi.php
session_start();
require_once __DIR__ . '/../includes/auth_tamu.php'; // Panggil otentikasi tamu

// Memanggil controller riwayat untuk memproses dan menampilkan halaman
require_once __DIR__ . '/controllers/riwayat_controller.php';
