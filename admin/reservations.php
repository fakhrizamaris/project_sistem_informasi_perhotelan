<?php
// admin/reservations.php
// Halaman untuk mengelola reservasi

session_start();

require_once '../config/database.php';
require_once '../includes/auth.php';
require_once '../models/Reservation.php';
require_once '../models/Guest.php';
require_once '../models/Room.php';

// Cek otentikasi admin
Auth::requireRole('admin');

$reservationModel = new Reservation();
$guestModel = new Guest();
$roomModel = new Room();

// Handle status update
if (isset($_POST['update_status'])) {
    $id = $_POST['reservation_id'];
    $status = $_POST['status'];

    if ($reservationModel->updateStatus($id, $status)) {
        $_SESSION['success'] = 'Status reservasi berhasil diupdate';
    } else {
        $_SESSION['error'] = 'Gagal mengupdate status reservasi';
    }
    header('Location: reservations.php');
    exit;
}

// Handle delete
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    if ($reservationModel->delete($id)) {
        $_SESSION['success'] = 'Reservasi berhasil dihapus';
    } else {
        $_SESSION['error'] = 'Gagal menghapus reservasi';
    }
    header('Location: reservations.php');
    exit;
}

// Handle new reservation
if ($_POST && isset($_POST['action']) && $_POST['action'] === 'create') {
    // Cari atau buat tamu baru
    $guest = $guestModel->getByIdentitas($_POST['no_identitas']);
    if (!$guest) {
        $guestId = $guestModel->create([
            'nama' => $_POST['nama_tamu'],
            'no_identitas' => $_POST['no_identitas'],
            'no_hp' => $_POST['no_hp'],
            'email' => $_POST['email']
        ]);
    } else {
        $guestId = $guest['id_tamu'];
    }

    if ($guestId) {
        // Hitung total biaya
        $room = $roomModel->getById($_POST['id_kamar']);
        $checkin = new DateTime($_POST['tgl_checkin']);
        $checkout = new DateTime($_POST['tgl_checkout']);
        $nights = $checkin->diff($checkout)->days;
        $total_biaya = $room['harga'] * $nights;

        $reservationData = [
            'id_tamu' => $guestId,
            'id_kamar' => $_POST['id_kamar'],
            'tgl_checkin' => $_POST['tgl_checkin'],
            'tgl_checkout' => $_POST['tgl_checkout'],
            'total_biaya' => $total_biaya,
            'status' => 'confirmed'
        ];

        if ($reservationModel->create($reservationData)) {
            $_SESSION['success'] = 'Reservasi berhasil ditambahkan';
        } else {
            $_SESSION['error'] = 'Gagal menambahkan reservasi';
        }
    } else {
        $_SESSION['error'] = 'Gagal menambahkan data tamu';
    }
    header('Location: reservations.php');
    exit;
}

// Get all reservations
$reservations = $reservationModel->getAll();
$availableRooms = $roomModel->getAvailable(date('Y-m-d'), date('Y-m-d', strtotime('+1 day')));

// Get reservation for viewing details
$viewReservation = null;
if (isset($_GET['view'])) {
    $viewReservation = $reservationModel->getById($_GET['view']);
}

$page_title = 'Kelola Reservasi';
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $page_title; ?> - Hotel System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>

<body class="bg-light">

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container-fluid">
            <a class="navbar-brand" href="dashboard.php">
                <i class="fas fa-hotel me-2"></i>Hotel Admin
            </a>
            <div class="navbar-nav ms-auto">
                <a class="nav-link" href="../logout.php">
                    <i class="fas fa-sign-out-alt me-1"></i>Logout
                </a>
            </div>
        </div>
    </nav>

    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-3 col-lg-2 px-0">
                <div class="d-flex flex-column vh-100 bg-white shadow-sm">
                    <div class="p-3">
                        <h6 class="text-muted">MENU UTAMA</h6>
                        <ul class="nav nav-pills flex-column">
                            <li class="nav-item">
                                <a class="nav-link" href="dashboard.php">
                                    <i class="fas fa-tachometer-alt me-2"></i>Dashboard
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="manage_rooms.php">
                                    <i class="fas fa-bed me-2"></i>Kelola Kamar
                                </a>
                            </li>