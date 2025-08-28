<?php
// admin/controllers/UsersController.php

require_once __DIR__ . '/../../config/koneksi.php';
require_once __DIR__ . '/../../models/Pegawai.php';
require_once __DIR__ . '/../includes/functions.php';

$page_title = 'Data Semua User';
$userModel = new Pegawai();
$user_to_edit = null;

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
            if ($userModel->createUser($data)) {
                setSuccess('User baru berhasil ditambahkan.');
            } else {
                setError('Gagal menambahkan user. Username mungkin sudah digunakan.');
            }
            break;
        case 'update':
            $data = [
                'nama' => $_POST['nama'],
                'username' => $_POST['username'],
                'password' => $_POST['password'], // Kosongkan jika tidak ingin ganti
                'role' => $_POST['role']
            ];
            if ($userModel->updateUser($id, $data)) {
                setSuccess('Data user berhasil diperbarui.');
            } else {
                setError('Gagal memperbarui data user.');
            }
            break;
    }
    header('Location: users.php');
    exit;
} else { // Metode GET
    switch ($action) {
        case 'edit':
            if ($id) {
                $user_to_edit = $userModel->getUserById($id);
            }
            break;
        case 'delete':
            if ($id) {
                if ($userModel->deleteUser($id)) {
                    setSuccess('User berhasil dihapus.');
                } else {
                    setError('Gagal menghapus user. User mungkin terhubung dengan data lain atau Anda mencoba menghapus akun sendiri.');
                }
                header('Location: users.php');
                exit;
            }
            break;
    }
}

// Mengambil semua data user
$all_users = $userModel->getAllUsers();

// Memanggil file layout
require_once __DIR__ . '/../includes/layout.php';
