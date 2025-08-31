<?php
// login.php
session_start();

// Cek jika sudah login, arahkan ke dashboard
if (isset($_SESSION['logged_in']) && $_SESSION['logged_in']) {
    $role_dashboard_map = [
        'admin' => 'admin/dashboard.php',
        'resepsionis' => 'admin/dashboard.php',
        'tamu' => 'tamu/dashboardtamu.php',
        'manajer' => 'manager/dashboard.php'
    ];
    if (isset($role_dashboard_map[$_SESSION['role']])) {
        header('Location: ' . $role_dashboard_map[$_SESSION['role']]);
        exit;
    }
}

require_once 'config/koneksi.php';
require_once 'includes/auth.php';

$error_message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = $_POST['password'];

    if (Auth::login($username, $password)) {
        // --- LOGIKA BARU UNTUK REDIRECT ---
        if (isset($_GET['redirect']) && !empty($_GET['redirect'])) {
            // Jika ada parameter redirect, arahkan ke sana
            // Pastikan user adalah tamu untuk redirect booking
            if ($_SESSION['role'] === 'tamu') {
                header('Location: ' . urldecode($_GET['redirect']));
                exit;
            }
        }

        // --- LOGIKA LAMA (DEFAULT) ---
        $role_dashboard_map = [
            'admin' => 'admin/dashboard.php',
            'resepsionis' => 'admin/dashboard.php',
            'tamu' => 'tamu/dashboardtamu.php',
            'manajer' => 'manager/dashboard.php'
        ];
        if (isset($role_dashboard_map[$_SESSION['role']])) {
            header('Location: ' . $role_dashboard_map[$_SESSION['role']]);
            exit;
        }
    } else {
        $error_message = 'Username atau password salah!';
    }
}

// Bagian HTML dari login.php tetap sama
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Hotel System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background: #f8f9fa;
            min-height: 100vh;
            display: flex;
            align-items: center;
        }

        .login-card {
            background: white;
            border-radius: 20px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        .login-header {
            background: linear-gradient(135deg, #012A2A 0%, #A69C67 100%);
            color: white;
            text-align: center;
            padding: 2rem 1rem;
        }

        .login-body {
            padding: 2rem;
        }

        .form-floating>.form-control {
            border-radius: 10px;
        }

        .form-floating>.form-control:focus {
            border-color: #A69C67;
            box-shadow: 0 0 0 0.2rem rgba(166, 156, 103, 0.25);
        }

        .btn-login {
            background: linear-gradient(135deg, #012A2A 0%, #A69C67 100%);
            border: none;
            border-radius: 10px;
            padding: 12px;
            font-weight: 600;
        }

        .btn-login:hover {
            opacity: 0.9;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10 col-lg-5">
                <div class="login-card">
                    <div class="login-header">
                        <h3 class="mb-0">Tourism Hotel</h3>
                        <p class="mb-0 opacity-75">Silakan Masuk Untuk Memesan</p>
                    </div>
                    <div class="login-body">
                        <?php if (!empty($error_message)): ?>
                            <div class="alert alert-danger"><i class="fas fa-exclamation-triangle me-2"></i><?php echo $error_message; ?></div>
                        <?php endif; ?>
                        <?php if (isset($_GET['error'])): ?>
                            <div class="alert alert-warning"><i class="fas fa-info-circle me-2"></i><?php echo htmlspecialchars($_GET['error']); ?></div>
                        <?php endif; ?>

                        <form method="POST">
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" id="username" name="username" placeholder="Username" required>
                                <label for="username"><i class="fas fa-user me-2"></i>Username</label>
                            </div>
                            <div class="form-floating mb-4">
                                <input type="password" class="form-control" id="password" name="password" placeholder="Password" required>
                                <label for="password"><i class="fas fa-lock me-2"></i>Password</label>
                            </div>
                            <button type="submit" class="btn btn-primary btn-login w-100 mb-3 text-white">Masuk</button>
                        </form>
                        <div class="text-center">
                            <small class="text-muted">
                                Belum punya akun?
                                <a href="register.php<?php echo isset($_GET['redirect']) ? '?redirect=' . htmlspecialchars($_GET['redirect']) : ''; ?>">
                                    Daftar di sini
                                </a>
                            </small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>