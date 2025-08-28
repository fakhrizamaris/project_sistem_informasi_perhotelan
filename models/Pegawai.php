<?php
// models/Pegawai.php

class Pegawai
{
    private $db;

    public function __construct()
    {
        $this->db = getDB();
    }

    // --- FUNGSI UNTUK STAFF ---
    public function getAll()
    {
        $stmt = $this->db->query("SELECT p.*, u.username, u.role 
                                 FROM pegawai p 
                                 LEFT JOIN users u ON p.id_user = u.id_user 
                                 ORDER BY p.nama ASC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($id)
    {
        $stmt = $this->db->prepare("SELECT p.*, u.username, u.role 
                                   FROM pegawai p 
                                   LEFT JOIN users u ON p.id_user = u.id_user 
                                   WHERE p.id_pegawai = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function create($data)
    {
        try {
            $this->db->beginTransaction();

            // Insert ke tabel users jika ada data login
            $userId = null;
            if (!empty($data['username']) && !empty($data['password'])) {
                $hashedPassword = password_hash($data['password'], PASSWORD_DEFAULT);
                $stmtUser = $this->db->prepare("INSERT INTO users (username, password, nama, role) VALUES (?, ?, ?, ?)");
                $stmtUser->execute([$data['username'], $hashedPassword, $data['nama'], $data['role']]);
                $userId = $this->db->lastInsertId();
            }

            // Insert ke tabel pegawai
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
            error_log("Error creating pegawai: " . $e->getMessage());
            return false;
        }
    }

    public function update($id, $data)
    {
        try {
            $this->db->beginTransaction();

            // Update tabel pegawai
            $stmt = $this->db->prepare("UPDATE pegawai SET nama = ?, jabatan = ?, status = ? WHERE id_pegawai = ?");
            $stmt->execute([$data['nama'], $data['jabatan'], $data['status'], $id]);

            // Update tabel users jika ada id_user
            $pegawai = $this->getById($id);
            if ($pegawai['id_user']) {
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

    public function delete($id)
    {
        try {
            $this->db->beginTransaction();

            // Ambil data pegawai
            $pegawai = $this->getById($id);

            // Hapus pegawai
            $stmt = $this->db->prepare("DELETE FROM pegawai WHERE id_pegawai = ?");
            $stmt->execute([$id]);

            // Hapus user jika ada
            if ($pegawai['id_user']) {
                $stmt = $this->db->prepare("DELETE FROM users WHERE id_user = ?");
                $stmt->execute([$pegawai['id_user']]);
            }

            $this->db->commit();
            return true;
        } catch (PDOException $e) {
            $this->db->rollBack();
            error_log("Error deleting pegawai: " . $e->getMessage());
            return false;
        }
    }

    // --- FUNGSI UNTUK USER TAMU ---
    public function getAllGuestUsers()
    {
        $stmt = $this->db->query("SELECT u.id_user, u.username, u.nama, t.no_identitas, t.no_hp, t.email 
                                 FROM users u 
                                 LEFT JOIN tamu t ON u.id_user = t.id_user 
                                 WHERE u.role = 'tamu' ORDER BY u.nama ASC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getGuestUserById($id)
    {
        $stmt = $this->db->prepare("SELECT u.id_user, u.username, u.nama, t.no_identitas, t.no_hp, t.email, t.alamat
                                   FROM users u 
                                   LEFT JOIN tamu t ON u.id_user = t.id_user 
                                   WHERE u.id_user = ? AND u.role = 'tamu'");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function createGuestUserAndProfile($data)
    {
        try {
            $this->db->beginTransaction();

            // Hash password
            $hashedPassword = password_hash($data['password'], PASSWORD_DEFAULT);

            // Insert ke tabel users
            $stmtUser = $this->db->prepare("INSERT INTO users (username, password, nama, role) VALUES (?, ?, ?, 'tamu')");
            $stmtUser->execute([$data['username'], $hashedPassword, $data['nama']]);

            // Ambil ID user yang baru saja dibuat
            $userId = $this->db->lastInsertId();

            // Insert ke tabel tamu
            $stmtTamu = $this->db->prepare("INSERT INTO tamu (id_user, nama, no_identitas, no_hp, email, alamat) VALUES (?, ?, ?, ?, ?, '')");
            $stmtTamu->execute([$userId, $data['nama'], $data['no_identitas'], $data['no_hp'], $data['email']]);

            $this->db->commit();
            return true;
        } catch (PDOException $e) {
            $this->db->rollBack();
            // Log error untuk debugging
            error_log("Error creating guest user: " . $e->getMessage());
            return false;
        }
    }

    public function updateGuestUser($id, $data)
    {
        try {
            $this->db->beginTransaction();

            // Update tabel users
            if (!empty($data['password'])) {
                $hashedPassword = password_hash($data['password'], PASSWORD_DEFAULT);
                $stmtUser = $this->db->prepare("UPDATE users SET username = ?, nama = ?, password = ? WHERE id_user = ?");
                $stmtUser->execute([$data['username'], $data['nama'], $hashedPassword, $id]);
            } else {
                $stmtUser = $this->db->prepare("UPDATE users SET username = ?, nama = ? WHERE id_user = ?");
                $stmtUser->execute([$data['username'], $data['nama'], $id]);
            }

            // Cek apakah record tamu sudah ada
            $checkTamu = $this->db->prepare("SELECT id_tamu FROM tamu WHERE id_user = ?");
            $checkTamu->execute([$id]);

            if ($checkTamu->fetch()) {
                // Update record yang sudah ada
                $stmtTamu = $this->db->prepare("UPDATE tamu SET nama = ?, no_identitas = ?, no_hp = ?, email = ? WHERE id_user = ?");
                $stmtTamu->execute([$data['nama'], $data['no_identitas'], $data['no_hp'], $data['email'], $id]);
            } else {
                // Insert record baru jika belum ada
                $stmtTamu = $this->db->prepare("INSERT INTO tamu (id_user, nama, no_identitas, no_hp, email, alamat) VALUES (?, ?, ?, ?, ?, '')");
                $stmtTamu->execute([$id, $data['nama'], $data['no_identitas'], $data['no_hp'], $data['email']]);
            }

            $this->db->commit();
            return true;
        } catch (PDOException $e) {
            $this->db->rollBack();
            // Log error untuk debugging
            error_log("Error updating guest user: " . $e->getMessage());
            return false;
        }
    }

    public function deleteGuestUser($id)
    {
        // Cek dulu apakah user tamu punya reservasi aktif
        $stmt = $this->db->prepare("SELECT COUNT(*) FROM reservasi r JOIN tamu t ON r.id_tamu = t.id_tamu WHERE t.id_user = ? AND r.status NOT IN ('checkout', 'cancelled')");
        $stmt->execute([$id]);
        if ($stmt->fetchColumn() > 0) {
            return false; // Gagal hapus jika ada reservasi aktif
        }

        try {
            $this->db->beginTransaction();

            // Hapus dari tabel anak (pembayaran, reservasi, tamu) terlebih dahulu
            $stmt = $this->db->prepare("DELETE p FROM pembayaran p 
                                       JOIN reservasi r ON p.id_reservasi = r.id_reservasi 
                                       JOIN tamu t ON r.id_tamu = t.id_tamu 
                                       WHERE t.id_user = ?");
            $stmt->execute([$id]);

            $stmt = $this->db->prepare("DELETE r FROM reservasi r 
                                       JOIN tamu t ON r.id_tamu = t.id_tamu 
                                       WHERE t.id_user = ?");
            $stmt->execute([$id]);

            $stmt = $this->db->prepare("DELETE FROM tamu WHERE id_user = ?");
            $stmt->execute([$id]);

            // Terakhir hapus dari tabel induk (users)
            $stmt = $this->db->prepare("DELETE FROM users WHERE id_user = ?");
            $stmt->execute([$id]);

            $this->db->commit();
            return true;
        } catch (PDOException $e) {
            $this->db->rollBack();
            error_log("Error deleting guest user: " . $e->getMessage());
            return false;
        }
    }

    // Fungsi helper untuk validasi username unik
    public function isUsernameExists($username, $excludeUserId = null)
    {
        if ($excludeUserId) {
            $stmt = $this->db->prepare("SELECT COUNT(*) FROM users WHERE username = ? AND id_user != ?");
            $stmt->execute([$username, $excludeUserId]);
        } else {
            $stmt = $this->db->prepare("SELECT COUNT(*) FROM users WHERE username = ?");
            $stmt->execute([$username]);
        }
        return $stmt->fetchColumn() > 0;
    }

    // Fungsi helper untuk validasi no_identitas unik
    public function isIdentityNumberExists($noIdentitas, $excludeUserId = null)
    {
        if ($excludeUserId) {
            $stmt = $this->db->prepare("SELECT COUNT(*) FROM tamu WHERE no_identitas = ? AND id_user != ?");
            $stmt->execute([$noIdentitas, $excludeUserId]);
        } else {
            $stmt = $this->db->prepare("SELECT COUNT(*) FROM tamu WHERE no_identitas = ?");
            $stmt->execute([$noIdentitas]);
        }
        return $stmt->fetchColumn() > 0;
    }
}
