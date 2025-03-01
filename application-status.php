<?php
session_start();
require 'db_connection.php'; // Include the database connection

// Ensure the database connection is established
if (!$conn) {
    die("Database connection is not established.");
}

// Check if the user is logged in
if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit;
}

// Get the logged-in user's email
$user_email = $_SESSION['email'];

// Get filter values from GET parameters
$application_type = $_GET['application_type'] ?? '';
$status = $_GET['status'] ?? '';

// Prepare the base query
$query = '';
$params = [];
$types = ''; // Types for prepared statement parameters

if ($application_type === 'savings') {
    $query = "SELECT * FROM savings_applications WHERE email = ?";
    $params[] = $user_email;
    $types .= 's';
} elseif ($application_type === 'mortgage') {
    $query = "SELECT * FROM mortgage_applications WHERE email = ?";
    $params[] = $user_email;
    $types .= 's';
} elseif ($application_type === 'loan') {
    $query = "SELECT * FROM loan_applications WHERE email = ?";
    $params[] = $user_email;
    $types .= 's';
} elseif ($application_type === 'investment') {
    $query = "SELECT * FROM investment_data WHERE email = ?";
    $params[] = $user_email;
    $types .= 's';
} else {
    // Default: show all application types for the logged-in user
    $query = "SELECT * FROM (
        SELECT id, status, 'savings' AS application_type FROM savings_applications WHERE email = ?
        UNION ALL
        SELECT id, status, 'mortgage' AS application_type FROM mortgage_applications WHERE email = ?
        UNION ALL
        SELECT id, status, 'loan' AS application_type FROM loan_applications WHERE email = ?
        UNION ALL
        SELECT id, status, 'investment' AS application_type FROM investment_data WHERE email = ?
    ) AS combined";
    $params = array_fill(0, 4, $user_email);
    $types = 'ssss';
}

// Add status filter if applied
if (!empty($status)) {
    $query .= $application_type ? " AND status = ?" : " WHERE status = ?";
    $params[] = $status;
    $types .= 's';
}

// Prepare and execute the query
$stmt = $conn->prepare($query);
if ($stmt === false) {
    die("Query preparation failed: " . $conn->error);
}
$stmt->bind_param($types, ...$params);
$stmt->execute();
$result = $stmt->get_result();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ecomy Finance</title>
    <link rel="stylesheet" href="application-status.css">
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

<!-- Application Status Content -->
<main>
    <!-- Filter Bar -->
    <form method="GET" action="application-status.php" class="filter-bar">
        <label for="application_type">Application Type:</label>
        <select name="application_type" id="application_type">
            <option value="">All</option>
            <option value="savings" <?php if ($application_type === 'savings') echo 'selected'; ?>>Savings</option>
            <option value="mortgage" <?php if ($application_type === 'mortgage') echo 'selected'; ?>>Mortgage</option>
            <option value="loan" <?php if ($application_type === 'loan') echo 'selected'; ?>>Loan</option>
            <option value="investment" <?php if ($application_type === 'investment') echo 'selected'; ?>>Investment</option>
        </select>

        <label for="status">Status:</label>
        <select name="status" id="status">
            <option value="">All</option>
            <option value="Pending" <?php if ($status === 'Pending') echo 'selected'; ?>>Pending</option>
            <option value="Approved" <?php if ($status === 'Approved') echo 'selected'; ?>>Approved</option>
            <option value="Rejected" <?php if ($status === 'Rejected') echo 'selected'; ?>>Rejected</option>
        </select>

        <button type="submit">Filter</button>
    </form>

    <!-- Application Cards -->
    <div class="applications">
        <?php if ($result && $result->num_rows > 0): ?>
            <?php while ($row = $result->fetch_assoc()): ?>
                <div class="card">
                    <h3>Application ID: <?php echo htmlspecialchars($row['id']); ?></h3>
                    <?php foreach ($row as $key => $value): ?>
                        <div class="field">
                            <span><?php echo htmlspecialchars(ucwords(str_replace('_', ' ', $key))); ?>:</span>
                            <?php echo htmlspecialchars($value); ?>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p>No applications found.</p>
        <?php endif; ?>
    </div>
</main>
<br>
<br>

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
