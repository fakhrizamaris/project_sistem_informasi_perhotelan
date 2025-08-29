<?php
// tamu/views/profile_view.php
global $profile, $page_title;
?>

<div class="row mb-4">
    <div class="col-12">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
                <li class="breadcrumb-item active"><?php echo $page_title; ?></li>
            </ol>
        </nav>
        <h4 class="mb-0"><?php echo $page_title; ?></h4>
        <p class="text-muted">Kelola informasi pribadi dan pengaturan akun Anda</p>
    </div>
</div>

<div class="row">
    <!-- Profil Card -->
    <div class="col-lg-4 mb-4">
        <div class="content-card">
            <div class="card-body text-center p-4">
                <div class="mb-3">
                    <div class="rounded-circle bg-primary d-inline-flex align-items-center justify-content-center" style="width: 100px; height: 100px;">
                        <i class="fas fa-user fa-3x text-white"></i>
                    </div>
                </div>
                <h5 class="mb-1"><?php echo htmlspecialchars($profile['nama']); ?></h5>
                <p class="text-muted mb-3">@<?php echo htmlspecialchars($profile['username']); ?></p>

                <div class="row text-center">
                    <div class="col-12 mb-2">
                        <small class="text-muted">Bergabung sejak</small><br>
                        <strong><?php echo formatTanggalIndonesia($profile['created_at'], false); ?></strong>
                    </div>
                </div>

                <hr>

                <div class="d-grid gap-2">
                    <button class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#editProfileModal">
                        <i class="fas fa-edit me-2"></i>Edit Profil
                    </button>
                    <button class="btn btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#changePasswordModal">
                        <i class="fas fa-key me-2"></i>Ubah Password
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Informasi Detail -->
    <div class="col-lg-8">
        <div class="content-card">
            <div class="card-header-custom">
                <h5 class="mb-0">Informasi Personal</h5>
            </div>
            <div class="card-body p-4">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="text-muted small">Nama Lengkap</label>
                        <p class="mb-0 fw-bold"><?php echo htmlspecialchars($profile['nama']) ?: '-'; ?></p>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="text-muted small">Username</label>
                        <p class="mb-0"><?php echo htmlspecialchars($profile['username']); ?></p>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="text-muted small">Email</label>
                        <p class="mb-0">
                            <?php if (!empty($profile['email'])): ?>
                                <i class="fas fa-envelope text-primary me-2"></i>
                                <?php echo htmlspecialchars($profile['email']); ?>
                            <?php else: ?>
                                <span class="text-muted">Belum diisi</span>
                            <?php endif; ?>
                        </p>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="text-muted small">No. Handphone</label>
                        <p class="mb-0">
                            <?php if (!empty($profile['no_hp'])): ?>
                                <i class="fas fa-phone text-success me-2"></i>
                                <?php echo htmlspecialchars($profile['no_hp']); ?>
                            <?php else: ?>
                                <span class="text-muted">Belum diisi</span>
                            <?php endif; ?>
                        </p>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="text-muted small">No. Identitas</label>
                        <p class="mb-0">
                            <i class="fas fa-id-card text-info me-2"></i>
                            <?php echo htmlspecialchars($profile['no_identitas']); ?>
                        </p>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12">
                        <label class="text-muted small">Alamat</label>
                        <p class="mb-0">
                            <?php if (!empty($profile['alamat'])): ?>
                                <i class="fas fa-map-marker-alt text-danger me-2"></i>
                                <?php echo nl2br(htmlspecialchars($profile['alamat'])); ?>
                            <?php else: ?>
                                <span class="text-muted">Belum diisi</span>
                            <?php endif; ?>
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Informasi Keamanan -->
        <div class="content-card">
            <div class="card-header-custom">
                <h5 class="mb-0">Keamanan Akun</h5>
            </div>
            <div class="card-body p-4">
                <div class="row">
                    <div class="col-md-8">
                        <h6>Password</h6>
                        <p class="text-muted mb-0">Terakhir diubah: <span class="text-muted">Data tidak tersedia</span></p>
                    </div>
                    <div class="col-md-4 text-end">
                        <button class="btn btn-outline-warning btn-sm" data-bs-toggle="modal" data-bs-target="#changePasswordModal">
                            <i class="fas fa-key me-1"></i>Ubah Password
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Edit Profil -->
<div class="modal fade" id="editProfileModal" tabindex="-1" aria-labelledby="editProfileModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="editProfileModalLabel">Edit Profil</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="profile.php?action=update_profile" method="POST" class="needs-validation" novalidate>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="nama" class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="nama" name="nama"
                                value="<?php echo htmlspecialchars($profile['nama']); ?>" required>
                            <div class="invalid-feedback">Nama lengkap wajib diisi.</div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="username" class="form-label">Username <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="username" name="username"
                                value="<?php echo htmlspecialchars($profile['username']); ?>" required>
                            <div class="invalid-feedback">Username wajib diisi.</div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email"
                                value="<?php echo htmlspecialchars($profile['email']); ?>">
                            <div class="invalid-feedback">Format email tidak valid.</div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="no_hp" class="form-label">No. Handphone</label>
                            <input type="tel" class="form-control" id="no_hp" name="no_hp"
                                value="<?php echo htmlspecialchars($profile['no_hp']); ?>"
                                placeholder="08xxxxxxxxxx atau +62xxxxxxxxx">
                            <div class="form-text">Contoh: 08123456789 atau +6281234567890</div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="alamat" class="form-label">Alamat Lengkap</label>
                        <textarea class="form-control" id="alamat" name="alamat" rows="3"
                            placeholder="Masukkan alamat lengkap Anda"><?php echo htmlspecialchars($profile['alamat']); ?></textarea>
                    </div>

                    <div class="alert alert-info">
                        <i class="fas fa-info-circle me-2"></i>
                        <strong>Catatan:</strong> No. Identitas tidak dapat diubah. Hubungi admin jika ada kesalahan data.
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-1"></i>Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Ubah Password -->
<div class="modal fade" id="changePasswordModal" tabindex="-1" aria-labelledby="changePasswordModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-warning text-dark">
                <h5 class="modal-title" id="changePasswordModalLabel">Ubah Password</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="profile.php?action=change_password" method="POST" class="needs-validation" novalidate>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="old_password" class="form-label">Password Lama <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <input type="password" class="form-control" id="old_password" name="old_password" required>
                            <button class="btn btn-outline-secondary" type="button" onclick="togglePassword('old_password')">
                                <i class="fas fa-eye" id="old_password_eye"></i>
                            </button>
                        </div>
                        <div class="invalid-feedback">Password lama wajib diisi.</div>
                    </div>

                    <div class="mb-3">
                        <label for="new_password" class="form-label">Password Baru <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <input type="password" class="form-control" id="new_password" name="new_password"
                                minlength="6" required>
                            <button class="btn btn-outline-secondary" type="button" onclick="togglePassword('new_password')">
                                <i class="fas fa-eye" id="new_password_eye"></i>
                            </button>
                        </div>
                        <div class="form-text">Minimal 6 karakter</div>
                        <div class="invalid-feedback">Password baru minimal 6 karakter.</div>
                    </div>

                    <div class="mb-3">
                        <label for="confirm_password" class="form-label">Konfirmasi Password Baru <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <input type="password" class="form-control" id="confirm_password" name="confirm_password"
                                minlength="6" required>
                            <button class="btn btn-outline-secondary" type="button" onclick="togglePassword('confirm_password')">
                                <i class="fas fa-eye" id="confirm_password_eye"></i>
                            </button>
                        </div>
                        <div class="invalid-feedback">Konfirmasi password tidak sama dengan password baru.</div>
                    </div>

                    <div class="alert alert-warning">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        <strong>Peringatan:</strong> Setelah mengubah password, Anda akan tetap login dengan session saat ini.
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-warning">
                        <i class="fas fa-key me-1"></i>Ubah Password
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Bootstrap form validation
        const forms = document.querySelectorAll('.needs-validation');

        forms.forEach(function(form) {
            form.addEventListener('submit', function(event) {
                if (!form.checkValidity()) {
                    event.preventDefault();
                    event.stopPropagation();
                }
                form.classList.add('was-validated');
            });
        });

        // Password confirmation validation
        const newPassword = document.getElementById('new_password');
        const confirmPassword = document.getElementById('confirm_password');

        function validatePasswordMatch() {
            if (confirmPassword.value !== newPassword.value) {
                confirmPassword.setCustomValidity('Password tidak sama');
            } else {
                confirmPassword.setCustomValidity('');
            }
        }

        if (newPassword && confirmPassword) {
            newPassword.addEventListener('change', validatePasswordMatch);
            confirmPassword.addEventListener('keyup', validatePasswordMatch);
        }
    });

    // Toggle password visibility
    function togglePassword(inputId) {
        const passwordInput = document.getElementById(inputId);
        const eyeIcon = document.getElementById(inputId + '_eye');

        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            eyeIcon.classList.remove('fa-eye');
            eyeIcon.classList.add('fa-eye-slash');
        } else {
            passwordInput.type = 'password';
            eyeIcon.classList.remove('fa-eye-slash');
            eyeIcon.classList.add('fa-eye');
        }
    }
</script>