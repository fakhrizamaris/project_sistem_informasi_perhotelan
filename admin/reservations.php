<?php
// admin/reservations.php
session_start();

// Menambahkan nama default agar tidak error (untuk preview)
$_SESSION['nama'] = $_SESSION['nama'] ?? 'Guest (Preview)';

// Memanggil controller reservasi untuk memproses dan menampilkan halaman
require_once 'controllers/ReservationController.php';
