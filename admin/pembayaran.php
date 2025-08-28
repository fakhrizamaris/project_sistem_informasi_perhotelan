<?php
// admin/pembayaran.php
session_start();
require_once __DIR__ . '/../includes/auth.php';

Auth::requireRole('admin'); // Atau bisa juga 'resepsionis'

// Memanggil controller pembayaran untuk memproses halaman
require_once __DIR__ . '/controllers/PembayaranController.php';
?>