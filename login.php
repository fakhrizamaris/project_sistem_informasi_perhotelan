<?php
// login.php
session_start();

// Jika sudah login, redirect ke dashboard sesuai role
if (isset($_SESSION['logged_in']) && $_SESSION['logged_in']) {
    if ($_SESSION['role'] === 'admin') {
        header('Location: admin/dashboard.php');
    } elseif ($_SESSION['role'] === 'tamu') {
        header('Location: tamu/dashboardtamu.php');
    } else {
        header('Location: admin/dashboard.php'); // Default untuk role lain
    }
    exit;
}

require_once 'config/koneksi.php';
require_once 'includes/auth.php';

$error_message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = $_POST['password'];

    if (Auth::login($username, $password)) {
        // Redirect berdasarkan role setelah login berhasil
        if ($_SESSION['role'] === 'admin') {
            header('Location: admin/dashboard.php');
        } elseif ($_SESSION['role'] === 'tamu') {
            header('Location: tamu/dashboard.php');
        } else {
            header('Location: admin/dashboard.php'); // Default
        }
        exit;
    } else {
        $error_message = 'Username atau password salah!';
    }
}
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
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
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
            background: linear-gradient(135deg, #2c3e50 0%, #3498db 100%);
            color: white;
            text-align: center;
            padding: 2rem 1rem;
        }

        .login-body {
            padding: 2rem;
        }

        .form-floating>.form-control {
            border: 2px solid #e9ecef;
            border-radius: 10px;
        }

        .form-floating>.form-control:focus {
            border-color: #3498db;
            box-shadow: 0 0 0 0.2rem rgba(52, 152, 219, 0.25);
        }

        .btn-login {
            background: linear-gradient(135deg, #2c3e50 0%, #3498db 100%);
            border: none;
            border-radius: 10px;
            padding: 12px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(52, 152, 219, 0.4);
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-5">
                <div class="login-card">
                    <div class="login-header">
                        <i class="fas fa-hotel fa-3x mb-3"></i>
                        <h3 class="mb-0">Hotel System</h3>
                        <p class="mb-0 opacity-75">Masuk ke Akun Anda</p>
                    </div>

                    <div class="login-body">
                        <?php if (!empty($error_message)): ?>
                            <div class="alert alert-danger" role="alert">
                                <i class="fas fa-exclamation-triangle me-2"></i>
                                <?php echo $error_message; ?>
                            </div>
                        <?php endif; ?>

                        <?php if (isset($_GET['error'])): ?>
                            <div class="alert alert-warning" role="alert">
                                <i class="fas fa-info-circle me-2"></i>
                                <?php echo htmlspecialchars($_GET['error']); ?>
                            </div>
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

                            <button type="submit" class="btn btn-primary btn-login w-100 mb-3">
                                <i class="fas fa-sign-in-alt me-2"></i>Masuk
                            </button>
                        </form>

                        <div class="text-center">
                            <small class="text-muted">
                                Belum punya akun? Hubungi administrator hotel untuk mendaftar.
                            </small>
                        </div>
                    </div>
                </div>

                <!-- Demo Credentials -->
                <div class="card mt-4 bg-light">
                    <div class="card-body">
                        <h6 class="card-title">Demo Login</h6>
                        <div class="row">
                            <div class="col-6">
                                <small class="text-muted">Admin:</small><br>
                                <small><strong>admin / admin123</strong></small>
                            </div>
                            <div class="col-6">
                                <small class="text-muted">Tamu:</small><br>
                                <small><strong>Buat akun melalui admin</strong></small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>