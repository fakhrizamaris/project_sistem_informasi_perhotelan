<?php
// admin/controllers/TamuController.php

require_once __DIR__ . '/../../config/koneksi.php';
require_once __DIR__ . '/../../models/Tamu.php';
require_once __DIR__ . '/../includes/functions.php';

$page_title = 'Kelola Data Tamu';
$guestModel = new Guest();

// Variabel untuk menampung data tamu yang akan diedit
$guest_to_edit = null;

// ROUTING SEDERHANA
$action = $_GET['action'] ?? 'index';
$id = $_GET['id'] ?? null;

switch ($action) {
    case 'create':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // ... (kode create yang sudah ada, tidak perlu diubah)
        }
        break;

    case 'edit':
        if ($id) {
            $guest_to_edit = $guestModel->getById($id);
        }
        break;

    case 'update':
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && $id) {
            $data = [
                'nama' => $_POST['nama'],
                'no_identitas' => $_POST['no_identitas'],
                'alamat' => $_POST['alamat'],
                'no_hp' => $_POST['no_hp'],
                'email' => $_POST['email']
            ];

            if ($guestModel->update($id, $data)) {
                setSuccess('Data tamu berhasil diperbarui.');
            } else {
                setError('Gagal memperbarui data tamu.');
            }
            header('Location: tamu.php');
            exit;
        }
        break;

    case 'delete':
        if ($guestModel->delete($id)) {
            setSuccess('Data tamu berhasil dihapus.');
        } else {
            setError('Gagal menghapus data. Tamu mungkin memiliki riwayat reservasi.');
        }
        header('Location: tamu.php');
        exit;
}

// Selalu ambil semua data tamu untuk ditampilkan di tabel
$guests = $guestModel->getAll();
require_once __DIR__ . '/../includes/layout.php';
