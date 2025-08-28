<?php
// admin/views/reservations_view.php
global $reservations, $availableRooms, $page_title, $guests; // Tambahkan $guests
?>

<div class="row mb-4">
    <div class="col-12 d-flex justify-content-between align-items-center">
        <h4 class="mb-0"><?php echo htmlspecialchars($page_title); ?></h4>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addReservationModal">
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
                                    <a href="?view=<?php echo $res['id_reservasi']; ?>" class="btn btn-sm btn-info" title="Lihat Detail"><i class="fas fa-eye"></i></a>
                                    <a href="reservations.php?action=delete&id=<?php echo $res['id_reservasi']; ?>" class="btn btn-sm btn-danger btn-delete" data-name="<?php echo 'reservasi ' . htmlspecialchars($res['nama_tamu']); ?>" title="Hapus"><i class="fas fa-trash"></i></a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="7" class="text-center">Belum ada data reservasi.</td>
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
            <form action="reservations.php" method="POST" class="needs-validation" novalidate>
                <input type="hidden" name="action" value="create">
                <div class="modal-header">
                    <h5 class="modal-title" id="addReservationModalLabel">Formulir Reservasi Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="id_tamu" class="form-label">Pilih Tamu</label>
                        <select class="form-select" id="id_tamu" name="id_tamu" required>
                            <option value="">-- Pilih Tamu yang Sudah Terdaftar --</option>
                            <?php foreach ($guests as $guest): ?>
                                <option value="<?php echo $guest['id_tamu']; ?>"><?php echo htmlspecialchars($guest['nama']) . ' (' . htmlspecialchars($guest['no_identitas']) . ')'; ?></option>
                            <?php endforeach; ?>
                        </select>
                        <div class="form-text">Jika tamu belum terdaftar, silakan tambahkan melalui menu <a href="tamu.php" target="_blank">Data Tamu</a>.</div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="tgl_checkin" class="form-label">Tanggal Check-in</label>
                            <input type="date" class="form-control" id="tgl_checkin" name="tgl_checkin" value="<?php echo date('Y-m-d'); ?>" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="tgl_checkout" class="form-label">Tanggal Check-out</label>
                            <input type="date" class="form-control" id="tgl_checkout" name="tgl_checkout" value="<?php echo date('Y-m-d', strtotime('+1 day')); ?>" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="id_kamar" class="form-label">Pilih Kamar yang Tersedia</label>
                        <select class="form-select" id="id_kamar" name="id_kamar" required>
                            <option value="">-- Pilih Kamar --</option>
                            <?php if (!empty($availableRooms)): ?>
                                <?php foreach ($availableRooms as $room): ?>
                                    <option value="<?php echo $room['id_kamar']; ?>" data-harga="<?php echo $room['harga']; ?>">
                                        <?php echo 'Kamar No. ' . htmlspecialchars($room['no_kamar']) . ' (' . htmlspecialchars($room['tipe_kamar']) . ') - ' . formatRupiah($room['harga']); ?>
                                    </option>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <option disabled>Tidak ada kamar yang tersedia untuk tanggal yang dipilih.</option>
                            <?php endif; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="total_biaya" class="form-label">Total Biaya</label>
                        <input type="number" class="form-control" id="total_biaya" name="total_biaya" readonly required>
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

            if (checkinDate >= checkoutDate) {
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

        checkinInput.addEventListener('change', calculateTotal);
        checkoutInput.addEventListener('change', calculateTotal);
        roomSelect.addEventListener('change', calculateTotal);
    });
</script>