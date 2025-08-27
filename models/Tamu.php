<?php
// models/Guest.php
// Model untuk mengelola data tamu

class Guest
{
    private $db;

    public function __construct()
    {
        $this->db = getDB();
    }

    public function getAll()
    {
        $stmt = $this->db->query("SELECT * FROM tamu ORDER BY created_at DESC");
        return $stmt->fetchAll();
    }

    public function getById($id)
    {
        $stmt = $this->db->prepare("SELECT * FROM tamu WHERE id_tamu = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public function getByIdentitas($no_identitas)
    {
        $stmt = $this->db->prepare("SELECT * FROM tamu WHERE no_identitas = ?");
        $stmt->execute([$no_identitas]);
        return $stmt->fetch();
    }

    public function create($data)
    {
        // Cek apakah tamu sudah ada berdasarkan no_identitas
        if ($this->getByIdentitas($data['no_identitas'])) {
            return false; // Tamu sudah ada
        }

        $sql = "INSERT INTO tamu (nama, no_identitas, alamat, no_hp, email) VALUES (?, ?, ?, ?, ?)";
        $stmt = $this->db->prepare($sql);
        $result = $stmt->execute([
            $data['nama'],
            $data['no_identitas'],
            $data['alamat'] ?? null,
            $data['no_hp'] ?? null,
            $data['email'] ?? null
        ]);

        if ($result) {
            return $this->db->lastInsertId();
        }
        return false;
    }

    public function update($id, $data)
    {
        // Cek apakah no_identitas sudah digunakan tamu lain
        $stmt = $this->db->prepare("SELECT id_tamu FROM tamu WHERE no_identitas = ? AND id_tamu != ?");
        $stmt->execute([$data['no_identitas'], $id]);
        if ($stmt->fetch()) {
            return false; // No identitas sudah digunakan
        }

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
    }

    public function delete($id)
    {
        // Cek apakah tamu memiliki reservasi
        $stmt = $this->db->prepare("SELECT COUNT(*) FROM reservasi WHERE id_tamu = ?");
        $stmt->execute([$id]);
        if ($stmt->fetchColumn() > 0) {
            return false; // Tidak bisa dihapus karena ada reservasi
        }

        $stmt = $this->db->prepare("DELETE FROM tamu WHERE id_tamu = ?");
        return $stmt->execute([$id]);
    }

    public function search($keyword)
    {
        $keyword = "%$keyword%";
        $sql = "SELECT * FROM tamu 
                WHERE nama LIKE ? OR no_identitas LIKE ? OR email LIKE ? OR no_hp LIKE ? 
                ORDER BY nama";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$keyword, $keyword, $keyword, $keyword]);
        return $stmt->fetchAll();
    }

    public function getReservationHistory($id)
    {
        $sql = "SELECT r.*, k.no_kamar, k.tipe_kamar 
                FROM reservasi r 
                JOIN kamar k ON r.id_kamar = k.id_kamar 
                WHERE r.id_tamu = ? 
                ORDER BY r.created_at DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetchAll();
    }
}
