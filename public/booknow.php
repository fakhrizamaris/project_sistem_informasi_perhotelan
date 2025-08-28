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

    /* ROOM CARD */
    .room {
      display: flex;
      gap: 20px;
      background: #fff;
      padding: 20px;
      margin-bottom: 20px;
      border-radius: 12px;
      box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
      align-items: flex-start;
    }

    .room img {
      width: 50%;
      border-radius: 10px;
    }

    .room-details h3 {
      margin-top: 0;
    }

    .room-details button {
      background: #007BFF;
      color: #fff;
      border: none;
      padding: 10px 15px;
      border-radius: 8px;
      cursor: pointer;
      margin-top: 10px;
    }

    .room-details button:hover {
      background: #0056b3;
    }

    /* CART/INVOICE */
    .cart {
      position: fixed;
      top: 0;
      right: 0; /* awalnya di layar tapi digeser dengan transform */
      width: 350px;
      height: 100%;
      background: #fff;
      box-shadow: -2px 0 5px rgba(0, 0, 0, 0.2);
      padding: 20px;
      z-index: 10001; /* lebih tinggi dari navbar */
      transform: translateX(400px); /* posisi awal di luar layar */
      transition: transform 0.4s ease; /* animasi halus */
    }

    .cart.active {
      transform: translateX(0); /* masuk layar */
    }

    .close-cart {
      background: red;
      color: white;
      border: none;
      padding: 5px 10px;
      border-radius: 5px;
      cursor: pointer;
      float: right;
    }

    .book-btn {
      background: green;
      color: white;
      border: none;
      padding: 10px 15px;
      border-radius: 8px;
      cursor: pointer;
      margin-top: 20px;
      width: 100%;
    }

    .book-btn:hover {
      background: darkgreen;
    }

    footer {
      margin-top: 40px;
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
  </header>

  <!-- ROOMS -->
  <div class="container mt-5">
    <!-- ROOM 1 -->
    <div class="room">
      <img src="img/executive.jpg" alt="Suite">
      <div class="room-details">
        <h3>Suite</h3>
        <p>a spacious and luxurious room designed with premium facilities for maximum comfort.</p>
        <p class="price">IDR 3,000,000</p>
        <label>Adults:</label>
        <select id="adults1">
          <option value="1">1 Adult</option>
          <option value="2">2 Adults</option>
        </select>
        <label>Children:</label>
        <select id="children1">
          <option value="0">0 Child</option>
          <option value="1">1 Child</option>
        </select>
        <br>
        <button onclick="addToCart('Suite', 3000000, 'adults1', 'children1')">Book Now</button>
      </div>
    </div>

    <!-- ROOM 2 -->
    <div class="room">
      <img src="img/deluxe.jpg" alt="Deluxe">
      <div class="room-details">
        <h3>Deluxe</h3>
        <p>Elegant room with modern design and complete amenities.</p>
        <p class="price">IDR 2,000,000</p>
        <label>Adults:</label>
        <select id="adults2">
          <option value="1">1 Adult</option>
          <option value="2">2 Adults</option>
        </select>
        <label>Children:</label>
        <select id="children2">
          <option value="0">0 Child</option>
          <option value="1">1 Child</option>
        </select>
        <br>
        <button onclick="addToCart('Deluxe', 2000000, 'adults2', 'children2')">Book Now</button>
      </div>
    </div>

    <!-- ROOM 3 -->
    <div class="room">
      <img src="img/standard.jpg" alt="Standard">
      <div class="room-details">
        <h3>Standard</h3>
        <p>a cozy, simple, and functional room at an affordable rate.</p>
        <p class="price">IDR 1,000,000</p>
        <label>Adults:</label>
        <select id="adults3">
          <option value="1">1 Adult</option>
          <option value="2">2 Adults</option>
        </select>
        <label>Children:</label>
        <select id="children3">
          <option value="0">0 Child</option>
          <option value="1">1 Child</option>
        </select>
        <br>
        <button onclick="addToCart('Standard', 1000000, 'adults3', 'children3')">Book Now</button>
      </div>
    </div>
  </div>

  <!-- CART/INVOICE -->
  <div class="cart" id="cart">
    <button class="close-cart" onclick="toggleCart()">X</button>
    <h2>Your Cart</h2>
    <div id="cart-details"></div>
    <hr>
     <div id="customer-info">
    <label for="customer-name">Name:</label>
    <input type="text" id="customer-name" placeholder="Your name" style="width:100%; margin-bottom:8px;">

    <label for="customer-email">Email:</label>
    <input type="email" id="customer-email" placeholder="you@example.com" style="width:100%; margin-bottom:8px;">

    <label for="customer-phone">Phone:</label>
    <input type="tel" id="customer-phone" placeholder="+62..." style="width:100%; margin-bottom:8px;">
  </div>
    <h3 id="cart-total"></h3>
    <button class="book-btn">Checkout</button>
  </div>

  <script>
    function toggleCart() {
      const cart = document.getElementById("cart");
      cart.classList.toggle("active");
    }

    function addToCart(roomName, price, adultsId, childrenId) {
      let adults = document.getElementById(adultsId).value;
      let children = document.getElementById(childrenId).value;
      let taxes = Math.round(price * 0.21);
      let total = price + taxes;

      document.getElementById("cart-details").innerHTML = `
        <p><strong>${roomName}</strong></p>
        <p>Best Available Rate with Breakfast</p>
        <p>1 Night stay</p>
        <p>Guests: ${adults} Adult(s), ${children} Child(ren)</p>
        <p>Price: IDR ${price.toLocaleString()}</p>
        <p>Taxes and Fees: IDR ${taxes.toLocaleString()}</p>
      `;

      document.getElementById("cart-total").innerHTML =
        `Total: IDR ${total.toLocaleString()}`;

      toggleCart(); // otomatis buka cart dengan animasi
    }
    function checkout() {
  const name = document.getElementById('customer-name').value;
  const email = document.getElementById('customer-email').value;
  const phone = document.getElementById('customer-phone').value;

  if (!name || !email || !phone) {
    alert("Please fill all your information!");
    return;
  }

  alert(`Thank you ${name}! Your booking has been received.\nWe will contact you at ${email} or ${phone}.`);
  // Setelah checkout, bisa reset cart
  document.getElementById('cart-details').innerHTML = '';
  document.getElementById('cart-total').innerHTML = '';
  toggleCart();
}
  </script>
  <footer class="text-white text-center py-4" style="background-color: #8C661F;">
    <p class="mb-0">&copy; 2025 Tourism Hotel. All rights reserved.</p>
  </footer>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
