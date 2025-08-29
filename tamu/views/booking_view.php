<?php
// tamu/views/booking_view.php
global $page_title, $search_performed, $checkin_date, $checkout_date, $available_rooms, $booking_summary;
?>

<div class="row mb-4">
    <div class="col-12">

        <h4 class="mb-0"><?php echo $page_title; ?></h4>
        <p class="text-muted">Cari dan pesan kamar impian Anda.</p>
    </div>
</div>

<div class="content-card mb-4">
    <div class="card-header-custom">
        <h5 class="mb-0">
            <i class="fas fa-search me-2"></i>Cari Ketersediaan Kamar
        </h5>
    </div>
    <div class="card-body p-4">
        <form action="booking.php?action=search" method="POST">
            <div class="row g-3 align-items-end">
                <div class="col-md-5">
                    <label for="checkin_date" class="form-label">Tanggal Check-in</label>
                    <input type="date" class="form-control" id="checkin_date" name="checkin_date" value="<?php echo htmlspecialchars($checkin_date); ?>" required>
                </div>
                <div class="col-md-5">
                    <label for="checkout_date" class="form-label">Tanggal Check-out</label>
                    <input type="date" class="form-control" id="checkout_date" name="checkout_date" value="<?php echo htmlspecialchars($checkout_date); ?>" required>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-outline-danger w-100">Cari</button>
                </div>
            </div>
        </form>
    </div>
</div>

<?php if ($search_performed && !empty($available_rooms)) : ?>
    <div class="content-card">
        <div class="card-header-custom">
            <h5 class="mb-0">Kamar Tersedia</h5>
        </div>
        <div class="card-body p-4">
            <div class="row">
                <?php foreach ($available_rooms as $room) : ?>
                    <div class="col-md-6 col-lg-4 mb-4">
                        <div class="card h-100">
                            <div class="card-body">
                                <h5 class="card-title text-capitalize"><?php echo htmlspecialchars($room['tipe_kamar']); ?></h5>
                                <h6 class="card-subtitle mb-2 text-muted">No. Kamar: <?php echo htmlspecialchars($room['no_kamar']); ?></h6>
                                <p class="card-text">Harga per malam: <strong><?php echo formatRupiah($room['harga']); ?></strong></p>
                                <a href="booking.php?action=select&room_id=<?php echo $room['id_kamar']; ?>&checkin=<?php echo $checkin_date; ?>&checkout=<?php echo $checkout_date; ?>" class="btn btn-sm btn-outline-primary">Pilih Kamar</a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
<?php endif; ?>

<?php if ($booking_summary) : ?>
    <div class="content-card">
        <div class="card-header-custom">
            <h5 class="mb-0">Konfirmasi Pesanan Anda</h5>
        </div>
        <div class="card-body p-4">
            <div class="row">
                <div class="col-md-8">
                    <h4><?php echo htmlspecialchars(ucfirst($booking_summary['room']['tipe_kamar'])); ?> - No. <?php echo htmlspecialchars($booking_summary['room']['no_kamar']); ?></h4>
                    <p>
                        Check-in: <strong><?php echo formatTanggalIndonesia($booking_summary['checkin']); ?></strong><br>
                        Check-out: <strong><?php echo formatTanggalIndonesia($booking_summary['checkout']); ?></strong><br>
                        Durasi: <strong><?php echo $booking_summary['durasi']; ?> malam</strong>
                    </p>
                    <hr>
                    <h5>Total Biaya: <span class="text-success"><?php echo formatRupiah($booking_summary['total_biaya']); ?></span></h5>
                </div>
                <div class="col-md-4 align-self-center">
                    <form action="booking.php?action=confirm" method="POST">
                        <input type="hidden" name="id_kamar" value="<?php echo $booking_summary['room']['id_kamar']; ?>">
                        <input type="hidden" name="tgl_checkin" value="<?php echo $booking_summary['checkin']; ?>">
                        <input type="hidden" name="tgl_checkout" value="<?php echo $booking_summary['checkout']; ?>">
                        <input type="hidden" name="total_biaya" value="<?php echo $booking_summary['total_biaya']; ?>">
                        <div class="d-grid">
                            <button type="submit" class="btn btn-success btn-lg">Konfirmasi & Booking</button>
                            <a href="booking.php" class="btn btn-secondary mt-2">Batal</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>