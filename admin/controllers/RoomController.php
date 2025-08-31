<?php
// admin/controllers/RoomController.php

require_once __DIR__ . '/../../config/koneksi.php';
require_once __DIR__ . '/../../models/Room.php';
require_once __DIR__ . '/../includes/functions.php';

$page_title = 'Kelola Kamar';
$roomModel = new Room();

// Variabel untuk menampung data kamar yang akan diedit
$room_to_edit = null;

// ROUTING SEDERHANA
$action = $_GET['action'] ?? 'index';
$id = $_GET['id'] ?? null;

// Logika untuk menangani request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($action === 'create') {
        $data = [
            'no_kamar' => $_POST['no_kamar'],
            'tipe_kamar' => $_POST['tipe_kamar'],
            'harga' => $_POST['harga'],
            'status' => 'kosong' // Status default saat dibuat
        ];

        if ($roomModel->create($data)) {
            setSuccess('Kamar baru berhasil ditambahkan.');
        } else {
            setError('Gagal menambahkan kamar. Nomor kamar mungkin sudah ada.');
        }
        header('Location: manage_rooms.php');
        exit;
    } elseif ($action === 'update' && $id) {
        $data = [
            'no_kamar' => $_POST['no_kamar'],
            'tipe_kamar' => $_POST['tipe_kamar'],
            'harga' => $_POST['harga'],
            'status' => $_POST['status']
        ];
        if ($roomModel->update($id, $data)) {
            setSuccess('Data kamar berhasil diperbarui.');
        } else {
            setError('Gagal memperbarui data kamar.');
        }
        header('Location: manage_rooms.php');
        exit;
    }
} else { // Metode GET
    if ($action === 'delete' && $id) {
        if ($roomModel->delete($id)) {
            setSuccess('Kamar berhasil dihapus.');
        } else {
            setError('Gagal menghapus kamar. Kamar mungkin sedang digunakan dalam reservasi.');
        }
        header('Location: manage_rooms.php');
        exit;
    } elseif ($action === 'edit' && $id) {
        $room_to_edit = $roomModel->getById($id);
    }
}

// Ambil semua data untuk ditampilkan di tabel
$rooms = $roomModel->getAll();
$stats = $roomModel->getRoomStatistics();

// Panggil layout utama
require_once __DIR__ . '/../includes/layout.php';
