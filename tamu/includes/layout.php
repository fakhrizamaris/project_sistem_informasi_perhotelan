<?php
// tamu/includes/layout.php

$page_name = basename($_SERVER['PHP_SELF'], '.php');
$content_file = "views/{$page_name}_view.php";

// Ganti nama view untuk dashboardtamu.php
if ($page_name == 'dashboardtamu') {
    $content_file = "views/dashboard_view.php";
} elseif ($page_name == 'riwayat_reservasi') {
    $content_file = "views/riwayat_view.php";
}

include 'includes/header.php';

if (file_exists($content_file)) {
    include $content_file;
} else {
    echo "<div class='alert alert-danger'>View file not found: {$content_file}</div>";
}

include 'includes/footer.php';
