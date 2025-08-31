<?php
// models/Reservation.php

class Reservation
{
    private $db;

    public function __construct()
    {
        $this->db = getDB();
    }

    // Ambil semua reservasi dengan data tamu dan kamar
    public function getAll()
    {
        try {
            $sql = "SELECT r.*, t.nama as nama_tamu, t.no_hp, t.email, 
                           k.no_kamar, k.tipe_kamar, k.harga
                    FROM reservasi r
                    JOIN tamu t ON r.id_tamu = t.id_tamu
                    JOIN kamar k ON r.id_kamar = k.id_kamar
                    ORDER BY r.created_at DESC";

            $stmt = $this->db->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error getting all reservations: " . $e->getMessage());
            return [];
        }
    }

    // Ambil reservasi berdasarkan ID
    public function getById($id)
    {
        try {
            $sql = "SELECT r.*, t.nama as nama_tamu, t.no_hp, t.email, t.alamat, t.no_identitas,
                           k.no_kamar, k.tipe_kamar, k.harga
                    FROM reservasi r
                    JOIN tamu t ON r.id_tamu = t.id_tamu
                    JOIN kamar k ON r.id_kamar = k.id_kamar
                    WHERE r.id_reservasi = :id";

            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error getting reservation by ID: " . $e->getMessage());
            return false;
        }
    }

    // Tambah reservasi baru
    public function create($data)
    {
        try {
            $sql = "INSERT INTO reservasi (id_tamu, id_kamar, tgl_checkin, tgl_checkout, total_biaya, status) 
                    VALUES (:id_tamu, :id_kamar, :tgl_checkin, :tgl_checkout, :total_biaya, :status)";

            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':id_tamu', $data['id_tamu']);
            $stmt->bindParam(':id_kamar', $data['id_kamar']);
            $stmt->bindParam(':tgl_checkin', $data['tgl_checkin']);
            $stmt->bindParam(':tgl_checkout', $data['tgl_checkout']);
            $stmt->bindParam(':total_biaya', $data['total_biaya']);
            $stmt->bindParam(':status', $data['status']);

            return $stmt->execute();
        } catch (PDOException $e) {
            error_log("Error creating reservation: " . $e->getMessage());
            return false;
        }
    }

    // Update data reservasi
    public function update($id, $data)
    {
        try {
            $sql = "UPDATE reservasi SET 
                    id_tamu = :id_tamu, 
                    id_kamar = :id_kamar, 
                    tgl_checkin = :tgl_checkin, 
                    tgl_checkout = :tgl_checkout, 
                    total_biaya = :total_biaya, 
                    status = :status
                    WHERE id_reservasi = :id";

            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':id', $id);
            $stmt->bindParam(':id_tamu', $data['id_tamu']);
            $stmt->bindParam(':id_kamar', $data['id_kamar']);
            $stmt->bindParam(':tgl_checkin', $data['tgl_checkin']);
            $stmt->bindParam(':tgl_checkout', $data['tgl_checkout']);
            $stmt->bindParam(':total_biaya', $data['total_biaya']);
            $stmt->bindParam(':status', $data['status']);

            return $stmt->execute();
        } catch (PDOException $e) {
            error_log("Error updating reservation: " . $e->getMessage());
            return false;
        }
    }

    // Update status reservasi - METHOD YANG HILANG!
    public function updateStatus($id, $status)
    {
        try {
            $sql = "UPDATE reservasi SET status = :status WHERE id_reservasi = :id";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':status', $status, PDO::PARAM_STR);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);

            $result = $stmt->execute();

            // Debugging - cek apakah query berhasil
            if ($result) {
                error_log("Reservation status updated successfully. ID: $id, Status: $status");
            } else {
                error_log("Failed to update reservation status. ID: $id, Status: $status");
            }

            return $result;
        } catch (PDOException $e) {
            error_log("Error updating reservation status: " . $e->getMessage());
            return false;
        }
    }

    // Hapus reservasi
    public function delete($id)
    {
        try {
            $sql = "DELETE FROM reservasi WHERE id_reservasi = :id";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            return $stmt->execute();
        } catch (PDOException $e) {
            error_log("Error deleting reservation: " . $e->getMessage());
            return false;
        }
    }

    // Cek ketersediaan kamar untuk periode tertentu
    public function checkRoomAvailability($room_id, $checkin_date, $checkout_date, $exclude_reservation_id = null)
    {
        try {
            $sql = "SELECT COUNT(*) as count FROM reservasi 
                    WHERE id_kamar = :room_id 
                    AND status NOT IN ('cancelled', 'checkout')
                    AND (
                        (tgl_checkin BETWEEN :checkin AND :checkout) OR
                        (tgl_checkout BETWEEN :checkin AND :checkout) OR
                        (tgl_checkin <= :checkin AND tgl_checkout >= :checkout)
                    )";

            if ($exclude_reservation_id) {
                $sql .= " AND id_reservasi != :exclude_id";
            }

            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':room_id', $room_id);
            $stmt->bindParam(':checkin', $checkin_date);
            $stmt->bindParam(':checkout', $checkout_date);

            if ($exclude_reservation_id) {
                $stmt->bindParam(':exclude_id', $exclude_reservation_id);
            }

            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            return $result['count'] == 0;
        } catch (PDOException $e) {
            error_log("Error checking room availability: " . $e->getMessage());
            return false;
        }
    }

    // Ambil reservasi berdasarkan tamu
    public function getByGuestId($guest_id)
    {
        try {
            $sql = "SELECT r.*, k.no_kamar, k.tipe_kamar, k.harga
                    FROM reservasi r
                    JOIN kamar k ON r.id_kamar = k.id_kamar
                    WHERE r.id_tamu = :guest_id
                    ORDER BY r.created_at DESC";

            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':guest_id', $guest_id, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error getting reservations by guest ID: " . $e->getMessage());
            return [];
        }
    }

    // Ambil reservasi berdasarkan status
    public function getByStatus($status)
    {
        try {
            $sql = "SELECT r.*, t.nama as nama_tamu, t.no_hp, 
                           k.no_kamar, k.tipe_kamar
                    FROM reservasi r
                    JOIN tamu t ON r.id_tamu = t.id_tamu
                    JOIN kamar k ON r.id_kamar = k.id_kamar
                    WHERE r.status = :status
                    ORDER BY r.created_at DESC";

            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':status', $status);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error getting reservations by status: " . $e->getMessage());
            return [];
        }
    }

    // Hitung total reservasi
    public function getTotalCount()
    {
        try {
            $sql = "SELECT COUNT(*) as total FROM reservasi";
            $stmt = $this->db->prepare($sql);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result['total'];
        } catch (PDOException $e) {
            error_log("Error getting total reservation count: " . $e->getMessage());
            return 0;
        }
    }

    // Generate kode reservasi unik
    public function generateReservationCode()
    {
        $prefix = 'RSV';
        $date = date('ymd');
        $random = str_pad(mt_rand(1, 9999), 4, '0', STR_PAD_LEFT);
        return $prefix . $date . $random;
    }
}
