<?php
// tamu/pembayaran.php
session_start();
require_once __DIR__ . '/../includes/auth.php';

// Hanya user dengan role 'tamu' yang bisa akses halaman ini
Auth::requireRole('tamu');

// Memanggil controller pembayaran untuk memproses halaman
require_once __DIR__ . '/controllers/PembayaranController.php';
?>