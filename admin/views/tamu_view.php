<?php
// admin/views/tamu_view.php
global $guests, $page_title;
?>

<div class="row mb-4">
    <div class="col-12 d-flex justify-content-between align-items-center">
        <h4 class="mb-0"><?php echo htmlspecialchars($page_title); ?></h4>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addGuestModal">
            <i class="fas fa-plus me-2"></i>Tambah Tamu
        </button>
    </div>
</div>

<div class="card shadow-sm">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped table-hover datatable">
                <thead class="table-light">
                    <tr>
                        <th>Nama</th>
                        <th>No Identitas</th>
                        <th>No HP</th>
                        <th>Email</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($guests)): ?>
                        <?php foreach ($guests as $guest) : ?>
                            <tr>
                                <td><strong><?php echo htmlspecialchars($guest['nama']); ?></strong></td>
                                <td><?php echo htmlspecialchars($guest['no_identitas']); ?></td>
                                <td><?php echo htmlspecialchars($guest['no_hp']); ?></td>
                                <td><?php echo htmlspecialchars($guest['email']); ?></td>
                                <td>
                                    <a href="#" class="btn btn-sm btn-info" title="Edit"><i class="fas fa-edit"></i></a>
                                    <a href="tamu.php?action=delete&id=<?php echo $guest['id_tamu']; ?>" class="btn btn-sm btn-danger btn-delete" data-name="<?php echo htmlspecialchars($guest['nama']); ?>" title="Hapus"><i class="fas fa-trash"></i></a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5" class="text-center">Belum ada data tamu.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="modal fade" id="addGuestModal" tabindex="-1" aria-labelledby="addGuestModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="tamu.php?action=create" method="POST" class="needs-validation" novalidate>
                <div class="modal-header">
                    <h5 class="modal-title" id="addGuestModalLabel">Formulir Tamu Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="nama" class="form-label">Nama Lengkap</label>
                        <input type="text" class="form-control" id="nama" name="nama" required>
                    </div>
                    <div class="mb-3">
                        <label for="no_identitas" class="form-label">No. Identitas (KTP/Passport)</label>
                        <input type="text" class="form-control" id="no_identitas" name="no_identitas" required>
                    </div>
                    <div class="mb-3">
                        <label for="no_hp" class="form-label">No. Handphone</label>
                        <input type="tel" class="form-control" id="no_hp" name="no_hp" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Alamat Email</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                    <div class="mb-3">
                        <label for="alamat" class="form-label">Alamat</label>
                        <textarea class="form-control" id="alamat" name="alamat" rows="3"></textarea>
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