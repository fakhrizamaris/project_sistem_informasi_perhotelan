<?php
// admin/includes/layout.php

// Pastikan auth dan functions sudah di-include di controller
// ... (kode header lainnya)

// Ambil nama file saat ini (misal: 'dashboard' dari 'dashboard.php')
$page_name = basename($_SERVER['PHP_SELF'], '.php');
// Tentukan path ke file view yang sesuai
$content_file = "views/{$page_name}_view.php";

// Include header
include 'includes/header.php';
?>

<div class="container-fluid">
    <?php
    // Muat file view jika ada
    if (file_exists($content_file)) {
        include $content_file;
    } else {
        echo "<div class='alert alert-danger'>View file not found: {$content_file}</div>";
    }
    ?>
</div>
<?php
// Include footer
include 'includes/footer.php';
?>