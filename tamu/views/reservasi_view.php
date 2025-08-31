<?php
// tamu/views/reservasi_view.php
global $reservations, $viewReservation, $page_title;
?>

<div class="row mb-4">
    <div class="col-12 d-flex justify-content-between align-items-center">
        <div>

            <h4 class="mb-0"><?php echo $page_title; ?></h4>
            <p class="text-muted">Kelola dan pantau status reservasi Anda</p>
        </div>
        <a href="booking.php" class="btn btn-outline-primary">
            <i class="fas fa-plus me-2"></i>Booking Baru
        </a>
    </div>
</div>

<!-- Filter Status -->
<div class="row mb-4">
    <div class="col-12">
        <div class="content-card">
            <div class="card-body p-3">
                <div class="btn-group" role="group">
                    <input type="radio" class="btn-check" name="status_filter" id="all" value="all" checked>
                    <label class="btn btn-outline-info" for="all">Semua</label>

                    <input type="radio" class="btn-check" name="status_filter" id="active" value="active">
                    <label class="btn btn-outline-warning" for="active">Aktif</label>

                    <input type="radio" class="btn-check" name="status_filter" id="completed" value="completed">
                    <label class="btn btn-outline-success" for="completed">Selesai</label>

                    <input type="radio" class="btn-check" name="status_filter" id="cancelled" value="cancelled">
                    <label class="btn btn-outline-danger" for="cancelled">Dibatalkan</label>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Daftar Reservasi -->
<div class="content-card">
    <div class="card-body">
        <?php if (empty($reservations)): ?>
            <div class="text-center py-5">
                <i class="fas fa-calendar-times fa-4x text-muted mb-4"></i>
                <h5 class="text-muted">Belum Ada Reservasi</h5>
                <p class="text-muted mb-4">Anda belum memiliki riwayat reservasi. Mulai booking kamar sekarang!</p>
                <a href="booking.php" class="btn btn-outline-primary btn-md">
                    <i class="fas fa-plus me-2"></i>Buat Reservasi Pertama
                </a>
            </div>
        <?php else: ?>
            <div class="table-responsive">
                <table class="table table-hover" id="reservationsTable">
                    <thead class="table-light">
                        <tr>
                            <th>Kode Booking</th>
                            <th>Kamar</th>
                            <th>Tanggal</th>
                            <th>Durasi</th>
                            <th>Total</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($reservations as $res): ?>
                            <?php
                            $durasi = hitungDurasiMenginap($res['tgl_checkin'], $res['tgl_checkout']);
                            $booking_ref = 'BK' . str_pad($res['id_reservasi'], 6, '0', STR_PAD_LEFT);
                            ?>
                            <tr data-status="<?php echo $res['status']; ?>">
                                <td>
                                    <strong class="text-primary"><?php echo $booking_ref; ?></strong><br>
                                    <small class="text-muted"><?php echo timeAgo($res['created_at']); ?></small>
                                </td>
                                <td>
                                    <strong>No. <?php echo htmlspecialchars($res['no_kamar']); ?></strong><br>
                                    <small class="text-muted text-capitalize"><?php echo htmlspecialchars($res['tipe_kamar']); ?></small>
                                </td>
                                <td>
                                    <strong><?php echo date('d M Y', strtotime($res['tgl_checkin'])); ?></strong><br>
                                    <small class="text-muted">s/d <?php echo date('d M Y', strtotime($res['tgl_checkout'])); ?></small>
                                </td>
                                <td>
                                    <span class="badge bg-info"><?php echo $durasi; ?> malam</span>
                                </td>
                                <td>
                                    <strong><?php echo formatRupiah($res['total_biaya']); ?></strong>
                                </td>
                                <td>
                                    <?php echo getStatusBadge($res['status']); ?>
                                </td>
                                // (Bagian atas file tetap sama)
                                ...
                                <td>
                                    <div class="btn-group" role="group">
                                        <button type="button" class="btn btn-sm" data-bs-toggle="modal" data-bs-target="#detailModal" data-reservation='<?php echo json_encode($res); ?>' title="Detail">
                                            <i class="fas fa-eye"></i>
                                        </button>

                                        <?php if ($res['status'] == 'pending') : ?>
                                            <a href="pembayaran.php?id=<?php echo $res['id_reservasi']; ?>"
                                                class="btn btn-sm"
                                                title="Bayar Sekarang">
                                                <i class="fas fa-money-check-alt"></i>
                                            </a>
                                        <?php endif; ?>

                                        <?php // Tombol Check-in untuk tamu
                                        if ($res['status'] == 'confirmed' && date('Y-m-d') >= $res['tgl_checkin']) : ?>
                                            <a href="reservasi.php?action=checkin&id=<?php echo $res['id_reservasi']; ?>" class="btn btn-sm btn-success" title="Check-in Mandiri" onclick="return confirm('Anda akan melakukan check-in sekarang?')">
                                                <i class="fas fa-sign-in-alt"></i>
                                            </a>
                                        <?php endif; ?>

                                        <?php // Tombol Check-out untuk tamu
                                        if ($res['status'] == 'checkin' && date('Y-m-d') >= $res['tgl_checkout']) : ?>
                                            <a href="reservasi.php?action=checkout&id=<?php echo $res['id_reservasi']; ?>" class="btn btn-sm btn-warning" title="Check-out Mandiri" onclick="return confirm('Anda akan melakukan check-out sekarang?')">
                                                <i class="fas fa-sign-out-alt"></i>
                                            </a>
                                        <?php endif; ?>

                                        <?php if (bisaBatalkanReservasi($res['status'], $res['tgl_checkin'])) : ?>
                                            <a href="reservasi.php?action=cancel&id=<?php echo $res['id_reservasi']; ?>"
                                                class="btn btn-sm btn-danger btn-cancel"
                                                title="Batalkan">
                                                <i class="fas fa-times"></i>
                                            </a>
                                        <?php endif; ?>
                                    </div>
                                </td>

                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>
</div>

<!-- Modal Detail Reservasi -->
<div class="modal fade" id="detailModal" tabindex="-1" aria-labelledby="detailModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="detailModalLabel">Detail Reservasi</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="modalBody">
                <!-- Konten akan diisi oleh JavaScript -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

<!-- Ringkasan Statistik -->
<?php if (!empty($reservations)): ?>
    <div class="row mt-4">
        <div class="col-md-3">
            <div class="card text-center border-primary">
                <div class="card-body">
                    <i class="fas fa-calendar-alt fa-2x text-primary mb-2"></i>
                    <h5><?php echo count($reservations); ?></h5>
                    <p class="text-muted mb-0">Total Reservasi</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-center border-warning">
                <div class="card-body">
                    <i class="fas fa-clock fa-2x text-warning mb-2"></i>
                    <h5><?php echo count(array_filter($reservations, function ($r) {
                            return in_array($r['status'], ['pending', 'confirmed', 'checkin']);
                        })); ?></h5>
                    <p class="text-muted mb-0">Reservasi Aktif</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-center border-success">
                <div class="card-body">
                    <i class="fas fa-check-circle fa-2x text-success mb-2"></i>
                    <h5><?php echo count(array_filter($reservations, function ($r) {
                            return $r['status'] == 'checkout';
                        })); ?></h5>
                    <p class="text-muted mb-0">Selesai</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-center border-info">
                <div class="card-body">
                    <i class="fas fa-money-bill-wave fa-2x text-info mb-2"></i>
                    <h5><?php echo formatRupiah(array_sum(array_column(array_filter($reservations, function ($r) {
                            return $r['status'] == 'checkout';
                        }), 'total_biaya'))); ?></h5>
                    <p class="text-muted mb-0">Total Pengeluaran</p>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Filter reservasi berdasarkan status
        const filterButtons = document.querySelectorAll('input[name="status_filter"]');
        const tableRows = document.querySelectorAll('#reservationsTable tbody tr');

        filterButtons.forEach(button => {
            button.addEventListener('change', function() {
                const filterValue = this.value;

                tableRows.forEach(row => {
                    const status = row.dataset.status;
                    let showRow = false;

                    switch (filterValue) {
                        case 'all':
                            showRow = true;
                            break;
                        case 'active':
                            showRow = ['pending', 'confirmed', 'checkin'].includes(status);
                            break;
                        case 'completed':
                            showRow = status === 'checkout';
                            break;
                        case 'cancelled':
                            showRow = status === 'cancelled';
                            break;
                    }

                    row.style.display = showRow ? '' : 'none';
                });
            });
        });

        // Modal detail reservasi
        const detailModal = document.getElementById('detailModal');
        detailModal.addEventListener('show.bs.modal', function(event) {
            const button = event.relatedTarget;
            const reservation = JSON.parse(button.getAttribute('data-reservation'));
            const modalBody = document.getElementById('modalBody');

            // Generate booking reference
            const bookingRef = 'BK' + String(reservation.id_reservasi).padStart(6, '0');

            // Hitung durasi
            const checkin = new Date(reservation.tgl_checkin);
            const checkout = new Date(reservation.tgl_checkout);
            const durasi = Math.ceil((checkout - checkin) / (1000 * 60 * 60 * 24));

            // Format tanggal
            const formatDate = (dateStr) => {
                const date = new Date(dateStr);
                return date.toLocaleDateString('id-ID', {
                    weekday: 'long',
                    year: 'numeric',
                    month: 'long',
                    day: 'numeric'
                });
            };

            // Format rupiah
            const formatRupiah = (amount) => {
                return new Intl.NumberFormat('id-ID', {
                    style: 'currency',
                    currency: 'IDR',
                    minimumFractionDigits: 0
                }).format(amount);
            };

            // Status badge
            let statusBadge = '';
            switch (reservation.status) {
                case 'pending':
                    statusBadge = '<span class="badge bg-warning">Menunggu Konfirmasi</span>';
                    break;
                case 'confirmed':
                    statusBadge = '<span class="badge bg-info">Dikonfirmasi</span>';
                    break;
                case 'checkin':
                    statusBadge = '<span class="badge bg-primary">Sudah Check-in</span>';
                    break;
                case 'checkout':
                    statusBadge = '<span class="badge bg-success">Selesai</span>';
                    break;
                case 'cancelled':
                    statusBadge = '<span class="badge bg-danger">Dibatalkan</span>';
                    break;
            }

            modalBody.innerHTML = `
            <div class="row">
                <div class="col-md-6">
                    <h6 class="text-primary mb-3">Informasi Booking</h6>
                    <table class="table table-borderless">
                        <tr>
                            <td width="40%">Kode Booking:</td>
                            <td><strong class="text-primary">${bookingRef}</strong></td>
                        </tr>
                        <tr>
                            <td>Status:</td>
                            <td>${statusBadge}</td>
                        </tr>
                        <tr>
                            <td>Tanggal Booking:</td>
                            <td>${formatDate(reservation.created_at)}</td>
                        </tr>
                    </table>
                </div>
                <div class="col-md-6">
                    <h6 class="text-primary mb-3">Detail Kamar</h6>
                    <table class="table table-borderless">
                        <tr>
                            <td width="40%">Nomor Kamar:</td>
                            <td><strong>${reservation.no_kamar}</strong></td>
                        </tr>
                        <tr>
                            <td>Tipe Kamar:</td>
                            <td class="text-capitalize">${reservation.tipe_kamar}</td>
                        </tr>
                    </table>
                </div>
            </div>
            
            <hr>
            
            <div class="row">
                <div class="col-12">
                    <h6 class="text-primary mb-3">Detail Menginap</h6>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="card bg-light">
                                <div class="card-body text-center">
                                    <i class="fas fa-calendar-check fa-2x text-success mb-2"></i>
                                    <h6>Check-in</h6>
                                    <p class="mb-0">${formatDate(reservation.tgl_checkin)}</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card bg-light">
                                <div class="card-body text-center">
                                    <i class="fas fa-calendar-times fa-2x text-warning mb-2"></i>
                                    <h6>Check-out</h6>
                                    <p class="mb-0">${formatDate(reservation.tgl_checkout)}</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card bg-light">
                                <div class="card-body text-center">
                                    <i class="fas fa-moon fa-2x text-info mb-2"></i>
                                    <h6>Durasi</h6>
                                    <p class="mb-0">${durasi} malam</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <hr>
            
            <div class="row">
                <div class="col-12">
                    <h6 class="text-primary mb-3">Rincian Biaya</h6>
                    <div class="card bg-light">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-8">
                                    <strong>Total Biaya:</strong>
                                </div>
                                <div class="col-4 text-end">
                                    <strong class="text-success">${formatRupiah(reservation.total_biaya)}</strong>
                                </div>
                            </div>
                            <hr class="my-2">
                            <small class="text-muted">* Harga sudah termasuk pajak dan service charge</small>
                        </div>
                    </div>
                </div>
            </div>
            
            ${reservation.status === 'pending' ? `
            <div class="alert alert-info mt-3">
                <i class="fas fa-info-circle me-2"></i>
                <strong>Informasi:</strong> Reservasi Anda sedang menunggu konfirmasi dari pihak hotel. 
                Anda akan mendapat notifikasi setelah reservasi dikonfirmasi.
            </div>
            ` : ''}
            
            ${reservation.status === 'confirmed' ? `
            <div class="alert alert-success mt-3">
                <i class="fas fa-check-circle me-2"></i>
                <strong>Selamat!</strong> Reservasi Anda telah dikonfirmasi. 
                Silakan datang pada tanggal check-in yang telah ditentukan.
            </div>
            ` : ''}
        `;
        });
    });
</script>