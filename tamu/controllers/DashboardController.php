<?php
// tamu/controllers/dashboard_controller.php

require_once __DIR__ . '/../../config/koneksi.php';
require_once __DIR__ . '/../../models/Tamu.php'; // Menggunakan model Tamu yang ada

// Konfigurasi Halaman
$page_title = 'Dashboard Tamu';

// Ambil data tamu yang sedang login dari session
$user_id = $_SESSION['user_id'];

// Ambil data reservasi aktif (misalnya yang akan datang atau sedang check-in)
// (Logika untuk mengambil data ini perlu ditambahkan di model atau di sini)
$reservasi_aktif = []; // Placeholder, perlu query database

// Memanggil file layout yang akan merangkai header, view, dan footer
require_once __DIR__ . '/../includes/layout.php';
