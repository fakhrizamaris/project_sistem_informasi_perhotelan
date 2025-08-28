<?php
// tamu/views/riwayat_view.php
global $page_title, $riwayat_reservasi;
?>

<div class="card">
    <div class="card-header">
        <h4><?php echo htmlspecialchars($page_title); ?></h4>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>No. Kamar</th>
                        <th>Tipe Kamar</th>
                        <th>Check-in</th>
                        <th>Check-out</th>
                        <th>Total Biaya</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($riwayat_reservasi)): ?>
                        <?php foreach ($riwayat_reservasi as $reservasi): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($reservasi['no_kamar']); ?></td>
                                <td class="text-capitalize"><?php echo htmlspecialchars($reservasi['tipe_kamar']); ?></td>
                                <td><?php echo date('d M Y', strtotime($reservasi['tgl_checkin'])); ?></td>
                                <td><?php echo date('d M Y', strtotime($reservasi['tgl_checkout'])); ?></td>
                                <td><?php echo formatRupiah($reservasi['total_biaya']); ?></td>
                                <td><?php echo getStatusBadge($reservasi['status'], 'reservation'); ?></td>
                                <td>
                                    <?php if ($reservasi['status'] == 'pending' || $reservasi['status'] == 'confirmed'): ?>
                                        <a href="#" class="btn btn-sm btn-success">Bayar Sekarang</a>
                                    <?php else: ?>
                                        -
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="7" class="text-center">Anda belum memiliki riwayat reservasi.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>