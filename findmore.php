<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TOURISM HOTEL</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600&family=Open+Sans&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
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
        img:hover {
        transform: scale(1.05);   /* Membesarkan sedikit */
        box-shadow: 0 8px 20px rgba(0,0,0,0.3); /* Efek terangkat */
        transition: 0.3s ease;   /* Biar halus */
        }
        .navbar .nav-link {
            color: #A69C67 !important;
            font-weight: 600;
            margin-right: 15px;
            font-size: 20px;
        }

        .navbar .nav-link:hover {
            text-decoration: underline;
        }
        .navbar {
  padding-top: 0.1rem;
  padding-bottom: 0.1rem;
}

/* Perkecil jarak antar menu */
.navbar-nav .nav-link {
  padding-top: 0.1rem;
  padding-bottom: 0.1rem;
  font-size: 0.95rem; /* biar lebih compact */
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
         /* Reset */
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      font-family: 'Open Sans', sans-serif;
      display: flex;
      flex-direction: column;
      min-height: 100vh;
    }

    header {
      background: #012A2A;
      color: white;
      padding: 20px;
      text-align: center;
    }

    nav ul {
      display: flex;
      justify-content: center;
      list-style: none;
      gap: 20px;
    }

    nav ul li a {
      text-decoration: none;
      color: white;
      font-weight: bold;
      transition: color 0.3s;
    }

    nav ul li a:hover {
      color: #FFD700;
    }

    main {
      flex: 1;
      padding: 40px 20px;
      text-align: center;
    }

    main h1 {
      font-family: 'Playfair Display', serif;
      font-size: 32px;
      margin-bottom: 20px;
    }

    /* Footer */
    .footer {
      background-color: #012A2A;
      color: white;
      text-align: center;
      padding: 40px 20px 20px;
      margin-top: auto;
    }

    .footer-container {
      display: flex;
      flex-direction: column;
      align-items: center;
      gap: 15px;
    }

    .footer-brand h2 {
      font-family: "Playfair Display", serif;
      font-size: 24px;
      margin-bottom: 5px;
    }

    .footer-brand p {
      font-size: 14px;
      font-style: italic;
      color: #ddd;
    }

    .footer-social {
      display: flex;
      gap: 20px;
      margin: 15px 0;
    }

    .footer-social a {
      color: white;
      font-size: 20px;
      transition: color 0.3s ease;
    }

    .footer-social a:hover {
      color: #FFD700; /* efek hover emas */
    }

    .footer-bottom {
      border-top: 1px solid rgba(255, 255, 255, 0.2);
      margin-top: 20px;
      padding-top: 15px;
      font-size: 14px;
      color: #aaa;
    }
    </style>
</head>

<body>
    <!-- HEADER -->
    <header class="site-header">
        <div class="top-bar" style="background-color: #012A2A">
            <div class="logo">
                <img src="img/logo.png" alt="Tourism Hotel Logo">
                <span class="logo-text">Stay-Explore-Enjoy</span>
            </div>
        </div>

        <!-- NAVBAR -->
  <nav class="navbar navbar-expand-lg site-nav">
    <div class="container">
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ms-auto">
          <li class="nav-item"><a class="nav-link" style="font-weight: font-family: georgia bold; font-size: 20px;" href="about.php">About</a></li>
          <li class="nav-item"><a class="nav-link" style="font-weight: font-family: georgia bold; font-size: 20px;" href="index.php">Home</a></li>
        </ul>
      </div>
    </div>
  </nav>
    </header>

  <section class="bg-light py-5 text-center">
        <div class="container">
            <section id="home">
                <h1 class="display-4" style="font-family: Poppins; color: #A69C67">Discover Tranquility</h1>
            </section>
            <br>
            <p style="font-family: lora; font-size: 18px;">Step into a world where elegance meets serenity. At tourism Hotel, we invite you to escape the noise of everyday life and immerse yourself in a haven of peace. Surrounded by warnm hospitality, refined comfort, and breathtaking settings, every moment is designed to help you relax, recharge, and radiscover balance. Whether you're here for leisure or business, tranquility awaits at every corner of your stay.</p>
        </div>
        <hr>
    </section>
            <main class="container border p-md-5 p-2">
            <div class="row g-2 g-md-4">
                <div class="col-6 col-md-3">
                    <img class="w-100" src="img/bar.jpg" style="height: 200px" alt="gambar design layout">
                    <h6 style="font-family: lora"><i>Dining</i></h6>
                    <h5 style="font-family: georgia"><b>Restaurant and Bar</b></h5>
                    <p style="font-family: georgia">Tourism Hotel invites you to enjoy the culinary excellence with distinguished restaurant and a sophisticated bar with uique charm.
                </div>
                <div class="col-6 col-md-3">
                    <img class="w-100" src="img/gym.jpg" style="height: 200px" alt="gambar design layout">
                    <h6 style="font-family: lora"><i>Wellbeing</i></h6>
                    <h5 style="font-family: georgia"><b>Gym</b></h5>
                    <p style="font-family: georgia">overlooking unrivaled 360 degrees of of panoramic vista of jakarta, featuring one of the most expansive training space, which is exclusive for registered in house guwst only.</p>
                </div>
                <div class="col-6 col-md-3">
                    <img class="w-100" src="img/lounge.jpg" style="height: 200px" alt="gambar design layout">
                    <h6 style="font-family: lora"><i>Dining</i></h6>
                    <h5 style="font-family: georgia"><b>Executive Lounge</b></h5>
                    <p style="font-family: georgia">Tourism hotel gives you executive lounge as a room for guests, and offering a distinguished selection of amenities and services for those who seek enhanced privacy and convenience.
                </div>
                    <div class="col-6 col-md-3">
                <img class="w-100" src="img/tenniscourt.jpg" style="height: 200px" alt="gambar design layout">
                <h6 style="font-family: lora"><i>Wellbeing</i></h6>
                <h5 style="font-family: georgia"><b>Tennis Court</b></h5>
                <p style="font-family: georgia">two exclusive tennis courts are reserved for the registered in house guests. Offering an ideal setting to unwind.
                </div>
                <hr>
                <div class="col-6 col-md-3">
                    <img class="w-100" src="img/swimpool.jpg" style="height: 200px" alt="gambar design layout">
                    <h6 style="font-family: lora"><i>Wellbeing</i></h6>
                    <h5 style="font-family: georgia"><b>Swimming Pool</b></h5>
                    <p style="font-family: georgia">After your workout, enjoy shoting drinks and light refreshments by the poolside. The olympic sized swimming pool is prefect for your regular exercise, unwiding from the daily routine, or simply relaxing on a sunbed, exclusively for registered in-house gusts.
                </div>
                <div class="col-6 col-md-3">
                    <img class="w-100" src="img/seminarroom.jpg" style="height: 200px" alt="gambar design layout">
                    <h6 style="font-family: lora"><i>Activities</i></h6>
                    <h5 style="font-family: georgia"><b>Business Centre</b></h5>
                    <p style="font-family: georgia">The business centre offers a full range of services and amenities. Facilities include a private busniess suite with a main office and separate reception area. Always available for small meeting rooms available for hire. 
                </div>
                <div class="col-6 col-md-3">
                    <img class="w-100" src="img/ballroom2.jpg" style="height: 200px" alt="gambar design layout">
                    <h6 style="font-family: lora"><i>Events</i></h6>
                    <h5 style="font-family: georgia"><b>The Grand Ballroom and Meeting Room</b></h5>
                    <p style="font-family: georgia">Wheter searching for a sophisticated meeting space a weedding venue or a stylish setting for a special event, leave the arrangements to a team of professionals and savour the magic of the moment while experiencing the thrill of a lifetime.
                </div>
                <div class="col-6 col-md-3">
                    <img class="w-100" src="img/spa.jpg" style="height: 200px" alt="gambar design layout">
                    <h6 style="font-family: lora"><i>Wellbeing</i></h6>
                    <h5 style="font-family: georgia"><b>Tourism Spa</b></h5>
                    <p style="font-family: georgia">Immerse in the tranquil and refined setting of Tourism Spa, an urban retreat providing a peaceful haven from busy world. revitalise the body and mind with bespoke massages that combine Oriental and Western techniques for a uniquely personalised experience.<p>
                </div>
            </div>
        </main>

    </script>
<!-- Footer -->
  <footer class="footer">
    <div class="footer-container">
      <!-- Brand -->
      <div class="footer-brand">
        <h2>Tourism Hotel</h2>
        <p>Comfort • Luxury • Hospitality</p>
      </div>

      <!-- Social Media -->
      <div class="footer-social">
        <a href="https://www.instagram.com/" target="_blank">
          <i class="fab fa-instagram"></i>
        </a>
        <a href="https://www.facebook.com/" target="_blank">
          <i class="fab fa-facebook-f"></i>
        </a>
        <a href="https://wa.me/628123456789" target="_blank">
          <i class="fab fa-whatsapp"></i>
        </a>
        <a href="mailto:info@tourismhotel.com" target="_blank">
          <i class="fas fa-envelope"></i>
        </a>
      </div>
    </div>

    <div class="footer-bottom">
      <p>&copy; 2025 Tourism Hotel. All rights reserved.</p>
    </div>
  </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>