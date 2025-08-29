<?php
// tamu/controllers/riwayat_controller.php

require_once __DIR__ . '/../../config/koneksi.php';
require_once __DIR__ . '/../../models/TamuReservation.php';
require_once __DIR__ . '/../../admin/includes/functions.php'; // Kita gunakan functions.php dari admin untuk format tanggal dll

$page_title = 'Riwayat Reservasi';
$tamuReservationModel = new TamuReservation();

// Dapatkan id_tamu dari user yang login
// Perlu query untuk mencari id_tamu berdasarkan $_SESSION['user_id']
$db = getDB();
$stmt = $db->prepare("SELECT id_tamu FROM tamu WHERE id_user = ?");
$stmt->execute([$_SESSION['user_id']]);
$tamu = $stmt->fetch();
$id_tamu = $tamu ? $tamu['id_tamu'] : null;

$riwayat_reservasi = [];
if ($id_tamu) {
    // Gunakan method yang ada di model Tamu untuk ambil riwayat
    $riwayat_reservasi = $guestModel->getReservationHistory($id_tamu);
}

// Panggil layout untuk menampilkan halaman
require_once __DIR__ . '/../includes/layout.php';
