<?php
// admin/views/manage_guest_users_view.php
global $guest_users, $page_title;
?>

<div class="row mb-4">
    <div class="col-12 d-flex justify-content-between align-items-center">
        <h4 class="mb-0"><?php echo $page_title; ?></h4>
        <button class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#addGuestUserModal">
            <i class="fas fa-plus me-2"></i>Tambah User Tamu
        </button>
    </div>
</div>

<div class="content-card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped table-hover datatable">
                <thead>
                    <tr>
                        <th>Nama</th>
                        <th>Username</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($guest_users as $user) : ?>
                        <tr>
                            <td><?php echo htmlspecialchars($user['nama']); ?></td>
                            <td><?php echo htmlspecialchars($user['username']); ?></td>
                            <td>
                                <a href="#" class="btn btn-sm btn-delete" data-name="<?php echo htmlspecialchars($user['nama']); ?>" title="Hapus"><i class="fas fa-trash"></i></a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="modal fade" id="addGuestUserModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="manage_guest_users.php" method="POST">
                <input type="hidden" name="action" value="create_guest_user">
                <div class="modal-header">
                    <h5 class="modal-title">Formulir User Tamu Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Nama Lengkap</label>
                        <input type="text" class="form-control" name="nama" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">No. Identitas (KTP/Passport)</label>
                        <input type="text" class="form-control" name="no_identitas" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">No. Handphone</label>
                        <input type="tel" class="form-control" name="no_hp" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" class="form-control" name="email" required>
                    </div>
                    <hr>
                    <div class="mb-3">
                        <label class="form-label">Username</label>
                        <input type="text" class="form-control" name="username" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Password</label>
                        <input type="password" class="form-control" name="password" required>
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