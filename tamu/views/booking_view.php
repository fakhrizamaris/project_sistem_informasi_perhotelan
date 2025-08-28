<?php
// tamu/controllers/BookingController.php

require_once __DIR__ . '/../../config/koneksi.php';
require_once __DIR__ . '/../../models/Tamu.php';
require_once __DIR__ . '/../includes/functions.php';

// Konfigurasi Halaman
$page_title = 'Booking Kamar';

// Inisialisasi model
$tamuReservationModel = new TamuReservation();

// ROUTING SEDERHANA
$action = $_GET['action'] ?? 'index';

// Variabel untuk form
$available_rooms = [];
$search_performed = false;
$checkin_date = '';
$checkout_date = '';
$selected_room = null;
$booking_summary = null;

switch ($action) {
    case 'search':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $checkin_date = sanitizeInput($_POST['checkin_date']);
            $checkout_date = sanitizeInput($_POST['checkout_date']);

            // Validasi tanggal
            $validation = validasiTanggalBooking($checkin_date, $checkout_date);
            if (!$validation['valid']) {
                setError($validation['message']);
                header('Location: booking.php');
                exit;
            }

            // Cari kamar yang tersedia
            $available_rooms = $tamuReservationModel->getAvailableRooms($checkin_date, $checkout_date);
            $search_performed = true;

            if (empty($available_rooms)) {
                setWarning('Tidak ada kamar tersedia untuk tanggal yang dipilih.');
            }
        }
        break;

    case 'select':
        $room_id = $_GET['room_id'] ?? null;
        $checkin_date = $_GET['checkin'] ?? '';
        $checkout_date = $_GET['checkout'] ?? '';

        if ($room_id && $checkin_date && $checkout_date) {
            // Ambil detail kamar
            $db = getDB();
            $stmt = $db->prepare("SELECT * FROM kamar WHERE id_kamar = ?");
            $stmt->execute([$room_id]);
            $selected_room = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($selected_room) {
                $durasi = hitungDurasiMenginap($checkin_date, $checkout_date);
                $total_biaya = hitungTotalBiaya($selected_room['harga'], $durasi);

                $booking_summary = [
                    'room' => $selected_room,
                    'checkin' => $checkin_date,
                    'checkout' => $checkout_date,
                    'durasi' => $durasi,
                    'total_biaya' => $total_biaya
                ];
            }
        }
        break;

    case 'confirm':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'id_kamar' => $_POST['id_kamar'],
                'tgl_checkin' => $_POST['tgl_checkin'],
                'tgl_checkout' => $_POST['tgl_checkout'],
                'total_biaya' => $_POST['total_biaya']
            ];

            // Validasi ulang tanggal
            $validation = validasiTanggalBooking($data['tgl_checkin'], $data['tgl_checkout']);
            if (!$validation['valid']) {
                setError($validation['message']);
                header('Location: booking.php');
                exit;
            }

            // Buat reservasi
            if ($tamuReservationModel->createReservation($_SESSION['user_id'], $data)) {
                setSuccess('Reservasi berhasil dibuat! Menunggu konfirmasi dari hotel.');
                header('Location: reservasi.php');
                exit;
            } else {
                setError('Gagal membuat reservasi. Silakan coba lagi.');
            }
        }
        break;
}

// Memanggil file layout yang akan merangkai header, view, dan footer
require_once __DIR__ . '/../includes/layout.php';
