<?php
// admin/controllers/StaffController.php

require_once __DIR__ . '/../../config/koneksi.php';
require_once __DIR__ . '/../../models/Pegawai.php';
require_once __DIR__ . '/../includes/functions.php';

$staffModel = new Pegawai();
$page_title = 'Kelola Staff';
$staff_to_edit = null;

// ROUTING
$action = $_GET['action'] ?? 'index';
$id = $_GET['id'] ?? null; // Ini adalah id_pegawai

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action_post = $_POST['action'] ?? '';

    if ($action_post === 'create') {
        $data = [
            'nama'      => $_POST['nama'],
            'jabatan'   => $_POST['jabatan'],
            'username'  => $_POST['username'],
            'password'  => $_POST['password'],
            'role'      => $_POST['role'],
            'status'    => 'aktif'
        ];
        if ($staffModel->create($data)) {
            setSuccess('Staff baru berhasil ditambahkan.');
        } else {
            setError('Gagal menambahkan staff. Username mungkin sudah digunakan.');
        }
        header('Location: manage_staff.php');
        exit;
    } elseif ($action === 'update' && $id) {
        $data = [
            'nama'      => $_POST['nama'],
            'jabatan'   => $_POST['jabatan'],
            'status'    => $_POST['status'],
            'username'  => $_POST['username'],
            'password'  => $_POST['password'], // Boleh kosong
            'role'      => $_POST['role']
        ];
        if ($staffModel->update($id, $data)) {
            setSuccess('Data staff berhasil diperbarui.');
        } else {
            setError('Gagal memperbarui data staff.');
        }
        header('Location: manage_staff.php');
        exit;
    }
} else { // Metode GET
    switch ($action) {
        case 'edit':
            if ($id) {
                $staff_to_edit = $staffModel->getById($id);
            }
            break;
        case 'delete':
            if ($id) {
                if ($staffModel->delete($id)) {
                    setSuccess('Data staff berhasil dihapus.');
                } else {
                    setError('Gagal menghapus staff.');
                }
                header('Location: manage_staff.php');
                exit;
            }
            break;
    }
}

// Mengambil semua data staff untuk ditampilkan di tabel
$staff_list = $staffModel->getAll();
require_once __DIR__ . '/../includes/layout.php';
