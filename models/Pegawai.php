<?php
// models/Pegawai.php

class Pegawai
{
    private $db;

    public function __construct()
    {
        $this->db = getDB();
    }

    // =================================================================
    // FUNGSI UNTUK MENGELOLA STAFF (ADMIN, RESEPSIONIS, MANAJER)
    // =================================================================

    /**
     * Mengambil semua data pegawai/staff beserta informasi login mereka.
     */
    public function getAll()
    {
        $stmt = $this->db->query("SELECT p.*, u.username, u.role 
                                 FROM pegawai p 
                                 LEFT JOIN users u ON p.id_user = u.id_user 
                                 ORDER BY p.nama ASC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Mengambil data pegawai tunggal berdasarkan ID pegawai.
     */
    public function getById($id)
    {
        $stmt = $this->db->prepare("SELECT p.*, u.username, u.role 
                                   FROM pegawai p 
                                   LEFT JOIN users u ON p.id_user = u.id_user 
                                   WHERE p.id_pegawai = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Membuat data pegawai baru beserta akun user-nya.
     */
    public function create($data)
    {
        try {
            $this->db->beginTransaction();

            // 1. Buat akun di tabel 'users' terlebih dahulu
            $hashedPassword = password_hash($data['password'], PASSWORD_DEFAULT);
            $stmtUser = $this->db->prepare("INSERT INTO users (username, password, nama, role) VALUES (?, ?, ?, ?)");
            $stmtUser->execute([$data['username'], $hashedPassword, $data['nama'], $data['role']]);
            $userId = $this->db->lastInsertId();

            // 2. Buat data di tabel 'pegawai' yang terhubung dengan user ID
            $stmt = $this->db->prepare("INSERT INTO pegawai (id_user, nama, jabatan, status) VALUES (?, ?, ?, ?)");
            $stmt->execute([
                $userId,
                $data['nama'],
                $data['jabatan'],
                $data['status'] ?? 'aktif'
            ]);

            $this->db->commit();
            return true;
        } catch (PDOException $e) {
            $this->db->rollBack();
            // Log error untuk debugging
            error_log("Error creating pegawai: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Mengupdate data pegawai dan akun user-nya.
     */
    public function update($id, $data)
    {
        try {
            $this->db->beginTransaction();

            // 1. Update tabel 'pegawai'
            $stmt = $this->db->prepare("UPDATE pegawai SET nama = ?, jabatan = ?, status = ? WHERE id_pegawai = ?");
            $stmt->execute([$data['nama'], $data['jabatan'], $data['status'], $id]);

            // 2. Ambil ID user dari pegawai yang diupdate
            $pegawai = $this->getById($id);
            if ($pegawai['id_user']) {
                // 3. Update tabel 'users'
                if (!empty($data['password'])) {
                    $hashedPassword = password_hash($data['password'], PASSWORD_DEFAULT);
                    $stmtUser = $this->db->prepare("UPDATE users SET username = ?, nama = ?, role = ?, password = ? WHERE id_user = ?");
                    $stmtUser->execute([$data['username'], $data['nama'], $data['role'], $hashedPassword, $pegawai['id_user']]);
                } else {
                    $stmtUser = $this->db->prepare("UPDATE users SET username = ?, nama = ?, role = ? WHERE id_user = ?");
                    $stmtUser->execute([$data['username'], $data['nama'], $data['role'], $pegawai['id_user']]);
                }
            }

            $this->db->commit();
            return true;
        } catch (PDOException $e) {
            $this->db->rollBack();
            error_log("Error updating pegawai: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Menghapus data pegawai beserta akun user-nya.
     */
    public function delete($id)
    {
        try {
            $this->db->beginTransaction();

            $pegawai = $this->getById($id);

            // 1. Hapus dari tabel 'pegawai'
            $stmt = $this->db->prepare("DELETE FROM pegawai WHERE id_pegawai = ?");
            $stmt->execute([$id]);

            // 2. Hapus dari tabel 'users' jika terhubung
            if ($pegawai && $pegawai['id_user']) {
                $stmtUser = $this->db->prepare("DELETE FROM users WHERE id_user = ?");
                $stmtUser->execute([$pegawai['id_user']]);
            }

            $this->db->commit();
            return true;
        } catch (PDOException $e) {
            $this->db->rollBack();
            error_log("Error deleting pegawai: " . $e->getMessage());
            return false;
        }
    }


    // =================================================================
    // FUNGSI UNTUK MENGELOLA USER TAMU (DARI REGISTRASI)
    // =================================================================

    /**
     * Membuat akun user tamu dan profilnya sekaligus.
     * Digunakan oleh halaman register.php.
     */
    public function createGuestUserAndProfile($data)
    {
        try {
            $this->db->beginTransaction();

            // 1. Buat akun di tabel 'users' dengan role 'tamu'
            $hashedPassword = password_hash($data['password'], PASSWORD_DEFAULT);
            $stmtUser = $this->db->prepare("INSERT INTO users (username, password, nama, role) VALUES (?, ?, ?, 'tamu')");
            $stmtUser->execute([$data['username'], $hashedPassword, $data['nama']]);
            $userId = $this->db->lastInsertId();

            // 2. Buat profil di tabel 'tamu' yang terhubung dengan user ID
            $stmtTamu = $this->db->prepare("INSERT INTO tamu (id_user, nama, no_identitas, no_hp, email, alamat) VALUES (?, ?, ?, ?, ?, '')");
            $stmtTamu->execute([$userId, $data['nama'], $data['no_identitas'], $data['no_hp'], $data['email']]);

            $this->db->commit();
            return true;
        } catch (PDOException $e) {
            $this->db->rollBack();
            error_log("Error creating guest user: " . $e->getMessage());
            return false;
        }
    }

    // ... (Anda bisa menambahkan fungsi update dan delete untuk user tamu jika diperlukan di masa depan)


    // =================================================================
    // FUNGSI VALIDASI & HELPER
    // =================================================================

    /**
     * Mengecek apakah sebuah username sudah ada di database.
     * $excludeUserId digunakan saat update agar tidak mendeteksi username milik sendiri.
     */
    public function isUsernameExists($username, $excludeUserId = null)
    {
        $sql = "SELECT COUNT(*) FROM users WHERE username = ?";
        $params = [$username];

        if ($excludeUserId) {
            $sql .= " AND id_user != ?";
            $params[] = $excludeUserId;
        }

        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchColumn() > 0;
    }

    /**
     * Mengecek apakah nomor identitas sudah ada di database.
     * $excludeUserId digunakan saat update agar tidak mendeteksi no_identitas milik sendiri.
     */
    public function isIdentityNumberExists($noIdentitas, $excludeUserId = null)
    {
        $sql = "SELECT COUNT(*) FROM tamu WHERE no_identitas = ?";
        $params = [$noIdentitas];

        if ($excludeUserId) {
            $sql .= " AND id_user != ?";
            $params[] = $excludeUserId;
        }

        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchColumn() > 0;
    }
}
