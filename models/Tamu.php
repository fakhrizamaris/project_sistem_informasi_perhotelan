<?php
// models/Tamu.php
// Model untuk mengelola data tamu dari sisi admin

class Guest
{
    private $db;

    public function __construct()
    {
        $this->db = getDB();
    }

    /**
     * Mengambil semua data tamu
     */
    public function getAll()
    {
        $stmt = $this->db->query("SELECT * FROM tamu ORDER BY nama ASC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Membuat data tamu baru
     */
    public function create($data)
    {
        try {
            $sql = "INSERT INTO tamu (nama, no_identitas, alamat, no_hp, email) VALUES (?, ?, ?, ?, ?)";
            $stmt = $this->db->prepare($sql);
            return $stmt->execute([
                $data['nama'],
                $data['no_identitas'],
                $data['alamat'],
                $data['no_hp'],
                $data['email']
            ]);
        } catch (PDOException $e) {
            // Mengembalikan false jika no_identitas sudah ada atau ada error lain
            return false;
        }
    }

    /**
     * Menghapus data tamu
     */

    public function update($id, $data)
    {
        try {
            $sql = "UPDATE tamu SET nama = ?, no_identitas = ?, alamat = ?, no_hp = ?, email = ? WHERE id_tamu = ?";
            $stmt = $this->db->prepare($sql);
            return $stmt->execute([
                $data['nama'],
                $data['no_identitas'],
                $data['alamat'],
                $data['no_hp'],
                $data['email'],
                $id
            ]);
        } catch (PDOException $e) {
            return false;
        }
    }

    public function delete($id)
    {
        $stmt = $this->db->prepare("SELECT COUNT(*) FROM reservasi WHERE id_tamu = ? AND status NOT IN ('cancelled', 'checkout')");
        $stmt->execute([$id]);
        if ($stmt->fetchColumn() > 0) {
            return false;
        }

        try {
            $stmt = $this->db->prepare("DELETE FROM tamu WHERE id_tamu = ?");
            return $stmt->execute([$id]);
        } catch (PDOException $e) {
            return false;
        }
    }

    /**
     * Mengambil data tamu berdasarkan ID
     */
    public function getById($id)
    {
        $stmt = $this->db->prepare("SELECT * FROM tamu WHERE id_tamu = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
