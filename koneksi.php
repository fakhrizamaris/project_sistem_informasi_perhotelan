<?php
// config/database.php
// Konfigurasi koneksi database

// Informasi database - sesuaikan dengan setting XAMPP Anda
define('DB_HOST', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', ''); // Kosong untuk XAMPP default
define('DB_NAME', 'db_hotel');

class Database {
    private $host = DB_HOST;
    private $username = DB_USERNAME;
    private $password = DB_PASSWORD;
    private $database = DB_NAME;
    private $connection;
    
    // Method untuk membuat koneksi
    public function connect() {
        $this->connection = null;
        
        try {
            // Membuat koneksi PDO (lebih aman dari mysqli)
            $dsn = "mysql:host=" . $this->host . ";dbname=" . $this->database . ";charset=utf8";
            $this->connection = new PDO($dsn, $this->username, $this->password);
            
            // Set error mode untuk debugging
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
        } catch(PDOException $e) {
            echo "Koneksi gagal: " . $e->getMessage();
            die();
        }
        
        return $this->connection;
    }
    
    // Method untuk menutup koneksi
    public function close() {
        $this->connection = null;
    }
}

// Fungsi helper untuk mendapatkan koneksi database
function getDBConnection() {
    $database = new Database();
    return $database->connect();
}

// Test koneksi (bisa dihapus setelah yakin koneksi berhasil)
try {
    $db = getDBConnection();
    echo "Koneksi database berhasil!";
} catch(Exception $e) {
    die("Error koneksi database: " . $e->getMessage());
}
?>