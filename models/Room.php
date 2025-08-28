<?php
// models/Room.php

class Room
{
    private $db;

    public function __construct()
    {
        $this->db = getDB();
    }

    public function getAll()
    {
        $stmt = $this->db->query("SELECT * FROM kamar ORDER BY no_kamar");
        return $stmt->fetchAll();
    }

    public function getById($id)
    {
        $stmt = $this->db->prepare("SELECT * FROM kamar WHERE id_kamar = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public function create($data)
    {
        $sql = "INSERT INTO kamar (no_kamar, tipe_kamar, harga, status) VALUES (?, ?, ?, ?)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            $data['no_kamar'],
            $data['tipe_kamar'],
            $data['harga'],
            $data['status'] ?? 'kosong'
        ]);
    }

    public function update($id, $data)
    {
        $sql = "UPDATE kamar SET no_kamar = ?, tipe_kamar = ?, harga = ?, status = ? WHERE id_kamar = ?";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            $data['no_kamar'],
            $data['tipe_kamar'],
            $data['harga'],
            $data['status'],
            $id
        ]);
    }

    public function getStats()
    {
        $stmt = $this->db->query("
            SELECT 
                COUNT(*) as total,
                SUM(CASE WHEN status = 'kosong' THEN 1 ELSE 0 END) as kosong,
                SUM(CASE WHEN status = 'terisi' THEN 1 ELSE 0 END) as terisi,
                SUM(CASE WHEN status = 'dibooking' THEN 1 ELSE 0 END) as dibooking,
                SUM(CASE WHEN status = 'maintenance' THEN 1 ELSE 0 END) as maintenance
            FROM kamar
        ");
        return $stmt->fetch();
    }

    public function delete($id)
    {
        // PERBAIKAN: Cek hanya reservasi yang AKTIF
        $stmt = $this->db->prepare("SELECT COUNT(*) FROM reservasi WHERE id_kamar = ? AND status NOT IN ('checkout', 'cancelled')");
        $stmt->execute([$id]);
        if ($stmt->fetchColumn() > 0) {
            // Jika ada reservasi aktif (pending, confirmed, checkin), maka GAGAL HAPUS
            return false;
        }

        // Jika tidak ada reservasi aktif, baru coba hapus.
        try {
            // Untuk mengatasi masalah foreign key, kita hapus dulu riwayat reservasi yang sudah selesai
            $stmt = $this->db->prepare("DELETE FROM reservasi WHERE id_kamar = ?");
            $stmt->execute([$id]);

            // Setelah riwayat reservasi dihapus, baru hapus kamarnya
            $stmt = $this->db->prepare("DELETE FROM kamar WHERE id_kamar = ?");
            return $stmt->execute([$id]);
        } catch (PDOException $e) {
            // Tangkap error jika ada masalah lain
            return false;
        }
    }

    public function getAvailable($checkin, $checkout)
    {
        $sql = "SELECT * FROM kamar WHERE status = 'kosong' 
                AND id_kamar NOT IN (
                    SELECT id_kamar FROM reservasi 
                    WHERE status NOT IN ('cancelled', 'checkout')
                    AND (tgl_checkin < ? AND tgl_checkout > ?)
                )";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$checkout, $checkin]);
        return $stmt->fetchAll();
    }
}
