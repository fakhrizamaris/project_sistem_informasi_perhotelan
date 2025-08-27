<?php
session_start();
// Memanggil file koneksi ke database
require_once 'config/koneksi.php';

// Memastikan request adalah metode POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Mengambil username dan password dari form
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Validasi dasar: pastikan input tidak kosong
    if (empty($username) || empty($password)) {
        // Jika kosong, kembalikan ke halaman login dengan pesan error
        header("Location: login.php?error=Username dan password wajib diisi");
        exit();
    }

    // Mendapatkan koneksi database
    $pdo = getDB();

    try {
        // Menyiapkan query untuk mencari user berdasarkan username
        // Mengambil semua data yang dibutuhkan untuk session
        $stmt = $pdo->prepare("SELECT id_user, username, password, nama, role FROM users WHERE username = ?");
        $stmt->execute([$username]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        // --- PERUBAHAN UTAMA ADA DI SINI ---
        // Memverifikasi apakah user ditemukan DAN password yang diinput sesuai dengan hash di database
        if ($user && password_verify($password, $user['password'])) {
            // Jika verifikasi berhasil, simpan informasi user ke dalam session

            session_regenerate_id(true); // Mencegah session fixation attacks

            $_SESSION['user_id'] = $user['id_user'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['nama'] = $user['nama']; // Menyimpan nama untuk ditampilkan di dashboard
            $_SESSION['role'] = $user['role'];

            // Arahkan user ke dashboard admin
            header("Location: admin/dashboard.php");
            exit();
        } else {
            // Jika user tidak ditemukan atau password salah, kembalikan ke halaman login
            header("Location: login.php?error=Username atau password salah");
            exit();
        }
    } catch (PDOException $e) {
        // Jika terjadi error pada database, tampilkan pesan generik atau log error
        // die("Error: " . $e->getMessage()); // Jangan tampilkan pesan error detail di production
        header("Location: login.php?error=Terjadi masalah pada sistem");
        exit();
    }
} else {
    // Jika halaman diakses bukan dengan metode POST, kembalikan ke halaman login
    header("Location: login.php");
    exit();
}
