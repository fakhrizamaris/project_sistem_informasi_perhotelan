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

// Logika untuk menangani request POST (dari form tambah atau edit)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Ambil aksi dari hidden input di dalam form
    $action_post = $_POST['action'] ?? '';

    if ($action_post === 'create_guest_user') {
        // Validasi input
        $errors = [];

        // Validasi required fields
        $requiredFields = ['nama', 'username', 'password', 'no_identitas', 'no_hp', 'email'];
        foreach ($requiredFields as $field) {
            if (empty($_POST[$field])) {
                $errors[] = "Field " . ucfirst(str_replace('_', ' ', $field)) . " harus diisi.";
            }
        }

        // Validasi username unik
        if (!empty($_POST['username']) && $userModel->isUsernameExists($_POST['username'])) {
            $errors[] = "Username sudah digunakan.";
        }

        // Validasi no_identitas unik
        if (!empty($_POST['no_identitas']) && $userModel->isIdentityNumberExists($_POST['no_identitas'])) {
            $errors[] = "No. Identitas sudah terdaftar.";
        }

        // Validasi email format
        if (!empty($_POST['email']) && !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
            $errors[] = "Format email tidak valid.";
        }

        // Jika ada error, tampilkan pesan error
        if (!empty($errors)) {
            setError(implode(' ', $errors));
        } else {
            // Jika tidak ada error, proses insert data
            $data = [
                'nama'         => trim($_POST['nama']),
                'username'     => trim($_POST['username']),
                'password'     => $_POST['password'],
                'no_identitas' => trim($_POST['no_identitas']),
                'no_hp'        => trim($_POST['no_hp']),
                'email'        => trim($_POST['email'])
            ];

            if ($userModel->createGuestUserAndProfile($data)) {
                setSuccess('User tamu baru berhasil ditambahkan.');
                // Redirect untuk mencegah double submit
                header('Location: manage_guest_users.php');
                exit;
            } else {
                setError('Gagal menambahkan user tamu. Silakan coba lagi.');
            }
        }
    } elseif ($action === 'update_guest_user' && $id) {
        // Validasi input untuk update
        $errors = [];

        // Validasi required fields (kecuali password yang bisa kosong)
        $requiredFields = ['nama', 'username', 'no_identitas', 'no_hp', 'email'];
        foreach ($requiredFields as $field) {
            if (empty($_POST[$field])) {
                $errors[] = "Field " . ucfirst(str_replace('_', ' ', $field)) . " harus diisi.";
            }
        }

        // Validasi username unik (kecuali untuk user yang sedang diedit)
        if (!empty($_POST['username']) && $userModel->isUsernameExists($_POST['username'], $id)) {
            $errors[] = "Username sudah digunakan oleh user lain.";
        }

        // Validasi no_identitas unik (kecuali untuk user yang sedang diedit)
        if (!empty($_POST['no_identitas']) && $userModel->isIdentityNumberExists($_POST['no_identitas'], $id)) {
            $errors[] = "No. Identitas sudah terdaftar oleh user lain.";
        }

        // Validasi email format
        if (!empty($_POST['email']) && !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
            $errors[] = "Format email tidak valid.";
        }

        // Jika ada error, tampilkan pesan error
        if (!empty($errors)) {
            setError(implode(' ', $errors));
            // Set data untuk tetap menampilkan modal edit
            $guest_user_to_edit = $userModel->getGuestUserById($id);
        } else {
            // Jika tidak ada error, proses update data
            $data = [
                'nama'         => trim($_POST['nama']),
                'username'     => trim($_POST['username']),
                'password'     => $_POST['password'], // Boleh kosong
                'no_identitas' => trim($_POST['no_identitas']),
                'no_hp'        => trim($_POST['no_hp']),
                'email'        => trim($_POST['email'])
            ];

            if ($userModel->updateGuestUser($id, $data)) {
                setSuccess('Data user tamu berhasil diperbarui.');
                header('Location: manage_guest_users.php');
                exit;
            } else {
                setError('Gagal memperbarui data user tamu. Silakan coba lagi.');
                // Set data untuk tetap menampilkan modal edit
                $guest_user_to_edit = $userModel->getGuestUserById($id);
            }
        }
    }
}

// Logika untuk menangani request GET (untuk menampilkan halaman, edit, dan delete)
if ($action === 'edit' && $id) {
    $guest_user_to_edit = $userModel->getGuestUserById($id);
    if (!$guest_user_to_edit) {
        setError('User tamu tidak ditemukan.');
        header('Location: manage_guest_users.php');
        exit;
    }
} elseif ($action === 'delete' && $id) {
    if ($userModel->deleteGuestUser($id)) {
        setSuccess('User tamu berhasil dihapus.');
    } else {
        setError('Gagal menghapus user tamu. User mungkin memiliki reservasi aktif.');
    }
    header('Location: manage_guest_users.php');
    exit;
}

// Selalu ambil semua data user tamu TERBARU dari database untuk ditampilkan
$guest_users = $userModel->getAllGuestUsers();
require_once __DIR__ . '/../includes/layout.php';
