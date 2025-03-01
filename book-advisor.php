<?php
session_start();
require 'db_connection.php';

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];
$success_message = $error_message = "";

// Fetch the client's details
$client_query = "SELECT fullname, email FROM client_register WHERE id = '$user_id'";
$client_result = mysqli_query($conn, $client_query);
$client_data = mysqli_fetch_assoc($client_result);

$fullname = mysqli_real_escape_string($conn, $client_data['fullname']);
$email = mysqli_real_escape_string($conn, $client_data['email']);

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get form inputs
    $advisor_id = mysqli_real_escape_string($conn, $_POST['advisor_id']);
    $appointment_date = mysqli_real_escape_string($conn, $_POST['appointment_date']);
    $appointment_time = mysqli_real_escape_string($conn, $_POST['appointment_time']);
    $message = mysqli_real_escape_string($conn, $_POST['message']);

    // Insert the booking into the database
    $insert_query = "INSERT INTO advisor_bookings (user_id, advisor_id, fullname, email, appointment_date, appointment_time, message)
                 VALUES ('$user_id', '$advisor_id', '$fullname', '$email', '$appointment_date', '$appointment_time', '$message')";
                     
    if ($conn->query($insert_query) === TRUE) {
        $success_message = "Appointment booked successfully.";
    } else {
        $error_message = "Error booking appointment: " . $conn->error;
    }
}

// Fetch the list of advisors (you can adjust this based on your advisors table)
$advisors_query = "SELECT id, fullname FROM advisors";
$advisors_result = mysqli_query($conn, $advisors_query);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ecomy Finance</title>
    <link rel="stylesheet" href="book-advisor.css">
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

<!-- Booking Page Content -->
    <main>
        <div class="section">
            <h1><i class="fa-solid fa-users"></i> Book a Personal Financial Advisor</h1>
            <img src="Images/Book Advisor.png" alt="Image" class="advisor-image">
            <p>Easily connect with a trusted personal financial advisor who can provide expert guidance tailored to your specific 
            goals and needs. Whether you’re planning for a secure future, managing debt, investing wisely, or saving for a 
            major milestone, our advisors are here to help you every step of the way. Simply select an advisor from our experienced 
            team, choose a convenient date and time for your meeting, and share any details or questions you’d like to discuss. 
            With personalized advice and a user-friendly booking process, taking control of your financial future has never been easier 
            or more convenient. Let us help you make informed decisions and achieve peace of mind with expert support designed just for you.</p>
            <form method="POST" action="book-advisor.php">
                <label for="advisor_id">Select Advisor:</label>
                <select name="advisor_id" id="advisor_id" required>
                    <?php while ($advisor = mysqli_fetch_assoc($advisors_result)): ?>
                        <option value="<?php echo $advisor['id']; ?>"><?php echo htmlspecialchars($advisor['fullname']); ?></option>
                    <?php endwhile; ?>
                </select>

                <label for="appointment_date">Appointment Date:</label>
                <input type="date" name="appointment_date" id="appointment_date" required>

                <label for="appointment_time">Appointment Time:</label>
                <input type="time" name="appointment_time" id="appointment_time" required>

                <label for="message">Message (optional):</label>
                <textarea name="message" id="message" placeholder="Any specific details?" rows="4"></textarea>

                <button type="submit">Book Appointment</button>

                <?php if ($success_message): ?>
                    <div class="success"><?php echo htmlspecialchars($success_message); ?></div>
                <?php elseif ($error_message): ?>
                    <div class="error"><?php echo htmlspecialchars($error_message); ?></div>
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
