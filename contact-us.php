<?php
session_start();
require 'db_connection.php';

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$feedback_message = "";

if (isset($_POST['submit'])) {
    // Collect form data
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $message = mysqli_real_escape_string($conn, $_POST['message']);

    // Insert into the database
    $query = "INSERT INTO contact_form (name, email, message) VALUES ('$name', '$email', '$message')";

    if (mysqli_query($conn, $query)) {
        $feedback_message = "<div class='success'>Your message has been sent successfully.</div>";
    } else {
        $feedback_message = "<div class='error'>Error: " . mysqli_error($conn) . "</div>";
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ecomy Finance</title>
    <link rel="stylesheet" href="contact-us.css">
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
        <div class="contact-us">
            <h1>GET IN TOUCH</h1>

            <div class="contact-image">
                <img src="Images/Contatct Us.png" alt="Contact Us" class="contact-img">
            </div>
            <hr>
            <p>If you have any questions or need assistance, feel free to reach out to us. We would love to hear from you!</p>

            <!-- Contact Form -->
            <form action="contact-us.php" method="POST" class="contact-form">
                <label for="name">Full Name</label>
                <input type="text" id="name" name="name" required placeholder="Your Full Name">

                <label for="email">Email Address</label>
                <input type="email" id="email" name="email" required placeholder="Your Email Address">

                <label for="message">Message</label>
                <textarea id="message" name="message" rows="4" required placeholder="Your Message"></textarea>

                <button type="submit" name="submit" class="submit-btn">Send Message</button>

                <!-- Display feedback message -->
                <?php if (!empty($feedback_message)): ?>
                    <div class="feedback">
                        <?php echo $feedback_message; ?>
                    </div>
                <?php endif; ?>
            </form>
        </div>
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
</body>
</html>
