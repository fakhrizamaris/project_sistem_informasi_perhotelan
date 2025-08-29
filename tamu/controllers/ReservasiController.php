<?php
// tamu/controllers/ReservasiController.php

require_once __DIR__ . '/../../config/koneksi.php';
require_once __DIR__ . '/../../models/TamuReservation.php';
require_once __DIR__ . '/../includes/functions.php';

// Konfigurasi Halaman
$page_title = 'Reservasi Saya';

// Inisialisasi model
$tamuReservationModel = new TamuReservation();
$user_id = $_SESSION['user_id'];

// ROUTING SEDERHANA
$action = $_GET['action'] ?? 'index';
$id = $_GET['id'] ?? null;

// Variabel untuk view
$reservations = [];
$viewReservation = null;

switch ($action) {
    case 'cancel':
        if ($id) {
            if ($tamuReservationModel->cancelReservation($user_id, $id)) {
                setSuccess('Reservasi berhasil dibatalkan.');
            } else {
                setError('Gagal membatalkan reservasi. Pastikan reservasi masih dalam status pending dan belum melewati batas waktu pembatalan.');
            }
        }
        header('Location: reservasi.php');
        exit;

    case 'view':
        // Tidak perlu action khusus, akan ditangani di view
        break;

    default: // 'index'
        $reservations = $tamuReservationModel->getAllReservations($user_id);

        // Jika ada parameter view, ambil detail reservasi
        if (isset($_GET['view'])) {
            $view_id = $_GET['view'];
            foreach ($reservations as $res) {
                if ($res['id_reservasi'] == $view_id) {
                    $viewReservation = $res;
                    break;
                }
            }
        }
        break;
}

// Memanggil file layout yang akan merangkai header, view, dan footer
require_once __DIR__ . '/../includes/layout.php';
