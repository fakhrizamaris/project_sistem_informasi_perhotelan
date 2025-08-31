<?php
// models/Guest.php
// Atau bisa juga models/Tamu.php - sesuaikan dengan pemanggilan di controller

class Guest
{
    private $db;

    public function __construct()
    {
        $this->db = getDB();
    }

    // Ambil semua tamu
    public function getAll()
    {
        try {
            $sql = "SELECT * FROM tamu ORDER BY nama";
            $stmt = $this->db->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error getting all guests: " . $e->getMessage());
            return [];
        }
    }

    // Ambil tamu berdasarkan ID
    public function getById($id)
    {
        try {
            $sql = "SELECT * FROM tamu WHERE id_tamu = :id";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error getting guest by ID: " . $e->getMessage());
            return false;
        }
    }

    // Tambah tamu baru
    public function create($data)
    {
        try {
            $sql = "INSERT INTO tamu (id_user, nama, no_identitas, alamat, no_hp, email) 
                    VALUES (:id_user, :nama, :no_identitas, :alamat, :no_hp, :email)";

            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':id_user', $data['id_user']);
            $stmt->bindParam(':nama', $data['nama']);
            $stmt->bindParam(':no_identitas', $data['no_identitas']);
            $stmt->bindParam(':alamat', $data['alamat']);
            $stmt->bindParam(':no_hp', $data['no_hp']);
            $stmt->bindParam(':email', $data['email']);

            return $stmt->execute();
        } catch (PDOException $e) {
            error_log("Error creating guest: " . $e->getMessage());
            return false;
        }
    }

    // Update data tamu
    public function update($id, $data)
    {
        try {
            $sql = "UPDATE tamu SET 
                    nama = :nama, 
                    no_identitas = :no_identitas, 
                    alamat = :alamat, 
                    no_hp = :no_hp, 
                    email = :email 
                    WHERE id_tamu = :id";

            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':id', $id);
            $stmt->bindParam(':nama', $data['nama']);
            $stmt->bindParam(':no_identitas', $data['no_identitas']);
            $stmt->bindParam(':alamat', $data['alamat']);
            $stmt->bindParam(':no_hp', $data['no_hp']);
            $stmt->bindParam(':email', $data['email']);

            return $stmt->execute();
        } catch (PDOException $e) {
            error_log("Error updating guest: " . $e->getMessage());
            return false;
        }
    }

    // Hapus tamu
    public function delete($id)
    {
        try {
            $sql = "DELETE FROM tamu WHERE id_tamu = :id";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            return $stmt->execute();
        } catch (PDOException $e) {
            error_log("Error deleting guest: " . $e->getMessage());
            return false;
        }
    }

    // Cek apakah nomor identitas sudah ada
    public function isIdentityExists($no_identitas, $exclude_id = null)
    {
        try {
            $sql = "SELECT COUNT(*) as count FROM tamu WHERE no_identitas = :no_identitas";

            if ($exclude_id) {
                $sql .= " AND id_tamu != :exclude_id";
            }

            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':no_identitas', $no_identitas);

            if ($exclude_id) {
                $stmt->bindParam(':exclude_id', $exclude_id);
            }

            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            return $result['count'] > 0;
        } catch (PDOException $e) {
            error_log("Error checking identity exists: " . $e->getMessage());
            return false;
        }
    }

    // Ambil tamu berdasarkan user ID
    public function getByUserId($user_id)
    {
        try {
            $sql = "SELECT * FROM tamu WHERE id_user = :user_id";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error getting guest by user ID: " . $e->getMessage());
            return false;
        }
    }

    // Search tamu berdasarkan nama atau nomor identitas
    public function search($keyword)
    {
        try {
            $sql = "SELECT * FROM tamu 
                    WHERE nama LIKE :keyword 
                    OR no_identitas LIKE :keyword 
                    OR no_hp LIKE :keyword 
                    ORDER BY nama";

            $stmt = $this->db->prepare($sql);
            $keyword = "%$keyword%";
            $stmt->bindParam(':keyword', $keyword);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error searching guests: " . $e->getMessage());
            return [];
        }
    }

    // Hitung total tamu
    public function getTotalCount()
    {
        try {
            $sql = "SELECT COUNT(*) as total FROM tamu";
            $stmt = $this->db->prepare($sql);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result['total'];
        } catch (PDOException $e) {
            error_log("Error getting total guest count: " . $e->getMessage());
            return 0;
        }
    }
}
