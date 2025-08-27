<?php
// 1. Mulai sesi
// Ini wajib dipanggil sebelum melakukan apa pun yang berhubungan dengan sesi.
session_start();

// 2. Hapus semua variabel sesi
// Menghapus semua data yang tersimpan di dalam sesi, seperti 'user_id', 'username', dll.
$_SESSION = array();

// 3. Hancurkan sesi
// Ini akan menghapus sesi itu sendiri dari server.
session_destroy();

// 4. Arahkan pengguna kembali ke halaman login
// Ini adalah bagian penting yang akan membawa pengguna ke halaman login.
header("Location: public/index.html");

// 5. Hentikan eksekusi skrip
// Penting untuk memastikan tidak ada kode lain yang berjalan setelah redirect.
exit;
