<?php
// manajer/controllers/dashboard_controller.php

// Memuat file-file yang diperlukan
require_once __DIR__ . '/../../config/koneksi.php';
require_once __DIR__ . '/../../admin/includes/functions.php';

// Konfigurasi Halaman
$page_title = 'Dashboard Manajer';

// Mengambil data statistik dari database 
$stats = getDashboardStats();
$recent_reservations = getRecentReservations(5);

// Jika gagal mengambil statistik, siapkan nilai default
if (!$stats) {
    $stats = [
        'rooms' => ['total_kamar' => 0, 'kamar_kosong' => 0, 'kamar_terisi' => 0],
        'reservations' => ['total_reservasi_hari_ini' => 0],
        'revenue' => ['pendapatan_bulan_ini' => 0],
        'occupancy_rate' => 0
    ];
}

// Memanggil file layout 
require_once __DIR__ . '/../includes/layout.php';
