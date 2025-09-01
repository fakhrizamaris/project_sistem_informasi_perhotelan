<?php
// public/invoice.php
session_start();
require_once __DIR__ . 'config/koneksi.php';
require_once __DIR__ . 'admin/includes/functions.php';
require_once __DIR__ . 'models/Reservation.php';

if (!isset($_GET['id'])) {
    die("ID Reservasi tidak ditemukan.");
}

$reservationModel = new Reservation();
$reservation = $reservationModel->getById($_GET['id']);

if (!$reservation) {
    die("Data reservasi tidak ditemukan.");
}

$durasi = hitungDurasiMenginap($reservation['tgl_checkin'], $reservation['tgl_checkout']);
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Invoice - <?php echo htmlspecialchars($reservation['nama_tamu']); ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }

        .invoice-container {
            max-width: 800px;
            margin: 40px auto;
            background: white;
            border: 1px solid #dee2e6;
            border-radius: 10px;
            padding: 40px;
        }

        .invoice-header {
            text-align: center;
            margin-bottom: 40px;
        }

        .invoice-header h1 {
            color: #0d6efd;
        }

        @media print {
            body {
                background-color: white;
            }

            .invoice-container {
                margin: 0;
                border: none;
            }

            .no-print {
                display: none;
            }
        }
    </style>
</head>

<body>
    <div class="invoice-container">
        <div class="invoice-header">
            <h1>INVOICE</h1>
            <h4>Tourism Hotel</h4>
        </div>

        <div class="row mb-4">
            <div class="col-6">
                <strong>Ditagihkan Kepada:</strong><br>
                <?php echo htmlspecialchars($reservation['nama_tamu']); ?><br>
                <?php echo htmlspecialchars($reservation['email']); ?><br>
                <?php echo htmlspecialchars($reservation['no_hp']); ?>
            </div>
            <div class="col-6 text-end">
                <strong>Kode Reservasi:</strong> BK<?php echo str_pad($reservation['id_reservasi'], 6, '0', STR_PAD_LEFT); ?><br>
                <strong>Tanggal Cetak:</strong> <?php echo date('d M Y'); ?><br>
            </div>
        </div>

        <table class="table table-bordered">
            <thead class="table-light">
                <tr>
                    <th>Deskripsi</th>
                    <th class="text-center">Durasi</th>
                    <th class="text-end">Total</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>
                        Menginap di Kamar No. <?php echo htmlspecialchars($reservation['no_kamar']); ?>
                        (Tipe <?php echo ucfirst(htmlspecialchars($reservation['tipe_kamar'])); ?>)<br>
                        <small>Check-in: <?php echo formatTanggalIndonesia($reservation['tgl_checkin'], false); ?></small><br>
                        <small>Check-out: <?php echo formatTanggalIndonesia($reservation['tgl_checkout'], false); ?></small>
                    </td>
                    <td class="text-center align-middle"><?php echo $durasi; ?> Malam</td>
                    <td class="text-end align-middle"><?php echo formatRupiah($reservation['total_biaya']); ?></td>
                </tr>
            </tbody>
            <tfoot>
                <tr class="fw-bold">
                    <td colspan="2" class="text-end">Grand Total</td>
                    <td class="text-end bg-light"><?php echo formatRupiah($reservation['total_biaya']); ?></td>
                </tr>
            </tfoot>
        </table>

        <div class="mt-4 text-center">
            <p>Terima kasih telah menginap di Tourism Hotel.</p>
        </div>
        <div class="text-center mt-4 no-print">
            <button onclick="window.print()" class="btn btn-primary">Cetak Invoice</button>
            <a href="../login.php" class="btn btn-secondary">Kembali ke Portal</a>
        </div>
    </div>
</body>

</html>