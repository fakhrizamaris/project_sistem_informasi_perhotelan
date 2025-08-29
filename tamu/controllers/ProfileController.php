<?php
// tamu/controllers/ProfileController.php

require_once __DIR__ . '/../../config/koneksi.php';
require_once __DIR__ . '/../includes/functions.php';

// Konfigurasi Halaman
$page_title = 'Profil Saya';
$user_id = $_SESSION['user_id'];

// ROUTING SEDERHANA
$action = $_GET['action'] ?? 'index';

// Ambil data profil tamu
$profile = getGuestProfile($user_id);

if (!$profile) {
    setError('Data profil tidak ditemukan.');
    header('Location: dashboard.php');
    exit;
}

switch ($action) {
    case 'update_profile':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'nama' => sanitizeInput($_POST['nama']),
                'username' => sanitizeInput($_POST['username']),
                'alamat' => sanitizeInput($_POST['alamat']),
                'no_hp' => sanitizeInput($_POST['no_hp']),
                'email' => sanitizeInput($_POST['email'])
            ];

            // Validasi email
            if (!empty($data['email']) && !isValidEmail($data['email'])) {
                setError('Format email tidak valid.');
                header('Location: profile.php');
                exit;
            }

            // Validasi nomor HP
            if (!empty($data['no_hp']) && !isValidPhoneNumber($data['no_hp'])) {
                setError('Format nomor handphone tidak valid. Gunakan format Indonesia (08xx atau +62xxx).');
                header('Location: profile.php');
                exit;
            }

            if (updateGuestProfile($user_id, $data)) {
                // Update session nama jika berubah
                $_SESSION['nama'] = $data['nama'];
                setSuccess('Profil berhasil diperbarui.');
            } else {
                setError('Gagal memperbarui profil. Username mungkin sudah digunakan.');
            }

            header('Location: profile.php');
            exit;
        }
        break;

    case 'change_password':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $old_password = $_POST['old_password'];
            $new_password = $_POST['new_password'];
            $confirm_password = $_POST['confirm_password'];

            // Validasi password baru
            if (strlen($new_password) < 6) {
                setError('Password baru minimal 6 karakter.');
                header('Location: profile.php');
                exit;
            }

            if ($new_password !== $confirm_password) {
                setError('Konfirmasi password tidak sama.');
                header('Location: profile.php');
                exit;
            }

            $result = changeGuestPassword($user_id, $old_password, $new_password);

            if ($result['success']) {
                setSuccess($result['message']);
            } else {
                setError($result['message']);
            }

            header('Location: profile.php');
            exit;
        }
        break;
}

// Refresh data profil setelah update
$profile = getGuestProfile($user_id);

// Memanggil file layout yang akan merangkai header, view, dan footer
require_once __DIR__ . '/../includes/layout.php';
