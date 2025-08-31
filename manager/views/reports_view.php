<?php
// manajer/views/reports_view.php
global $page_title, $todays_revenue, $weekly_revenue, $monthly_revenue, $yearly_revenue, $recent_transactions;
?>

<div class="row mb-4">
    <div class="col-12">
        <h4 class="mb-0"><?php echo $page_title; ?></h4>
        <p class="text-muted">Ringkasan pendapatan dan transaksi hotel.</p>
    </div>
</div>

<div class="row mb-4">
    <div class="col-md-3">
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
    <div class="col-md-3">
        <div class="card border-left-info shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Pendapatan Minggu Ini</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            <?php echo formatRupiah($weekly_revenue['total_pendapatan']); ?>
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-calendar-week fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Pendapatan Bulan Ini</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            <?php echo formatRupiah($monthly_revenue['total_pendapatan']); ?>
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-calendar-alt fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-left-warning shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Pendapatan Tahun Ini</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            <?php echo formatRupiah($yearly_revenue['total_pendapatan']); ?>
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-calendar fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="row">
    <div class="col-12">
        <div class="content-card p-4">
            <div class="card-header">
                <h5 class="mb-2 mx-1">10 Transaksi Terakhir (Checkout)</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
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