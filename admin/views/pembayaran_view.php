<?php
// admin/views/pembayaran_view.php
global $page_title, $pending_payments;
?>

<div class="row mb-4">
    <div class="col-12">
        <h4 class="mb-0"><?php echo $page_title; ?></h4>
        <p class="text-muted">Daftar pembayaran dari tamu yang memerlukan verifikasi.</p>
    </div>
</div>

<div class="content-card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover datatable">
                <thead>
                    <tr>
                        <th>Tgl Bayar</th>
                        <th>Nama Tamu</th>
                        <th>Jumlah</th>
                        <th>Bukti</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($pending_payments as $payment) : ?>
                        <tr>
                            <td><?php echo formatTanggalIndonesia($payment['tgl_bayar']); ?></td>
                            <td><?php echo htmlspecialchars($payment['nama_tamu']); ?></td>
                            <td><?php echo formatRupiah($payment['jumlah']); ?></td>
                            <td>
                                <a href="../public/uploads/<?php echo htmlspecialchars($payment['bukti_pembayaran']); ?>" target="_blank" class="btn btn-sm btn-info">Lihat Bukti</a>
                            </td>
                            <td>
                                <a href="pembayaran.php?action=approve&id=<?php echo $payment['id_pembayaran']; ?>" class="btn btn-sm btn-success" onclick="return confirm('Yakin ingin menyetujui pembayaran ini?')">Setujui</a>
                                <a href="pembayaran.php?action=reject&id=<?php echo $payment['id_pembayaran']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menolak pembayaran ini?')">Tolak</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>