<?php
// tamu/views/dashboardtamu_view.php
global $stats, $recent_reservations, $active_reservations;
?>

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

<div class="row mt-2">
    <div class="col-md-6 mb-3">
        <a href="booking.php" class="btn btn-md w-100">
            <i class="fas fa-plus-circle mb-2 d-block fa-2x"></i>
            Booking Kamar Baru
        </a>
    </div>
    <div class="col-md-6 mb-3">
        <a href="reservasi.php" class="btn btn-md w-100">
            <i class="fas fa-list mb-2 d-block fa-2x"></i>
            Lihat Semua Reservasi
        </a>
    </div>
</div>

<div class="row mt-3">
    <div class="col-12">
        <div class="content-card">
            <div class="card-header-custom">
                <h5 class="mb-0">Reservasi Aktif Anda</h5>
            </div>
            <div class="card-body">
                <?php if (empty($active_reservations)): ?>
                    <div class="text-center py-4">
                        <i class="fas fa-calendar-times fa-3x text-muted mb-3"></i>
                        <p class="text-muted">Tidak ada reservasi aktif saat ini.</p>
                    </div>
                <?php else: ?>
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Kamar</th>
                                    <th>Tanggal Check-in</th>
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