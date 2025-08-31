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
        if ($id && $tamuReservationModel->cancelReservation($user_id, $id)) {
            setSuccess('Reservasi berhasil dibatalkan.');
        } else {
            setError('Gagal membatalkan reservasi. Mungkin reservasi sudah dikonfirmasi atau sudah lewat waktunya.');
        }
        header('Location: reservasi.php');
        exit;

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
        if ($id) {
            // Logika untuk menampilkan detail satu reservasi (opsional, jika diperlukan)
            // Untuk saat ini, modal di view sudah cukup
        }
        break;

    default: // 'index' atau jika tidak ada aksi
        // Ambil semua data reservasi untuk tamu yang login
        $reservations = $tamuReservationModel->getAllReservations($user_id);
        break;
}

// Memanggil file layout yang akan merangkai header, view, dan footer
require_once __DIR__ . '/../includes/layout.php';
