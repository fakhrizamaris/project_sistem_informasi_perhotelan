<?php
// admin/reservations.php
session_start();
require_once __DIR__ . '/../includes/auth.php';

// Hanya user dengan role 'admin' yang bisa akses halaman ini
Auth::requireRole('admin');


// Memanggil controller reservasi untuk memproses dan menampilkan halaman
require_once __DIR__ . '/controllers/ReservationController.php';
