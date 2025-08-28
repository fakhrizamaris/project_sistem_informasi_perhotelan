<?php
// models/Pembayaran.php

class Pembayaran
{
    private $db;

    public function __construct()
    {
        $this->db = getDB();
    }

    public function create($data)
    {
        $file = $data['file_bukti'];

        // 1. Cek apakah ada error saat upload dari sisi PHP
        if ($file['error'] !== UPLOAD_ERR_OK) {
            // Error ini bisa terjadi karena berbagai alasan, misal file terlalu besar dari konfigurasi server
            return false;
        }

        // 2. Path folder upload yang sudah diperbaiki
        // Dari /models, kita naik satu level ke root proyek, lalu masuk ke /public/uploads
        $upload_dir = __DIR__ . '/../public/uploads/';

        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0755, true);
        }

        $file_name = uniqid() . '-' . basename($file['name']);
        $target_file = $upload_dir . $file_name;

        // 3. Validasi Tipe dan Ukuran File
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        $allowed_types = ['jpg', 'png', 'jpeg'];
        
        if ($file['size'] > 2097152) { // Batas ukuran 2MB
            return false;
        }
        if (!in_array($imageFileType, $allowed_types)) {
            return false;
        }

        // 4. Pindahkan file yang di-upload
        if (move_uploaded_file($file['tmp_name'], $target_file)) {
            try {
                $sql = "INSERT INTO pembayaran (id_reservasi, metode, jumlah, status, tgl_bayar, bukti_pembayaran) 
                        VALUES (?, ?, ?, 'pending', NOW(), ?)";
                $stmt = $this->db->prepare($sql);
                return $stmt->execute([
                    $data['id_reservasi'],
                    $data['metode'],
                    $data['jumlah'],
                    $file_name
                ]);
            } catch (PDOException $e) {
                // Jika gagal insert ke DB, hapus file yang sudah ter-upload
                unlink($target_file);
                return false;
            }
        }
        
        return false;
    }

    public function getPending()
    {
        $sql = "SELECT p.*, r.id_reservasi, t.nama as nama_tamu
                FROM pembayaran p
                JOIN reservasi r ON p.id_reservasi = r.id_reservasi
                JOIN tamu t ON r.id_tamu = t.id_tamu
                WHERE p.status = 'pending'
                ORDER BY p.tgl_bayar ASC";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function verify($id_pembayaran, $new_status)
    {
        $this->db->beginTransaction();
        try {
            // 1. Update status pembayaran
            $stmt = $this->db->prepare("UPDATE pembayaran SET status = ? WHERE id_pembayaran = ?");
            $stmt->execute([$new_status, $id_pembayaran]);

            // 2. Jika disetujui, update status reservasi menjadi 'confirmed'
            if ($new_status === 'berhasil') {
                $stmt = $this->db->prepare("SELECT id_reservasi FROM pembayaran WHERE id_pembayaran = ?");
                $stmt->execute([$id_pembayaran]);
                $pembayaran = $stmt->fetch();
                $id_reservasi = $pembayaran['id_reservasi'];

                $stmt = $this->db->prepare("UPDATE reservasi SET status = 'confirmed' WHERE id_reservasi = ?");
                $stmt->execute([$id_reservasi]);
            }

            $this->db->commit();
            return true;
        } catch (PDOException $e) {
            $this->db->rollBack();
            return false;
        }
    }
}
?>