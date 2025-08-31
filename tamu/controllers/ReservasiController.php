<?php
// tamu/controllers/ReservasiController.php

require_once __DIR__ . '/../../config/koneksi.php';
require_once __DIR__ . '/../../models/TamuReservation.php';
require_once __DIR__ . '/../../models/Reservation.php'; // Panggil model Reservation
require_once __DIR__ . '/../includes/functions.php';

// Konfigurasi Halaman
$page_title = 'Reservasi Saya';

// Inisialisasi model
$tamuReservationModel = new TamuReservation();
$reservationModel = new Reservation(); // Inisialisasi model Reservation
$user_id = $_SESSION['user_id'];

// ROUTING SEDERHANA
$action = $_GET['action'] ?? 'index';
$id = $_GET['id'] ?? null;

// Variabel untuk view
$reservations = [];
$viewReservation = null;

switch ($action) {
    case 'cancel':
        // ... (logika cancel)
        break;

    case 'checkin':
        if ($id && $reservationModel->updateStatus($id, 'checkin')) {
            setSuccess('Anda berhasil check-in.');
        } else {
            setError('Gagal melakukan check-in.');
        }
        header('Location: reservasi.php');
        exit;

    case 'checkout':
        if ($id && $reservationModel->updateStatus($id, 'checkout')) {
            setSuccess('Anda berhasil check-out. Terima kasih atas kunjungan Anda.');
            // Redirect ke halaman invoice setelah checkout
            header('Location: ../public/invoice.php?id=' . $id);
            exit;
        } else {
            setError('Gagal melakukan check-out.');
        }
        header('Location: reservasi.php');
        exit;

    case 'view':
        // ... (logika view)
        break;

    default: // 'index'
        // ... (logika index)
        break;
}

// (Sisa file tetap sama)

// Memanggil file layout yang akan merangkai header, view, dan footer
require_once __DIR__ . '/../includes/layout.php';
