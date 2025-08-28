<?php
session_start();
// Memanggil file koneksi ke database
require_once 'config/koneksi.php';

// Memastikan request adalah metode POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // ... (kode pengambilan username & password)

    try {
        // ... (kode query SELECT user)
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password'])) {
            session_regenerate_id(true);

            $_SESSION['user_id'] = $user['id_user'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['nama'] = $user['nama'];
            $_SESSION['role'] = $user['role'];

            // --- INI BAGIAN YANG DIUBAH ---
            if ($user['role'] === 'tamu') {
                // Jika role adalah tamu, arahkan ke dashboard tamu
                header("Location: tamu/dashboardtamu.php");
            } else {
                // Jika bukan, arahkan ke dashboard admin
                header("Location: admin/dashboard.php");
            }
            exit();
        } else {
            header("Location: login.php?error=Username atau password salah");
            exit();
        }
    } catch (PDOException $e) {
        header("Location: login.php?error=Terjadi masalah pada sistem");
        exit();
    }
} else {
    header("Location: login.php");
    exit();
}
