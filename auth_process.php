<?php
session_start();
// 1. Panggil file koneksi ke database
require_once 'config/koneksi.php';

// 2. Pastikan request adalah metode POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Mengambil username dan password dari form
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Validasi dasar: pastikan input tidak kosong
    if (empty($username) || empty($password)) {
        header("Location: login.php?error=Username dan password wajib diisi");
        exit();
    }

    // 3. Dapatkan koneksi database dan simpan ke variabel $pdo
    $pdo = getDB();

    try {
        // 4. Siapkan dan eksekusi query menggunakan $pdo
        $stmt = $pdo->prepare("SELECT id_user, username, password, nama, role FROM users WHERE username = ?");
        $stmt->execute([$username]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        // Memverifikasi apakah user ditemukan DAN password yang diinput sesuai
        if ($user && password_verify($password, $user['password'])) {
            session_regenerate_id(true);

            $_SESSION['user_id'] = $user['id_user'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['nama'] = $user['nama'];
            $_SESSION['role'] = $user['role'];

            // --- TAMBAHKAN BARIS INI ---
            $_SESSION['logged_in'] = true;

            // Arahkan user ke dashboard yang sesuai dengan rolenya
            if ($user['role'] === 'tamu') {
                header("Location: tamu/dashboardtamu.php");
            } else {
                header("Location: admin/dashboard.php");
            }
            exit();
        } else {
            // Jika user tidak ditemukan atau password salah
            header("Location: login.php?error=Username atau password salah");
            exit();
        }
    } catch (PDOException $e) {
        // Jika terjadi error pada database
        // die("Error: " . $e->getMessage()); // Baris ini bisa diaktifkan untuk debugging
        header("Location: login.php?error=Terjadi masalah pada sistem");
        exit();
    }
} else {
    // Jika halaman diakses bukan dengan metode POST
    header("Location: login.php");
    exit();
}
