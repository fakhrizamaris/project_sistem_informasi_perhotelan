<?php
// tamu/booking.php
session_start();
require_once __DIR__ . '/../includes/auth.php';

// Hanya user dengan role 'tamu' yang bisa akses halaman ini
Auth::requireRole('tamu');

// Memanggil controller booking untuk memproses dan menampilkan halaman
require_once __DIR__ . '/controllers/BookingController.php';
