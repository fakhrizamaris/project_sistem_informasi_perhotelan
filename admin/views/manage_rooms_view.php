<?php
// admin/views/manage_rooms_view.php
global $rooms, $stats, $page_title, $room_to_edit;
?>

<div class="row mb-4">
    <div class="col-12 d-flex justify-content-between align-items-center">
        <h4 class="mb-0"><?php echo $page_title; ?></h4>
        <button class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#addRoomModal">
            <i class="fas fa-plus me-2"></i>Tambah Kamar
        </button>
    </div>
</div>

<div class="content-card">
    <div class="card-body">
        <div class="table-responsive p-3">
            <table class="table table-striped table-hover datatable">
                <thead>
                    <tr>
                        <th>No. Kamar</th>
                        <th>Tipe Kamar</th>
                        <th>Harga/Malam</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($rooms as $room) : ?>
                        <tr>
                            <td><strong><?php echo htmlspecialchars($room['no_kamar']); ?></strong></td>
                            <td class="text-capitalize"><?php echo htmlspecialchars($room['tipe_kamar']); ?></td>
                            <td><?php echo formatRupiah($room['harga']); ?></td>
                            <td><?php echo getStatusBadge($room['status'], 'room'); ?></td>
                            <td>
                                <a href="manage_rooms.php?action=edit&id=<?php echo $room['id_kamar']; ?>" class="btn btn-sm" title="Edit"><i class="fas fa-edit"></i></a>
                                <a href="manage_rooms.php?action=delete&id=<?php echo $room['id_kamar']; ?>" class="btn btn-sm  btn-delete" data-name="Kamar No. <?php echo htmlspecialchars($room['no_kamar']); ?>" title="Hapus"><i class="fas fa-trash"></i></a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="modal fade" id="addRoomModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="manage_rooms.php?action=create" method="POST" class="needs-validation" novalidate>
                <div class="modal-header">
                    <h5 class="modal-title">Formulir Kamar Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Nomor Kamar</label>
                        <input type="number" class="form-control" name="no_kamar" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Tipe Kamar</label>
                        <select name="tipe_kamar" class="form-select" required>
                            <option value="standar">Standar</option>
                            <option value="deluxe">Deluxe</option>
                            <option value="suite">Suite</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Harga per Malam</label>
                        <input type="number" class="form-control" name="harga" placeholder="Contoh: 500000" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php if ($room_to_edit): ?>
    <div class="modal fade" id="editRoomModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="manage_rooms.php?action=update&id=<?php echo $room_to_edit['id_kamar']; ?>" method="POST">
                    <div class="modal-header">
                        <h5 class="modal-title">Edit Data Kamar</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Nomor Kamar</label>
                            <input type="number" class="form-control" name="no_kamar" value="<?php echo htmlspecialchars($room_to_edit['no_kamar']); ?>" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Tipe Kamar</label>
                            <select name="tipe_kamar" class="form-select" required>
                                <option value="standar" <?php echo $room_to_edit['tipe_kamar'] == 'standar' ? 'selected' : ''; ?>>Standar</option>
                                <option value="deluxe" <?php echo $room_to_edit['tipe_kamar'] == 'deluxe' ? 'selected' : ''; ?>>Deluxe</option>
                                <option value="suite" <?php echo $room_to_edit['tipe_kamar'] == 'suite' ? 'selected' : ''; ?>>Suite</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Harga per Malam</label>
                            <input type="number" class="form-control" name="harga" value="<?php echo htmlspecialchars($room_to_edit['harga']); ?>" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Status Kamar</label>
                            <select name="status" class="form-select" required>
                                <option value="kosong" <?php echo $room_to_edit['status'] == 'kosong' ? 'selected' : ''; ?>>Kosong</option>
                                <option value="terisi" <?php echo $room_to_edit['status'] == 'terisi' ? 'selected' : ''; ?>>Terisi</option>
                                <option value="dibooking" <?php echo $room_to_edit['status'] == 'dibooking' ? 'selected' : ''; ?>>Dibooking</option>
                                <option value="maintenance" <?php echo $room_to_edit['status'] == 'maintenance' ? 'selected' : ''; ?>>Maintenance</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var editModal = new bootstrap.Modal(document.getElementById('editRoomModal'));
            editModal.show();
        });
    </script>
<?php endif; ?>