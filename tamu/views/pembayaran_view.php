<?php
// tamu/views/pembayaran_view.php
global $page_title, $reservasi;
?>

<div class="row mb-4">
    <div class="col-12">
        <h4 class="mb-0"><?php echo $page_title; ?></h4>
    </div>
</div>

<div class="content-card">
    <div class="card-header-custom">
        <h5 class="mb-0">Detail Tagihan</h5>
    </div>
    <div class="card-body p-4">
        <div class="row">
            <div class="col-md-6">
                <h6>Informasi Reservasi</h6>
                <p>
                    <strong>No. Kamar:</strong> <?php echo htmlspecialchars($reservasi['no_kamar']); ?> (<?php echo htmlspecialchars(ucfirst($reservasi['tipe_kamar'])); ?>)<br>
                    <strong>Check-in:</strong> <?php echo formatTanggalIndonesia($reservasi['tgl_checkin']); ?><br>
                    <strong>Check-out:</strong> <?php echo formatTanggalIndonesia($reservasi['tgl_checkout']); ?>
                </p>
            </div>
            <div class="col-md-6 text-md-end">
                <h6>Total Pembayaran</h6>
                <h3 class="text-success"><?php echo formatRupiah($reservasi['total_biaya']); ?></h3>
            </div>
        </div>
        <hr>
        <h6>Instruksi Pembayaran</h6>
        <p>Silakan lakukan transfer ke salah satu rekening berikut:</p>
        <ul>
            <li><strong>Bank ABC:</strong> 123-456-7890 a/n PT Hotel Tourism</li>
            <li><strong>Bank XYZ:</strong> 098-765-4321 a/n PT Hotel Tourism</li>
        </ul>
        <p>Setelah melakukan transfer, mohon unggah bukti pembayaran Anda melalui formulir di bawah ini.</p>
    </div>
</div>

<div class="content-card mt-4">
    <div class="card-header-custom">
        <h5 class="mb-0">Konfirmasi Pembayaran</h5>
    </div>
    <div class="card-body p-4">
        <form method="POST" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="metode_pembayaran" class="form-label">Metode Pembayaran</label>
                <select class="form-select" id="metode_pembayaran" name="metode_pembayaran" required>
                    <option value="transfer">Transfer Bank</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="bukti_pembayaran" class="form-label">Unggah Bukti Pembayaran</label>
                <input class="form-control" type="file" id="bukti_pembayaran" name="bukti_pembayaran" accept="image/jpeg,image/png" required>
                <div class="form-text">Format file: JPG, PNG. Ukuran maksimal: 2MB.</div>
            </div>
            <button type="submit" name="konfirmasi_pembayaran" class="btn btn-primary">Kirim Konfirmasi</button>
            <a href="reservasi.php" class="btn btn-secondary">Kembali</a>
        </form>
    </div>
</div>