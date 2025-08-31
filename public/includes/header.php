<?php
session_start();
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tourism Hotel - Stay, Explore, Enjoy</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&family=Lora:ital,wght@0,400;0,600;1,400&display=swap" rel="stylesheet">

    <style>
        :root {
            --primary-dark: #012A2A;
            --primary-gold: #A69C67;
            --text-light: #f8f9fa;
            --text-dark: #343a40;
        }

        body {
            font-family: 'Lora', serif;
            background-color: #fdfdfd;
            padding-top: 125px;
            /* Height of the fixed header */
        }

        h1,
        h2,
        h3,
        h4,
        h5,
        h6,
        .navbar-brand,
        .logo-text {
            font-family: 'Playfair Display', serif;
        }

        /* --- Header --- */
        .site-header {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            z-index: 1030;
            background-color: white;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            transition: top 0.3s;
        }

        .top-bar {
            background-color: var(--primary-dark);
            padding: 0.5rem 1.5rem;
        }

        .logo img {
            height: 50px;
        }

        .logo-text {
            color: var(--primary-gold);
            font-size: 1.1rem;
            font-style: italic;
        }

        .top-bar .book-btn {
            background-color: var(--primary-gold);
            color: white;
            padding: 0.5rem 1.2rem;
            border-radius: 6px;
            text-decoration: none;
            font-weight: 600;
            transition: background-color 0.3s ease;
        }

        .top-bar .book-btn:hover {
            background-color: #bfb26f;
        }

        .navbar-nav .nav-link {
            color: var(--primary-dark) !important;
            font-weight: 600;
            font-family: 'Lora', serif;
            font-size: 1.1rem;
            margin: 0 0.5rem;
            border-bottom: 2px solid transparent;
            transition: border-color 0.3s;
        }

        .navbar-nav .nav-link:hover,
        .navbar-nav .nav-link.active {
            color: var(--primary-gold) !important;
            border-bottom-color: var(--primary-gold);
        }

        /* --- Slideshow --- */
        .slideshow-container {
            width: 100%;
            max-height: 600px;
            overflow: hidden;
        }

        .slideshow-container img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        /* --- Content Section --- */
        .section-title {
            color: var(--primary-dark);
            margin-bottom: 1rem;
            position: relative;
            padding-bottom: 10px;
        }

        .section-title::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 60px;
            height: 3px;
            background-color: var(--primary-gold);
        }

        .custom-section {
            background-color: var(--primary-dark);
            color: var(--text-light);
        }

        .custom-section h2 {
            color: var(--primary-gold);
            font-style: italic;
        }

        /* --- Room Cards --- */
        .card {
            border: none;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
            transition: transform 0.3s, box-shadow 0.3s;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.12);
        }

        .card .card-title {
            color: var(--primary-dark);
        }

        .card .features {
            font-size: 0.9rem;
            color: #6c757d;
        }
    </style>
</head>

<body>
    <header class="site-header">
        <div class="top-bar d-flex justify-content-between align-items-center">
            <a href="index.php" class="logo d-flex align-items-center text-decoration-none">
                <img src="img/logoputih.png" alt="Tourism Hotel Logo">
                <span class="logo-text ms-2 d-none d-sm-block">Stay, Explore, Enjoy</span>
            </a>
            <a href="booknow.php" class="book-btn">BOOK NOW</a>
        </div>

        <nav class="navbar navbar-expand-lg bg-white">
            <div class="container">
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav mx-auto">
                        <li class="nav-item"><a class="nav-link active" href="index.php">Home</a></li>
                        <li class="nav-item"><a class="nav-link" href="about.php">About</a></li>
                        <li class="nav-item"><a class="nav-link" href="#facilities">Facilities</a></li>
                        <li class="nav-item"><a class="nav-link" href="#room">Room Types</a></li>
                        <li class="nav-item"><a class="nav-link" href="../login.php">Login</a></li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>

    <main>