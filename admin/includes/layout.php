<?php
// includes/admin_layout.php
// Wrapper untuk layout admin yang konsisten

// Pastikan auth dan functions sudah di-include
require_once '../includes/auth.php';
require_once '../includes/functions.php';

// Cek role admin
auth()->requireRole('admin');

// Variabel untuk customization halaman
$page_title = isset($page_title) ? $page_title : 'Admin Dashboard';
$additional_css = isset($additional_css) ? $additional_css : '';
$additional_js = isset($additional_js) ? $additional_js : '';
$external_js = isset($external_js) ? $external_js : [];
$breadcrumb_items = isset($breadcrumb_items) ? $breadcrumb_items : [];

// Include header
include '../includes/admin_header.php';
?>

<!-- Content Area Start -->
<?php if (!empty($breadcrumb_items)): ?>
    <div class="row mb-3">
        <div class="col-12">
            <?php echo generateBreadcrumb($breadcrumb_items); ?>
        </div>
    </div>
<?php endif; ?>

<!-- Page Content akan diisi oleh halaman yang menggunakan layout ini -->
<?php
// Content akan diisi oleh file yang include layout ini
if (isset($content_file)) {
    include $content_file;
}
?>
<!-- Content Area End -->

<?php
// Include footer
include '../includes/admin_footer.php';
?>