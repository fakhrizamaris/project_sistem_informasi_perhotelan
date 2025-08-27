<?php
// admin/controllers/TamuController.php

require_once __DIR__ . '/../../config/koneksi.php';
require_once __DIR__ . '/../../models/Tamu.php';
require_once __DIR__ . '/../includes/functions.php';

$page_title = 'Kelola Data Tamu';
$guestModel = new Guest(); // Sesuai dengan nama class di file Tamu.php

// ROUTING SEDERHANA
$action = $_GET['action'] ?? 'index';
$id = $_GET['id'] ?? null;

switch ($action) {
    case 'create':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'nama' => $_POST['nama'],
                'no_identitas' => $_POST['no_identitas'],
                'alamat' => $_POST['alamat'],
                'no_hp' => $_POST['no_hp'],
                'email' => $_POST['email']
            ];

            if ($guestModel->create($data)) {
                setSuccess('Tamu baru berhasil ditambahkan.');
            } else {
                setError('Gagal menambahkan tamu. No identitas mungkin sudah terdaftar.');
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

    default: // 'index'
        $guests = $guestModel->getAll();
        require_once __DIR__ . '/../includes/layout.php';
        break;
}
