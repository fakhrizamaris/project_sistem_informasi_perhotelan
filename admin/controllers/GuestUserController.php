<?php
// admin/controllers/GuestUserController.php

require_once __DIR__ . '/../../config/koneksi.php';
require_once __DIR__ . '/../../models/Pegawai.php';
require_once __DIR__ . '/../includes/functions.php';

$userModel = new Pegawai();
$page_title = 'Kelola User Tamu';
$guest_user_to_edit = null;

$action = $_GET['action'] ?? 'index';
$id = $_GET['id'] ?? null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Ambil aksi dari input tersembunyi jika ada, jika tidak, gunakan dari URL
    $action_post = $_POST['action'] ?? $action;

    switch ($action_post) {
        case 'create_guest_user':
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
            break;

        case 'update_guest_user':
            // Ambil id dari URL
            $id_update = $_GET['id'] ?? null;
            if ($id_update) {
                $data = [
                    'nama' => $_POST['nama'],
                    'username' => $_POST['username'],
                    'password' => $_POST['password'],
                    'no_identitas' => $_POST['no_identitas'],
                    'no_hp' => $_POST['no_hp'],
                    'email' => $_POST['email']
                ];
                if ($userModel->updateGuestUser($id_update, $data)) {
                    setSuccess('Data user tamu berhasil diperbarui.');
                } else {
                    setError('Gagal memperbarui data user tamu.');
                }
            }
            break;
    }
    header('Location: manage_guest_users.php');
    exit;
} else { // Metode GET
    switch ($action) {
        case 'edit':
            if ($id) {
                $guest_user_to_edit = $userModel->getGuestUserById($id);
            }
            break;
        case 'delete':
            if ($id) {
                if ($userModel->deleteGuestUser($id)) {
                    setSuccess('User tamu berhasil dihapus.');
                } else {
                    setError('Gagal menghapus user tamu. User mungkin memiliki reservasi aktif.');
                }
                header('Location: manage_guest_users.php');
                exit;
            }
            break;
    }
}

// Mengambil semua data user tamu untuk ditampilkan
$guest_users = $userModel->getAllGuestUsers();
require_once __DIR__ . '/../includes/layout.php';
