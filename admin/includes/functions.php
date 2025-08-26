<?php
// includes/functions.php
// Fungsi-fungsi helper untuk sistem hotel

require_once 'config/database.php';

/**
 * FUNGSI ALERT DAN NOTIFIKASI
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
 * FUNGSI VALIDASI
 */

// Validasi email
function isValidEmail($email)
{
    return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
}

// Validasi nomor telepon Indonesia
function isValidPhoneNumber($phone)
{
    $pattern = '/^(\+62|62|0)[0-9]{8,13}$/';
    return preg_match($pattern, $phone);
}

// Sanitize input
function sanitizeInput($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

// Validasi upload file gambar
function validateImageUpload($file, $max_size = 2097152)
{ // 2MB default
    $allowed_types = ['image/jpeg', 'image/png', 'image/jpg'];
    $allowed_extensions = ['jpg', 'jpeg', 'png'];

    if ($file['error'] !== UPLOAD_ERR_OK) {
        return ['success' => false, 'message' => 'Error upload file'];
    }

    if ($file['size'] > $max_size) {
        return ['success' => false, 'message' => 'Ukuran file terlalu besar (max 2MB)'];
    }

    if (!in_array($file['type'], $allowed_types)) {
        return ['success' => false, 'message' => 'Tipe file tidak diizinkan (hanya JPG, JPEG, PNG)'];
    }

    $file_extension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
    if (!in_array($file_extension, $allowed_extensions)) {
        return ['success' => false, 'message' => 'Ekstensi file tidak diizinkan'];
    }

    return ['success' => true];
}

/**
 * FUNGSI FORMAT
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

// Format jam
function formatJam($time)
{
    return date('H:i', strtotime($time));
}

// Time ago function (misal: 2 jam yang lalu)
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
function getStatusBadge($status, $type = 'room')
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
                    return '<span class="badge bg-warning">Menunggu</span>';
                case 'confirmed':
                    return '<span class="badge bg-info">Dikonfirmasi</span>';
                case 'checkin':
                    return '<span class="badge bg-primary">Check-in</span>';
                case 'checkout':
                    return '<span class="badge bg-success">Check-out</span>';
                case 'cancelled':
                    return '<span class="badge bg-danger">Dibatalkan</span>';
                default:
                    return '<span class="badge bg-dark">Unknown</span>';
            }

        case 'payment':
            switch ($status) {
                case 'pending':
                    return '<span class="badge bg-warning">Menunggu</span>';
                case 'berhasil':
                    return '<span class="badge bg-success">Berhasil</span>';
                case 'gagal':
                    return '<span class="badge bg-danger">Gagal</span>';
                default:
                    return '<span class="badge bg-dark">Unknown</span>';
            }
    }

    return '<span class="badge bg-secondary">' . ucfirst($status) . '</span>';
}

/**
 * FUNGSI DATABASE HELPER
 */

// Generate kode reservasi unik
function generateReservationCode()
{
    $prefix = 'RSV';
    $date = date('ymd');
    $random = str_pad(mt_rand(1, 9999), 4, '0', STR_PAD_LEFT);
    return $prefix . $date . $random;
}

// Cek ketersediaan kamar
function checkRoomAvailability($room_id, $checkin_date, $checkout_date, $exclude_reservation_id = null)
{
    $db = getDBConnection();

    $sql = "SELECT COUNT(*) as count FROM reservasi 
            WHERE id_kamar = :room_id 
            AND status NOT IN ('cancelled', 'checkout')
            AND (
                (tgl_checkin BETWEEN :checkin AND :checkout) OR
                (tgl_checkout BETWEEN :checkin AND :checkout) OR
                (tgl_checkin <= :checkin AND tgl_checkout >= :checkout)
            )";

    if ($exclude_reservation_id) {
        $sql .= " AND id_reservasi != :exclude_id";
    }

    $stmt = $db->prepare($sql);
    $stmt->bindParam(':room_id', $room_id);
    $stmt->bindParam(':checkin', $checkin_date);
    $stmt->bindParam(':checkout', $checkout_date);

    if ($exclude_reservation_id) {
        $stmt->bindParam(':exclude_id', $exclude_reservation_id);
    }

    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    return $result['count'] == 0;
}

// Get kamar yang tersedia
function getAvailableRooms($checkin_date, $checkout_date, $room_type = null)
{
    $db = getDBConnection();

    $sql = "SELECT k.*, jk.nama_jenis, jk.deskripsi, jk.fasilitas, jk.max_tamu
            FROM kamar k
            JOIN jenis_kamar jk ON k.id_jenis = jk.id_jenis
            WHERE k.status = 'kosong'
            AND k.id_kamar NOT IN (
                SELECT DISTINCT id_kamar FROM reservasi 
                WHERE status NOT IN ('cancelled', 'checkout')
                AND (
                    (tgl_checkin BETWEEN :checkin AND :checkout) OR
                    (tgl_checkout BETWEEN :checkin AND :checkout) OR
                    (tgl_checkin <= :checkin AND tgl_checkout >= :checkout)
                )
            )";

    if ($room_type) {
        $sql .= " AND k.id_jenis = :room_type";
    }

    $sql .= " ORDER BY k.no_kamar";

    $stmt = $db->prepare($sql);
    $stmt->bindParam(':checkin', $checkin_date);
    $stmt->bindParam(':checkout', $checkout_date);

    if ($room_type) {
        $stmt->bindParam(':room_type', $room_type);
    }

    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Hitung jumlah malam
function calculateNights($checkin_date, $checkout_date)
{
    $checkin = new DateTime($checkin_date);
    $checkout = new DateTime($checkout_date);
    $diff = $checkin->diff($checkout);
    return $diff->days;
}

// Hitung total biaya
function calculateTotalCost($room_price, $nights, $services = [])
{
    $total = $room_price * $nights;

    foreach ($services as $service) {
        $total += $service['price'] * $service['quantity'];
    }

    return $total;
}

/**
 * FUNGSI STATISTIK DAN LAPORAN
 */

// Get statistik dashboard
function getDashboardStats()
{
    $db = getDBConnection();

    try {
        // Statistik kamar
        $stmt = $db->query("SELECT 
            COUNT(*) as total_kamar,
            SUM(CASE WHEN status = 'kosong' THEN 1 ELSE 0 END) as kamar_kosong,
            SUM(CASE WHEN status = 'terisi' THEN 1 ELSE 0 END) as kamar_terisi,
            SUM(CASE WHEN status = 'dibooking' THEN 1 ELSE 0 END) as kamar_booking,
            SUM(CASE WHEN status = 'maintenance' THEN 1 ELSE 0 END) as kamar_maintenance
            FROM kamar");
        $room_stats = $stmt->fetch(PDO::FETCH_ASSOC);

        // Statistik reservasi hari ini
        $stmt = $db->query("SELECT 
            COUNT(*) as total_reservasi_hari_ini,
            SUM(CASE WHEN status = 'pending' THEN 1 ELSE 0 END) as reservasi_pending,
            SUM(CASE WHEN status = 'confirmed' THEN 1 ELSE 0 END) as reservasi_confirmed,
            SUM(CASE WHEN status = 'checkin' THEN 1 ELSE 0 END) as reservasi_checkin
            FROM reservasi WHERE DATE(created_at) = CURDATE()");
        $reservation_stats = $stmt->fetch(PDO::FETCH_ASSOC);

        // Total tamu
        $stmt = $db->query("SELECT COUNT(*) as total_tamu FROM tamu");
        $guest_stats = $stmt->fetch(PDO::FETCH_ASSOC);

        // Pendapatan bulan ini
        $stmt = $db->query("SELECT 
            COALESCE(SUM(total_biaya), 0) as pendapatan_bulan_ini
            FROM reservasi 
            WHERE MONTH(created_at) = MONTH(CURDATE()) 
            AND YEAR(created_at) = YEAR(CURDATE())
            AND status IN ('confirmed', 'checkin', 'checkout')");
        $revenue_stats = $stmt->fetch(PDO::FETCH_ASSOC);

        // Okupansi hari ini
        $occupancy_rate = 0;
        if ($room_stats['total_kamar'] > 0) {
            $occupied_rooms = $room_stats['kamar_terisi'] + $room_stats['kamar_booking'];
            $occupancy_rate = round(($occupied_rooms / $room_stats['total_kamar']) * 100, 2);
        }

        return [
            'rooms' => $room_stats,
            'reservations' => $reservation_stats,
            'guests' => $guest_stats,
            'revenue' => $revenue_stats,
            'occupancy_rate' => $occupancy_rate
        ];
    } catch (PDOException $e) {
        return false;
    }
}

// Get reservasi terbaru
function getRecentReservations($limit = 5)
{
    $db = getDBConnection();

    try {
        $stmt = $db->prepare("SELECT r.*, t.nama as nama_tamu, k.no_kamar, jk.nama_jenis
                             FROM reservasi r
                             JOIN tamu t ON r.id_tamu = t.id_tamu
                             JOIN kamar k ON r.id_kamar = k.id_kamar
                             JOIN jenis_kamar jk ON k.id_jenis = jk.id_jenis
                             ORDER BY r.created_at DESC
                             LIMIT :limit");
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        return [];
    }
}

/**
 * FUNGSI FILE UPLOAD
 */

// Upload file dengan nama unik
function uploadFile($file, $upload_dir, $allowed_types = ['jpg', 'jpeg', 'png'])
{
    if (!is_dir($upload_dir)) {
        mkdir($upload_dir, 0755, true);
    }

    $file_extension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));

    if (!in_array($file_extension, $allowed_types)) {
        return ['success' => false, 'message' => 'Tipe file tidak diizinkan'];
    }

    $unique_name = uniqid() . '_' . time() . '.' . $file_extension;
    $target_path = $upload_dir . '/' . $unique_name;

    if (move_uploaded_file($file['tmp_name'], $target_path)) {
        return ['success' => true, 'filename' => $unique_name, 'path' => $target_path];
    } else {
        return ['success' => false, 'message' => 'Gagal upload file'];
    }
}

// Hapus file
function deleteFile($file_path)
{
    if (file_exists($file_path)) {
        return unlink($file_path);
    }
    return true;
}

/**
 * FUNGSI PAGINATION
 */

// Generate pagination links
function generatePagination($current_page, $total_pages, $base_url, $params = [])
{
    $pagination = '';

    if ($total_pages <= 1) return $pagination;

    $pagination .= '<nav aria-label="Page navigation"><ul class="pagination justify-content-center">';

    // Previous button
    if ($current_page > 1) {
        $prev_params = array_merge($params, ['page' => $current_page - 1]);
        $prev_url = $base_url . '?' . http_build_query($prev_params);
        $pagination .= '<li class="page-item"><a class="page-link" href="' . $prev_url . '">Previous</a></li>';
    } else {
        $pagination .= '<li class="page-item disabled"><span class="page-link">Previous</span></li>';
    }

    // Page numbers
    $start_page = max(1, $current_page - 2);
    $end_page = min($total_pages, $current_page + 2);

    if ($start_page > 1) {
        $first_params = array_merge($params, ['page' => 1]);
        $first_url = $base_url . '?' . http_build_query($first_params);
        $pagination .= '<li class="page-item"><a class="page-link" href="' . $first_url . '">1</a></li>';
        if ($start_page > 2) {
            $pagination .= '<li class="page-item disabled"><span class="page-link">...</span></li>';
        }
    }

    for ($i = $start_page; $i <= $end_page; $i++) {
        if ($i == $current_page) {
            $pagination .= '<li class="page-item active"><span class="page-link">' . $i . '</span></li>';
        } else {
            $page_params = array_merge($params, ['page' => $i]);
            $page_url = $base_url . '?' . http_build_query($page_params);
            $pagination .= '<li class="page-item"><a class="page-link" href="' . $page_url . '">' . $i . '</a></li>';
        }
    }

    if ($end_page < $total_pages) {
        if ($end_page < $total_pages - 1) {
            $pagination .= '<li class="page-item disabled"><span class="page-link">...</span></li>';
        }
        $last_params = array_merge($params, ['page' => $total_pages]);
        $last_url = $base_url . '?' . http_build_query($last_params);
        $pagination .= '<li class="page-item"><a class="page-link" href="' . $last_url . '">' . $total_pages . '</a></li>';
    }

    // Next button
    if ($current_page < $total_pages) {
        $next_params = array_merge($params, ['page' => $current_page + 1]);
        $next_url = $base_url . '?' . http_build_query($next_params);
        $pagination .= '<li class="page-item"><a class="page-link" href="' . $next_url . '">Next</a></li>';
    } else {
        $pagination .= '<li class="page-item disabled"><span class="page-link">Next</span></li>';
    }

    $pagination .= '</ul></nav>';

    return $pagination;
}

/**
 * FUNGSI KEAMANAN
 */

// Generate CSRF token
function generateCSRFToken()
{
    if (!isset($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

// Validasi CSRF token
function validateCSRFToken($token)
{
    return isset($_SESSION['csrf_token']) && hash_equals($_SESSION['csrf_token'], $token);
}

// Generate secure random password
function generatePassword($length = 8)
{
    $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*';
    return substr(str_shuffle($chars), 0, $length);
}

/**
 * FUNGSI EXPORT DATA
 */

// Export data to CSV
function exportToCSV($data, $filename, $headers = [])
{
    header('Content-Type: text/csv; charset=utf-8');
    header('Content-Disposition: attachment; filename="' . $filename . '.csv"');

    $output = fopen('php://output', 'w');

    // Add BOM for UTF-8
    fprintf($output, chr(0xEF) . chr(0xBB) . chr(0xBF));

    if (!empty($headers)) {
        fputcsv($output, $headers);
    }

    foreach ($data as $row) {
        fputcsv($output, $row);
    }

    fclose($output);
    exit();
}

/**
 * FUNGSI LOGGING
 */

// Simple logging function
function writeLog($message, $level = 'INFO', $file = 'app.log')
{
    $log_dir = '../logs/';
    if (!is_dir($log_dir)) {
        mkdir($log_dir, 0755, true);
    }

    $timestamp = date('Y-m-d H:i:s');
    $log_message = "[{$timestamp}] [{$level}] {$message}" . PHP_EOL;

    file_put_contents($log_dir . $file, $log_message, FILE_APPEND | LOCK_EX);
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

// Check if request is GET
function isGet()
{
    return $_SERVER['REQUEST_METHOD'] === 'GET';
}

// Get current URL
function getCurrentUrl()
{
    return $_SERVER['REQUEST_URI'];
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
