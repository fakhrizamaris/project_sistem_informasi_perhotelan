<?php
// tamu/views/dashboard_view.php
global $page_title, $reservasi_aktif;
?>

<div class="row mb-4">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Selamat Datang, <?php echo htmlspecialchars($_SESSION['nama']); ?>!</h4>
                <p class="text-muted mb-0">Ini adalah halaman dashboard Anda.</p>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6 mb-4">
        <div class="card h-100">
            <div class="card-body text-center">
                <i class="fas fa-calendar-check fa-3x text-primary mb-3"></i>
                <h5 class="card-title">Pesan Kamar</h5>
                <p class="card-text">Lihat ketersediaan kamar dan buat reservasi baru.</p>
                <a href="../public/booknow.html" class="btn btn-primary">Pesan Sekarang</a>
            </div>
        </div>
    </div>
    <div class="col-md-6 mb-4">
        <div class="card h-100">
            <div class="card-body text-center">
                <i class="fas fa-history fa-3x text-success mb-3"></i>
                <h5 class="card-title">Riwayat Reservasi</h5>
                <p class="card-text">Lihat semua riwayat pemesanan dan status pembayaran Anda.</p>
                <a href="riwayat_reservasi.php" class="btn btn-success">Lihat Riwayat</a>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5>Reservasi Aktif Anda</h5>
            </div>
            <div class="card-body">
                <?php if (!empty($reservasi_aktif)): ?>
                <?php else: ?>
                    <p>Anda tidak memiliki reservasi yang sedang aktif.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>