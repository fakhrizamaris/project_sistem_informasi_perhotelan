<?php
// admin/views/manage_guest_users_view.php
global $guest_users, $page_title, $guest_user_to_edit;
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
        <div class="table-responsive p-3">
            <table class="table table-striped table-hover datatable">
                <thead>
                    <tr>
                        <th>Nama</th>
                        <th>Username</th>
                        <th>No. HP</th>
                        <th>Email</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($guest_users as $user) : ?>
                        <tr>
                            <td><?php echo htmlspecialchars($user['nama']); ?></td>
                            <td><?php echo htmlspecialchars($user['username']); ?></td>
                            <td><?php echo htmlspecialchars($user['no_hp']); ?></td>
                            <td><?php echo htmlspecialchars($user['email']); ?></td>
                            <td>
                                <a href="manage_guest_users.php?action=edit&id=<?php echo $user['id_user']; ?>" class="btn btn-sm btn-info" title="Edit"><i class="fas fa-edit"></i></a>
                                <a href="manage_guest_users.php?action=delete&id=<?php echo $user['id_user']; ?>" class="btn btn-sm btn-danger btn-delete" data-name="<?php echo htmlspecialchars($user['nama']); ?>" title="Hapus"><i class="fas fa-trash"></i></a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="modal fade" id="addGuestUserModal" tabindex="-1">
</div>

<?php if ($guest_user_to_edit): ?>
    <div class="modal fade" id="editGuestUserModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form action="manage_guest_users.php?action=update_guest_user&id=<?php echo $guest_user_to_edit['id_user']; ?>" method="POST">
                    <div class="modal-header">
                        <h5 class="modal-title">Edit User Tamu</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Nama Lengkap</label>
                            <input type="text" class="form-control" name="nama" value="<?php echo htmlspecialchars($guest_user_to_edit['nama']); ?>" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">No. Identitas (KTP/Passport)</label>
                            <input type="text" class="form-control" name="no_identitas" value="<?php echo htmlspecialchars($guest_user_to_edit['no_identitas']); ?>" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">No. Handphone</label>
                            <input type="tel" class="form-control" name="no_hp" value="<?php echo htmlspecialchars($guest_user_to_edit['no_hp']); ?>" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" class="form-control" name="email" value="<?php echo htmlspecialchars($guest_user_to_edit['email']); ?>" required>
                        </div>
                        <hr>
                        <div class="mb-3">
                            <label class="form-label">Username</label>
                            <input type="text" class="form-control" name="username" value="<?php echo htmlspecialchars($guest_user_to_edit['username']); ?>" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Password</label>
                            <input type="password" class="form-control" name="password" placeholder="Kosongkan jika tidak ingin ganti">
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
            var editModal = new bootstrap.Modal(document.getElementById('editGuestUserModal'));
            editModal.show();
        });
    </script>
<?php endif; ?>