<?php
// admin/dashboard.php
// Konfigurasi halaman
$page_title = 'Dashboard Admin';
$breadcrumb_items = [
    ['title' => 'Home', 'url' => 'dashboard.php'],
    ['title' => 'Dashboard']
];

// Include layout dan functions
require_once '../includes/layout.php';

// Ambil statistik dashboard
$stats = getDashboardStats();
$recent_reservations = getRecentReservations(5);

// Jika gagal ambil data
if (!$stats) {
    $stats = [
        'rooms' => ['total_kamar' => 0, 'kamar_kosong' => 0, 'kamar_terisi' => 0, 'kamar_booking' => 0, 'kamar_maintenance' => 0],
        'reservations' => ['total_reservasi_hari_ini' => 0, 'reservasi_pending' => 0, 'reservasi_confirmed' => 0, 'reservasi_checkin' => 0],
        'guests' => ['total_tamu' => 0],
        'revenue' => ['pendapatan_bulan_ini' => 0, 'pendapatan_hari_ini' => 0],
        'occupancy_rate' => 0
    ];
}
?>

<!-- Welcome Header -->
<div class="row mb-4">
    <div class="col-12">
        <div class="content-card">
            <div class="card-body-custom">
                <div class="row align-items-center">
                    <div class="col-md-6 pe-3">
                        <h2 class="mb-1">Selamat Datang, <?php echo $_SESSION['nama']; ?>!</h2>
                        <p class="text-muted mb-0">Berikut adalah ringkasan aktivitas hotel hari ini.</p>
                    </div>
                    <div class="col-md-4 text-end">
                        <div class="d-flex flex-column align-items-end">
                            <div class="h5 mb-0" id="currentTime"></div>
                            <small class="text-muted" id="currentDate"></small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Statistics Cards -->
<div class="row mb-4">
    <!-- Total Kamar -->
    <div class="col-xl-3 col-md-6 mb-3">
        <div class="card stat-card info">
            <div class="card-body text-center">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h3 class="mb-0"><?php echo $stats['rooms']['total_kamar']; ?></h3>
                        <p class="mb-0 opacity-75">Total Kamar</p>
                    </div>
                    <div>
                        <i class="fas fa-bed fa-2x opacity-50"></i>
                    </div>
                </div>
                <div class="mt-3">
                    <small class="opacity-75">
                        Tersedia: <?php echo $stats['rooms']['kamar_kosong']; ?> |
                        Terisi: <?php echo $stats['rooms']['kamar_terisi']; ?>
                    </small>
                </div>
            </div>
        </div>
    </div>

    <!-- Okupansi -->
    <div class="col-xl-3 col-md-6 mb-3">
        <div class="card stat-card success">
            <div class