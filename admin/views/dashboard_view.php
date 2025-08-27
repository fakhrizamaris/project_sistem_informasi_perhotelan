<?php
// admin/views/dashboard_view.php
// File ini dipanggil dari dalam layout.php, sehingga memiliki akses ke variabel dari controller
global $stats, $recent_reservations;
?>

<div class="row mb-4">
    <div class="col-12">
        <div class="content-card">
            <div class="card-body p-4">
                <h4 class="card-title">Selamat Datang, <?php echo htmlspecialchars($_SESSION['nama']); ?>!</h4>
                <p class="text-muted mb-0">Berikut adalah ringkasan aktivitas hotel hari ini, <?php echo date('d F Y'); ?>.</p>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total Kamar</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $stats['rooms']['total_kamar']; ?></div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-bed fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-success shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Tingkat Okupansi</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $stats['occupancy_rate']; ?>%</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-chart-pie fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-info shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Reservasi Hari Ini</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $stats['reservations']['total_reservasi_hari_ini']; ?></div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-calendar-check fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-warning shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Pendapatan (Bulan Ini)</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo formatRupiah($stats['revenue']['pendapatan_bulan_ini']); ?></div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="content-card">
            <div class="card-header p-4">
                <h5 class="mb-0">Reservasi Terbaru</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive ps-3">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Nama Tamu</th>
                                <th>No. Kamar</th>
                                <th>Tipe Kamar</th>
                                <th>Check-in</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($recent_reservations)): ?>
                                <tr>
                                    <td colspan="5" class="text-center">Tidak ada reservasi terbaru.</td>
                                </tr>
                            <?php else: ?>
                                <?php foreach ($recent_reservations as $res): ?>
                                    <tr>
                                        <td><strong><?php echo htmlspecialchars($res['nama_tamu']); ?></strong></td>
                                        <td><?php echo htmlspecialchars($res['no_kamar']); ?></td>
                                        <td class="text-capitalize"><?php echo htmlspecialchars($res['nama_jenis']); ?></td>
                                        <td><?php echo formatTanggalIndonesia($res['tgl_checkin'], false); ?></td>
                                        <td><?php echo getStatusBadge($res['status'], 'reservation'); ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>