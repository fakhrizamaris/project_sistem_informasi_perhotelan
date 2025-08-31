<?php
// admin/controllers/ReservationController.php

require_once __DIR__ . '/../../config/koneksi.php';
require_once __DIR__ . '/../../models/Reservation.php';
require_once __DIR__ . '/../../models/Tamu.php';
require_once __DIR__ . '/../../models/Room.php';
require_once __DIR__ . '/../includes/functions.php';

// Inisialisasi Model
$reservationModel = new Reservation();
$guestModel = new Guest();
$roomModel = new Room();
$page_title = 'Kelola Reservasi';

// Logika untuk menangani request POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // ... (kode POST yang sudah ada)
}

// Logika untuk menangani request GET (hapus, checkin, checkout)
$action = $_GET['action'] ?? null;
$id = $_GET['id'] ?? null;

if ($action && $id) {
    switch ($action) {
        case 'delete':
            if ($reservationModel->delete($id)) {
                setSuccess('Reservasi berhasil dihapus.');
            } else {
                setError('Gagal menghapus reservasi.');
            }
            break;
        case 'checkin':
            if ($reservationModel->updateStatus($id, 'checkin')) {
                setSuccess('Tamu berhasil check-in.');
            } else {
                setError('Gagal melakukan check-in.');
            }
            break;
        case 'checkout':
            if ($reservationModel->updateStatus($id, 'checkout')) {
                setSuccess('Tamu berhasil check-out.');
                // Redirect ke halaman invoice setelah checkout
                header('Location: ../public/invoice.php?id=' . $id);
                exit;
            } else {
                setError('Gagal melakukan check-out.');
            }
            break;
    }
    header('Location: reservations.php');
    exit;
}


// Mengambil semua data yang diperlukan untuk view
$reservations = $reservationModel->getAll();
$availableRooms = $roomModel->getAvailable(date('Y-m-d'), date('Y-m-d', strtotime('+1 day')));
$guests = $guestModel->getAll(); // Memastikan data tamu diambil

// Data reservasi untuk modal detail
$viewReservation = null;
if (isset($_GET['view'])) {
    $viewReservation = $reservationModel->getById($_GET['view']);
}

// Memanggil file layout
require_once __DIR__ . '/../includes/layout.php';
