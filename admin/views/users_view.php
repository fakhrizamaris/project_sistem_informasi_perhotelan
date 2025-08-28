<?php
// admin/views/users_view.php
global $all_users, $page_title, $user_to_edit;
?>

<div class="row mb-4">
    <div class="col-12 d-flex justify-content-between align-items-center">
        <h4 class="mb-0"><?php echo $page_title; ?></h4>
        <button class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#addUserModal">
            <i class="fas fa-plus me-2"></i>Tambah User
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
                        <th>Role</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($all_users as $user) : ?>
                        <tr>
                            <td><?php echo htmlspecialchars($user['nama']); ?></td>
                            <td><?php echo htmlspecialchars($user['username']); ?></td>
                            <td class="text-capitalize"><?php echo htmlspecialchars($user['role']); ?></td>
                            <td>
                                <a href="users.php?action=edit&id=<?php echo $user['id_user']; ?>" class="btn btn-sm " title="Edit"><i class="fas fa-edit"></i></a>
                                <a href="users.php?action=delete&id=<?php echo $user['id_user']; ?>" class="btn btn-sm btn-delete" data-name="<?php echo htmlspecialchars($user['nama']); ?>" title="Hapus"><i class="fas fa-trash"></i></a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="modal fade" id="addUserModal" tabindex="-1" aria-labelledby="addUserModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="users.php" method="POST">
                <input type="hidden" name="action" value="create">
                <div class="modal-header">
                    <h5 class="modal-title" id="addUserModalLabel">Formulir User Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Nama Lengkap</label>
                        <input type="text" class="form-control" name="nama" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Username</label>
                        <input type="text" class="form-control" name="username" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Password</label>
                        <input type="password" class="form-control" name="password" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Role</label>
                        <select name="role" class="form-select" required>
                            <option value="admin">Admin</option>
                            <option value="resepsionis">Resepsionis</option>
                            <option value="manajer">Manajer</option>
                            <option value="tamu">Tamu</option>
                        </select>
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

<?php if ($user_to_edit): ?>
    <div class="modal fade" id="editUserModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="users.php?action=update&id=<?php echo $user_to_edit['id_user']; ?>" method="POST">
                    <div class="modal-header">
                        <h5 class="modal-title">Edit Data User</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Nama Lengkap</label>
                            <input type="text" class="form-control" name="nama" value="<?php echo htmlspecialchars($user_to_edit['nama']); ?>" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Username</label>
                            <input type="text" class="form-control" name="username" value="<?php echo htmlspecialchars($user_to_edit['username']); ?>" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Password Baru</label>
                            <input type="password" class="form-control" name="password" placeholder="Kosongkan jika tidak ingin ganti">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Role</label>
                            <select name="role" class="form-select" required>
                                <option value="admin" <?php echo $user_to_edit['role'] == 'admin' ? 'selected' : ''; ?>>Admin</option>
                                <option value="resepsionis" <?php echo $user_to_edit['role'] == 'resepsionis' ? 'selected' : ''; ?>>Resepsionis</option>
                                <option value="manajer" <?php echo $user_to_edit['role'] == 'manajer' ? 'selected' : ''; ?>>Manajer</option>
                                <option value="tamu" <?php echo $user_to_edit['role'] == 'tamu' ? 'selected' : ''; ?>>Tamu</option>
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
            var editModal = new bootstrap.Modal(document.getElementById('editUserModal'));
            editModal.show();
        });
    </script>
<?php endif; ?>