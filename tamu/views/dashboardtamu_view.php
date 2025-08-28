<?php
// tamu/views/dashboard_view.php
global $stats, $recent_reservations, $active_reservations;
?>

<!-- Welcome Section -->
<div class="welcome-card">
    <div class="row align-items-center">
        <div class="col-md-8">
            <h3>Selamat Datang, <?php echo htmlspecialchars($_SESSION['nama']); ?>!</h3>
            <p class="mb-0">Kelola reservasi dan nikmati layanan hotel terbaik dari kami.</p>
        </div>
        <div class="col-md-4 text-end">
            <div class="d-flex flex-column align-items-end">
                <div class="h5 mb-0 text-white" id="currentTime"></div>
                <small class="text-white-50" id="currentDate"></small>
            </div>
        </div>
    </div>
</div>

<!-- Statistics Cards -->
<div class="row mb-4">
    <!-- Total Reservasi -->
    <div class="col-xl-3 col-md-6 mb-3">
        <div class="card stat-card info h-100">
            <div class="card-body text-center p-4">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h3 class="mb-0"><?php echo $stats['total_reservasi']; ?></h3>
                        <p class="mb-0 opacity-75">Total Reservasi</p>
                    </div>
                    <div>
                        <i class="fas fa-calendar-alt fa-2x opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Reservasi Aktif -->
    <div class="col-xl-3 col-md-6 mb-3">
        <div class="card stat-card warning h-100">
            <div class="card-body text-center p-4">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h3 class="mb-0"><?php echo $stats['reservasi_aktif']; ?></h3>
                        <p class="mb-0 opacity-75">Reservasi Aktif</p>
                    </div>
                    <div>
                        <i class="fas fa-clock fa-2x opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Total Selesai -->
    <div class="col-xl-3 col-md-6 mb-3">
        <div class="card stat-card success h-100">
            <div class="card-body text-center p-4">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h3 class="mb-0"><?php echo $stats['total_checkout']; ?></h3>
                        <p class="mb-0 opacity-75">Menginap Selesai</p>
                    </div>
                    <div>
                        <i class="fas fa-check-circle fa-2x opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Total Pengeluaran -->
    <div class="col-xl-3 col-md-6 mb-3">
        <div class="card stat-card danger h-100">
            <div class="card-body text-center p-4">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="mb-0"><?php echo formatRupiah($stats['total_biaya_keseluruhan']); ?></h5>
                        <p class="mb-0 opacity-75">Total Pengeluaran</p>
                    </div>
                    <div>
                        <i class="fas fa-money-bill-wave fa-2x opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <!-- Reservasi Aktif -->
    <div class="col-lg-6 mb-4">
        <div class="content-card">
            <div class="card-header-custom">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Reservasi Aktif</h5>
                    <a href="booking.php" class="btn btn-light btn-sm">
                        <i class="fas fa-plus me-1"></i>Booking Baru
                    </a>
                </div>
            </div>
            <div class="card-body">
                <?php if (empty($active_reservations)): ?>
                    <div class="text-center py-4">
                        <i class="fas fa-calendar-times fa-3x text-muted mb-3"></i>
                        <p class="text-muted">Tidak ada reservasi aktif saat ini.</p>
                        <a href="booking.php" class="btn btn-primary">Buat Reservasi Baru</a>
                    </div>
                <?php else: ?>
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Kamar</th>
                                    <th>Check-in</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($active_reservations as $res): ?>
                                    <tr>
                                        <td>
                                            <strong>No. <?php echo htmlspecialchars($res['no_kamar']); ?></strong><br>
                                            <small class="text-muted text-capitalize"><?php echo htmlspecialchars($res['tipe_kamar']); ?></small>
                                        </td>
                                        <td><?php echo formatTanggalIndonesia($res['tgl_checkin'], false); ?></td>
                                        <td><?php echo getStatusBadge($res['status']); ?></td>
                                        <td>
                                            <a href="reservasi.php?view=<?php echo $res['id_reservasi']; ?>" class="btn btn-sm btn-info" title="Lihat Detail">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <?php if ($res['status'] == 'pending' && bisaBatalkanReservasi($res['status'], $res['tgl_checkin'])): ?>
                                                <a href="reservasi.php?action=cancel&id=<?php echo $res['id_reservasi']; ?>" class="btn btn-sm btn-danger btn-cancel" title="Batalkan">
                                                    <i class="fas fa-times"></i>
                                                </a>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Riwayat Reservasi -->
    <div class="col-lg-6 mb-4">
        <div class="content-card">
            <div class="card-header-custom">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Riwayat Terbaru</h5>
                    <a href="reservasi.php" class="btn btn-light btn-sm">
                        Lihat Semua
                    </a>
                </div>
            </div>
            <div class="card-body">
                <?php if (empty($recent_reservations)): ?>
                    <div class="text-center py-4">
                        <i class="fas fa-history fa-3x text-muted mb-3"></i>
                        <p class="text-muted">Belum ada riwayat reservasi.</p>
                    </div>
                <?php else: ?>
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Kamar</th>
                                    <th>Tanggal</th>
                                    <th>Status</th>
                                    <th>Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach (array_slice($recent_reservations, 0, 5) as $res): ?>
                                    <tr>
                                        <td>
                                            <strong>No. <?php echo htmlspecialchars($res['no_kamar']); ?></strong><br>
                                            <small class="text-muted text-capitalize"><?php echo htmlspecialchars($res['tipe_kamar']); ?></small>
                                        </td>
                                        <td>
                                            <small>
                                                <?php echo date('d M Y', strtotime($res['tgl_checkin'])); ?><br>
                                                <span class="text-muted"><?php echo timeAgo($res['created_at']); ?></span>
                                            </small>
                                        </td>
                                        <td><?php echo getStatusBadge($res['status']); ?></td>
                                        <td>
                                            <small><?php echo formatRupiah($res['total_biaya']); ?></small>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<!-- Quick Actions -->
<div class="row">
    <div class="col-12">
        <div class="content-card">
            <div class="card-body text-center py-4">
                <h5 class="mb-4">Aksi Cepat</h5>
                <div class="row">
                    <div class="col-md-3 mb-3">
                        <a href="booking.php" class="btn btn-primary btn-lg w-100">
                            <i class="fas fa-plus-circle mb-2 d-block fa-2x"></i>
                            Booking Kamar
                        </a>
                    </div>
                    <div class="col-md-3 mb-3">
                        <a href="reservasi.php" class="btn btn-info btn-lg w-100">
                            <i class="fas fa-list mb-2 d-block fa-2x"></i>
                            Lihat Reservasi
                        </a>
                    </div>
                    <div class="col-md-3 mb-3">
                        <a href="profile.php" class="btn btn-success btn-lg w-100">
                            <i class="fas fa-user-edit mb-2 d-block fa-2x"></i>
                            Edit Profil
                        </a>
                    </div>
                    <div class="col-md-3 mb-3">
                        <a href="mailto:info@hotel.com" class="btn btn-warning btn-lg w-100">
                            <i class="fas fa-envelope mb-2 d-block fa-2x"></i>
                            Hubungi Hotel
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>