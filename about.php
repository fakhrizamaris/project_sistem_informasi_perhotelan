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

    .navbar .nav-link {
      color: #A69C67 !important;
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
      color: #FFD700;
      /* efek hover emas */
    }

    .footer-bottom {
      border-top: 1px solid rgba(255, 255, 255, 0.2);
      margin-top: 20px;
      padding-top: 15px;
      font-size: 14px;
      color: #aaa;
    }

    .navbar {
      padding-top: 0.1rem;
      padding-bottom: 0.1rem;
    }

    /* Perkecil jarak antar menu */
    .navbar-nav .nav-link {
      padding-top: 0.1rem;
      padding-bottom: 0.1rem;
      font-size: 0.95rem;
      /* biar lebih compact */
    }
  </style>
</head>

<body>
  <!-- HEADER -->
  <header class="site-header">
    <div class="top-bar" style="background-color: #012A2A">
      <div class="logo">
        <img src="public/img/logo.png" alt="Tourism Hotel Logo">
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
            <li class="nav-item"><a class="nav-link" href="index.php">Home</a></li>
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
      <img src="public/img/sejarah.jpg" width="500 px">
      <br>
      <br>
      <p style="font-family: lora; font-size: 18px; text-align: center;">Hotel Tourism was established in 1985 as a modest family-run inn. Located in the heart of the city, the hotel initially offered only 10 rooms and served local travelers visiting for business or leisure.</p>
      <br>
      <p style="font-family: lora; font-size: 18px; text-align: center;">As the city grew and tourism flourished, Hotel Tourism began undergoing a series of improvements. In 2000, a major renovation was carried out to expand the number of rooms and upgrade public facilities, including a restaurant and meeting rooms.</p>
      <br>
      <p style="font-family: lora; font-size: 18px; text-align: center;">Today, Hotel Tourism has evolved into one of the city’s most popular hotels, offering more than 100 rooms, modern facilities, and service that continues to reflect the warmth of its family heritage. Our commitment is to preserve this legacy while constantly innovating to provide the best experience for every guest.</p>
    </div>
  </section>


  <?php include 'public/includes/footer.php'; ?>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>