<?php
// tamu/controllers/PembayaranController.php

require_once __DIR__ . '/../../config/koneksi.php';
require_once __DIR__ . '/../../models/Tamu.php';
require_once __DIR__ . '/../../models/Pembayaran.php';
require_once __DIR__ . '/../includes/functions.php';

$page_title = 'Pembayaran Reservasi';
$user_id = $_SESSION['user_id'];
$reservation_id = $_GET['id'] ?? null;

if (!$reservation_id) {
    setError('ID Reservasi tidak valid.');
    header('Location: reservasi.php');
    exit;
}

$tamuModel = new TamuReservation();
$pembayaranModel = new Pembayaran();
$reservasi = null;

// Ambil semua reservasi untuk verifikasi kepemilikan
$semua_reservasi_user = $tamuModel->getAllReservations($user_id);
foreach ($semua_reservasi_user as $r) {
    if ($r['id_reservasi'] == $reservation_id) {
        $reservasi = $r;
        break;
    }
}

if (!$reservasi) {
    setError('Reservasi tidak ditemukan atau Anda tidak memiliki akses.');
    header('Location: reservasi.php');
    exit;
}

// Proses form upload bukti pembayaran
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['konfirmasi_pembayaran'])) {
    $data = [
        'id_reservasi' => $reservation_id,
        'metode' => $_POST['metode_pembayaran'],
        'jumlah' => $reservasi['total_biaya'],
        'file_bukti' => $_FILES['bukti_pembayaran']
    ];

    if ($pembayaranModel->create($data)) {
        setSuccess('Bukti pembayaran berhasil diunggah dan sedang menunggu verifikasi.');
        header('Location: reservasi.php');
        exit;
    } else {
        setError('Gagal mengunggah bukti pembayaran. Pastikan file adalah gambar dan ukurannya tidak lebih dari 2MB.');
    }
}

require_once __DIR__ . '/../includes/layout.php';
?>