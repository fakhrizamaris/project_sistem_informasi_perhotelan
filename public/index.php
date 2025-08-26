<?php
// Sertakan header dari folder includes
require_once 'includes/header.php';
// Sertakan file koneksi database
require_once '../config/koneksi.php'; // Sesuaikan path ke file koneksi Anda
?>

<div class="hero-section">
    <div class="container text-center text-black mt-5 pt-3">
        <h1 class="display-4 fw-bold">Selamat Datang di Tourism Hotel</h1>
        <p class="lead">Pengalaman menginap mewah dengan pemandangan terbaik di kota.</p>
        <a href="booking.php" class="btn btn-primary btn-lg mt-3">Pesan Kamar Sekarang</a>
    </div>
</div>

<div class="container my-5">
    <section class="about-section text-center mb-5">
        <h2>Tentang Hotel Kami</h2>
        <p class="lead text-muted">Tourism Hotel adalah pilihan ideal bagi para pelancong yang mencari kemewahan dan kenyamanan. Dengan lokasi strategis dan layanan berkelas dunia, kami berkomitmen untuk membuat pengalaman menginap Anda tak terlupakan.</p>
    </section>

    <section class="featured-rooms-section">
        <h2 class="text-center mb-4">Kamar Unggulan Kami</h2>
        <div class="row">
            <?php
            // Ambil koneksi database
            $pdo = getDBConnection();

            // Query untuk mengambil 3 kamar yang statusnya 'kosong'
            try {
                $stmt = $pdo->query("SELECT tipe_kamar, harga FROM kamar WHERE status = 'kosong' LIMIT 3");

                // Periksa jika ada hasil
                if ($stmt->rowCount() > 0) {
                    while ($kamar = $stmt->fetch(PDO::FETCH_ASSOC)) {
                        // Tampilkan setiap kamar dalam format card Bootstrap
                        echo '
                        <div class="col-md-4 mb-4">
                            <div class="card h-100 shadow-sm">
                                <img src="https://source.unsplash.com/400x300/?hotel,room,' . htmlspecialchars($kamar['tipe_kamar']) . '" class="card-img-top" alt="' . htmlspecialchars($kamar['tipe_kamar']) . '">
                                <div class="card-body">
                                    <h5 class="card-title text-capitalize">Kamar ' . htmlspecialchars($kamar['tipe_kamar']) . '</h5>
                                    <p class="card-text">Harga mulai dari <br><strong class="fs-5">Rp ' . number_format($kamar['harga'], 0, ',', '.') . '</strong> / malam</p>
                                    <a href="rooms.php" class="btn btn-outline-primary">Lihat Detail</a>
                                </div>
                            </div>
                        </div>';
                    }
                } else {
                    echo '<div class="col-12"><p class="alert alert-info">Saat ini semua kamar unggulan sedang terisi. Silakan lihat pilihan lainnya.</p></div>';
                }
            } catch (PDOException $e) {
                // Pesan error jika query gagal
                echo "<p class='alert alert-danger'>Gagal mengambil data kamar: " . $e->getMessage() . "</p>";
            }
            ?>
        </div>
    </section>
</div>

<?php
// Sertakan footer dari folder includes
require_once 'includes/footer.php';
?>