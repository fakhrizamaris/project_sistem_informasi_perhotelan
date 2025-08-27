<?php
// admin/controllers/RoomController.php

// 1. PERBAIKI PATH & NAMA FILE KONEKSI
require_once '../config/koneksi.php';
require_once '../includes/auth.php';
require_once '../models/Room.php';
require_once 'includes/functions.php';

class RoomController
{
    private $roomModel;

    public function __construct()
    {
        // Auth::requireRole('admin'); // Aktifkan jika sudah implementasi login penuh
        $this->roomModel = new Room();
    }

    public function index()
    {
        // Ambil data untuk ditampilkan di view
        global $rooms, $stats, $page_title; // Jadikan variabel global agar bisa diakses di view

        $page_title = 'Kelola Kamar';
        $rooms = $this->roomModel->getAll();
        $stats = $this->roomModel->getStats();

        // Panggil layout utama yang akan memuat view
        require_once 'includes/layout.php';
    }

    public function create()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'no_kamar' => $_POST['no_kamar'],
                'tipe_kamar' => $_POST['tipe_kamar'],
                'harga' => $_POST['harga'],
                'status' => $_POST['status'] ?? 'kosong'
            ];

            if ($this->roomModel->create($data)) {
                setSuccess('Kamar berhasil ditambahkan.');
            } else {
                setError('Gagal menambahkan kamar.');
            }
            header('Location: manage_rooms.php');
            exit;
        }
    }

    public function delete($id)
    {
        if ($this->roomModel->delete($id)) {
            setSuccess('Kamar berhasil dihapus.');
        } else {
            setError('Gagal menghapus kamar. Mungkin kamar sedang digunakan.');
        }
        header('Location: manage_rooms.php');
        exit;
    }

    // Fungsi edit bisa ditambahkan di sini...
}

// ROUTING SEDERHANA
$action = $_GET['action'] ?? 'index';
$id = $_GET['id'] ?? null;

$controller = new RoomController();

switch ($action) {
    case 'create':
        $controller->create();
        break;
    case 'delete':
        $controller->delete($id);
        break;
    default:
        $controller->index();
        break;
}
