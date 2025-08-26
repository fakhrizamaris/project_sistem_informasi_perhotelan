</div> <!-- End container-fluid -->
</div> <!-- End main-content -->

<!-- Footer -->
<footer class="text-center py-3 mt-auto">
    <div class="container-fluid">
        <small class="text-muted">
            &copy; <?php echo date('Y'); ?> Hotel System. Dibuat untuk Projek Kelompok Sistem Informasi.
        </small>
    </div>
</footer>

<!-- Loading Overlay -->
<div id="loadingOverlay" class="d-none" style="
        position: fixed; 
        top: 0; left: 0; 
        width: 100%; height: 100%; 
        background: rgba(0,0,0,0.5); 
        z-index: 9999;
        display: flex !important;
        align-items: center;
        justify-content: center;
    ">
    <div class="text-center text-white">
        <div class="spinner-border mb-3" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
        <div>Memproses...</div>
    </div>
</div>

<!-- Scripts -->
<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<!-- DataTables -->
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

<!-- Sweet Alert -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<!-- Chart.js (untuk grafik) -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<!-- Custom Admin JavaScript -->
<script>
    $(document).ready(function() {
        // Inisialisasi DataTables untuk semua tabel dengan class .datatable
        $('.datatable').DataTable({
            language: {
                url: 'https://cdn.datatables.net/plug-ins/1.13.6/i18n/id.json'
            },
            responsive: true,
            pageLength: 10,
            lengthMenu: [
                [10, 25, 50, -1],
                [10, 25, 50, "Semua"]
            ],
            order: [
                [0, 'desc']
            ] // Default sort by first column descending
        });

        // Sidebar Toggle
        $('#sidebarToggle, #mobileSidebarToggle').on('click', function() {
            $('#sidebar').toggleClass('collapsed show');
            $('#mainContent').toggleClass('expanded');
        });

        // Close sidebar on mobile when clicking outside
        $(document).on('click', function(e) {
            if ($(window).width() <= 768) {
                if (!$(e.target).closest('#sidebar, #sidebarToggle, #mobileSidebarToggle').length) {
                    $('#sidebar').removeClass('show');
                }
            }
        });

        // Auto-hide alerts after 5 seconds
        $('.alert').not('.alert-permanent').delay(5000).fadeOut();

        // Konfirmasi delete dengan Sweet Alert
        $('.btn-delete').on('click', function(e) {
            e.preventDefault();
            const url = $(this).attr('href');
            const itemName = $(this).data('name') || 'item ini';

            Swal.fire({
                title: 'Hapus Data?',
                text: `Yakin ingin menghapus ${itemName}? Data yang sudah dihapus tidak dapat dikembalikan!`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    showLoading();
                    window.location.href = url;
                }
            });
        });

        // Form validation helper
        $('.needs-validation').on('submit', function(e) {
            if (!this.checkValidity()) {
                e.preventDefault();
                e.stopPropagation();

                // Focus pada field error pertama
                const firstError = $(this).find(':invalid').first();
                firstError.focus();

                Swal.fire({
                    title: 'Form Tidak Valid',
                    text: 'Harap periksa kembali data yang Anda masukkan.',
                    icon: 'error'
                });
            }
            $(this).addClass('was-validated');
        });

        // Loading overlay untuk form submission
        $('form').on('submit', function() {
            if ($(this).hasClass('needs-validation') && !this.checkValidity()) {
                return false;
            }
            showLoading();
        });

        // Auto refresh untuk halaman tertentu
        if ($('body').hasClass('auto-refresh')) {
            setInterval(function() {
                location.reload();
            }, 30000); // Refresh setiap 30 detik
        }
    });

    // Utility Functions
    function showLoading() {
        $('#loadingOverlay').removeClass('d-none');
    }

    function hideLoading() {
        $('#loadingOverlay').addClass('d-none');
    }

    // Success notification
    function showSuccess(message) {
        Swal.fire({
            title: 'Berhasil!',
            text: message,
            icon: 'success',
            timer: 3000,
            showConfirmButton: false
        });
    }

    // Error notification
    function showError(message) {
        Swal.fire({
            title: 'Error!',
            text: message,
            icon: 'error'
        });
    }

    // Format currency (Rupiah)
    function formatRupiah(amount) {
        return new Intl.NumberFormat('id-ID', {
            style: 'currency',
            currency: 'IDR',
            minimumFractionDigits: 0
        }).format(amount);
    }

    // Format date to Indonesian
    function formatDateIndonesian(dateString) {
        const options = {
            year: 'numeric',
            month: 'long',
            day: 'numeric'
        };
        return new Date(dateString).toLocaleDateString('id-ID', options);
    }

    // Preview image before upload
    function previewImage(input, targetId) {
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                $(targetId).attr('src', e.target.result).show();
            };
            reader.readAsDataURL(input.files[0]);
        }
    }

    // Export table to Excel (jika dibutuhkan)
    function exportTableToExcel(tableId, filename) {
        const table = document.getElementById(tableId);
        const wb = XLSX.utils.table_to_book(table);
        XLSX.writeFile(wb, filename + '.xlsx');
    }

    // Print function
    function printDiv(divId) {
        const printContent = document.getElementById(divId);
        const originalContent = document.body.innerHTML;

        document.body.innerHTML = printContent.innerHTML;
        window.print();
        document.body.innerHTML = originalContent;
        location.reload();
    }

    // Real-time clock
    function updateClock() {
        const now = new Date();
        const timeString = now.toLocaleTimeString('id-ID');
        const dateString = now.toLocaleDateString('id-ID', {
            weekday: 'long',
            year: 'numeric',
            month: 'long',
            day: 'numeric'
        });

        $('#currentTime').text(timeString);
        $('#currentDate').text(dateString);
    }

    // Update clock every second if element exists
    if ($('#currentTime').length) {
        updateClock();
        setInterval(updateClock, 1000);
    }
</script>

<?php if (isset($additional_js)): ?>
    <script>
        <?php echo $additional_js; ?>
    </script>
<?php endif; ?>

<?php if (isset($external_js)): ?>
    <?php foreach ($external_js as $js_file): ?>
        <script src="<?php echo $js_file; ?>"></script>
    <?php endforeach; ?>
<?php endif; ?>
</body>

</html>