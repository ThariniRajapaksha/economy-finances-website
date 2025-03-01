<?php
session_start();
require 'db_connection.php';
$fullname = $_SESSION['fullname'];
$email = $_SESSION['email'];

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Personal Information
    $fullname = $_POST['fullname'];
    $address = $_POST['address'];
    $gender = $_POST['gender'];
    $dob = $_POST['dob'];
    $email = $_POST['email'];
    $contact = $_POST['contact'];

    // Loan Details
    $loan_amount = $_POST['loan_amount'];
    $interest_rate = $_POST['interest_rate'];
    $loan_duration = $_POST['loan_duration'];

    // Additional Fields
    $property_address = $_POST['property_address'];
    $property_value = $_POST['property_value'];
    $down_payment = $_POST['down_payment'];
    $employment_status = $_POST['employment_status'];
    $employer_name = $_POST['employer_name'];
    $annual_income = $_POST['annual_income'];
    $additional_income = $_POST['additional_income'];
    $loan_purpose = $_POST['loan_purpose'];

    // Define the absolute upload directory path
    $upload_dir = 'C:/xampp/htdocs/Tharini Rajapaksha (00238334) SDLC/uploads/';

    // Check if the directory exists, if not create it
    if (!file_exists($upload_dir)) {
        mkdir($upload_dir, 0777, true); // Create the directory with permissions
    }

    // File Uploads - Capture the full file paths for each upload
    $id_proof = $upload_dir . basename($_FILES['id_proof']['name']);
    $address_proof = $upload_dir . basename($_FILES['address_proof']['name']);
    $income_proof = $upload_dir . basename($_FILES['income_proof']['name']);
    $property_documents = $upload_dir . basename($_FILES['property_documents']['name']);

    // Move the uploaded files to the specified directory
    $upload_success = true;

    if (!move_uploaded_file($_FILES['id_proof']['tmp_name'], $id_proof)) {
        $upload_success = false;
        echo "<script>alert('Error uploading ID Proof file.');</script>";
    }

    if (!move_uploaded_file($_FILES['address_proof']['tmp_name'], $address_proof)) {
        $upload_success = false;
        echo "<script>alert('Error uploading Address Proof file.');</script>";
    }

    if (!move_uploaded_file($_FILES['income_proof']['tmp_name'], $income_proof)) {
        $upload_success = false;
        echo "<script>alert('Error uploading Income Proof file.');</script>";
    }

    if (!move_uploaded_file($_FILES['property_documents']['tmp_name'], $property_documents)) {
        $upload_success = false;
        echo "<script>alert('Error uploading Property Documents file.');</script>";
    }

    // If files uploaded successfully, proceed with inserting into the database
    if ($upload_success) {
        // SQL Query to insert the form data into the database
        $sql = "INSERT INTO mortgage_applications 
            (fullname, address, gender, dob, email, contact, loan_amount, interest_rate, loan_duration, 
            property_address, property_value, down_payment, employment_status, employer_name, annual_income, 
            additional_income, loan_purpose, id_proof, address_proof, income_proof, property_documents) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

        // Prepare and bind parameters to the SQL query
        $stmt = $conn->prepare($sql);
        $stmt->bind_param(
            "ssssssssdsdssssssssss",
            $fullname, $address, $gender, $dob, $email, $contact, $loan_amount, $interest_rate, $loan_duration,
            $property_address, $property_value, $down_payment, $employment_status, $employer_name, $annual_income,
            $additional_income, $loan_purpose, $id_proof, $address_proof, $income_proof, $property_documents
        );

        // Execute the query and check for success
        if ($stmt->execute()) {
            echo "<script>alert('Application submitted successfully!');</script>";
        } else {
            echo "<script>alert('Error submitting application.');</script>";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ecomy Finance</title>
    <link rel="stylesheet" href="mortgages.css">
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
<div class="mortgage-section">
        <img src="Images/Mortgage.avif" alt="Mortgage Image" class="mortgage-image">
        <h1>Mortgage</h1>
        <p>
            Mortgage loans can be obtained for any valid purpose with the provision of a security with a deed. You can also be eligible if you meet the basic fundamental housing requirements as deemed realistic in society, a real estate value of suitable value, or any developments that you may have had in the real estate market. Enjoy this facility that brings you a low and competitive interest rate, and approvals within a significantly short period of time.
        </p>
        <hr>
        <h2>Eligibility</h2>
        <ul>
            <li>Sri Lankan Nationals / Foreigners over 18 years of age, holding a valid National Identity Card/valid passport and residing in Sri Lanka.</li>
            <li>Easy loans for repairing your home, building a new home, purchasing or adding an extension to your home, or purchasing land.</li>
            <li>Lowest payment rates & longest payment periods.</li>
            <li>Overseas working professionals can obtain loans based on foreign earnings and build their dream home in Sri Lanka.</li>
            <li>Maximum support in fulfilling legal and other formalities.</li>
            <li>Minimum red tape and quick service.</li>
            <li>Fast approval process.</li>
        </ul>
        <hr>
        <h2>Apply Now</h2>
        <form method="POST" action="" enctype="multipart/form-data">
            <!-- Personal Information -->
            <label for="fullname">Full Name</label>
            <input type="text" id="fullname" name="fullname" value="<?php echo htmlspecialchars($fullname); ?>" readonly required>

            <label>Address</label>
            <input type="text" name="address" required>

            <label>Gender</label>
            <select name="gender" required>
                <option value="Male">Male</option>
                <option value="Female">Female</option>
                <option value="Other">Other</option>
            </select>

            <label>Date of Birth</label>
            <input type="date" name="dob" required>

            <label for="email">Email</label>
            <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($email); ?>" readonly required>

            <label>Contact</label>
            <input type="text" name="contact" required>

            <!-- Loan Details -->
            <label>Loan Amount</label>
            <input type="number" name="loan_amount" required>

            <label>Interest Rate (%)</label>
            <input type="number" step="0.01" name="interest_rate" required>

            <label>Loan Duration (in months)</label>
            <input type="number" name="loan_duration" required>

            <!-- Additional Mortgage Fields -->
            <label>Property Address</label>
            <input type="text" name="property_address" required>

            <label>Property Value</label>
            <input type="number" name="property_value" required>

            <label>Down Payment</label>
            <input type="number" name="down_payment" required>

            <label>Employment Status</label>
            <select name="employment_status" required>
                <option value="Employed">Employed</option>
                <option value="Self-Employed">Self-Employed</option>
                <option value="Unemployed">Unemployed</option>
            </select>

            <label>Employer Name (if applicable)</label>
            <input type="text" name="employer_name">

            <label>Annual Income</label>
            <input type="number" name="annual_income" required>

            <label>Additional Income Sources (if applicable)</label>
            <input type="text" name="additional_income">

            <label>Purpose of Loan</label>
            <select name="loan_purpose" required>
                <option value="Purchase">Purchase</option>
                <option value="Refinance">Refinance</option>
                <option value="Renovation">Renovation</option>
            </select>

            <!-- File Uploads -->
            <label>ID or Passport</label>
            <input type="file" name="id_proof" required>

            <label>Address Proof</label>
            <input type="file" name="address_proof" required>

            <label>Income Proof</label>
            <input type="file" name="income_proof" required>

            <label>Property Documents</label>
            <input type="file" name="property_documents" required>

            <div class="form-buttons">
                <button type="reset">Reset</button>
                <button type="submit">Submit</button>
            </div>
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
