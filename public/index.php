<?php include 'includes/header.php'; ?>

<div id="hotelCarousel" class="carousel slide" data-bs-ride="carousel">
  <div class="carousel-indicators">
    <button type="button" data-bs-target="#hotelCarousel" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
    <button type="button" data-bs-target="#hotelCarousel" data-bs-slide-to="1" aria-label="Slide 2"></button>
    <button type="button" data-bs-target="#hotelCarousel" data-bs-slide-to="2" aria-label="Slide 3"></button>
  </div>
  <div class="carousel-inner slideshow-container">
    <div class="carousel-item active">
      <img src="img/tourismhotel.jpg" class="d-block w-100" alt="Hotel Exterior">
    </div>
    <div class="carousel-item">
      <img src="img/receptionist.jpg" class="d-block w-100" alt="Receptionist">
    </div>
    <div class="carousel-item">
      <img src="img/executive.jpg" class="d-block w-100" alt="Executive Room">
    </div>
  </div>
  <button class="carousel-control-prev" type="button" data-bs-target="#hotelCarousel" data-bs-slide="prev">
    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Previous</span>
  </button>
  <button class="carousel-control-next" type="button" data-bs-target="#hotelCarousel" data-bs-slide="next">
    <span class="carousel-control-next-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Next</span>
  </button>
</div>

<section id="facilities" class="py-5">
  <div class="container">
    <h1 class="text-center section-title mb-5">Our Facilities</h1>

    <div class="custom-section py-5 rounded">
      <div class="container">
        <div class="row align-items-center g-4">
          <div class="col-md-6">
            <h2 class="text-center text-md-start">Restaurant</h2>
            <p class="text-center text-md-start">Enjoy an exceptional dining experience with a wide selection of dishes, crafted by our skilled chefs. Our restaurant is the perfect place for any occasion.</p>
          </div>
          <div class="col-6 col-md-3">
            <img class="img-fluid rounded shadow" src="img/restaurant1.png" alt="Restaurant View 1">
          </div>
          <div class="col-6 col-md-3">
            <img class="img-fluid rounded shadow" src="img/restaurant2.png" alt="Restaurant View 2">
          </div>
        </div>
      </div>
    </div>

    <div class="py-5">
      <div class="container">
        <div class="row align-items-center g-4">
          <div class="col-6 col-md-3">
            <img class="img-fluid rounded shadow" src="img/pool1.jpg" alt="Swimming Pool 1">
          </div>
          <div class="col-6 col-md-3">
            <img class="img-fluid rounded shadow" src="img/pool2.jpg" alt="Swimming Pool 2">
          </div>
          <div class="col-md-6 text-center text-md-end">
            <h2 class="section-title d-inline-block">Swimming Pool</h2>
            <p>Relax and unwind at our crystal-clear swimming pool, surrounded by a refreshing atmosphere and comfortable lounge chairs.</p>
          </div>
        </div>
      </div>
    </div>

  </div>
</section>

<div class="container-fluid p-0">
  <div class="position-relative text-center">
    <img src="img/bookbed.jpg" alt="Comfortable Bed" class="img-fluid">
    <div class="position-absolute top-50 start-50 translate-middle bg-white bg-opacity-75 p-4 rounded shadow">
      <h3 class="text-dark">Find More Facilities</h3>
      <a href="findmore.php" class="btn btn-outline-dark mt-2">Discover More</a>
    </div>
  </div>
</div>


<section id="room" class="py-5 bg-light">
  <div class="container">
    <h1 class="text-center section-title mb-4">Our Rooms</h1>
    <p class="text-center text-muted mb-5 mx-auto" style="max-width: 700px;">Our rooms are thoughtfully designed to provide comfort and relaxation. Each is equipped with modern amenities to ensure a pleasant stay for both business and leisure travelers.</p>

    <div class="row g-4 justify-content-center">

      <div class="col-md-6 col-lg-4">
        <div class="card h-100">
          <img src="img/executive.jpg" class="card-img-top" alt="Suite Room">
          <div class="card-body d-flex flex-column">
            <h5 class="card-title">Suite</h5>
            <p class="card-text">A spacious and luxurious room with premium facilities for maximum comfort.</p>
            <div class="features d-flex justify-content-around my-3">
              <span><i class="fas fa-ruler-combined"></i> 48m²</span>
              <span><i class="fas fa-bed"></i> 1 King</span>
              <span><i class="fas fa-users"></i> 2 Adults</span>
            </div>
            <div class="mt-auto text-center">
              <a href="suite.php" class="btn btn-outline-dark w-100">View Details</a>
            </div>
          </div>
        </div>
      </div>

      <div class="col-md-6 col-lg-4">
        <div class="card h-100">
          <img src="img/deluxe.jpg" class="card-img-top" alt="Deluxe Room">
          <div class="card-body d-flex flex-column">
            <h5 class="card-title">Deluxe</h5>
            <p class="card-text">An elegant room with modern design and complete amenities for extra comfort.</p>
            <div class="features d-flex justify-content-around my-3">
              <span><i class="fas fa-ruler-combined"></i> 32m²</span>
              <span><i class="fas fa-bed"></i> 1 King/Twin</span>
              <span><i class="fas fa-users"></i> 2 Adults</span>
            </div>
            <div class="mt-auto text-center">
              <a href="deluxe.php" class="btn btn-outline-dark w-100">View Details</a>
            </div>
          </div>
        </div>
      </div>

      <div class="col-md-6 col-lg-4">
        <div class="card h-100">
          <img src="img/standard.jpg" class="card-img-top" alt="Standard Room">
          <div class="card-body d-flex flex-column">
            <h5 class="card-title">Standard</h5>
            <p class="card-text">A cozy, simple, and functional room for a pleasant stay at an affordable rate.</p>
            <div class="features d-flex justify-content-around my-3">
              <span><i class="fas fa-ruler-combined"></i> 24m²</span>
              <span><i class="fas fa-bed"></i> 1 Queen/Twin</span>
              <span><i class="fas fa-users"></i> 2 Adults</span>
            </div>
            <div class="mt-auto text-center">
              <a href="standard.php" class="btn btn-outline-dark w-100">View Details</a>
            </div>
          </div>
        </div>
      </div>

    </div>
  </div>
</section>

<?php include 'includes/footer.php'; ?>