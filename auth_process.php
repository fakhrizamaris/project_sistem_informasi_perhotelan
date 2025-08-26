<?php
session_start();
require_once 'config/koneksi.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    if (empty($username) || empty($password)) {
        header("Location: login.php?error=Username dan password wajib diisi");
        exit();
    }

    $pdo = getDBConnection();

    try {
        $stmt = $pdo->prepare("SELECT id_user, username, password, role FROM users WHERE username = ?");
        $stmt->execute([$username]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        // Verifikasi user dan password (untuk sekarang kita samakan langsung, idealnya pakai password_hash)
        if ($user && $password === $user['password']) {
            // Simpan informasi user ke session
            $_SESSION['user_id'] = $user['id_user'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['role'] = $user['role'];

            // Redirect ke dashboard
            header("Location: admin/dashboard.php");
            exit();
        } else {
            header("Location: login.php?error=Username atau password salah");
            exit();
        }
    } catch (PDOException $e) {
        die("Error: " . $e->getMessage());
    }
} else {
    header("Location: login.php");
    exit();
}
