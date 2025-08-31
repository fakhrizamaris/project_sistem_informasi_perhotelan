<?php
// manajer/controllers/ReportController.php

require_once __DIR__ . '/../../config/koneksi.php';
require_once __DIR__ . '/../../models/Report.php';
require_once __DIR__ . '/../../admin/includes/functions.php';

// Inisialisasi model
$reportModel = new Report();

// Konfigurasi halaman
$page_title = 'Laporan';

// Ambil data dari model
$todays_revenue = $reportModel->getTodaysRevenue();
$recent_transactions = $reportModel->getRecentTransactions();

// Panggil layout utama
require_once __DIR__ . '/../includes/layout.php';
