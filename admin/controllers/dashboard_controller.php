<?php
// admin/controllers/dashboard_controller.php

// Memuat file-file yang diperlukan
require_once '../config/koneksi.php';
require_once 'includes/functions.php'; // Lokasi functions.php

// Konfigurasi Halaman
$page_title = 'Dashboard Admin';
$breadcrumb_items = [
    ['title' => 'Dashboard']
];

// Mengambil data statistik dari database menggunakan fungsi yang sudah ada
$stats = getDashboardStats();
$recent_reservations = getRecentReservations(5); // Ambil 5 reservasi terbaru

// Jika gagal mengambil statistik, siapkan nilai default untuk mencegah error
if (!$stats) {
    $stats = [
        'rooms' => ['total_kamar' => 0, 'kamar_kosong' => 0, 'kamar_terisi' => 0],
        'reservations' => ['total_reservasi_hari_ini' => 0],
        'revenue' => ['pendapatan_bulan_ini' => 0],
        'occupancy_rate' => 0
    ];
}

// Memanggil file layout yang akan merangkai header, view, dan footer
require_once 'includes/layout.php';
