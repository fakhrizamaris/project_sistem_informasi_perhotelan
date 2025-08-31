<?php
// register.php
session_start();
require_once 'includes/auth.php'; // Menambahkan file class Auth
require_once 'config/koneksi.php';
require_once 'models/Pegawai.php'; // Model ini berisi fungsi untuk membuat user tamu
require_once 'admin/includes/functions.php'; // Menggunakan functions dari admin

$error_messages = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userModel = new Pegawai();

    // Ambil dan bersihkan data dari form
    $nama = sanitizeInput($_POST['nama']);
    $username = sanitizeInput($_POST['username']);
    $email = sanitizeInput($_POST['email']);
    $no_hp = sanitizeInput($_POST['no_hp']);
    $no_identitas = sanitizeInput($_POST['no_identitas']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // --- Validasi ---
    if ($password !== $confirm_password) {
        $error_messages[] = "Konfirmasi password tidak cocok.";
    }
    if (strlen($password) < 6) {
        $error_messages[] = "Password minimal harus 6 karakter.";
    }
    if ($userModel->isUsernameExists($username)) {
        $error_messages[] = "Username sudah digunakan. Silakan pilih yang lain.";
    }
    if ($userModel->isIdentityNumberExists($no_identitas)) {
        $error_messages[] = "Nomor identitas sudah terdaftar.";
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error_messages[] = "Format email tidak valid.";
    }

    if (empty($error_messages)) {
        $data = [
            'nama' => $nama,
            'username' => $username,
            'password' => $password,
            'no_identitas' => $no_identitas,
            'no_hp' => $no_hp,
            'email' => $email
        ];

        if ($userModel->createGuestUserAndProfile($data)) {
            // Jika pendaftaran berhasil, arahkan ke halaman login dengan pesan sukses.
            // Jangan login-kan pengguna secara otomatis.

            // Cek apakah ada redirect URL, jika ada, teruskan ke halaman login
            $redirectUrl = '';
            if (isset($_POST['redirect']) && !empty($_POST['redirect'])) {
                $redirectUrl = '&redirect=' . urlencode($_POST['redirect']);
            }

            header('Location: login.php?success=registration_completed' . $redirectUrl);
            exit;
        } else {
            $error_messages[] = "Terjadi kesalahan saat mendaftarkan akun. Silakan coba lagi.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Akun - Tourism Hotel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background: #f8f9fa;
        }

        .register-card {
            margin-top: 3rem;
            margin-bottom: 3rem;
            background: white;
            border-radius: 20px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        .register-header {
            background: linear-gradient(135deg, #012A2A 0%, #A69C67 100%);
            color: white;
            text-align: center;
            padding: 2rem 1rem;
        }

        .register-body {
            padding: 2rem;
        }

        .form-control {
            border-radius: 10px;
        }

        .btn-register {
            background: linear-gradient(135deg, #012A2A 0%, #A69C67 100%);
            border: none;
            border-radius: 10px;
            padding: 12px;
            font-weight: 600;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10 col-lg-6">
                <div class="register-card">
                    <div class="register-header">
                        <h3 class="mb-0">Buat Akun Baru</h3>
                        <p class="mb-0 opacity-75">Daftar untuk mulai memesan kamar</p>
                    </div>
                    <div class="register-body">
                        <?php if (!empty($error_messages)): ?>
                            <div class="alert alert-danger">
                                <?php foreach ($error_messages as $error): ?>
                                    <p class="mb-0"><?php echo $error; ?></p>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>

                        <form method="POST">
                            <input type="hidden" name="redirect" value="<?php echo isset($_GET['redirect']) ? htmlspecialchars($_GET['redirect']) : ''; ?>">

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="nama" class="form-label">Nama Lengkap</label>
                                    <input type="text" class="form-control" id="nama" name="nama" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="username" class="form-label">Username</label>
                                    <input type="text" class="form-control" id="username" name="username" required>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" name="email" required>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="no_hp" class="form-label">No. Handphone</label>
                                    <input type="tel" class="form-control" id="no_hp" name="no_hp" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="no_identitas" class="form-label">No. Identitas (KTP/Passport)</label>
                                    <input type="text" class="form-control" id="no_identitas" name="no_identitas" required>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="password" class="form-label">Password</label>
                                    <input type="password" class="form-control" id="password" name="password" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="confirm_password" class="form-label">Konfirmasi Password</label>
                                    <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary btn-register w-100 text-white mt-3">Daftar</button>
                        </form>
                        <div class="text-center mt-3">
                            <small class="text-muted">
                                Sudah punya akun? <a href="login.php<?php echo isset($_GET['redirect']) ? '?redirect=' . htmlspecialchars($_GET['redirect']) : ''; ?>">Masuk di sini</a>
                            </small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>