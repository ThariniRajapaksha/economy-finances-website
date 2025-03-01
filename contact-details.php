<?php
session_start();
require 'db_connection.php';  // Include database connection

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

// Initialize success/error messages
$success_message = "";
$error_message = "";

// Check if form is submitted to save client profile details
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Retrieve form data
    $title = $_POST['title'];
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $dob = $_POST['dob'];
    $marital_status = $_POST['marital_status'];
    $dependents = $_POST['dependents'];
    $nationality = $_POST['nationality'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];
    $city = $_POST['city'];
    $zip = $_POST['zip'];
    $user_id = $_SESSION['user_id'];  // Assuming the user is logged in and their user ID is stored in the session

    // Check if a profile already exists for the logged-in user
    $stmt = $conn->prepare("SELECT id FROM client_profiles WHERE user_id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Profile exists, perform an update
        $stmt = $conn->prepare("UPDATE client_profiles SET 
            title = ?, first_name = ?, last_name = ?, dob = ?, marital_status = ?, 
            dependents = ?, nationality = ?, email = ?, phone = ?, address = ?, city = ?, zip = ? 
            WHERE user_id = ?");
        $stmt->bind_param("ssssssssssssi", $title, $first_name, $last_name, $dob, $marital_status, $dependents, $nationality, $email, $phone, $address, $city, $zip, $user_id);
    } else {
        // Profile doesn't exist, insert a new one
        $stmt = $conn->prepare("INSERT INTO client_profiles 
        (user_id, title, first_name, last_name, dob, marital_status, dependents, nationality, email, phone, address, city, zip) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("issssssssssss", $user_id, $title, $first_name, $last_name, $dob, $marital_status, $dependents, $nationality, $email, $phone, $address, $city, $zip);
    }

    if ($stmt->execute()) {
        $success_message = "Your profile has been successfully updated!";
    } else {
        $error_message = "Error: " . $stmt->error;
    }
    $stmt->close();
}

// Fetch the saved profile for the logged-in user
$stmt = $conn->prepare("SELECT * FROM client_profiles WHERE user_id = ?");
$stmt->bind_param("i", $_SESSION['user_id']);
$stmt->execute();
$result = $stmt->get_result();

// Check if any data was retrieved
if ($result->num_rows > 0) {
    $client = $result->fetch_assoc();
} else {
    $client = null;  // No data found
}
$stmt->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ecomy Finance</title>
    <link rel="stylesheet" href="contact-details.css">
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
    <div class="profile-container">
        <div class="profile-details">
            <h1><i class="fa-solid fa-circle-user"></i> Client Profile</h1>
            <section class="profile-section">
                <h2>Personal Information</h2>
                <?php if ($client): ?>
                    <div class="profile-field">
                        <label>Title:</label>
                        <span><?php echo htmlspecialchars($client['title']); ?></span>
                    </div>
                    <div class="profile-field">
                        <label>First Name:</label>
                        <span><?php echo htmlspecialchars($client['first_name']); ?></span>
                    </div>
                    <div class="profile-field">
                        <label>Last Name:</label>
                        <span><?php echo htmlspecialchars($client['last_name']); ?></span>
                    </div>
                    <div class="profile-field">
                        <label>Date of Birth:</label>
                        <span><?php echo htmlspecialchars($client['dob']); ?></span>
                    </div>
                    <div class="profile-field">
                        <label>Marital Status:</label>
                        <span><?php echo htmlspecialchars($client['marital_status']); ?></span>
                    </div>
                    <div class="profile-field">
                        <label>Dependents:</label>
                        <span><?php echo htmlspecialchars($client['dependents']); ?></span>
                    </div>
                    <div class="profile-field">
                        <label>Nationality:</label>
                        <span><?php echo htmlspecialchars($client['nationality']); ?></span>
                    </div>
                <?php else: ?>
                    <p>No profile data available. Please complete your profile.</p>
                <?php endif; ?>
            </section>

            <section class="profile-section">
                <h2>Contact Information</h2>
                <?php if ($client): ?>
                    <div class="profile-field">
                        <label>Email Address:</label>
                        <span><?php echo htmlspecialchars($client['email']); ?></span>
                    </div>
                    <div class="profile-field">
                        <label>Phone Number:</label>
                        <span><?php echo htmlspecialchars($client['phone']); ?></span>
                    </div>
                    <div class="profile-field">
                        <label>Address:</label>
                        <span><?php echo htmlspecialchars($client['address']); ?></span>
                    </div>
                    <div class="profile-field">
                        <label>City:</label>
                        <span><?php echo htmlspecialchars($client['city']); ?></span>
                    </div>
                    <div class="profile-field">
                        <label>Postal Code:</label>
                        <span><?php echo htmlspecialchars($client['zip']); ?></span>
                    </div>
                <?php else: ?>
                    <p>No contact data available. Please complete your profile.</p>
                <?php endif; ?>
            </section>

            <!-- Update Form -->
            <section class="update-form-section">
                <h2>Update Your Information</h2>
                <form method="POST" action="contact-details.php">
                    <fieldset>
                        <legend>Personal Details</legend>
                        <label for="title">Title:</label>
                        <select name="title" id="title" required>
                            <option value="Mr" <?php echo isset($client['title']) && $client['title'] == 'Mr' ? 'selected' : ''; ?>>Mr</option>
                            <option value="Ms" <?php echo isset($client['title']) && $client['title'] == 'Ms' ? 'selected' : ''; ?>>Ms</option>
                            <option value="Mrs" <?php echo isset($client['title']) && $client['title'] == 'Mrs' ? 'selected' : ''; ?>>Mrs</option>
                            <option value="Dr" <?php echo isset($client['title']) && $client['title'] == 'Dr' ? 'selected' : ''; ?>>Dr</option>
                            <option value="Prof" <?php echo isset($client['title']) && $client['title'] == 'Prof' ? 'selected' : ''; ?>>Prof</option>
                        </select>

                        <label for="first_name">First Name:</label>
                        <input type="text" name="first_name" id="first_name" value="<?php echo isset($client['first_name']) ? htmlspecialchars($client['first_name']) : ''; ?>" required>

                        <label for="last_name">Last Name:</label>
                        <input type="text" name="last_name" id="last_name" value="<?php echo isset($client['last_name']) ? htmlspecialchars($client['last_name']) : ''; ?>" required>

                        <label for="dob">Date of Birth:</label>
                        <input type="date" name="dob" id="dob" value="<?php echo isset($client['dob']) ? htmlspecialchars($client['dob']) : ''; ?>" required>

                        <label for="marital_status">Marital Status:</label>
                        <select name="marital_status" id="marital_status" required>
                            <option value="Single" <?php echo isset($client['marital_status']) && $client['marital_status'] == 'Single' ? 'selected' : ''; ?>>Single</option>
                            <option value="Married" <?php echo isset($client['marital_status']) && $client['marital_status'] == 'Married' ? 'selected' : ''; ?>>Married</option>
                            <option value="Divorced" <?php echo isset($client['marital_status']) && $client['marital_status'] == 'Divorced' ? 'selected' : ''; ?>>Divorced</option>
                            <option value="Widowed" <?php echo isset($client['marital_status']) && $client['marital_status'] == 'Widowed' ? 'selected' : ''; ?>>Widowed</option>
                        </select>

                        <label for="dependents">Dependents:</label>
                        <input type="number" name="dependents" id="dependents" value="<?php echo isset($client['dependents']) ? htmlspecialchars($client['dependents']) : ''; ?>" required>

                        <label for="nationality">Nationality:</label>
                        <input type="text" name="nationality" id="nationality" value="<?php echo isset($client['nationality']) ? htmlspecialchars($client['nationality']) : ''; ?>" required>
                    </fieldset>

                    <fieldset>
                        <legend>Contact Details</legend>
                        <label for="email">Email Address:</label>
                        <input type="email" name="email" id="email" value="<?php echo isset($client['email']) ? htmlspecialchars($client['email']) : ''; ?>" required>

                        <label for="phone">Phone Number:</label>
                        <input type="tel" name="phone" id="phone" value="<?php echo isset($client['phone']) ? htmlspecialchars($client['phone']) : ''; ?>" required>

                        <label for="address">Address:</label>
                        <textarea name="address" id="address" rows="2" required><?php echo isset($client['address']) ? htmlspecialchars($client['address']) : ''; ?></textarea>

                        <label for="city">City:</label>
                        <input type="text" name="city" id="city" value="<?php echo isset($client['city']) ? htmlspecialchars($client['city']) : ''; ?>" required>

                        <label for="zip">Postal Code:</label>
                        <input type="text" name="zip" id="zip" value="<?php echo isset($client['zip']) ? htmlspecialchars($client['zip']) : ''; ?>" required>
                    </fieldset>

                    <button type="submit" class="btn-submit">Update Profile</button>

                    <!-- Success/Error Messages -->
                    <?php if (!empty($success_message) || !empty($error_message)): ?>
                        <div class="message <?php echo !empty($success_message) ? 'success' : 'error'; ?>">
                            <?php echo !empty($success_message) ? htmlspecialchars($success_message) : htmlspecialchars($error_message); ?>
                        </div>
                    <?php endif; ?>
                        </form>
            </section>
        </div>
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
