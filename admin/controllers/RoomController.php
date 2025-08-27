<?php
// admin/controllers/RoomController.php
// Controller untuk mengelola kamar

require_once '../../config/database.php';
require_once '../../includes/auth.php';
require_once '../../models/Room.php';

class RoomController
{
    private $roomModel;

    public function __construct()
    {
        Auth::requireRole('admin');
        $this->roomModel = new Room();
    }

    public function index()
    {
        $rooms = $this->roomModel->getAll();
        $stats = $this->roomModel->getStats();

        include '../views/rooms/index.php';
    }

    public function create()
    {
        if ($_POST) {
            $data = [
                'no_kamar' => $_POST['no_kamar'],
                'tipe_kamar' => $_POST['tipe_kamar'],
                'harga' => $_POST['harga'],
                'status' => $_POST['status'] ?? 'kosong'
            ];

            if ($this->roomModel->create($data)) {
                $_SESSION['success'] = 'Kamar berhasil ditambahkan';
                header('Location: manage_rooms.php');
                exit;
            } else {
                $_SESSION['error'] = 'Gagal menambahkan kamar';
            }
        }

        include '../views/rooms/create.php';
    }

    public function edit($id)
    {
        $room = $this->roomModel->getById($id);
        if (!$room) {
            $_SESSION['error'] = 'Kamar tidak ditemukan';
            header('Location: manage_rooms.php');
            exit;
        }

        if ($_POST) {
            $data = [
                'no_kamar' => $_POST['no_kamar'],
                'tipe_kamar' => $_POST['tipe_kamar'],
                'harga' => $_POST['harga'],
                'status' => $_POST['status']
            ];

            if ($this->roomModel->update($id, $data)) {
                $_SESSION['success'] = 'Kamar berhasil diupdate';
                header('Location: manage_rooms.php');
                exit;
            } else {
                $_SESSION['error'] = 'Gagal mengupdate kamar';
            }
        }

        include '../views/rooms/edit.php';
    }

    public function delete($id)
    {
        if ($this->roomModel->delete($id)) {
            $_SESSION['success'] = 'Kamar berhasil dihapus';
        } else {
            $_SESSION['error'] = 'Gagal menghapus kamar. Mungkin kamar sedang digunakan.';
        }
        header('Location: manage_rooms.php');
        exit;
    }
}

// Handle routing
session_start();

$action = $_GET['action'] ?? 'index';
$id = $_GET['id'] ?? null;

$controller = new RoomController();

switch ($action) {
    case 'create':
        $controller->create();
        break;
    case 'edit':
        $controller->edit($id);
        break;
    case 'delete':
        $controller->delete($id);
        break;
    default:
        $controller->index();
        break;
}
