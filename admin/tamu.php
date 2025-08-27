<?php
// admin/tamu.php
session_start();

// Menambahkan nama default agar tidak error (untuk preview)
$_SESSION['nama'] = $_SESSION['nama'] ?? 'Guest (Preview)';

// Memanggil controller tamu untuk memproses dan menampilkan halaman
require_once __DIR__ . '/controllers/TamuController.php';
