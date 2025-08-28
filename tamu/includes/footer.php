<footer class="py-3 mt-auto">
    <div class="container-fluid text-center">
        <small class="text-muted">
            &copy; <?php echo date('Y'); ?> Hotel System - Portal Tamu. Dibuat untuk Projek Kelompok Sistem Informasi.
        </small>
    </div>
</footer>

<!-- Loading Overlay -->
</div>
</div>
<div id="loadingOverlay" class="d-none" style="
        position: fixed; 
        top: 0; left: 0; 
        width: 100%; height: 100%; 
        background: rgba(0,0,0,0.5); 
        z-index: 9999;
        display: flex;
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

<!-- JavaScript -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    $(document).ready(function() {
        // Initialize DataTables
        $('.datatable').DataTable({
            "language": {
                "lengthMenu": "Tampilkan _MENU_ data per halaman",
                "zeroRecords": "Data tidak ditemukan",
                "info": "Menampilkan halaman _PAGE_ dari _PAGES_",
                "infoEmpty": "Tidak ada data tersedia",
                "infoFiltered": "(difilter dari _MAX_ total data)",
                "search": "Cari:",
                "paginate": {
                    "first": "Pertama",
                    "last": "Terakhir",
                    "next": "Selanjutnya",
                    "previous": "Sebelumnya"
                }
            },
            "pageLength": 10,
            "ordering": true,
            "searching": true
        });

        // Confirm delete dengan SweetAlert
        $('.btn-delete').click(function(e) {
            e.preventDefault();
            const href = $(this).attr('href');
            const name = $(this).data('name');

            Swal.fire({
                title: 'Konfirmasi Hapus',
                text: `Yakin ingin menghapus ${name}?`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = href;
                }
            });
        });

        // Confirm cancel reservation
        $('.btn-cancel').click(function(e) {
            e.preventDefault();
            const href = $(this).attr('href');

            Swal.fire({
                title: 'Konfirmasi Pembatalan',
                text: 'Yakin ingin membatalkan reservasi ini?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya, Batalkan!',
                cancelButtonText: 'Tidak'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = href;
                }
            });
        });

        // Mobile sidebar toggle
        $('#mobileSidebarToggle').click(function() {
            $('#sidebar').toggleClass('show');
        });

        // Close sidebar when clicking outside on mobile
        $(document).click(function(e) {
            if (!$(e.target).closest('#sidebar, #mobileSidebarToggle').length) {
                $('#sidebar').removeClass('show');
            }
        });

        // Auto update current time
        function updateTime() {
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

        // Update time every second
        if ($('#currentTime').length) {
            updateTime();
            setInterval(updateTime, 1000);
        }
    });
</script>
</body>

</html>