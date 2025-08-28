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
            top: 70px;
            /* di bawah top-bar */
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
            padding-top: 130px;
            /* top-bar + navbar */
            background: #f8f8f8;
        }

        .suite-section {
            max-width: 1000px;
            margin: 40px auto;
            background: white;
            border-radius: 12px;
            box-shadow: 0 6px 18px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            display: grid;
            grid-template-columns: 1fr 1fr;
            /* dua kolom */
            gap: 0;
        }

        .suite-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
        }

        .suite-content {
            padding: 24px;
        }

        .suite-content h1 {
            margin-top: 0;
            color: #046c4e;
        }

        .features {
            margin: 20px 0;
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 12px;
        }

        .features i {
            color: #046c4e;
            margin-right: 8px;
        }

        .price {
            font-size: 20px;
            font-weight: bold;
            color: #046c4e;
            margin: 20px 0;
        }

        .btn {
            padding: 10px 18px;
            border-radius: 8px;
            border: none;
            cursor: pointer;
            font-weight: 600;
        }

        .btn-book {
            background: #10B981;
            color: white;
        }

        footer {
            text-align: center;
            padding: 20px;
            background: #333;
            color: white;
            margin-top: 40px;
        }

        @media(max-width: 768px) {
            .suite-section {
                grid-template-columns: 1fr;
                /* jadi satu kolom kalau layar kecil */
            }
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
    </header>

    <!-- Main menu -->
  <nav class="navbar navbar-expand-lg site-nav">
    <div class="container">
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ms-auto">
          <li class="nav-item"><a class="nav-link" style="font-weight: font-family: georgia bold; font-size: 20px;" href="about.php">About/</a></li>
          <li class="nav-item"><a class="nav-link" style="font-weight: font-family: georgia bold; font-size: 20px;" href="index.php">Home/</a></li>
        </ul>
      </div>
    </div>
  </nav>

    <!-- HERO SECTION -->

    <section class="suite-section">
        <div class="suite-image">
            <img src="img/executive.jpg" alt="Suite Room">
        </div>
        <div class="suite-content">
            <h1>Deluxe</h1>
            <p>Deluxe Room offers modern comfort in a spacious 35 m² area, featuring a cozy King Size bed, a work desk,
                and a flat-screen TV with international channels. Guests can enjoy complimentary Wi-Fi, a minibar, and
                coffee/tea-making facilities. The elegant bathroom is equipped with a refreshing shower, toiletries, and
                a hair dryer. Perfect for couples or business travelers seeking more comfort than a standard room.</p>

            <div class="features">
                <div><i class="fa-solid fa-bed"></i> Tempat tidur King Size</div>
                <div><i class="fa-solid fa-bath"></i> Hot/Cold Shower</div>
                <div><i class="fa-solid fa-wifi"></i> Free Wifi</div>
                <div><i class="fa-solid fa-wifi"></i> Table Work</div>
                <div><i class="fa-solid fa-tv"></i> 55 Flat-screen Tv</div>
            </div>

            <div class="price">IDR 2.000.000 / night</div>
            <a href="booknow.php" class="btn btn-book">Book Now</a>
        </div>
    </section>
    <hr>

    </script>
    <footer class="text-white text-center py-4" style="background-color: #8C661F;">
        <p class="mb-0">&copy; 2025 Tourism Hotel. All rights reserved.</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>