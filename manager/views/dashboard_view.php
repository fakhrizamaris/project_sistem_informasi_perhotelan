<?php
// manajer/views/dashboard_view.php
global $page_title, $todays_revenue, $recent_transactions, $staff_list;
?>

<div class="row mb-4">
    <div class="col-12">
        <div class="content-card">
            <div class="card-body p-4">
                <h4 class="card-title">Selamat Datang, <?php echo htmlspecialchars($_SESSION['nama']); ?>!</h4>
                <p class="text-muted mb-0">Berikut adalah ringkasan laporan pendapatan hotel hingga saat ini, <?php echo date('d F Y'); ?>.</p>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-xl-6 col-md-6 mb-4">
        <div class="card border-left-success shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Pendapatan Hari Ini</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            <?php echo formatRupiah($todays_revenue['total_pendapatan']); ?>
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-6 col-md-6 mb-4">
        <div class="card border-left-info shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Transaksi Selesai Hari Ini</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            <?php echo $todays_revenue['jumlah_transaksi']; ?> Transaksi
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-receipt fa-2x text-gray-300"></i>
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
                <h5 class="mb-0">Manajemen Pegawai</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive ps-3">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Nama</th>
                                <th>Jabatan</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($staff_list)): ?>
                                <tr>
                                    <td colspan="3" class="text-center">Tidak ada data pegawai.</td>
                                </tr>
                            <?php else: ?>
                                <?php foreach ($staff_list as $staff): ?>
                                    <tr>
                                        <td><strong><?php echo htmlspecialchars($staff['nama']); ?></strong></td>
                                        <td><?php echo htmlspecialchars($staff['jabatan']); ?></td>
                                        <td><?php echo getStatusBadge($staff['status']); ?></td>
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