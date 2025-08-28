<?php
// models/Reservation.php
// Model untuk mengelola data reservasi

class Reservation
{
    private $db;

    public function __construct()
    {
        $this->db = getDB();
    }

    public function getAll()
    {
        $sql = "SELECT r.*, t.nama as nama_tamu, k.no_kamar, k.tipe_kamar 
                FROM reservasi r 
                JOIN tamu t ON r.id_tamu = t.id_tamu 
                JOIN kamar k ON r.id_kamar = k.id_kamar 
                ORDER BY r.created_at DESC";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll();
    }

    public function getById($id)
    {
        $sql = "SELECT r.*, t.nama as nama_tamu, t.email, t.no_hp, 
                       k.no_kamar, k.tipe_kamar 
                FROM reservasi r 
                JOIN tamu t ON r.id_tamu = t.id_tamu 
                JOIN kamar k ON r.id_kamar = k.id_kamar 
                WHERE r.id_reservasi = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public function create($data)
    {
        try {
            $this->db->beginTransaction();

            // Generate kode reservasi
            // $kode_reservasi = 'RSV' . date('ymd') . rand(1000, 9999);

            $sql = "INSERT INTO reservasi (id_tamu, id_kamar, tgl_checkin, tgl_checkout, total_biaya, status) 
                    VALUES ( ?, ?, ?, ?, ?, ?)";
            $stmt = $this->db->prepare($sql);
            $result = $stmt->execute([
                // $kode_reservasi,
                $data['id_tamu'],
                $data['id_kamar'],
                $data['tgl_checkin'],
                $data['tgl_checkout'],
                $data['total_biaya'],
                $data['status'] ?? 'pending'
            ]);

            if ($result) {
                // Update status kamar menjadi dibooking
                $stmt = $this->db->prepare("UPDATE kamar SET status = 'dibooking' WHERE id_kamar = ?");
                $stmt->execute([$data['id_kamar']]);

                $this->db->commit();
                return true;
            }

            $this->db->rollback();
            return false;
        } catch (PDOException $e) {
            $this->db->rollback();
            return false;
        }
    }

    public function update($id, $data)
    {
        $sql = "UPDATE reservasi SET tgl_checkin = ?, tgl_checkout = ?, total_biaya = ?, status = ? WHERE id_reservasi = ?";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            $data['tgl_checkin'],
            $data['tgl_checkout'],
            $data['total_biaya'],
            $data['status'],
            $id
        ]);
    }

    public function updateStatus($id, $status)
    {
        try {
            $this->db->beginTransaction();

            // Update status reservasi
            $stmt = $this->db->prepare("UPDATE reservasi SET status = ? WHERE id_reservasi = ?");
            $result = $stmt->execute([$status, $id]);

            if ($result) {
                // Update status kamar berdasarkan status reservasi
                $reservasi = $this->getById($id);
                if ($reservasi) {
                    $kamar_status = 'kosong';
                    switch ($status) {
                        case 'confirmed':
                        case 'pending':
                            $kamar_status = 'dibooking';
                            break;
                        case 'checkin':
                            $kamar_status = 'terisi';
                            break;
                        case 'checkout':
                        case 'cancelled':
                            $kamar_status = 'kosong';
                            break;
                    }

                    $stmt = $this->db->prepare("UPDATE kamar SET status = ? WHERE id_kamar = ?");
                    $stmt->execute([$kamar_status, $reservasi['id_kamar']]);
                }

                $this->db->commit();
                return true;
            }

            $this->db->rollback();
            return false;
        } catch (PDOException $e) {
            $this->db->rollback();
            return false;
        }
    }

    public function delete($id)
    {
        try {
            $this->db->beginTransaction();

            // Ambil data reservasi
            $reservasi = $this->getById($id);
            if (!$reservasi) {
                return false;
            }

            // Hapus reservasi
            $stmt = $this->db->prepare("DELETE FROM reservasi WHERE id_reservasi = ?");
            $result = $stmt->execute([$id]);

            if ($result) {
                // Update status kamar menjadi kosong
                $stmt = $this->db->prepare("UPDATE kamar SET status = 'kosong' WHERE id_kamar = ?");
                $stmt->execute([$reservasi['id_kamar']]);

                $this->db->commit();
                return true;
            }

            $this->db->rollback();
            return false;
        } catch (PDOException $e) {
            $this->db->rollback();
            return false;
        }
    }

    public function getToday()
    {
        $sql = "SELECT r.*, t.nama as nama_tamu, k.no_kamar, k.tipe_kamar 
                FROM reservasi r 
                JOIN tamu t ON r.id_tamu = t.id_tamu 
                JOIN kamar k ON r.id_kamar = k.id_kamar 
                WHERE DATE(r.tgl_checkin) = CURDATE() 
                ORDER BY r.created_at DESC";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll();
    }

    public function getStats()
    {
        $stmt = $this->db->query("
            SELECT 
                COUNT(*) as total,
                SUM(CASE WHEN status = 'pending' THEN 1 ELSE 0 END) as pending,
                SUM(CASE WHEN status = 'confirmed' THEN 1 ELSE 0 END) as confirmed,
                SUM(CASE WHEN status = 'checkin' THEN 1 ELSE 0 END) as checkin,
                SUM(CASE WHEN status = 'checkout' THEN 1 ELSE 0 END) as checkout,
                SUM(CASE WHEN status = 'cancelled' THEN 1 ELSE 0 END) as cancelled
            FROM reservasi 
            WHERE DATE(created_at) = CURDATE()
        ");
        return $stmt->fetch();
    }
}
