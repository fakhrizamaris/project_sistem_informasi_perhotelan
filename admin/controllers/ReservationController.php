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
    // Tambahkan logika POST di sini jika diperlukan
    // Contoh: tambah reservasi baru
    if (isset($_POST['action']) && $_POST['action'] === 'add') {
        // Logika tambah reservasi
        $data = [
            'id_tamu' => $_POST['id_tamu'],
            'id_kamar' => $_POST['id_kamar'],
            'tgl_checkin' => $_POST['tgl_checkin'],
            'tgl_checkout' => $_POST['tgl_checkout'],
            'total_biaya' => $_POST['total_biaya'],
            'status' => 'pending'
        ];

        if ($reservationModel->create($data)) {
            setSuccess('Reservasi berhasil ditambahkan.');
        } else {
            setError('Gagal menambahkan reservasi.');
        }

        header('Location: reservations.php');
        exit;
    }
}

// Logika untuk menangani request GET (hapus, checkin, checkout)
$action = $_GET['action'] ?? null;
$id = $_GET['id'] ?? null;

if ($action && $id) {
    // Validasi ID terlebih dahulu
    if (!is_numeric($id)) {
        setError('ID reservasi tidak valid.');
        header('Location: reservations.php');
        exit;
    }

    switch ($action) {
        case 'delete':
            try {
                if ($reservationModel->delete($id)) {
                    setSuccess('Reservasi berhasil dihapus.');
                } else {
                    setError('Gagal menghapus reservasi.');
                }
            } catch (Exception $e) {
                setError('Error: ' . $e->getMessage());
            }
            break;

        case 'checkin':
            try {
                // Cek apakah reservasi ada dan statusnya valid untuk check-in
                $reservation = $reservationModel->getById($id);
                if (!$reservation) {
                    setError('Reservasi tidak ditemukan.');
                } elseif ($reservation['status'] !== 'confirmed') {
                    setError('Reservasi harus dalam status confirmed untuk bisa check-in.');
                } else {
                    if ($reservationModel->updateStatus($id, 'checkin')) {
                        // Update status kamar menjadi terisi
                        $roomModel->updateStatus($reservation['id_kamar'], 'terisi');
                        setSuccess('Tamu berhasil check-in.');
                    } else {
                        setError('Gagal melakukan check-in.');
                    }
                }
            } catch (Exception $e) {
                setError('Error: ' . $e->getMessage());
            }
            break;

        case 'checkout':
            try {
                // Cek apakah reservasi ada dan statusnya valid untuk check-out
                $reservation = $reservationModel->getById($id);
                if (!$reservation) {
                    setError('Reservasi tidak ditemukan.');
                } elseif ($reservation['status'] !== 'checkin') {
                    setError('Reservasi harus dalam status check-in untuk bisa check-out.');
                } else {
                    if ($reservationModel->updateStatus($id, 'checkout')) {
                        // Update status kamar menjadi kosong
                        $roomModel->updateStatus($reservation['id_kamar'], 'kosong');
                        setSuccess('Tamu berhasil check-out.');

                        // Redirect ke halaman invoice setelah checkout
                        header('Location: ../public/invoice.php?id=' . $id);
                        exit;
                    } else {
                        setError('Gagal melakukan check-out.');
                    }
                }
            } catch (Exception $e) {
                setError('Error: ' . $e->getMessage());
            }
            break;

        case 'confirm':
            try {
                $reservation = $reservationModel->getById($id);
                if (!$reservation) {
                    setError('Reservasi tidak ditemukan.');
                } elseif ($reservation['status'] !== 'pending') {
                    setError('Hanya reservasi pending yang bisa dikonfirmasi.');
                } else {
                    if ($reservationModel->updateStatus($id, 'confirmed')) {
                        // Update status kamar menjadi dibooking
                        $roomModel->updateStatus($reservation['id_kamar'], 'dibooking');
                        setSuccess('Reservasi berhasil dikonfirmasi.');
                    } else {
                        setError('Gagal mengkonfirmasi reservasi.');
                    }
                }
            } catch (Exception $e) {
                setError('Error: ' . $e->getMessage());
            }
            break;

        case 'cancel':
            try {
                $reservation = $reservationModel->getById($id);
                if (!$reservation) {
                    setError('Reservasi tidak ditemukan.');
                } else {
                    if ($reservationModel->updateStatus($id, 'cancelled')) {
                        // Jika kamar dalam status dibooking, kembalikan ke kosong
                        if ($reservation['status'] === 'confirmed') {
                            $roomModel->updateStatus($reservation['id_kamar'], 'kosong');
                        }
                        setSuccess('Reservasi berhasil dibatalkan.');
                    } else {
                        setError('Gagal membatalkan reservasi.');
                    }
                }
            } catch (Exception $e) {
                setError('Error: ' . $e->getMessage());
            }
            break;

        default:
            setError('Aksi tidak valid.');
    }

    header('Location: reservations.php');
    exit;
}

// Mengambil semua data yang diperlukan untuk view
try {
    $reservations = $reservationModel->getAll();
    $availableRooms = $roomModel->getAvailable(date('Y-m-d'), date('Y-m-d', strtotime('+1 day')));
    $guests = $guestModel->getAll();

    // Data reservasi untuk modal detail
    $viewReservation = null;
    if (isset($_GET['view'])) {
        $viewId = $_GET['view'];
        if (is_numeric($viewId)) {
            $viewReservation = $reservationModel->getById($viewId);
        }
    }
} catch (Exception $e) {
    setError('Error mengambil data: ' . $e->getMessage());
    $reservations = [];
    $availableRooms = [];
    $guests = [];
    $viewReservation = null;
}

// Memanggil file layout
require_once __DIR__ . '/../includes/layout.php';
