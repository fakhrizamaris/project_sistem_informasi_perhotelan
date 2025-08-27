<?php
// models/Pegawai.php

class Pegawai
{
    private $db;

    public function __construct()
    {
        // Fungsi getDB() berasal dari file koneksi.php
        $this->db = getDB();
    }

    /**
     * Mengambil semua data pegawai (user)
     */
    public function getAll()
    {
        // Mengambil semua user kecuali tamu
        $stmt = $this->db->query("SELECT id_user, username, nama, role FROM users WHERE role != 'tamu' ORDER BY nama ASC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Membuat pegawai baru
     */
    public function create($data)
    {
        try {
            $hashedPassword = password_hash($data['password'], PASSWORD_DEFAULT);
            $sql = "INSERT INTO users (username, password, nama, role) VALUES (?, ?, ?, ?)";
            $stmt = $this->db->prepare($sql);
            return $stmt->execute([
                $data['username'],
                $hashedPassword,
                $data['nama'],
                $data['role']
            ]);
        } catch (PDOException $e) {
            // Mengembalikan false jika username sudah ada atau ada error lain
            return false;
        }
    }

    // Fungsi update dan delete bisa ditambahkan di sini...
}
