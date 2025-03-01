<?php
session_start();
require 'db_connection.php';
$fullname = $_SESSION['fullname'];
$email = $_SESSION['email'];

// Define the absolute upload directory path
$upload_dir = 'C:/xampp/htdocs/Tharini Rajapaksha (00238334) SDLC/uploads/';

// Check if the directory exists, if not create it
if (!file_exists($upload_dir)) {
    mkdir($upload_dir, 0777, true); // Create the directory with permissions
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get POST data
    $fullname = $_POST['fullname'];
    $gender = $_POST['gender'];
    $dob = $_POST['dob'];
    $nationality = $_POST['nationality'];
    $nic_passport = $_POST['nic_passport'];
    $marital_status = $_POST['marital_status'];
    $address = $_POST['address'];
    $postal_code = $_POST['postal_code'];
    $contact_number = $_POST['contact_number'];
    $occupation = $_POST['occupation'];
    $email = $_POST['email'];
    $loan_type = $_POST['loan_type'];
    $loan_amount = $_POST['loan_amount'];
    $repayment_period = $_POST['repayment_period'];
    $purpose = $_POST['purpose'];
    $monthly_income = $_POST['monthly_income'] ?? null; // Optional field
    $guarantor_name = $_POST['guarantor_name'] ?? null; // Optional field
    $guarantor_contact = $_POST['guarantor_contact'] ?? null; // Optional field

    // File Uploads - Capture the full file paths for each upload
    $id_document = $upload_dir . basename($_FILES['id_proof']['name']);
    $address_proof = $upload_dir . basename($_FILES['address_proof']['name']);
    $income_proof = $upload_dir . basename($_FILES['income_proof']['name']);

    // Move the uploaded files to the specified directory
    $upload_success = true;

    if (!move_uploaded_file($_FILES['id_proof']['tmp_name'], $id_document)) {
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

    if ($upload_success) {
        // Insert form data into the database
        $query = "INSERT INTO loan_applications (fullname, gender, dob, nationality, nic_passport, marital_status, address, postal_code, contact_number, occupation, email, loan_type, loan_amount, repayment_period, purpose, id_proof, address_proof, income_proof, monthly_income, guarantor_name, guarantor_contact) 
                  VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

        if ($stmt = $conn->prepare($query)) {
            $stmt->bind_param("ssssssssssssdsdssssss", $fullname, $gender, $dob, $nationality, $nic_passport, $marital_status, $address, $postal_code, $contact_number, $occupation, $email, $loan_type, $loan_amount, $repayment_period, $purpose, $id_document, $address_proof, $income_proof, $monthly_income, $guarantor_name, $guarantor_contact);
            
            if ($stmt->execute()) {
                echo "<script>alert('Loan application submitted successfully!'); window.location.href = 'loans.php';</script>";
            } else {
                echo "<script>alert('Error submitting the application. Please try again.');</script>";
            }
        } else {
            echo "<script>alert('Error preparing the SQL query.');</script>";
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
    <link rel="stylesheet" href="loans.css">
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
    <!-- Image after header -->
    <img src="Images/Loan.webp" alt="Loan Image" class="loan-image">
    <!-- Loan Info Section -->
        <h1>Loan Services & Application</h1>
        <p>
        Focusing on providing a fast, financial solution especially for salaried employees to meet their numerous personal financial needs, the Relax Personal Loan financially aids customers to achieve their goals. The loan covers everything from funding education, family functions and travel expenses, to weddings, purchase of vehicles, settlement of personal debts, etc. We are ready to offer you a hassle-free group loan or an individual loan depending on your requirements.
        </p>
        <hr>
        <!-- Loan Types -->
        <h2>Our Loan Types</h2>
        <div class="loan-types">
            <div class="loan-type">
                <i class="fas fa-user fa-3x"></i>
                <h3>Personal Loan</h3>
                <p>Whether it's for debt consolidation, home improvements, or unexpected expenses, our personal loans offer flexible terms with low interest rates to help you meet your financial goals.</p>
            </div>
            <div class="loan-type">
                <i class="fas fa-building fa-3x"></i>
                <h3>Business Loan</h3>
                <p>Get the funding you need to grow your business with a business loan. We offer competitive interest rates and flexible repayment options to support your business’s expansion and development.</p>
            </div>
        </div>
        <hr>
    <!-- Key Features Section -->
        <h2>Key Features</h2>
        <ul>
            <li>Quick and Easy Process</li>
            <li>Low Interest Rates</li>
            <li>Flexible Repayment Plans</li>
            <li>Attractive Loan Amounts</li>
            <li>Hassle-free Application Process</li>
        </ul>
        <hr>
    <!-- Eligibility Section -->
        <h2>Eligibility</h2>
        <p>Customers with a satisfactory CRIB and with adequate repayment capacity, between the ages of 24-50 are eligible to apply for this loan.</p>
        <hr>
    <!-- Requirements Section -->
        <h2>Requirements</h2>
        <ul>
            <li>Employer’s Letter of Confirmation</li>
            <li>Registered Primary Mortgage over Residential Property</li>
            <li>2 Acceptable Guarantors or Mortgage</li>
        </ul>
        <hr>
    <!-- Rates and Fees Section -->
        <h2>Rates and Fees</h2>
        <table>
            <thead>
                <tr>
                    <th>Loan Type</th>
                    <th>Interest Rate</th>
                    <th>Processing Fee</th>
                    <th>Late Payment Fee</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Personal Loan</td>
                    <td>8.5%</td>
                    <td>1% of Loan Amount</td>
                    <td>5% of Pending Amount</td>
                </tr>
                <tr>
                    <td>Business Loan</td>
                    <td>10%</td>
                    <td>2% of Loan Amount</td>
                    <td>6% of Pending Amount</td>
                </tr>
            </tbody>
        </table>
        <hr>
    <!-- Application Form Section -->
        <h2>Get a Loan Apply Now!</h2>
        <form action="" method="POST" enctype="multipart/form-data">
            <h3>Personal Information</h3>
            <label for="fullname">Full Name</label>
            <input type="text" id="fullname" name="fullname" value="<?php echo htmlspecialchars($fullname); ?>" readonly required>

            <label for="gender">Gender:</label>
            <select id="gender" name="gender" required>
                <option value="Male">Male</option>
                <option value="Female">Female</option>
            </select>

            <label for="dob">Date of Birth:</label>
            <input type="date" id="dob" name="dob" required>

            <label for="nationality">Nationality:</label>
            <input type="text" id="nationality" name="nationality" required>

            <label for="nic_passport">NIC/Passport:</label>
            <input type="text" id="nic_passport" name="nic_passport" required>

            <label for="marital_status">Marital Status:</label>
            <select id="marital_status" name="marital_status" required>
                <option value="Single">Single</option>
                <option value="Married">Married</option>
                <option value="Divorced">Divorced</option>
            </select>

            <label for="address">Address:</label>
            <textarea id="address" name="address" required></textarea>

            <label for="postal_code">Postal Code:</label>
            <input type="text" id="postal_code" name="postal_code" required>

            <label for="contact_number">Contact Number:</label>
            <input type="text" id="contact_number" name="contact_number" required>

            <label for="occupation">Business/Occupation:</label>
            <input type="text" id="occupation" name="occupation" required>

            <label for="email">Email</label>
            <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($email); ?>" readonly required>

            <h3>Loan Information</h3>
            <label for="loan_type">Loan Type:</label>
            <select id="loan_type" name="loan_type" required>
                <option value="Personal">Personal</option>
                <option value="Business">Business</option>
            </select>

            <label for="loan_amount">Loan Amount:</label>
            <input type="number" id="loan_amount" name="loan_amount" required>

            <label for="repayment_period">Period of Repayment (Months):</label>
            <input type="number" id="repayment_period" name="repayment_period" required>

            <label for="purpose">Purpose:</label>
            <textarea id="purpose" name="purpose" required></textarea>

            <h3>Documents Upload</h3>
            <label for="id_proof">Upload ID Proof:</label>
            <input type="file" id="id_proof" name="id_proof" accept=".jpg,.jpeg,.png,.pdf" required>

            <label for="address_proof">Upload Address Proof:</label>
            <input type="file" id="address_proof" name="address_proof" accept=".jpg,.jpeg,.png,.pdf" required>

            <label for="income_proof">Upload Income Proof:</label>
            <input type="file" id="income_proof" name="income_proof" accept=".jpg,.jpeg,.png,.pdf" required>

            <h3>Income & Guarantor (Optional)</h3>
            <label for="monthly_income">Monthly Income:</label>
            <input type="number" id="monthly_income" name="monthly_income">

            <label for="guarantor_name">Guarantor Name (if applicable):</label>
            <input type="text" id="guarantor_name" name="guarantor_name">

            <label for="guarantor_contact">Guarantor Contact:</label>
            <input type="text" id="guarantor_contact" name="guarantor_contact">

            <label for="terms">
                <input type="checkbox" id="terms" name="terms" required>
                I agree to the terms and conditions.
            </label>

            <div class="form-buttons">
                <button type="reset">Reset</button>
                <button type="submit">Submit</button>
            </div>
        </form>

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
