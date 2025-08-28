<?php
// admin/views/reservations_view.php
global $reservations, $availableRooms, $page_title, $guests, $viewReservation;
?>

<div class="row mb-4">
    <div class="col-12 d-flex justify-content-between align-items-center">
        <h4 class="mb-0"><?php echo htmlspecialchars($page_title); ?></h4>
        <button class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#addReservationModal">
            <i class="fas fa-plus me-2"></i>Tambah Reservasi
        </button>
    </div>
</div>

<div class="content-card">
    <div class="card-body">
        <div class="table-responsive p-3">
            <table class="table table-striped table-hover datatable">
                <thead class="bg-light">
                    <tr>
                        <th>Nama Tamu</th>
                        <th>No. Kamar</th>
                        <th>Check-in</th>
                        <th>Check-out</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($reservations)): ?>
                        <?php foreach ($reservations as $res) : ?>
                            <tr>
                                <td><?php echo htmlspecialchars($res['nama_tamu']); ?></td>
                                <td><?php echo htmlspecialchars($res['no_kamar']); ?></td>
                                <td><?php echo date('d M Y', strtotime($res['tgl_checkin'])); ?></td>
                                <td><?php echo date('d M Y', strtotime($res['tgl_checkout'])); ?></td>
                                <td><?php echo getStatusBadge($res['status'], 'reservation'); ?></td>
                                <td>
                                    <a href="?view=<?php echo $res['id_reservasi']; ?>" class="btn btn-sm" title="Lihat Detail"><i class="fas fa-eye"></i></a>
                                    <a href="reservations.php?action=delete&id=<?php echo $res['id_reservasi']; ?>" class="btn btn-sm btn-delete" data-name="<?php echo 'reservasi ' . htmlspecialchars($res['nama_tamu']); ?>" title="Hapus"><i class="fas fa-trash"></i></a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="6" class="text-center">Belum ada data reservasi.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="modal fade" id="addReservationModal" tabindex="-1" aria-labelledby="addReservationModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="reservations.php" method="POST">
                <input type="hidden" name="action" value="create">
                <div class="modal-header">
                    <h5 class="modal-title" id="addReservationModalLabel">Formulir Reservasi Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="id_tamu" class="form-label">Pilih Tamu</label>
                        <select name="id_tamu" id="id_tamu" class="form-select" required>
                            <option value="">-- Pilih Tamu --</option>
                            <?php foreach ($guests as $guest): ?>
                                <option value="<?php echo $guest['id_tamu']; ?>"><?php echo htmlspecialchars($guest['nama']); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="tgl_checkin" class="form-label">Tanggal Check-in</label>
                            <input type="date" class="form-control" name="tgl_checkin" id="tgl_checkin" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="tgl_checkout" class="form-label">Tanggal Check-out</label>
                            <input type="date" class="form-control" name="tgl_checkout" id="tgl_checkout" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="id_kamar" class="form-label">Pilih Kamar</label>
                        <select name="id_kamar" id="id_kamar" class="form-select" required>
                            <option value="">-- Pilih Kamar Tersedia --</option>
                            <?php foreach ($availableRooms as $room): ?>
                                <option value="<?php echo $room['id_kamar']; ?>" data-harga="<?php echo $room['harga']; ?>">
                                    No. <?php echo htmlspecialchars($room['no_kamar']); ?> (<?php echo htmlspecialchars(ucfirst($room['tipe_kamar'])); ?>) - <?php echo formatRupiah($room['harga']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="total_biaya" class="form-label">Total Biaya</label>
                        <input type="number" class="form-control" name="total_biaya" id="total_biaya" readonly required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan Reservasi</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php if (isset($viewReservation) && $viewReservation): ?>
    <div class="modal fade" id="detailReservationModal" tabindex="-1" aria-labelledby="detailReservationModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="detailReservationModalLabel">Detail Reservasi</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h5>Data Tamu</h5>
                            <p><strong>Nama:</strong> <?php echo htmlspecialchars($viewReservation['nama_tamu']); ?></p>
                            <p><strong>Email:</strong> <?php echo htmlspecialchars($viewReservation['email']); ?></p>
                            <p><strong>No. HP:</strong> <?php echo htmlspecialchars($viewReservation['no_hp']); ?></p>
                        </div>
                        <div class="col-md-6">
                            <h5>Data Reservasi</h5>
                            <p><strong>No. Kamar:</strong> <?php echo htmlspecialchars($viewReservation['no_kamar']); ?> (<?php echo htmlspecialchars(ucfirst($viewReservation['tipe_kamar'])); ?>)</p>
                            <p><strong>Check-in:</strong> <?php echo date('d M Y', strtotime($viewReservation['tgl_checkin'])); ?></p>
                            <p><strong>Check-out:</strong> <?php echo date('d M Y', strtotime($viewReservation['tgl_checkout'])); ?></p>
                            <p><strong>Total Biaya:</strong> <?php echo formatRupiah($viewReservation['total_biaya']); ?></p>
                        </div>
                    </div>
                    <hr>
                    <form action="reservations.php" method="POST">
                        <input type="hidden" name="reservation_id" value="<?php echo $viewReservation['id_reservasi']; ?>">
                        <div class="row align-items-end">
                            <div class="col-md-8">
                                <label for="status" class="form-label"><strong>Ubah Status Reservasi</strong></label>
                                <select name="status" id="status" class="form-select">
                                    <option value="pending" <?php echo $viewReservation['status'] == 'pending' ? 'selected' : ''; ?>>Pending</option>
                                    <option value="confirmed" <?php echo $viewReservation['status'] == 'confirmed' ? 'selected' : ''; ?>>Confirmed</option>
                                    <option value="checkin" <?php echo $viewReservation['status'] == 'checkin' ? 'selected' : ''; ?>>Check-in</option>
                                    <option value="checkout" <?php echo $viewReservation['status'] == 'checkout' ? 'selected' : ''; ?>>Check-out</option>
                                    <option value="cancelled" <?php echo $viewReservation['status'] == 'cancelled' ? 'selected' : ''; ?>>Cancelled</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <button type="submit" name="update_status" class="btn btn-success w-100">Update Status</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var detailModal = new bootstrap.Modal(document.getElementById('detailReservationModal'));
            detailModal.show();
        });
    </script>
<?php endif; ?>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const checkinInput = document.getElementById('tgl_checkin');
        const checkoutInput = document.getElementById('tgl_checkout');
        const roomSelect = document.getElementById('id_kamar');
        const totalBiayaInput = document.getElementById('total_biaya');

        function calculateTotal() {
            const checkinDate = new Date(checkinInput.value);
            const checkoutDate = new Date(checkoutInput.value);
            const selectedOption = roomSelect.options[roomSelect.selectedIndex];
            const hargaPerMalam = selectedOption ? parseFloat(selectedOption.getAttribute('data-harga')) : 0;

            if (!checkinInput.value || !checkoutInput.value || checkinDate >= checkoutDate) {
                totalBiayaInput.value = 0;
                return;
            }

            if (hargaPerMalam > 0) {
                const timeDiff = checkoutDate.getTime() - checkinDate.getTime();
                const nights = Math.ceil(timeDiff / (1000 * 3600 * 24));
                const total = nights * hargaPerMalam;
                totalBiayaInput.value = total;
            } else {
                totalBiayaInput.value = 0;
            }
        }

        if (checkinInput) {
            checkinInput.addEventListener('change', calculateTotal);
        }
        if (checkoutInput) {
            checkoutInput.addEventListener('change', calculateTotal);
        }
        if (roomSelect) {
            roomSelect.addEventListener('change', calculateTotal);
        }
    });
</script>