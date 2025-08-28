<?php
// models/TamuReservation.php
// Model khusus untuk tamu mengelola reservasi mereka sendiri

class TamuReservation
{
    private $db;

    public function __construct()
    {
        $this->db = getDB();
    }

    /**
     * Mendapatkan statistik tamu berdasarkan user_id
     */
    public function getGuestStats($user_id)
    {
        try {
            // Dapatkan id_tamu dari user_id
            $stmt = $this->db->prepare("SELECT id_tamu FROM tamu WHERE id_user = ?");
            $stmt->execute([$user_id]);
            $tamu = $stmt->fetch();

            if (!$tamu) {
                return false;
            }

            $id_tamu = $tamu['id_tamu'];

            // Ambil statistik reservasi
            $stmt = $this->db->prepare("
                SELECT 
                    COUNT(*) as total_reservasi,
                    SUM(CASE WHEN status IN ('pending', 'confirmed', 'checkin') THEN 1 ELSE 0 END) as reservasi_aktif,
                    SUM(CASE WHEN status = 'checkout' THEN 1 ELSE 0 END) as total_checkout,
                    COALESCE(SUM(CASE WHEN status = 'checkout' THEN total_biaya ELSE 0 END), 0) as total_biaya_keseluruhan
                FROM reservasi 
                WHERE id_tamu = ?
            ");
            $stmt->execute([$id_tamu]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return false;
        }
    }

    /**
     * Mendapatkan reservasi terbaru tamu
     */
    public function getRecentReservations($user_id, $limit = 5)
    {
        try {
            // Dapatkan id_tamu dari user_id
            $stmt = $this->db->prepare("SELECT id_tamu FROM tamu WHERE id_user = ?");
            $stmt->execute([$user_id]);
            $tamu = $stmt->fetch();

            if (!$tamu) {
                return [];
            }

            $id_tamu = $tamu['id_tamu'];

            $stmt = $this->db->prepare("
                SELECT 
                    r.*,
                    k.no_kamar,
                    k.tipe_kamar,
                    t.nama as nama_tamu
                FROM reservasi r
                JOIN kamar k ON r.id_kamar = k.id_kamar
                JOIN tamu t ON r.id_tamu = t.id_tamu
                WHERE r.id_tamu = ?
                ORDER BY r.created_at DESC
                LIMIT ?
            ");
            $stmt->bindParam(1, $id_tamu, PDO::PARAM_INT);
            $stmt->bindParam(2, $limit, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return [];
        }
    }

    /**
     * Mendapatkan reservasi yang masih aktif (belum checkout/cancel)
     */
    public function getActiveReservations($user_id)
    {
        try {
            // Dapatkan id_tamu dari user_id
            $stmt = $this->db->prepare("SELECT id_tamu FROM tamu WHERE id_user = ?");
            $stmt->execute([$user_id]);
            $tamu = $stmt->fetch();

            if (!$tamu) {
                return [];
            }

            $id_tamu = $tamu['id_tamu'];

            $stmt = $this->db->prepare("
                SELECT 
                    r.*,
                    k.no_kamar,
                    k.tipe_kamar
                FROM reservasi r
                JOIN kamar k ON r.id_kamar = k.id_kamar
                WHERE r.id_tamu = ? 
                AND r.status IN ('pending', 'confirmed', 'checkin')
                ORDER BY r.tgl_checkin ASC
            ");
            $stmt->execute([$id_tamu]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return [];
        }
    }

    /**
     * Mendapatkan semua reservasi tamu untuk halaman riwayat
     */
    public function getAllReservations($user_id)
    {
        try {
            // Dapatkan id_tamu dari user_id
            $stmt = $this->db->prepare("SELECT id_tamu FROM tamu WHERE id_user = ?");
            $stmt->execute([$user_id]);
            $tamu = $stmt->fetch();

            if (!$tamu) {
                return [];
            }

            $id_tamu = $tamu['id_tamu'];

            $stmt = $this->db->prepare("
                SELECT 
                    r.*,
                    k.no_kamar,
                    k.tipe_kamar
                FROM reservasi r
                JOIN kamar k ON r.id_kamar = k.id_kamar
                WHERE r.id_tamu = ?
                ORDER BY r.created_at DESC
            ");
            $stmt->execute([$id_tamu]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return [];
        }
    }

    /**
     * Membuat reservasi baru untuk tamu
     */
    public function createReservation($user_id, $data)
    {
        try {
            // Dapatkan id_tamu dari user_id
            $stmt = $this->db->prepare("SELECT id_tamu FROM tamu WHERE id_user = ?");
            $stmt->execute([$user_id]);
            $tamu = $stmt->fetch();

            if (!$tamu) {
                return false;
            }

            $id_tamu = $tamu['id_tamu'];

            $this->db->beginTransaction();

            $sql = "INSERT INTO reservasi (id_tamu, id_kamar, tgl_checkin, tgl_checkout, total_biaya, status) 
                    VALUES (?, ?, ?, ?, ?, ?)";
            $stmt = $this->db->prepare($sql);
            $result = $stmt->execute([
                $id_tamu,
                $data['id_kamar'],
                $data['tgl_checkin'],
                $data['tgl_checkout'],
                $data['total_biaya'],
                'pending' // Status default untuk tamu
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

    /**
     * Membatalkan reservasi (hanya jika masih pending)
     */
    public function cancelReservation($user_id, $reservation_id)
    {
        try {
            // Dapatkan id_tamu dari user_id
            $stmt = $this->db->prepare("SELECT id_tamu FROM tamu WHERE id_user = ?");
            $stmt->execute([$user_id]);
            $tamu = $stmt->fetch();

            if (!$tamu) {
                return false;
            }

            $id_tamu = $tamu['id_tamu'];

            $this->db->beginTransaction();

            // Pastikan reservasi milik tamu dan masih bisa dibatalkan
            $stmt = $this->db->prepare("
                SELECT r.*, k.id_kamar 
                FROM reservasi r 
                JOIN kamar k ON r.id_kamar = k.id_kamar 
                WHERE r.id_reservasi = ? AND r.id_tamu = ? AND r.status = 'pending'
            ");
            $stmt->execute([$reservation_id, $id_tamu]);
            $reservation = $stmt->fetch();

            if (!$reservation) {
                $this->db->rollback();
                return false; // Reservasi tidak ditemukan atau tidak bisa dibatalkan
            }

            // Update status reservasi
            $stmt = $this->db->prepare("UPDATE reservasi SET status = 'cancelled' WHERE id_reservasi = ?");
            $stmt->execute([$reservation_id]);

            // Update status kamar menjadi kosong
            $stmt = $this->db->prepare("UPDATE kamar SET status = 'kosong' WHERE id_kamar = ?");
            $stmt->execute([$reservation['id_kamar']]);

            $this->db->commit();
            return true;
        } catch (PDOException $e) {
            $this->db->rollback();
            return false;
        }
    }

    /**
     * Mendapatkan kamar yang tersedia untuk reservasi
     */
    public function getAvailableRooms($checkin_date, $checkout_date)
    {
        $sql = "SELECT * FROM kamar WHERE status = 'kosong' 
                AND id_kamar NOT IN (
                    SELECT id_kamar FROM reservasi 
                    WHERE status NOT IN ('cancelled', 'checkout')
                    AND (
                        (tgl_checkin < ? AND tgl_checkout > ?) OR
                        (tgl_checkin < ? AND tgl_checkout > ?) OR
                        (tgl_checkin <= ? AND tgl_checkout >= ?)
                    )
                ) ORDER BY tipe_kamar, harga";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$checkout_date, $checkin_date, $checkout_date, $checkin_date, $checkin_date, $checkout_date]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
