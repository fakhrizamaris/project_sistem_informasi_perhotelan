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

    public function getAllGuestUsers()
    {
        $stmt = $this->db->query("SELECT id_user, username, nama FROM users WHERE role = 'tamu' ORDER BY nama ASC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Membuat user tamu baru (akun login + data tamu)
     */
    public function createGuestUserAndProfile($data)
    {
        try {
            $this->db->beginTransaction();

            // 1. Buat entri di tabel 'users'
            $hashedPassword = password_hash($data['password'], PASSWORD_DEFAULT);
            $sqlUser = "INSERT INTO users (username, password, nama, role) VALUES (?, ?, ?, 'tamu')";
            $stmtUser = $this->db->prepare($sqlUser);
            $stmtUser->execute([$data['username'], $hashedPassword, $data['nama']]);
            $userId = $this->db->lastInsertId();

            // 2. Buat entri di tabel 'tamu'
            $sqlTamu = "INSERT INTO tamu (id_user, nama, no_identitas, no_hp, email) VALUES (?, ?, ?, ?, ?)";
            $stmtTamu = $this->db->prepare($sqlTamu);
            $stmtTamu->execute([$userId, $data['nama'], $data['no_identitas'], $data['no_hp'], $data['email']]);

            $this->db->commit();
            return true;
        } catch (PDOException $e) {
            $this->db->rollback();
            // error_log($e->getMessage()); // Opsional untuk debugging
            return false;
        }
    }

    // Fungsi update dan delete bisa ditambahkan di sini...
}
