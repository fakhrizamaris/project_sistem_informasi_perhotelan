<?php
// manajer/controllers/dashboard_controller.php

// Memuat file-file yang diperlukan
require_once __DIR__ . '/../../config/koneksi.php';
require_once __DIR__ . '/../../models/Report.php'; // Menggunakan model Report
require_once __DIR__ . '/../../admin/includes/functions.php';

// Konfigurasi Halaman
$page_title = 'Dashboard Manajer';

// Inisialisasi model Report
$reportModel = new Report();

// Mengambil data yang relevan untuk manajer
$todays_revenue = $reportModel->getTodaysRevenue();
$recent_transactions = $reportModel->getRecentTransactions(10); // Mengambil 10 transaksi terakhir

// Memanggil file layout 
require_once __DIR__ . '/../includes/layout.php';
