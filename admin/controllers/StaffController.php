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
$id = $_GET['id'] ?? null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? $action;
    switch ($action) {
        case 'create':
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
            break;
        case 'update':
            $data = [
                'nama' => $_POST['nama'],
                'username' => $_POST['username'],
                'password' => $_POST['password'], // Kosongkan jika tidak ingin ganti
                'role' => $_POST['role']
            ];
            if ($staffModel->update($id, $data)) {
                setSuccess('Data staff berhasil diperbarui.');
            } else {
                setError('Gagal memperbarui data staff.');
            }
            break;
    }
    header('Location: manage_staff.php');
    exit;
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
                    setError('Gagal menghapus staff. Anda tidak bisa menghapus akun sendiri.');
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
