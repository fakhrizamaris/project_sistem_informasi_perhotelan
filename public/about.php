<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>TOURISM HOTEL</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    /* HEADER & NAVBAR */
    .site-header {
      position: fixed;
      top: 0;
      left: 0;
      right: 0;
      background-color: white;
      z-index: 9999;
      width: 100%;
    }

    .top-bar {
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 10px 24px;
      background: rgba(255, 255, 255, 0.95);
      border-bottom: 1px solid rgba(0, 0, 0, 0.06);
    }

    .logo img {
      height: 56px;
    }

    .logo-text {
      font-size: 1rem;
      font-weight: bold;
      color: #A69C67;
      font-family: cursive;
      margin-left: 10px;
    }

    .navbar {
      background-color: #A69C67 !important;
      position: fixed;
      top: 70px; /* di bawah top-bar */
      width: 100%;
      z-index: 10000;
    }

    .navbar .nav-link {
      color: white !important;
      font-weight: 600;
      margin-right: 15px;
      font-size: 20px;
    }

    .navbar .nav-link:hover {
      text-decoration: underline;
    }

    body {
      font-family: Arial, sans-serif;
      margin: 0;
      padding-top: 130px; /* top-bar + navbar */
      background: #f8f8f8;
    }
</style>
</head>

<body>
  <!-- HEADER -->
  <header class="site-header">
    <div class="top-bar">
      <div class="logo">
        <img src="img/logoputih.png" alt="Tourism Hotel Logo">
        <span class="logo-text">Stay-Explore-Enjoy</span>
      </div>
    </div>

    <!-- NAVBAR -->
    <nav class="navbar navbar-expand-lg">
      <div class="container">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
          <ul class="navbar-nav ms-auto">
            <li class="nav-item"><a class="nav-link" href="index.php">Home/</a></li>
          </ul>
        </div>
      </div>
    </nav>
  </header>

  <section class="bg-light py-5 text-center">
        <div class="container">
            <section id="home">
                <h1 class="display-4" style="font-family: Poppins;">Hi, Welcome to Tourism Hotel</h1>
            </section>
            <br>
            <p style="font-family: lora; font-size: 18px;">Welcome to Tourism Hotel where you can find a big Experience Exceptional Hospitality.
                Nestled in the heart of the city, our hotel offers a perfect blend of comfort, elegance, and
                personalized service. Whether you're here for business or leisure, we invite you to relax, unwind, and
                enjoy an unforgettable stay with us.</p>
        </div>
        <hr>
        <div class="container text-center">
            <h1 class="display-4" style="font-family: Poppins;">Our History</h1>
            <img src="img/sejarah.jpg" width="500 px">
            <br>
            <br>
            <p style="font-family: lora; font-size: 18px; text-align: center;">Hotel Tourism didirikan pada tahun 1985 sebagai sebuah penginapan sederhana yang dikelola oleh keluarga.
                Berlokasi di pusat kota, hotel ini awalnya hanya memiliki 10 kamar dan melayani para pelancong lokal
                yang datang untuk urusan bisnis atau berwisata.</p>
            <br>
            <p style="font-family: lora; font-size: 18px; text-align: center;">Seiring dengan perkembangan kota dan meningkatnya kunjungan wisatawan, Hotel Nusantara mulai melakukan
                berbagai pembaruan. Pada tahun 2000, dilakukan renovasi besar-besaran untuk meningkatkan kapasitas kamar
                dan fasilitas umum, termasuk restoran dan ruang pertemuan.</p>
            <br>
            <p style="font-family: lora; font-size: 18px; text-align: center;">Saat ini, Hotel Nusantara telah berkembang menjadi salah satu hotel favorit di kota, dengan lebih dari
                100 kamar, fasilitas modern, serta pelayanan yang tetap mengedepankan keramahan khas keluarga. Komitmen
                kami adalah menjaga warisan sejarah sambil terus berinovasi untuk memberikan pengalaman terbaik bagi
                setiap tamu.</p>
        </div>
    </section>

  <footer class="text-white text-center py-4" style="background-color: #A69C67;">
    <p class="mb-0">&copy; 2025 Tourism Hotel. All rights reserved.</p>
  </footer>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
