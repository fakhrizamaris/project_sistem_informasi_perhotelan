<?php
// tamu/includes/functions.php
// Fungsi-fungsi helper khusus untuk tamu

require_once __DIR__ . '/../../config/koneksi.php';

/**
 * FUNGSI ALERT DAN NOTIFIKASI (sama seperti admin)
 */

// Set alert session
function setAlert($type, $message)
{
    $_SESSION['alert'] = [
        'type' => $type,
        'message' => $message
    ];
}

// Set success alert
function setSuccess($message)
{
    setAlert('success', $message);
}

// Set error alert
function setError($message)
{
    setAlert('danger', $message);
}

// Set warning alert
function setWarning($message)
{
    setAlert('warning', $message);
}

// Set info alert
function setInfo($message)
{
    setAlert('info', $message);
}

/**
 * FUNGSI FORMAT (sama seperti admin)
 */

// Format rupiah
function formatRupiah($amount, $include_symbol = true)
{
    if ($include_symbol) {
        return 'Rp ' . number_format($amount, 0, ',', '.');
    }
    return number_format($amount, 0, ',', '.');
}

// Format tanggal Indonesia
function formatTanggalIndonesia($date, $include_day = true)
{
    $months = [
        1 => 'Januari',
        'Februari',
        'Maret',
        'April',
        'Mei',
        'Juni',
        'Juli',
        'Agustus',
        'September',
        'Oktober',
        'November',
        'Desember'
    ];

    $days = [
        'Sunday' => 'Minggu',
        'Monday' => 'Senin',
        'Tuesday' => 'Selasa',
        'Wednesday' => 'Rabu',
        'Thursday' => 'Kamis',
        'Friday' => 'Jumat',
        'Saturday' => 'Sabtu'
    ];

    $timestamp = strtotime($date);
    $day = date('j', $timestamp);
    $month = $months[date('n', $timestamp)];
    $year = date('Y', $timestamp);

    $result = $day . ' ' . $month . ' ' . $year;

    if ($include_day) {
        $day_name = $days[date('l', $timestamp)];
        $result = $day_name . ', ' . $result;
    }

    return $result;
}

// Time ago function
function timeAgo($datetime)
{
    $time = time() - strtotime($datetime);

    if ($time < 60) return 'baru saja';
    if ($time < 3600) return floor($time / 60) . ' menit yang lalu';
    if ($time < 86400) return floor($time / 3600) . ' jam yang lalu';
    if ($time < 2592000) return floor($time / 86400) . ' hari yang lalu';
    if ($time < 31104000) return floor($time / 2592000) . ' bulan yang lalu';

    return floor($time / 31104000) . ' tahun yang lalu';
}

/**
 * FUNGSI STATUS DAN BADGE
 */

// Get status badge HTML
function getStatusBadge($status, $type = 'reservation')
{
    switch ($type) {
        case 'room':
            switch ($status) {
                case 'kosong':
                    return '<span class="badge bg-success">Tersedia</span>';
                case 'terisi':
                    return '<span class="badge bg-danger">Terisi</span>';
                case 'dibooking':
                    return '<span class="badge bg-warning">Dibooking</span>';
                case 'maintenance':
                    return '<span class="badge bg-secondary">Maintenance</span>';
                default:
                    return '<span class="badge bg-dark">Unknown</span>';
            }

        case 'reservation':
            switch ($status) {
                case 'pending':
                    return '<span class="badge bg-warning">Menunggu Konfirmasi</span>';
                case 'confirmed':
                    return '<span class="badge bg-info">Dikonfirmasi</span>';
                case 'checkin':
                    return '<span class="badge bg-primary">Sudah Check-in</span>';
                case 'checkout':
                    return '<span class="badge bg-success">Selesai</span>';
                case 'cancelled':
                    return '<span class="badge bg-danger">Dibatalkan</span>';
                default:
                    return '<span class="badge bg-dark">Unknown</span>';
            }
    }

    return '<span class="badge bg-secondary">' . ucfirst($status) . '</span>';
}

/**
 * FUNGSI KHUSUS TAMU
 */

// Hitung durasi menginap
function hitungDurasiMenginap($checkin_date, $checkout_date)
{
    $checkin = new DateTime($checkin_date);
    $checkout = new DateTime($checkout_date);
    $diff = $checkin->diff($checkout);
    return $diff->days;
}

// Hitung total biaya
function hitungTotalBiaya($harga_per_malam, $durasi_menginap)
{
    return $harga_per_malam * $durasi_menginap;
}

// Validasi tanggal booking
function validasiTanggalBooking($checkin_date, $checkout_date)
{
    $today = new DateTime();
    $checkin = new DateTime($checkin_date);
    $checkout = new DateTime($checkout_date);

    // Check-in harus minimal hari ini
    if ($checkin < $today->setTime(0, 0, 0)) {
        return ['valid' => false, 'message' => 'Tanggal check-in tidak boleh kurang dari hari ini'];
    }

    // Check-out harus setelah check-in
    if ($checkout <= $checkin) {
        return ['valid' => false, 'message' => 'Tanggal check-out harus setelah tanggal check-in'];
    }

    // Maksimal booking 30 hari ke depan
    $max_date = (clone $today)->modify('+30 days');
    if ($checkin > $max_date) {
        return ['valid' => false, 'message' => 'Booking hanya bisa dilakukan maksimal 30 hari ke depan'];
    }

    // Maksimal menginap 7 hari
    $durasi = $checkin->diff($checkout)->days;
    if ($durasi > 7) {
        return ['valid' => false, 'message' => 'Maksimal menginap adalah 7 hari'];
    }

    return ['valid' => true];
}

// Cek apakah tamu bisa membatalkan reservasi
function bisaBatalkanReservasi($status, $checkin_date)
{
    if ($status !== 'pending') {
        return false;
    }

    $today = new DateTime();
    $checkin = new DateTime($checkin_date);
    $diff = $today->diff($checkin)->days;

    // Bisa dibatalkan minimal 1 hari sebelum check-in
    return $diff >= 1;
}

// Get informasi tipe kamar
function getTipeKamarInfo($tipe)
{
    $info = [
        'standar' => [
            'nama' => 'Kamar Standar',
            'deskripsi' => 'Kamar nyaman dengan fasilitas standar',
            'fasilitas' => ['AC', 'TV', 'Wi-Fi', 'Kamar Mandi Dalam'],
            'max_tamu' => 2
        ],
        'deluxe' => [
            'nama' => 'Kamar Deluxe',
            'deskripsi' => 'Kamar luas dengan fasilitas lengkap',
            'fasilitas' => ['AC', 'TV LED', 'Wi-Fi', 'Kamar Mandi Dalam', 'Mini Bar', 'Balkon'],
            'max_tamu' => 3
        ],
        'suite' => [
            'nama' => 'Suite Room',
            'deskripsi' => 'Kamar mewah dengan ruang tamu terpisah',
            'fasilitas' => ['AC', 'TV LED', 'Wi-Fi', 'Kamar Mandi Dalam', 'Mini Bar', 'Balkon', 'Ruang Tamu', 'Jacuzzi'],
            'max_tamu' => 4
        ]
    ];

    return $info[$tipe] ?? $info['standar'];
}

// Generate booking reference
function generateBookingReference()
{
    return 'BK' . date('ymd') . str_pad(mt_rand(1, 9999), 4, '0', STR_PAD_LEFT);
}

/**
 * FUNGSI DATABASE HELPER KHUSUS TAMU
 */

// Ambil profil tamu berdasarkan user_id
function getGuestProfile($user_id)
{
    $db = getDB();
    try {
        $stmt = $db->prepare("
            SELECT t.*, u.username 
            FROM tamu t 
            JOIN users u ON t.id_user = u.id_user 
            WHERE t.id_user = ?
        ");
        $stmt->execute([$user_id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        return false;
    }
}

// Update profil tamu
function updateGuestProfile($user_id, $data)
{
    $db = getDB();
    try {
        $db->beginTransaction();

        // Update tabel users
        if (isset($data['username'])) {
            $stmt = $db->prepare("UPDATE users SET username = ?, nama = ? WHERE id_user = ?");
            $stmt->execute([$data['username'], $data['nama'], $user_id]);
        }

        // Update tabel tamu
        $stmt = $db->prepare("
            UPDATE tamu SET 
                nama = ?, 
                alamat = ?, 
                no_hp = ?, 
                email = ? 
            WHERE id_user = ?
        ");
        $stmt->execute([
            $data['nama'],
            $data['alamat'] ?? null,
            $data['no_hp'] ?? null,
            $data['email'] ?? null,
            $user_id
        ]);

        $db->commit();
        return true;
    } catch (PDOException $e) {
        $db->rollback();
        return false;
    }
}

// Ubah password tamu
function changeGuestPassword($user_id, $old_password, $new_password)
{
    $db = getDB();
    try {
        // Verifikasi password lama
        $stmt = $db->prepare("SELECT password FROM users WHERE id_user = ?");
        $stmt->execute([$user_id]);
        $user = $stmt->fetch();

        if (!$user || !password_verify($old_password, $user['password'])) {
            return ['success' => false, 'message' => 'Password lama tidak sesuai'];
        }

        // Update password baru
        $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
        $stmt = $db->prepare("UPDATE users SET password = ? WHERE id_user = ?");
        $result = $stmt->execute([$hashed_password, $user_id]);

        return ['success' => $result, 'message' => $result ? 'Password berhasil diubah' : 'Gagal mengubah password'];
    } catch (PDOException $e) {
        return ['success' => false, 'message' => 'Terjadi kesalahan sistem'];
    }
}

/**
 * FUNGSI UTILITY LAINNYA
 */

// Redirect dengan message
function redirectWithMessage($url, $type, $message)
{
    setAlert($type, $message);
    header("Location: $url");
    exit();
}

// Check if request is POST
function isPost()
{
    return $_SERVER['REQUEST_METHOD'] === 'POST';
}

// Sanitize input
function sanitizeInput($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

// Generate breadcrumb
function generateBreadcrumb($items)
{
    $breadcrumb = '<nav aria-label="breadcrumb"><ol class="breadcrumb">';

    foreach ($items as $index => $item) {
        if ($index === count($items) - 1) {
            $breadcrumb .= '<li class="breadcrumb-item active" aria-current="page">' . $item['title'] . '</li>';
        } else {
            if (isset($item['url'])) {
                $breadcrumb .= '<li class="breadcrumb-item"><a href="' . $item['url'] . '">' . $item['title'] . '</a></li>';
            } else {
                $breadcrumb .= '<li class="breadcrumb-item">' . $item['title'] . '</li>';
            }
        }
    }

    $breadcrumb .= '</ol></nav>';
    return $breadcrumb;
}
