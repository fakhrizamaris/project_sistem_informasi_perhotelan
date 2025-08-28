<?php
// tamu/controllers/dashboard_controller.php

require_once __DIR__ . '/../../config/koneksi.php';
require_once __DIR__ . '/../../models/Tamu.php';
require_once __DIR__ . '/../includes/functions.php';

// Konfigurasi Halaman
$page_title = 'Dashboard Tamu';

// Ambil data tamu berdasarkan user login
$user_id = $_SESSION['user_id'];

// Inisialisasi model
$tamuReservationModel = new TamuReservation();

// Mengambil data statistik tamu
$stats = $tamuReservationModel->getGuestStats($user_id);
$recent_reservations = $tamuReservationModel->getRecentReservations($user_id, 5);
$active_reservations = $tamuReservationModel->getActiveReservations($user_id);

// Jika gagal mengambil statistik, siapkan nilai default
if (!$stats) {
    $stats = [
        'total_reservasi' => 0,
        'reservasi_aktif' => 0,
        'total_checkout' => 0,
        'total_biaya_keseluruhan' => 0
    ];
}

// Memanggil file layout yang akan merangkai header, view, dan footer
require_once __DIR__ . '/../includes/layout.php';
