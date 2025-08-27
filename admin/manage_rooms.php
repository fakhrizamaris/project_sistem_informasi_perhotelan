<?php
// admin/manage_rooms.php
session_start();

// Menambahkan nama default agar tidak error (untuk preview)
$_SESSION['nama'] = $_SESSION['nama'] ?? 'Guest (Preview)';

// Memanggil controller kamar untuk memproses dan menampilkan halaman
require_once 'controllers/RoomController.php';
