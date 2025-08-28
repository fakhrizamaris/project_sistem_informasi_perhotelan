<footer class="py-3 mt-auto">
    <div class="container-fluid text-center">
        <small class="text-muted">
            &copy; <?php echo date('Y'); ?> Hotel System. Dibuat untuk Projek Kelompok Sistem Informasi.
        </small>
    </div>
</footer>

</div>
</div>

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
                "search": "Cari:",
                "lengthMenu": "Tampilkan _MENU_ data",
                "info": "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
                "paginate": {
                    "next": "Berikutnya",
                    "previous": "Sebelumnya"
                }
            }
        });

        // Confirm delete dengan SweetAlert
        // Ketika tombol dengan class .btn-delete di-klik
        $('.btn-delete').on('click', function(e) {
            e.preventDefault(); // Mencegah link langsung dieksekusi
            const href = $(this).attr('href');
            const name = $(this).data('name');

            Swal.fire({
                title: 'Apakah Anda Yakin?',
                text: `Anda akan menghapus data ${name}. Tindakan ini tidak bisa dibatalkan.`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya, Hapus Saja!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                // Jika user menekan tombol "Ya, Hapus Saja!"
                if (result.isConfirmed) {
                    // Arahkan ke link hapus
                    window.location.href = href;
                }
            });
        });
    });
</script>

</body>

</html>