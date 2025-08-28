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
    // Handle update status
    if (isset($_POST['update_status'])) {
        $id = $_POST['reservation_id'];
        $status = $_POST['status'];
        if ($reservationModel->updateStatus($id, $status)) {
            setSuccess('Status reservasi berhasil diupdate.');
        } else {
            setError('Gagal mengupdate status reservasi.');
        }
        header('Location: reservations.php');
        exit;
    }
    // Handle reservasi baru dari form modal
    elseif (isset($_POST['action']) && $_POST['action'] === 'create') {
        $data = [
            'id_tamu'       => $_POST['id_tamu'],
            'id_kamar'      => $_POST['id_kamar'],
            'tgl_checkin'   => $_POST['tgl_checkin'],
            'tgl_checkout'  => $_POST['tgl_checkout'],
            'total_biaya'   => $_POST['total_biaya'],
            'status'        => 'confirmed' // Langsung set 'confirmed' karena dibuat oleh admin
        ];

        if ($reservationModel->create($data)) {
            setSuccess('Reservasi baru berhasil ditambahkan.');
        } else {
            setError('Gagal menambahkan reservasi. Pastikan semua data sudah benar.');
        }
        header('Location: reservations.php');
        exit;
    }
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
$guests = $guestModel->getAll(); // Memastikan data tamu diambil

// Data reservasi untuk modal detail
$viewReservation = null;
if (isset($_GET['view'])) {
    $viewReservation = $reservationModel->getById($_GET['view']);
}

// Memanggil file layout
require_once __DIR__ . '/../includes/layout.php';
