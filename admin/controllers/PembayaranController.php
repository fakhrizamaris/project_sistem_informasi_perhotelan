<?php
// admin/controllers/PembayaranController.php

require_once __DIR__ . '/../../config/koneksi.php';
require_once __DIR__ . '/../../models/Pembayaran.php';
require_once __DIR__ . '/../includes/functions.php';

$page_title = 'Verifikasi Pembayaran';
$pembayaranModel = new Pembayaran();

// Aksi untuk verifikasi (approve/reject)
if (isset($_GET['action']) && isset($_GET['id'])) {
    $id_pembayaran = $_GET['id'];
    $action = $_GET['action'];

    if ($action == 'approve') {
        if ($pembayaranModel->verify($id_pembayaran, 'berhasil')) {
            setSuccess('Pembayaran berhasil diverifikasi.');
        } else {
            setError('Gagal memverifikasi pembayaran.');
        }
    } elseif ($action == 'reject') {
        if ($pembayaranModel->verify($id_pembayaran, 'gagal')) {
            setWarning('Pembayaran ditolak.');
        } else {
            setError('Gagal menolak pembayaran.');
        }
    }
    header('Location: pembayaran.php');
    exit;
}

// Ambil semua data pembayaran yang menunggu verifikasi
$pending_payments = $pembayaranModel->getPending();

require_once __DIR__ . '/../includes/layout.php';
?>