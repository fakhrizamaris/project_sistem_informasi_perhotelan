<?php
// admin/controllers/StaffController.php

require_once '../config/koneksi.php';
require_once '../models/Pegawai.php'; // Menggunakan model Pegawai yang baru
require_once 'includes/functions.php';

$staffModel = new Pegawai();
$page_title = 'Kelola Staff';

// Logika untuk menambah staff baru
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'create') {
    $data = [
        'nama' => $_POST['nama'],
        'username' => $_POST['username'],
        'password' => $_POST['password'],
        'role' => $_POST['role']
    ];

    if ($staffModel->create($data)) {
        setSuccess('Staff baru berhasil ditambahkan.');
    } else {
        setError('Gagal menambahkan staff. Username mungkin sudah digunakan.');
    }
    header('Location: manage_staff.php');
    exit;
}

// Mengambil semua data staff untuk ditampilkan di view
$staff_list = $staffModel->getAll();

require_once 'includes/layout.php';
