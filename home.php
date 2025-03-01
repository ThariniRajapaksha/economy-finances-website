<?php
session_start();
require 'db_connection.php';

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Enomy Finances</title>
    <link rel="stylesheet" href="home.css">
    <!-- Font Awesome CDN link -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
</head>
<body>
    <!-- Header Section -->
    <header>
    <nav>
        <div class="logo">
            <a href="home.php"> 
                <img src="Images/Logo.png" alt="Logo">
            </a>
        </div> 
        <div class="dropdown">
            <button><i class="fa-solid fa-headset"></i> Touch with Us</button>
            <ul class="dropdown-menu">
                <li><a href="about-us.php"><i class="fa-solid fa-address-card"></i> About Us</a></li>
                <li><a href="contact-us.php"><i class="fa-solid fa-phone-volume"></i> Contact Us</a></li>
            </ul>
        </div>
        <div class="dropdown">
            <button><i class="fa-solid fa-layer-group"></i> Services Offered</button>
            <ul class="dropdown-menu">
                <li><a href="mortgages.php"><i class="fa-solid fa-landmark"></i> Mortgages</a></li>
                <li><a href="savings.php"><i class="fa-solid fa-money-check-dollar"></i> Savings</a></li> 
                <li><a href="loans.php"><i class="fa-solid fa-dollar-sign"></i> Loans</a></li> 
                <li><a href="investments.php"><i class="fa-solid fa-hand-holding-dollar"></i> Investments</a></li> 
            </ul>
        </div>
        <a href="currency-exchange.php"><button><i class="fa-solid fa-rotate"></i> Currency Exchange</button></a>
        <a href="calculate.php"><button><i class="fa-solid fa-calculator"></i> Calculate Tools</button></a>
        <div class="dropdown">
            <button><i class="fa-solid fa-gear"></i> Profile and Settings</button>
            <ul class="dropdown-menu">
                <li><a href="contact-details.php"><i class="fa-solid fa-user-gear"></i>  Your Profile</a></li> 
                <li><a href="security.php"><i class="fa-solid fa-user-lock"></i>  Security</a></li> 
                <li><a href="application-status.php"><i class="fa-brands fa-wpforms"></i> Application Status</a></li>
                <li><a href="book-advisor.php"><i class="fa-solid fa-calendar-check"></i>  Book Personal Advisor</a></li> 
                <li><a href="logout.php"><i class="fa-solid fa-arrow-right-from-bracket"></i>  Logout</a></li> 
            </ul>
        </div>
    </nav>
    <div class="user-info">
        <?php
            if (isset($_SESSION['fullname'])): ?>
            <span> Welcome, <?php echo htmlspecialchars($_SESSION['fullname']); ?></span>
        <?php endif; ?>
    </div>
</header>

<main>

    <!-- Image Slider Section -->
    <div class="image-slider">
        <div class="slide">
            <img src="Images/1.jpg" class="slider-image" alt="Finance 1">
            <div class="caption">
                <h3>Explore Your Financial Future</h3>
                <p>Get the best mortgage rates with Enomy-Finances.</p>
            </div>
        </div>
        <div class="slide">
            <img src="Images/2.jpg" class="slider-image" alt="Finance 2">
            <div class="caption">
                <h3>Start Saving Today</h3>
                <p>Grow your savings with our personalized plans.</p>
            </div>
        </div>
        <div class="slide">
            <img src="Images/3.jpg" class="slider-image" alt="Finance 3">
            <div class="caption">
                <h3>Achieve Your Dream with Loans</h3>
                <p>Apply for loans tailored to your needs.</p>
            </div>
        </div>
        <div class="slide">
            <img src="Images/4.webp" class="slider-image" alt="Finance 4">
            <div class="caption">
                <h3>Invest with Confidence</h3>
                <p>Explore investment opportunities that bring returns.</p>
            </div>
        </div>
    </div>

    <!-- Services Section -->
    <section class="services">
        <div class="service-title">
            <h2>Services Offered By Enomy-Finances</h2>
        </div>
        <div class="service-card">
            <img src="Images/Mortgage.jpeg" alt="Mortgages">
            <h3>Mortgages</h3>
            <a href="mortgages.php"><button><i class="fa-solid fa-magnifying-glass"></i> Explore</button></a>
        </div>

        <!-- Service Card for Savings -->
        <div class="service-card">
            <img src="Images/Savings.jpeg" alt="Savings">
            <h3>Savings</h3>
            <a href="savings.php"><button><i class="fa-solid fa-magnifying-glass"></i> Explore</button></a>
        </div>

        <!-- Service Card for Loans -->
        <div class="service-card">
            <img src="Images/Loan.jpg" alt="Loans">
            <h3>Loans</h3>
            <a href="loans.php"><button><i class="fa-solid fa-magnifying-glass"></i> Explore</button></a>
        </div>

        <!-- Service Card for Investments -->
        <div class="service-card">
            <img src="Images/Investment.jpeg" alt="Investments">
            <h3>Investments</h3>
            <a href="investments.php"><button><i class="fa-solid fa-magnifying-glass"></i> Explore</button></a>
        </div>

    </section>

    <!-- Welcome Content Section -->
    <section class="welcome">
        <div class="welcome-content">
            <h1>Welcome to Enomy-Finances </h1>
            <p>At Enomy-Finances, we are committed to helping you achieve your financial goals with ease and </p>
            <p>confidence. Whether you are looking to secure a mortgage, save for the future, take out a loan, or </p>
            <p>make investments, we offer a wide range of services tailored to meet your unique needs. Our team </p>
            <p>of financial experts is dedicated to providing you with personalized advice and innovative solutions </p>
            <p>that empower you to make informed decisions about your financial journey. Join us today and take </p>
            <p>the first step toward a brighter financial future.</p>
        </div>
        <div class="welcome-image">
            <img src="Images/Welcome.webp" alt="Finance">
        </div>
    </section>
</main>
    <!-- Footer Section -->
    <footer>
        <div class="footer-left">
            <ul>
                <h3>Services</h3>
                <li><a href="mortgages.php">Mortgages</a></li>
                <li><a href="savings.php">Savings</a></li>
                <li><a href="loans.php">Loans</a></li>
                <li><a href="investments.php">Investments</a></li>
            </ul>
            <ul>
                <h3>Company</h3>
                <li><a href="about-us.php">About Us</a></li>
                <li><a href="contact-us.php">Contact Us</a></li>
            </ul>
            <ul>
                <h3>Find Us on Social Media</h3>
                <li><a href="#"><i class="fa-brands fa-instagram"></i> Instagram</a></li>
                <li><a href="#"><i class="fa-brands fa-twitter"></i> X (formerly Twitter)</a></li>
                <li><a href="#"><i class="fa-brands fa-facebook"></i> Facebook</a></li>
                <li><a href="#"><i class="fa-brands fa-linkedin-in"></i> LinkedIn</a></li>
            </ul>
            <ul>
                <h3>Useful Links</h3>
                <li><a href="TermsOfUse.php">Terms of Use</a></li>
                <li><a href="PrivacyPolicy.php">Privacy Policy</a></li>
                <li><a href="CookiePolicy.php">Cookie Policy</a></li>
            </ul>
        </div>
        <div class="footer-right">
            <p>&copy; Enomy-Finances 2025. All Rights Reserved.</p>
            <a href="home.php">
                <img src="Images/Logo.png" alt="Footer Logo" style="width: 100px; margin-top: 10px;">
            </a>
        </div>

    </footer>



    <script>
        let currentIndex = 0;
        const slides = document.querySelectorAll(".slide");

        function showNextImage() {
            // Hide the current image
            slides[currentIndex].style.opacity = 0;
            slides[currentIndex].style.display = 'none'; // Hide the image by setting display to none

            // Update the index to the next image
            currentIndex = (currentIndex + 1) % slides.length;

            // Show the next image
            slides[currentIndex].style.opacity = 1;
            slides[currentIndex].style.display = 'block'; // Show the image by setting display to block
        }

        // Initialize the first image to be visible
        slides[currentIndex].style.display = 'block';
        slides[currentIndex].style.opacity = 1;

        // Run the slider every 5 seconds
        setInterval(showNextImage, 5000);





    </script>
</body>
</html>
