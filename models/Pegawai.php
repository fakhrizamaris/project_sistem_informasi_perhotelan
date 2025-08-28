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
    { /* ... kode yang sudah ada ... */
    }
    public function getById($id)
    { /* ... kode yang sudah ada ... */
    }
    public function create($data)
    { /* ... kode yang sudah ada ... */
    }
    public function update($id, $data)
    { /* ... kode yang sudah ada ... */
    }
    public function delete($id)
    { /* ... kode yang sudah ada ... */
    }

    // --- FUNGSI UNTUK USER TAMU ---
    public function getAllGuestUsers()
    {
        $stmt = $this->db->query("SELECT u.id_user, u.username, u.nama, t.no_identitas, t.no_hp, t.email 
                                 FROM users u 
                                 JOIN tamu t ON u.id_user = t.id_user 
                                 WHERE u.role = 'tamu' ORDER BY u.nama ASC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getGuestUserById($id)
    {
        $stmt = $this->db->prepare("SELECT u.id_user, u.username, u.nama, t.no_identitas, t.no_hp, t.email, t.alamat
                                   FROM users u 
                                   JOIN tamu t ON u.id_user = t.id_user 
                                   WHERE u.id_user = ? AND u.role = 'tamu'");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function createGuestUserAndProfile($data)
    {
        // ... (kode yang sudah ada, tidak perlu diubah)
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

            // Update tabel tamu
            $stmtTamu = $this->db->prepare("UPDATE tamu SET nama = ?, no_identitas = ?, no_hp = ?, email = ? WHERE id_user = ?");
            $stmtTamu->execute([$data['nama'], $data['no_identitas'], $data['no_hp'], $data['email'], $id]);

            $this->db->commit();
            return true;
        } catch (PDOException $e) {
            $this->db->rollBack();
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
            // Hapus dari tabel anak (tamu, pembayaran, reservasi) terlebih dahulu
            $stmt = $this->db->prepare("DELETE FROM pembayaran WHERE id_reservasi IN (SELECT id_reservasi FROM reservasi WHERE id_tamu IN (SELECT id_tamu FROM tamu WHERE id_user = ?))");
            $stmt->execute([$id]);
            $stmt = $this->db->prepare("DELETE FROM reservasi WHERE id_tamu IN (SELECT id_tamu FROM tamu WHERE id_user = ?)");
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
            return false;
        }
    }
}
