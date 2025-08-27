<?php
// admin/views/reservations_view.php
global $reservations, $availableRooms, $page_title;
?>

<div class="row mb-4">
    <div class="col-12 d-flex justify-content-between align-items-center">
        <h4 class="mb-0"><?php echo $page_title; ?></h4>
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
                        <th>Kode</th>
                        <th>Nama Tamu</th>
                        <th>No. Kamar</th>
                        <th>Check-in</th>
                        <th>Check-out</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($reservations as $res) : ?>
                        <tr>
                            <td><strong><?php echo htmlspecialchars($res['kode_reservasi']); ?></strong></td>
                            <td><?php echo htmlspecialchars($res['nama_tamu']); ?></td>
                            <td><?php echo htmlspecialchars($res['no_kamar']); ?></td>
                            <td><?php echo date('d M Y', strtotime($res['tgl_checkin'])); ?></td>
                            <td><?php echo date('d M Y', strtotime($res['tgl_checkout'])); ?></td>
                            <td><?php echo getStatusBadge($res['status'], 'reservation'); ?></td>
                            <td>
                                <a href="?view=<?php echo $res['id_reservasi']; ?>" class="btn btn-sm btn-info" title="Lihat Detail"><i class="fas fa-eye"></i></a>
                                <a href="?action=delete&id=<?php echo $res['id_reservasi']; ?>" class="btn btn-sm btn-danger btn-delete" data-name="<?php echo 'reservasi ' . htmlspecialchars($res['kode_reservasi']); ?>" title="Hapus"><i class="fas fa-trash"></i></a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="modal fade" id="addReservationModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Formulir Reservasi Baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>Formulir penambahan reservasi oleh admin...</p>
            </div>
        </div>
    </div>
</div><?php
        // admin/views/reservations_view.php
        global $reservations, $availableRooms, $page_title;
        ?>


<div class="modal fade" id="addReservationModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Formulir Reservasi Baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>Formulir penambahan reservasi oleh admin...</p>
            </div>
        </div>
    </div>
</div>