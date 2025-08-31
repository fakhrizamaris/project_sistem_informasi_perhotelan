<?php
// manajer/views/dashboard_view.php
global $page_title, $todays_revenue, $recent_transactions;
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
                <h5 class="mb-0">10 Transaksi Terakhir (Checkout)</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive ps-3">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Tanggal Checkout</th>
                                <th>Nama Tamu</th>
                                <th>No. Kamar</th>
                                <th>Total Bayar</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($recent_transactions)): ?>
                                <tr>
                                    <td colspan="4" class="text-center">Belum ada transaksi yang selesai.</td>
                                </tr>
                            <?php else: ?>
                                <?php foreach ($recent_transactions as $trx): ?>
                                    <tr>
                                        <td><?php echo formatTanggalIndonesia($trx['tanggal_checkout']); ?></td>
                                        <td><strong><?php echo htmlspecialchars($trx['nama_tamu']); ?></strong></td>
                                        <td><?php echo htmlspecialchars($trx['no_kamar']); ?></td>
                                        <td><?php echo formatRupiah($trx['total_biaya']); ?></td>
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