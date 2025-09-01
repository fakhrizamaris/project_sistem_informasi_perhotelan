<?php
// public/booknow.php
require_once __DIR__ . 'config/koneksi.php';
require_once __DIR__ . 'tamu/includes/functions.php'; // Menggunakan functions dari /tamu

$search_performed = false;
$available_rooms = [];
$checkin_date = '';
$checkout_date = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['search_rooms'])) {
  $checkin_date = sanitizeInput($_POST['checkin_date']);
  $checkout_date = sanitizeInput($_POST['checkout_date']);

  $validation = validasiTanggalBooking($checkin_date, $checkout_date);

  if (!$validation['valid']) {
    // Simpan pesan error di session untuk ditampilkan setelah redirect
    session_start();
    setError($validation['message']);
    header('Location: booknow.php');
    exit;
  }

  try {
    $db = getDB();
    // Query untuk mencari kamar yang TIDAK terkonflik dengan tanggal yang dipilih
    $sql = "SELECT * FROM kamar WHERE status = 'kosong' AND id_kamar NOT IN (
                    SELECT id_kamar FROM reservasi 
                    WHERE status NOT IN ('cancelled', 'checkout')
                    AND (
                        (tgl_checkin < :checkout_date AND tgl_checkout > :checkin_date)
                    )
                ) ORDER BY harga ASC";

    $stmt = $db->prepare($sql);
    $stmt->execute([
      ':checkin_date' => $checkin_date,
      ':checkout_date' => $checkout_date
    ]);
    $available_rooms = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $search_performed = true;
  } catch (PDOException $e) {
    die("Error: " . $e->getMessage());
  }
}

// Sertakan header
include 'includes/header.php';
?>

<div class="container my-5">
  <div class="card shadow-sm mb-5">
    <div class="card-body p-4">
      <h2 class="text-center mb-4 section-title">Cari Ketersediaan Kamar</h2>
      <form action="booknow.php" method="POST">
        <div class="row g-3 align-items-end">
          <div class="col-md-5">
            <label for="checkin_date" class="form-label fw-bold">Tanggal Check-in</label>
            <input type="date" class="form-control" id="checkin_date" name="checkin_date" value="<?php echo htmlspecialchars($checkin_date); ?>" required>
          </div>
          <div class="col-md-5">
            <label for="checkout_date" class="form-label fw-bold">Tanggal Check-out</label>
            <input type="date" class="form-control" id="checkout_date" name="checkout_date" value="<?php echo htmlspecialchars($checkout_date); ?>" required>
          </div>
          <div class="col-md-2">
            <button type="submit" name="search_rooms" class="btn btn-dark w-100" style="background-color: var(--primary-dark);">Cari</button>
          </div>
        </div>
      </form>
    </div>
  </div>

  <?php
  // Menampilkan alert jika ada dari validasi
  if (isset($_SESSION['alert'])) {
    $alert = $_SESSION['alert'];
    echo "<div class='alert alert-{$alert['type']}'>{$alert['message']}</div>";
    unset($_SESSION['alert']);
  }
  ?>

  <?php if ($search_performed) : ?>
    <hr class="my-5">
    <h3 class="text-center mb-4">Kamar Tersedia (<?php echo htmlspecialchars(date('d M Y', strtotime($checkin_date))) . " - " . htmlspecialchars(date('d M Y', strtotime($checkout_date))); ?>)</h3>

    <?php if (empty($available_rooms)) : ?>
      <div class="alert alert-warning text-center">
        Mohon maaf, tidak ada kamar yang tersedia untuk tanggal yang Anda pilih.
      </div>
    <?php else : ?>
      <div class="row g-4">
        <?php foreach ($available_rooms as $room) : ?>
          <div class="col-md-6 col-lg-4">
            <div class="card h-100">
              <?php
              $image_path = "img/" . strtolower($room['tipe_kamar']) . ".jpg";
              $default_image = "img/deluxe.jpg";
              ?>
              <img src="<?php echo file_exists($image_path) ? $image_path : $default_image; ?>" class="card-img-top" alt="<?php echo htmlspecialchars($room['tipe_kamar']); ?>" style="height: 200px; object-fit: cover;">
              <div class="card-body d-flex flex-column">
                <h5 class="card-title text-capitalize"><?php echo htmlspecialchars($room['tipe_kamar']); ?></h5>
                <p class="card-text text-muted">Kamar No. <?php echo htmlspecialchars($room['no_kamar']); ?></p>
                <h6 class="text-success"><?php echo formatRupiah($room['harga']); ?> / malam</h6>
                <div class="mt-auto">
                  <?php
                  // --- PERBAIKAN DI SINI ---
                  // Hapus "../" agar path menjadi relatif terhadap root folder
                  $redirect_url = urlencode("tamu/booking.php?action=select&room_id={$room['id_kamar']}&checkin={$checkin_date}&checkout={$checkout_date}");
                  ?>
                  <a href="../login.php?redirect=<?php echo $redirect_url; ?>" class="btn btn-outline-dark w-100">
                    Pilih Kamar
                  </a>
                </div>
              </div>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>
  <?php endif; ?>
</div>

<?php
// Sertakan footer
include 'includes/footer.php';
?>