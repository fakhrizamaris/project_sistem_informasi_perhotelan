<?php
// models/Report.php

class Report
{
    private $db;

    public function __construct()
    {
        $this->db = getDB();
    }

    /**
     * Mengambil statistik pendapatan untuk hari ini.
     */
    public function getTodaysRevenue()
    {
        // --- UBAH QUERY DI BAWAH INI ---
        $stmt = $this->db->query("
            SELECT 
                -- Menghitung total pendapatan dari reservasi yang statusnya 'checkout' DAN tanggal checkout-nya adalah hari ini
                COALESCE(SUM(total_biaya), 0) as total_pendapatan,
                -- Menghitung jumlah transaksi/reservasi yang selesai hari ini
                COUNT(id_reservasi) as jumlah_transaksi
            FROM reservasi 
            WHERE status = 'checkout' AND DATE(tgl_checkout) = CURDATE()
        ");
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Mengambil daftar transaksi terakhir (misal: 10 transaksi checkout terbaru).
     */
    public function getRecentTransactions($limit = 10)
    {
        $stmt = $this->db->prepare("
            SELECT 
                r.total_biaya, 
                r.updated_at as tanggal_checkout, 
                t.nama as nama_tamu, 
                k.no_kamar
            FROM reservasi r
            JOIN tamu t ON r.id_tamu = t.id_tamu
            JOIN kamar k ON r.id_kamar = k.id_kamar
            WHERE r.status = 'checkout'
            ORDER BY r.updated_at DESC
            LIMIT :limit
        ");
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
