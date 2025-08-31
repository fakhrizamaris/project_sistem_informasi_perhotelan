<?php
// models/Room.php

class Room
{
    private $db;

    public function __construct()
    {
        $this->db = getDB();
    }

    // Ambil semua kamar
    public function getAll()
    {
        try {
            $sql = "SELECT * FROM kamar ORDER BY no_kamar";
            $stmt = $this->db->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error getting all rooms: " . $e->getMessage());
            return [];
        }
    }

    // Ambil kamar berdasarkan ID
    public function getById($id)
    {
        try {
            $sql = "SELECT * FROM kamar WHERE id_kamar = :id";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error getting room by ID: " . $e->getMessage());
            return false;
        }
    }

    // Tambah kamar baru
    public function create($data)
    {
        try {
            $sql = "INSERT INTO kamar (tipe_kamar, no_kamar, harga, status) 
                    VALUES (:tipe_kamar, :no_kamar, :harga, :status)";

            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':tipe_kamar', $data['tipe_kamar']);
            $stmt->bindParam(':no_kamar', $data['no_kamar']);
            $stmt->bindParam(':harga', $data['harga']);
            $stmt->bindParam(':status', $data['status']);

            return $stmt->execute();
        } catch (PDOException $e) {
            error_log("Error creating room: " . $e->getMessage());
            return false;
        }
    }

    // Update data kamar
    public function update($id, $data)
    {
        try {
            $sql = "UPDATE kamar SET 
                    tipe_kamar = :tipe_kamar, 
                    no_kamar = :no_kamar, 
                    harga = :harga, 
                    status = :status 
                    WHERE id_kamar = :id";

            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':id', $id);
            $stmt->bindParam(':tipe_kamar', $data['tipe_kamar']);
            $stmt->bindParam(':no_kamar', $data['no_kamar']);
            $stmt->bindParam(':harga', $data['harga']);
            $stmt->bindParam(':status', $data['status']);

            return $stmt->execute();
        } catch (PDOException $e) {
            error_log("Error updating room: " . $e->getMessage());
            return false;
        }
    }

    // Update status kamar - METHOD YANG HILANG!
    public function updateStatus($id, $status)
    {
        try {
            $sql = "UPDATE kamar SET status = :status WHERE id_kamar = :id";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':status', $status, PDO::PARAM_STR);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);

            $result = $stmt->execute();

            // Debugging - cek apakah query berhasil
            if ($result) {
                error_log("Room status updated successfully. ID: $id, Status: $status");
            } else {
                error_log("Failed to update room status. ID: $id, Status: $status");
            }

            return $result;
        } catch (PDOException $e) {
            error_log("Error updating room status: " . $e->getMessage());
            return false;
        }
    }

    // Hapus kamar
    public function delete($id)
    {
        try {
            $sql = "DELETE FROM kamar WHERE id_kamar = :id";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            return $stmt->execute();
        } catch (PDOException $e) {
            error_log("Error deleting room: " . $e->getMessage());
            return false;
        }
    }

    // Ambil kamar yang tersedia
    public function getAvailable($checkin_date, $checkout_date, $room_type = null)
    {
        try {
            $sql = "SELECT k.*
                    FROM kamar k
                    WHERE k.status = 'kosong'
                    AND k.id_kamar NOT IN (
                        SELECT DISTINCT id_kamar FROM reservasi 
                        WHERE status NOT IN ('cancelled', 'checkout')
                        AND (
                            (tgl_checkin BETWEEN :checkin AND :checkout) OR
                            (tgl_checkout BETWEEN :checkin AND :checkout) OR
                            (tgl_checkin <= :checkin AND tgl_checkout >= :checkout)
                        )
                    )";

            if ($room_type) {
                $sql .= " AND k.tipe_kamar = :room_type";
            }

            $sql .= " ORDER BY k.no_kamar";

            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':checkin', $checkin_date);
            $stmt->bindParam(':checkout', $checkout_date);

            if ($room_type) {
                $stmt->bindParam(':room_type', $room_type);
            }

            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error getting available rooms: " . $e->getMessage());
            return [];
        }
    }

    // Ambil kamar berdasarkan status
    public function getByStatus($status)
    {
        try {
            $sql = "SELECT * FROM kamar WHERE status = :status ORDER BY no_kamar";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':status', $status);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error getting rooms by status: " . $e->getMessage());
            return [];
        }
    }

    // Ambil kamar berdasarkan tipe
    public function getByType($type)
    {
        try {
            $sql = "SELECT * FROM kamar WHERE tipe_kamar = :type ORDER BY no_kamar";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':type', $type);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error getting rooms by type: " . $e->getMessage());
            return [];
        }
    }

    // Cek apakah nomor kamar sudah ada
    public function isRoomNumberExists($no_kamar, $exclude_id = null)
    {
        try {
            $sql = "SELECT COUNT(*) as count FROM kamar WHERE no_kamar = :no_kamar";

            if ($exclude_id) {
                $sql .= " AND id_kamar != :exclude_id";
            }

            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':no_kamar', $no_kamar);

            if ($exclude_id) {
                $stmt->bindParam(':exclude_id', $exclude_id);
            }

            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            return $result['count'] > 0;
        } catch (PDOException $e) {
            error_log("Error checking room number exists: " . $e->getMessage());
            return false;
        }
    }

    // Hitung statistik kamar
    public function getRoomStatistics()
    {
        try {
            $sql = "SELECT 
                        COUNT(*) as total_kamar,
                        SUM(CASE WHEN status = 'kosong' THEN 1 ELSE 0 END) as kamar_kosong,
                        SUM(CASE WHEN status = 'terisi' THEN 1 ELSE 0 END) as kamar_terisi,
                        SUM(CASE WHEN status = 'dibooking' THEN 1 ELSE 0 END) as kamar_booking,
                        SUM(CASE WHEN status = 'maintenance' THEN 1 ELSE 0 END) as kamar_maintenance
                    FROM kamar";

            $stmt = $this->db->prepare($sql);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error getting room statistics: " . $e->getMessage());
            return [];
        }
    }

    // Hitung tingkat okupansi
    public function getOccupancyRate()
    {
        try {
            $stats = $this->getRoomStatistics();
            if ($stats['total_kamar'] > 0) {
                $occupied_rooms = $stats['kamar_terisi'] + $stats['kamar_booking'];
                return round(($occupied_rooms / $stats['total_kamar']) * 100, 2);
            }
            return 0;
        } catch (Exception $e) {
            error_log("Error calculating occupancy rate: " . $e->getMessage());
            return 0;
        }
    }

    // Ambil daftar tipe kamar yang unik
    public function getRoomTypes()
    {
        try {
            $sql = "SELECT DISTINCT tipe_kamar FROM kamar ORDER BY tipe_kamar";
            $stmt = $this->db->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_COLUMN);
        } catch (PDOException $e) {
            error_log("Error getting room types: " . $e->getMessage());
            return [];
        }
    }
}
