<?php
// admin/controllers/GuestUserController.php

require_once __DIR__ . '/../../config/koneksi.php';
require_once __DIR__ . '/../../models/Pegawai.php'; // Kita pakai model Pegawai
require_once __DIR__ . '/../includes/functions.php';

$userModel = new Pegawai(); // Inisialisasi model
$page_title = 'Kelola User Tamu';

// Logika untuk menambah user tamu baru
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'create_guest_user') {
    $data = [
        'nama'         => $_POST['nama'],
        'username'     => $_POST['username'],
        'password'     => $_POST['password'],
        'no_identitas' => $_POST['no_identitas'],
        'no_hp'        => $_POST['no_hp'],
        'email'        => $_POST['email']
    ];

    if ($userModel->createGuestUserAndProfile($data)) {
        setSuccess('User tamu baru berhasil ditambahkan.');
    } else {
        setError('Gagal menambahkan user tamu. Username atau No. Identitas mungkin sudah digunakan.');
    }
    header('Location: manage_guest_users.php');
    exit;
}

// Mengambil semua data user tamu untuk ditampilkan
$guest_users = $userModel->getAllGuestUsers();

require_once __DIR__ . '/../includes/layout.php';
