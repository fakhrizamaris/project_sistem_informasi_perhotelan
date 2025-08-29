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
    /* Header Top */
    .top-bar {
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 5px 35px;
      border-bottom: 1px solid #ddd;
      background-color: #012A2A;
    }

    .logo img {
      width: 100px;
      height: auto;
    }

    .book-btn:hover {
      background-color: #A69C67;
    }

    /* Navbar 
    .navbar {
      background-color:  #A69C67 !important;
    }*/

    .navbar .nav-link {
      color: #A69C67 !important;
      font-weight: 600;
      margin-right: 20px;
    }

    .navbar .nav-link:hover {
      text-decoration: underline;
    }

    /* Slideshow */
    .slideshow-container img {
      width: 100%;
      height: 500px;
      object-fit: cover;
    }

    .prev,
    .next {
      cursor: pointer;
      position: absolute;
      top: 50%;
      padding: 12px;
      color: white;
      font-weight: bold;
      font-size: 20px;
      background: rgba(0, 0, 0, 0.5);
      border-radius: 5px;
      transform: translateY(-50%);
    }

    .next {
      right: 20px;
    }

    .prev {
      left: 20px;
    }

    .dot-container {
      text-align: center;
      position: absolute;
      bottom: 15px;
      width: 100%;
    }

    .dot {
      cursor: pointer;
      height: 12px;
      width: 12px;
      margin: 0 4px;
      background-color: #bbb;
      border-radius: 50%;
      display: inline-block;
      transition: background-color 0.6s ease;
    }

    .active,
    .dot:hover {
      background-color: #717171;
    }

    /* Card Room */
    .card {
      border-radius: 12px;
      overflow: hidden;
      box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
      transition: transform 0.3s;
    }

    .card:hover {
      transform: translateY(-5px);
    }

    .card-title {
      font-size: 24px;
      font-weight: bold;
      color: #A69C67;
    }

    .features {
      display: flex;
      justify-content: space-around;
      margin: 15px 0;
      font-size: 14px;
      color: #333;
    }

    .room {
      display: flex;
      /* bikin sejajar kiri-kanan */
      flex-direction: row;
      /* pastikan horizontal */
      align-items: flex-start;
      /* sejajarkan ke atas */
      gap: 20px;
      background: #fff;
      padding: 20px;
      margin-bottom: 20px;
      border-radius: 12px;
      box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
    }

    .room-container {
      position: relative;
    }

    .room-info {
      position: absolute;
      bottom: 50px;
      right: 50px;
      width: 500px;
      background: rgba(255, 255, 255, 0.9);
      padding: 20px;
      border-radius: 10px;
    }

    .pool-img {
      width: 100%;
      height: 500px;
      object-fit: cover;
      border-radius: 10px;
      /* opsional biar lebih estetik */
    }

    /*ini untuk dua gambar*/
    .room-gallery {
      text-align: center;
      margin: 60px auto;
      max-width: 1200px;
    }

    .gallery-images {
      display: flex;
      justify-content: center;
      gap: 20px;
    }

    .gallery-images img {
      width: 100%;
      max-width: 500px;
      height: 350px;
      object-fit: cover;
      border-radius: 12px;
      box-shadow: 0 4px 10px rgba(0, 0, 0, 0.15);
    }

    .gallery-action {
      margin-top: 20px;
    }

    .book-btn {
      display: inline-block;
      padding: 12px 28px;
      font-family: georgia;
      font-size: 30px;
      background-color: #A69C67;
      /* hijau emerald gelap */
      color: white;
      text-decoration: none;
      font-weight: bold;
      border-radius: 8px;
      transition: 0.3s;
    }

    .book-btn:hover {
      background-color: #50C878;
      /* hijau emerald terang */
    }

    .custom-section {
      background-color: #012A2A;
      /* hijau tua */
      padding: 50px 20px;
      color: white;
      text-align: center;
    }

    .custom-container {
      max-width: 1000px;
      margin: 0 auto;
    }

    .custom-container h2 {
      font-size: 2rem;
      margin-bottom: 20px;
      color: #A69C67;
      /* gold */
    }

    .custom-container p {
      max-width: 700px;
      margin: 0 auto 30px;
      line-height: 1.6;
    }

    .custom-gallery {
      display: flex;
      justify-content: center;
      gap: 20px;
    }

    .custom-gallery img {
      width: 300px;
      height: 200px;
      object-fit: cover;
      border-radius: 10px;
    }

    .logo-text {
      font-size: 1 rem;
      font-weight: bold;
      color: #A69C67;
      font-family: cursive;
      /* bisa diganti sesuai selera */
    }

    /* bikin header tetap di atas layar */
    .site-header {
      position: fixed;
      top: 0;
      left: 0;
      right: 0;
      background-color: white;
      z-index: 9999;
      /* tinggi agar selalu di atas */
      width: 100%;
    }

    /* bar paling atas (logo + book) */
    .top-bar {
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 10px 24px;
      background: rgba(255, 255, 255, 0.95);
      /* transparan tipis, ubah sesuai selera */
      border-bottom: 1px solid rgba(0, 0, 0, 0.06);
    }

    /* tombol book */
    .book-btn {
      background-color:

/* Wajib ditambahkan di CSS */
body {
  display: flex;
  flex-direction: column;
  min-height: 100vh; /* supaya setinggi layar */
}

main {
  flex: 1; /* konten utama biar dorong footer ke bawah */
}
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
    /* Kecilkan tinggi navbar */
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

=======
      /* bikin header tetap di atas layar */
      .site-header {
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        z-index: 9999;
        /* tinggi agar selalu di atas */
        width: 100%;
      }

      /* bar paling atas (logo + book) */
      .top-bar {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 10px 24px;
        background: rgba(255, 255, 255, 0.95);
        /* transparan tipis, ubah sesuai selera */
        border-bottom: 1px solid rgba(0, 0, 0, 0.06);
      }

      /* tombol book */
      .book-btn {
        background-color: #A69C67;
        color: white;
        padding: 8px 16px;
        border-radius: 6px;
        text-decoration: none;
        font-weight: 600;
      }

      /* pastikan logo proporsional */
      .logo img {
        height: 56px;
      }

      /* fallback: kalau JS tidak jalan, beri body padding minimal */
      body {
        padding-top: 110px;
      }

      /* sesuaikan jika headermu lebih tinggi */
      ;
      color: white;
      padding: 8px 16px;
      border-radius: 6px;
      text-decoration: none;
      font-weight: 600;
    }

    /* pastikan logo proporsional */
    .logo img {
      height: 56px;
    }

    /* fallback: kalau JS tidak jalan, beri body padding minimal */
    body {
      padding-top: 110px;
    }

    /* sesuaikan jika headermu lebih tinggi */
  </style>
</head>

<body>
  <!-- Top Bar -->
  <header class="site-header">
<<<<<<< HEAD
  <div class="top-bar" style="background-color: #012A2A">
    <div class="logo">
      <img src="img/logo.png" alt="Tourism Hotel Logo">
      <span class="logo-text">Stay-Explore-Enjoy</span>
    </div>
    <a href="booknow.php" class="book-btn">BOOK NOW</a>
  </div>

  <!-- Navbar -->
  <nav class="navbar navbar-expand-lg site-nav">
    <div class="container">
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ms-auto">
          <li class="nav-item"><a class="nav-link" style="font-family: georgia; font-size: 20px;" href="about.php">About</a></li>
          <li class="nav-item"><a class="nav-link" style="font-family: georgia; font-size: 20px;" href="index.php">Home</a></li>
          <li class="nav-item"><a class="nav-link" style="font-family: georgia; font-size: 20px;"  href="#facilities">Facilities</a></li>
          <li class="nav-item"><a class="nav-link" style="font-family: georgia; font-size: 20px;" href="#room">Room</a></li>
          <li class="nav-item"><a class="nav-link" style="font-family: georgia; font-size: 20px;" href="../login.php">Login</a></li>
        </ul>

    <div class="top-bar" style="background-color: #012A2A">
      <div class="logo">
        <img src="img/logoputih.png" alt="Tourism Hotel Logo">
        <span class="logo-text">Stay-Explore-Enjoy</span>
      </div>
      <a href="booknow.php" class="book-btn">BOOK NOW</a>
    </div>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg site-nav">
      <div class="container">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
          <ul class="navbar-nav ms-auto">
            <li class="nav-item"><a class="nav-link" style="font-weight: font-family: georgia bold; font-size: 20px;" href="about.php">About</a></li>
            <li class="nav-item"><a class="nav-link" style="font-weight: font-family: georgia bold; font-size: 20px;" href="index.php">Home</a></li>
            <li class="nav-item"><a class="nav-link" style="font-weight: font-family: georgia bold; font-size: 20px;" href="#facilities">Facilities</a></li>
            <li class="nav-item"><a class="nav-link" style="font-weight: font-family: georgia bold; font-size: 20px;" href="#room">Room</a></li>
            <li class="nav-item"><a class="nav-link" style="font-weight: font-family: georgia bold; font-size: 20px;" href="../login.php">Login</a></li>
          </ul>
        </div>
      </div>
    </nav>
  </header>

  <!-- Slideshow -->
  <div class="slideshow-container position-relative">
    <div class="mySlides text-center">
      <img src="img/tourismhotel.jpg" alt="Hotel">
    </div>
    <div class="mySlides text-center">
      <img src="img/receptionist.jpg" alt="Receptionist">
    </div>
    <div class="mySlides text-center">
      <img src="img/executive.jpg" alt="Receptionist">
    </div>
    <a class="prev" onclick="plusSlides(-1)">&#10094;</a>
    <a class="next" onclick="plusSlides(1)">&#10095;</a>

    <div class="dot-container">
      <span class="dot" onclick="currentSlide(1)"></span>
      <span class="dot" onclick="currentSlide(2)"></span>
    </div>
  </div>

  <script>
    let slideIndex = 0;
    let slideInterval;

    function showSlides() {
      let slides = document.getElementsByClassName("mySlides");
      let dots = document.getElementsByClassName("dot");

      for (let i = 0; i < slides.length; i++) {
        slides[i].style.display = "none";
      }

      slideIndex++;
      if (slideIndex > slides.length) {
        slideIndex = 1
      }

      for (let i = 0; i < dots.length; i++) {
        dots[i].className = dots[i].className.replace(" active", "");
      }

      slides[slideIndex - 1].style.display = "block";
      dots[slideIndex - 1].className += " active";

      slideInterval = setTimeout(showSlides, 3000); // auto slide 3 detik
    }

    function plusSlides(n) {
      clearTimeout(slideInterval);
      slideIndex += n - 1;
      showSlides();
    }

    function currentSlide(n) {
      clearTimeout(slideInterval);
      slideIndex = n - 1;
      showSlides();
    }

    showSlides();
  </script>

  <hr>


  <!--facilities-->
  <section id="facilities">
    <h1 class="display-4 text-center" style="font-family: Poppins;">FACILITIES</h1>
  </section>
  <section class="custom-section py-12">
    <div class="custom-container">
      <br>
      <div class="row">
        <div class="col-md-6">
          <h1 class="text-center" style="font-family: georgia; font-style: italic; color: #DAA520;">Restaurant
          </h1>
          <p class="text-center" style="font-family: lora; font-size: 18px;">Enjoy an exceptional dining
            experience with a wide selection dishes, crafted by our skilled chefs. with its cosy yet elegant
            atmosphere, our restaurant is the perfect place for breakfast, lunch, or dinner with family,
            business partners, or loved ones.</p>
        </div>
        <div class="col-6 col-md-3">
          <img class="w-100" src="img/restaurant1.png" width="100px" alt="gambar design layout">
        </div>
        <div class="col-6 col-md-3">
          <img class="w-100" src="img/restaurant2.png" width="100px" alt="gambar design layout">
        </div>
      </div>
    </div>
  </section>
  <hr>

    <section class="custom-section py-5">
        <div class="custom-container">
            <br>
            <div class="row">
                <div class="col-6 col-md-3">
                    <img class="w-100" src="img/meeting1.jpg" width="100px" alt="gambar design layout">
                </div>
                <div class="col-6 col-md-3">
                    <img class="w-100" src="img/meeting2.jpg" width="100px" alt="gambar design layout">
                </div>
                <div class="col-md-6 text-center">
                    <h1 style="font-family: georgia; font-style: italic; color:#DAA520;">Ballroom</h1>
                    <p style="font-family: lora; font-size: 18px;">Our elegant ballroom offers a spacious and versatile venue, perfect for hosting grand celebrations, corporate events, or social gatherings. Featuring luxurious decor, advanced lighting and sound systems, and customizable seating arrangements, the ballroom provides the ideal setting to make your special occasion truly unforgettable.</p>
                </div>
            </div>
        </div>
    </section>

<div class="room-container text-center">
            <img src="img/bookbed.jpg" alt="bookbed" width="100%" class="pool-img">
            <div class="room-info">
                <h3 style="font-family: georgia; font-style: italic; color:#8a733f;">Tourism Hotel</h3>
                <a href="findmore.php" class="btn btn-outline-primary">Find for More</a>
  <section class="custom-section py-5">
    <div class="custom-container">
      <br>
      <div class="row">
        <div class="col-6 col-md-3">
          <img class="w-100" src="img/meeting1.jpg" width="100px" alt="gambar design layout">
        </div>
        <div class="col-6 col-md-3">
          <img class="w-100" src="img/meeting2.jpg" width="100px" alt="gambar design layout">
        </div>
        <div class="col-md-6 text-center">
          <h1 style="font-family: georgia; font-style: italic; color:#DAA520;">Meeting Room</h1>
          <p style="font-family: lora; font-size: 18px;">Our meeting rooms are designed to support your
            business needs, equipped with modern facilities such as projectors, audio-visual systems,
            high-speed Wi-Fi, and flexible layouts. Perfect for small meetings, seminars, or professional
            presentation in a calm and productive setting.</p>
        </div>
      </div>
    </div>
  </section>
  <hr>

  <section class="custom-section py-5">
    <div class="custom-container">
      <br>
      <div class="row">
        <div class="col-md-6 text-center">
          <h1 style="font-family: georgia; font-style: italic; color:#DAA520;">Swimming Pool</h1>
          <p style="font-family: lora; font-size: 18px;">Relax and unwind at our crystal-clear swimming pool, surrounded bt a refreshing atmosphere and comfortable lounge chairs. Whether you want to swim a few laps, enjoy a casual dip, or simply soak up the sun, our pool is the perfect spot for both leisure and relaxation</p>
        </div>
        <div class="col-6 col-md-3">
          <img class="w-100" src="img/pool1.jpg" width="100px" alt="gambar design layout">
        </div>
        <div class="col-6 col-md-3">
          <img class="w-100" src="img/pool2.jpg" width="100px" alt="gambar design layout">
        </div>
      </div>
    </div>
  </section>
  <hr>

  <div class="room-container text-center">
    <img src="img/bookbed.jpg" alt="bookbed" width="100%" class="pool-img">
    <div class="room-info">
      <h3 style="font-family: georgia; font-style: italic; color:#8a733f;">Tourism Hotel</h3>
      <a href="findmore.php" class="btn btn-outline-primary">Find for More</a>
    </div>
  </div>

  <!--Room-->
  <section class="custom-section py-5">
    <div class="custom-container">
      <div class="row g-4 text-center">
        <section id="room">
          <h1 class="text-center" style="font-family: georgia; font-style: italic; color: #DAA520;">ROOM</h1>
        </section>
        <p style="font-family: lora; font-size: 18px; ">Our rooms are thoughtfully designed to provide comfort, convenience, and relaxation for every guest. Each room is equipped with modern amenities including a comfortable bed, air, codnitioning, flat-screen TV, complimentary WI-Fi, and a private bathroom with premium toiletries. With a cozy atmosphere and elegant design, our rooms ensure a pleasant stay for both bussiness and leisure travelers. </p>
        <div class="col-md-4">
          <div class="card">
            <img src="img/executive.jpg" width="800px" class="card-img-top" alt="Gambar 1">
            <div class="card-body">
              <h5 class="card-title" style="font-family: poppins; font-size: 30px; color: #DAA520">Suite</h5>
              <p class="card-text" style="font-family: Poppins;">a spacious and luxurious room designed
                with premium facilities for maximum comfort. Perfect for guests seeking an exclusives
                stay with top-class service.</p>
              <div class="features">
                <div class="feature" style="font-size: 15px">📏 <span><b>48m<sup>2</b></sup></span></div>
                <div class="feature" style="font-size: 15px">🛏️ <span><b>1 king</b></span></div>
                <div class="feature" style="font-size: 15px">👤 <span><b>2 adults + 2 child</b></span></div>
              </div>
              <a href="suite.php" class="btn btn-outline-primary">See More</a>
              <a href="booknow.php" class="btn btn-outline-primary">Book Now</a>
            </div>
          </div>
        </div>

    <!--Room-->
    <section class="custom-section py-5">
        <div class="custom-container">
            <div class="row g-4 text-center">
                <section id="room">
                    <h1 class="text-center" style="font-family: georgia; font-style: italic; color: #DAA520;">ROOM</h1>
                </section>
                <p style="font-family: lora; font-size: 18px; ">Our rooms are thoughtfully designed to provide comfort, convenience, and relaxation for every guest. Each room is equipped with modern amenities including a comfortable bed, air, codnitioning, flat-screen TV, complimentary WI-Fi, and a private bathroom with premium toiletries. With a cozy atmosphere and elegant design, our rooms ensure a pleasant stay for both bussiness and leisure travelers. </p>
                <div class="col-md-4">
                    <div class="card">
                        <img src="img/executive.jpg" width="800px" class="card-img-top" alt="Gambar 1">
                        <div class="card-body">
                            <h5 class="card-title" style="font-family: poppins; font-size: 30px; color: #DAA520">Suite</h5>
                            <p class="card-text" style="font-family: Poppins;">a spacious and luxurious room designed
                                with premium facilities for maximum comfort. Perfect for guests seeking an exclusives
                                stay with top-class service.</p>
                            <div class="features">
                                <div class="feature" style="font-size: 15px">📏 <span><b>48m<sup>2</b></sup></span></div>
                                <div class="feature" style="font-size: 15px">🛏️ <span><b>1 king</b></span></div>
                                <div class="feature" style="font-size: 15px">👤 <span><b>2 adults + 2 child</b></span>
                              </div>
                            </div>
                            <a href="suite.php" class="btn btn-outline-primary">See More</a>
                            <a href="booknow.php" class="btn btn-outline-primary">Book Now</a>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card">
                        <img src="img/deluxe.jpg" width="800px" class="card-img-top" alt="Gambar 2">
                        <div class="card-body">
                            <h5 class="card-title" style="font-family: poppins; font-size: 30px; color: #DAA520">Deluxe</h5>
                            <p class="card-text" style="font-family: Poppins;">an Elegant room with modern design and
                                complete amenities. Offering extra comfort at a friendly price, ideal for both business
                                and leisure travelers.</p>
                            <div class="features">
                                <div class="feature" style="font-size: 15px">📏 <span><b>32m<sup>2</b></sup></span></div>
                                <div class="feature" style="font-size: 15px">🛏️ <span><b>1 king / Twin</b></span></div>
                                <div class="feature" style="font-size: 15px">👤 <span><b>3 people</b></span></div>
                            </div>
                            <a href="deluxe.php" class="btn btn-outline-primary">See More</a>
                            <a href="booknow.php" class="btn btn-outline-primary">BOOK NOW</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card">
                        <img src="img/standard.jpg" width="800px" class="card-img-top" alt="Gambar 2">
                        <div class="card-body">
                            <h5 class="card-title" style="font-family: poppins; font-size: 30px; color: #DAA520">Standard</h5>
                            <p class="card-text" style="font-family: Poppins;">a cozy, simple, and functional room.
                                Equipped with dacilities to ensure a pleasant stay at an affordable rate.</p>
                            <div class="features">
                                <div class="feature" style="font-size: 15px">📏 <span><b>24m<sup>2</b></sup></span></div>
                                <div class="feature" style="font-size: 15px">🛏️ <span><b>1 queen / Twin</b></span></div>
                                <div class="feature" style="font-size: 15px">👤 <span><b>2 adults</b></span></div>
                            </div>
                            <a href="standard.php" class="btn btn-outline-primary">See More</a>
                            <a href="booknow.php" class="btn btn-outline-primary">BOOK NOW</a>
                        </div>
                    </div>
                </div>
        <div class="col-md-4">
          <div class="card">
            <img src="img/deluxe.jpg" width="800px" class="card-img-top" alt="Gambar 2">
            <div class="card-body">
              <h5 class="card-title" style="font-family: poppins; font-size: 30px; color: #DAA520">Deluxe</h5>
              <p class="card-text" style="font-family: Poppins;">an Elegant room with modern design and
                complete amenities. Offering extra comfort at a friendly price, ideal for both business
                and leisure travelers.</p>
              <div class="features">
                <div class="feature" style="font-size: 15px">📏 <span><b>32m<sup>2</b></sup></span></div>
                <div class="feature" style="font-size: 15px">🛏️ <span><b>1 king / Twin</b></span></div>
                <div class="feature" style="font-size: 15px">👤 <span><b>3 people</b></span></div>
              </div>
              <a href="deluxe.php" class="btn btn-outline-primary">See More</a>
              <a href="booknow.php" class="btn btn-outline-primary">BOOK NOW</a>
            </div>
          </div>
        </div>
        </div>
    </section>
    <hr>

<!-- FOOTER --> 
<footer class="footer">
    <div class="footer-container">
      <!-- Brand -->
      <div class="footer-brand">
        <h2>Tourism Hotel</h2>
        <p>Stay • Explore • Enjoy</p>
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
        <div class="col-md-4">
          <div class="card">
            <img src="img/standard.jpg" width="800px" class="card-img-top" alt="Gambar 2">
            <div class="card-body">
              <h5 class="card-title" style="font-family: poppins; font-size: 30px; color: #DAA520">Standard</h5>
              <p class="card-text" style="font-family: Poppins;">a cozy, simple, and functional room.
                Equipped with dacilities to ensure a pleasant stay at an affordable rate.</p>
              <div class="features">
                <div class="feature" style="font-size: 15px">📏 <span><b>24m<sup>2</b></sup></span></div>
                <div class="feature" style="font-size: 15px">🛏️ <span><b>1 queen / Twin</b></span></div>
                <div class="feature" style="font-size: 15px">👤 <span><b>2 adults</b></span></div>
              </div>
              <a href="standard.php" class="btn btn-outline-primary">See More</a>
              <a href="booknow.php" class="btn btn-outline-primary">BOOK NOW</a>
            </div>
          </div>
        </div>
      </div>
    </div>
    </div>
  </section>
  <hr>

  <section class="bg-light py-5 text-center">
    <div class="container">
      <div class="row">
        <h1 style="font-family: georgia; font-style: italic; color:#8a733f;">Tourism Hotel</h1>
        <p style="font-family: lora; font-size: 18px;">Jalan Kapitan Pattimura Kota no 37 Medan Sumatera Utara
        </p>
        <p style="font-family: lora; font-size: 18px;">+6282150263345</p>
      </div>
    </div>
    </div>
  </section>
  <!-- FOOTER -->
  <footer class="text-white text-center py-4" style="background-color: #A69C67;">
    <p class="mb-0 font-size:25px">&copy; 2025 Tourism Hotel. All rights reserved.</p>
  </footer>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>