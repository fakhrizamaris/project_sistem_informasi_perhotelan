<?php
// admin/controllers/ReportController.php

require_once __DIR__ . '/../../config/koneksi.php';
require_once __DIR__ . '/../../models/Report.php';
// --- PERBAIKAN PATH DI SINI ---
require_once __DIR__ . '/../includes/functions.php';

// Inisialisasi model
$reportModel = new Report();

// Konfigurasi halaman
$page_title = 'Laporan';

// Ambil data dari model untuk ditampilkan di view
$todays_revenue = $reportModel->getTodaysRevenue();
$recent_transactions = $reportModel->getRecentTransactions();


// Panggil layout utama yang akan merangkai semua bagian halaman
require_once __DIR__ . '/../includes/layout.php';
