<?php
// includes/auth.php
// Sistem autentikasi sederhana

class Auth
{
    public static function login($username, $password)
    {
        try {
            $db = getDB();
            $stmt = $db->prepare("SELECT * FROM users WHERE username = ?");
            $stmt->execute([$username]);
            $user = $stmt->fetch();

            if ($user && password_verify($password, $user['password'])) {
                $_SESSION['user_id'] = $user['id_user'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['nama'] = $user['nama'];
                $_SESSION['role'] = $user['role'];
                $_SESSION['logged_in'] = true;

                return true;
            }
            return false;
        } catch (PDOException $e) {
            return false;
        }
    }

    public static function logout()
    {
        session_destroy();
        header('Location: ../login.php');
        exit;
    }

    public static function isLoggedIn()
    {
        return isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true;
    }

    public static function requireAuth()
    {
        if (!self::isLoggedIn()) {
            header('Location: ../login.php');
            exit;
        }
    }

    public static function requireRole($role)
    {
        self::requireAuth();
        if ($_SESSION['role'] !== $role) {
            header('Location: ../login.php?error=Access denied');
            exit;
        }
    }

    public static function getUser()
    {
        if (self::isLoggedIn()) {
            return [
                'id' => $_SESSION['user_id'],
                'username' => $_SESSION['username'],
                'nama' => $_SESSION['nama'],
                'role' => $_SESSION['role']
            ];
        }
        return null;
    }
}

// Helper function
function auth()
{
    return new Auth();
}
