<?php
// models/TamuReservation.php
// Model KHUSUS untuk tamu mengelola reservasi mereka sendiri

class TamuReservation
{
    private $db;

    public function __construct()
    {
        $this->db = getDB();
    }

    private function getIdTamu($user_id)
    {
        $stmt = $this->db->prepare("SELECT id_tamu FROM tamu WHERE id_user = ?");
        $stmt->execute([$user_id]);
        $tamu = $stmt->fetch();
        return $tamu ? $tamu['id_tamu'] : null;
    }

    public function getGuestStats($user_id)
    {
        $id_tamu = $this->getIdTamu($user_id);
        if (!$id_tamu) return false;

        try {
            $stmt = $this->db->prepare("
                SELECT 
                    COUNT(*) as total_reservasi,
                    SUM(CASE WHEN status IN ('pending', 'confirmed', 'checkin') THEN 1 ELSE 0 END) as reservasi_aktif,
                    SUM(CASE WHEN status = 'checkout' THEN 1 ELSE 0 END) as total_checkout,
                    COALESCE(SUM(CASE WHEN status = 'checkout' THEN total_biaya ELSE 0 END), 0) as total_biaya_keseluruhan
                FROM reservasi WHERE id_tamu = ?
            ");
            $stmt->execute([$id_tamu]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return false;
        }
    }

    public function getRecentReservations($user_id, $limit = 5)
    {
        $id_tamu = $this->getIdTamu($user_id);
        if (!$id_tamu) return [];

        try {
            $stmt = $this->db->prepare("
                SELECT r.*, k.no_kamar, k.tipe_kamar
                FROM reservasi r JOIN kamar k ON r.id_kamar = k.id_kamar
                WHERE r.id_tamu = ? ORDER BY r.created_at DESC LIMIT ?
            ");
            $stmt->bindParam(1, $id_tamu, PDO::PARAM_INT);
            $stmt->bindParam(2, $limit, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return [];
        }
    }

    public function getActiveReservations($user_id)
    {
        $id_tamu = $this->getIdTamu($user_id);
        if (!$id_tamu) return [];

        try {
            $stmt = $this->db->prepare("
                SELECT r.*, k.no_kamar, k.tipe_kamar
                FROM reservasi r JOIN kamar k ON r.id_kamar = k.id_kamar
                WHERE r.id_tamu = ? AND r.status IN ('pending', 'confirmed', 'checkin')
                ORDER BY r.tgl_checkin ASC
            ");
            $stmt->execute([$id_tamu]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return [];
        }
    }

    public function getAllReservations($user_id)
    {
        $id_tamu = $this->getIdTamu($user_id);
        if (!$id_tamu) return [];

        try {
            $stmt = $this->db->prepare("
                SELECT r.*, k.no_kamar, k.tipe_kamar
                FROM reservasi r JOIN kamar k ON r.id_kamar = k.id_kamar
                WHERE r.id_tamu = ? ORDER BY r.created_at DESC
            ");
            $stmt->execute([$id_tamu]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return [];
        }
    }

    public function createReservation($user_id, $data)
    {
        $id_tamu = $this->getIdTamu($user_id);
        if (!$id_tamu) return false;

        try {
            $this->db->beginTransaction();
            $sql = "INSERT INTO reservasi (id_tamu, id_kamar, tgl_checkin, tgl_checkout, total_biaya, status) VALUES (?, ?, ?, ?, ?, 'pending')";
            $stmt = $this->db->prepare($sql);
            $result = $stmt->execute([$id_tamu, $data['id_kamar'], $data['tgl_checkin'], $data['tgl_checkout'], $data['total_biaya']]);

            if ($result) {
                $stmt = $this->db->prepare("UPDATE kamar SET status = 'dibooking' WHERE id_kamar = ?");
                $stmt->execute([$data['id_kamar']]);
                $this->db->commit();
                return true;
            }
            $this->db->rollBack();
            return false;
        } catch (PDOException $e) {
            $this->db->rollBack();
            return false;
        }
    }

    public function cancelReservation($user_id, $reservation_id)
    {
        $id_tamu = $this->getIdTamu($user_id);
        if (!$id_tamu) return false;

        try {
            $this->db->beginTransaction();
            $stmt = $this->db->prepare("SELECT id_kamar FROM reservasi WHERE id_reservasi = ? AND id_tamu = ? AND status = 'pending'");
            $stmt->execute([$reservation_id, $id_tamu]);
            $reservation = $stmt->fetch();

            if (!$reservation) {
                $this->db->rollBack();
                return false;
            }

            $stmt = $this->db->prepare("UPDATE reservasi SET status = 'cancelled' WHERE id_reservasi = ?");
            $stmt->execute([$reservation_id]);

            $stmt = $this->db->prepare("UPDATE kamar SET status = 'kosong' WHERE id_kamar = ?");
            $stmt->execute([$reservation['id_kamar']]);

            $this->db->commit();
            return true;
        } catch (PDOException $e) {
            $this->db->rollBack();
            return false;
        }
    }

    public function getAvailableRooms($checkin_date, $checkout_date)
    {
        $sql = "SELECT * FROM kamar WHERE status = 'kosong' 
                AND id_kamar NOT IN (
                    SELECT id_kamar FROM reservasi 
                    WHERE status NOT IN ('cancelled', 'checkout')
                    AND (tgl_checkin < ? AND tgl_checkout > ?)
                ) ORDER BY harga ASC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$checkout_date, $checkin_date]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
