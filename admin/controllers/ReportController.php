<?php
// admin/controllers/ReportController.php

require_once '../config/koneksi.php';
require_once '../models/Report.php'; // Menggunakan model Report yang baru
require_once 'includes/functions.php';

// Inisialisasi model
$reportModel = new Report();

// Konfigurasi halaman
$page_title = 'Laporan';

// Ambil data dari model untuk ditampilkan di view
$todays_revenue = $reportModel->getTodaysRevenue();
$recent_transactions = $reportModel->getRecentTransactions();


// Panggil layout utama yang akan merangkai semua bagian halaman
require_once 'includes/layout.php';