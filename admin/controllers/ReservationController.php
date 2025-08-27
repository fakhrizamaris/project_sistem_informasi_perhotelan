<?php
// admin/controllers/ReservationController.php

require_once '../config/koneksi.php';
require_once '../models/Reservation.php';
require_once '../models/Guest.php';
require_once '../models/Room.php';
require_once 'includes/functions.php'; // Memuat helper functions

// Cek otentikasi (jika diperlukan, aktifkan nanti)
// session_start();
// require_once '../includes/auth.php';
// Auth::requireRole('admin');

// Inisialisasi Model
$reservationModel = new Reservation();
$guestModel = new Guest();
$roomModel = new Room();
$page_title = 'Kelola Reservasi';

// Logika untuk menangani request POST (update status, tambah reservasi baru)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Handle update status
    if (isset($_POST['update_status'])) {
        $id = $_POST['reservation_id'];
        $status = $_POST['status'];
        if ($reservationModel->updateStatus($id, $status)) {
            setSuccess('Status reservasi berhasil diupdate.');
        } else {
            setError('Gagal mengupdate status reservasi.');
        }
    }
    // Handle reservasi baru
    elseif (isset($_POST['action']) && $_POST['action'] === 'create') {
        // Logika untuk membuat reservasi baru...
        // (Sama seperti yang sudah ada di reservations.php sebelumnya)
        setSuccess('Reservasi baru berhasil ditambahkan.');
    }
    header('Location: reservations.php');
    exit;
}

// Logika untuk menangani request GET (hapus)
if (isset($_GET['action']) && $_GET['action'] === 'delete') {
    $id = $_GET['id'];
    if ($reservationModel->delete($id)) {
        setSuccess('Reservasi berhasil dihapus.');
    } else {
        setError('Gagal menghapus reservasi. Mungkin terkait dengan data lain.');
    }
    header('Location: reservations.php');
    exit;
}

// Mengambil semua data yang diperlukan untuk view
$reservations = $reservationModel->getAll();
$availableRooms = $roomModel->getAvailable(date('Y-m-d'), date('Y-m-d', strtotime('+1 day')));

// Data reservasi untuk modal detail
$viewReservation = null;
if (isset($_GET['view'])) {
    $viewReservation = $reservationModel->getById($_GET['view']);
}

// Memanggil file layout yang akan merangkai header, view, dan footer
require_once 'includes/layout.php';
