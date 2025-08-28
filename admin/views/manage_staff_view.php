<?php
// admin/views/manage_staff_view.php
global $staff_list, $page_title, $staff_to_edit;
?>

<div class="row mb-4">
    <div class="col-12 d-flex justify-content-between align-items-center">
        <h4 class="mb-0"><?php echo $page_title; ?></h4>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addStaffModal">
            <i class="fas fa-user-plus me-2"></i>Tambah Staff
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
                        <th>Role / Jabatan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($staff_list as $staff) : ?>
                        <tr>
                            <td><?php echo htmlspecialchars($staff['nama']); ?></td>
                            <td><?php echo htmlspecialchars($staff['username']); ?></td>
                            <td class="text-capitalize"><?php echo htmlspecialchars($staff['role']); ?></td>
                            <td>
                                <a href="manage_staff.php?action=edit&id=<?php echo $staff['id_user']; ?>" class="btn btn-sm btn-info" title="Edit"><i class="fas fa-edit"></i></a>
                                <a href="manage_staff.php?action=delete&id=<?php echo $staff['id_user']; ?>" class="btn btn-sm btn-danger btn-delete" data-name="<?php echo htmlspecialchars($staff['nama']); ?>" title="Hapus"><i class="fas fa-trash"></i></a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="modal fade" id="addStaffModal" tabindex="-1">
</div>

<?php if ($staff_to_edit): ?>
    <div class="modal fade" id="editStaffModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="manage_staff.php?action=update&id=<?php echo $staff_to_edit['id_user']; ?>" method="POST">
                    <div class="modal-header">
                        <h5 class="modal-title">Edit Data Staff</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Nama Lengkap</label>
                            <input type="text" class="form-control" name="nama" value="<?php echo htmlspecialchars($staff_to_edit['nama']); ?>" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Username</label>
                            <input type="text" class="form-control" name="username" value="<?php echo htmlspecialchars($staff_to_edit['username']); ?>" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Password</label>
                            <input type="password" class="form-control" name="password" placeholder="Kosongkan jika tidak ingin ganti">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Role</label>
                            <select name="role" class="form-select" required>
                                <option value="admin" <?php echo $staff_to_edit['role'] == 'admin' ? 'selected' : ''; ?>>Admin</option>
                                <option value="resepsionis" <?php echo $staff_to_edit['role'] == 'resepsionis' ? 'selected' : ''; ?>>Resepsionis</option>
                                <option value="manajer" <?php echo $staff_to_edit['role'] == 'manajer' ? 'selected' : ''; ?>>Manajer</option>
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
            var editModal = new bootstrap.Modal(document.getElementById('editStaffModal'));
            editModal.show();
        });
    </script>
<?php endif; ?>