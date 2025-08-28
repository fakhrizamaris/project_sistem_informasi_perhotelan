<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>TOURISM HOTEL</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      margin: 0;
      font-family: "Poppins", Arial, sans-serif;
    }

    /* Header Top */
    .top-bar {
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 8px 40px;
      border-bottom: 1px solid #ddd;
      background-color: #fff;
    }

    .logo img {
      height: 60px;
    }

    .book-btn {
      background-color: #BC8F8F;
      color: white;
      padding: 10px 20px;
      text-decoration: none;
      font-weight: bold;
      border-radius: 5px;
      transition: 0.3s;
    }

    .book-btn:hover {
      background-color: #8a733f;
    }

    /* Navbar */
    .navbar {
      background-color: #BC8F8F !important;
    }

    .navbar .nav-link {
      color: white !important;
      font-weight: 600;
      margin-right: 15px;
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
      color: #8a733f;
    }

    .features {
      display: flex;
      justify-content: space-around;
      margin: 15px 0;
      font-size: 14px;
      color: #333;
    }

    /* Footer */
    footer {
      background-color: #BC8F8F;
      color: white;
    }
  </style>
</head>

<body>
  <!-- Top Bar -->
  <div class="top-bar">
    <div class="logo">
      <img src="img/logoputih.png" alt="Tourism Hotel Logo">
    </div>
    <a href="booknow.html" class="book-btn">BOOK NOW</a>
  </div>

  <!-- Navbar -->
  <nav class="navbar navbar-expand-lg">
    <div class="container">
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ms-auto">
          <li class="nav-item"><a class="nav-link" href="aboutus.html">About</a></li>
          <li class="nav-item"><a class="nav-link" href="#home">Home</a></li>
          <li class="nav-item"><a class="nav-link" href="#facilities">Facilities</a></li>
          <li class="nav-item"><a class="nav-link" href="#room">Room</a></li>
        </ul>
      </div>
    </div>
  </nav>



  </script>
    <!-- Footer -->
  <footer class="text-center py-4">
    <p class="mb-0">&copy; 2025 Tourism Hotel. All rights reserved.</p>
  </footer>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

