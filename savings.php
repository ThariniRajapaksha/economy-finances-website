<?php
session_start();
require 'db_connection.php';
$fullname = $_SESSION['fullname'];
$email = $_SESSION['email'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get form data
    $fullname = $_POST['fullname'];
    $gender = $_POST['gender'];
    $dob = $_POST['dob'];
    $marital_status = $_POST['marital_status'];
    $nic_passport = $_POST['nic_passport'];
    $address = $_POST['address'];
    $email = $_POST['email'];
    $postal_code = $_POST['postal_code'];
    $nationality = $_POST['nationality'];
    $contact_number = $_POST['contact_number'];
    $account_type = $_POST['account_type'];

    // Check if the account type is Joint, and get joint account holder details
    $joint_fullname = ($account_type === 'Joint') ? $_POST['joint_fullname'] : null;
    $joint_contact_number = ($account_type === 'Joint') ? $_POST['joint_contact_number'] : null;

    // File upload handling
    $upload_dir = 'C:/xampp/htdocs/Tharini Rajapaksha (00238334) SDLC/uploads/';

    // Check if the directory exists, if not create it
    if (!file_exists($upload_dir)) {
        mkdir($upload_dir, 0777, true); // Create the directory with permissions
    }

    // File Uploads - Capture the full file paths for each upload
    $id_document = $upload_dir . basename($_FILES['id_document']['name']);
    $address_proof = $upload_dir . basename($_FILES['address_proof']['name']);
    $tax_information = $upload_dir . basename($_FILES['tax_information']['name']);

    $upload_success = true;

    // Move the uploaded files to the specified directory
    if (!move_uploaded_file($_FILES['id_document']['tmp_name'], $id_document)) {
        $upload_success = false;
        echo "<script>alert('Error uploading ID Proof file.');</script>";
    }

    if (!move_uploaded_file($_FILES['address_proof']['tmp_name'], $address_proof)) {
        $upload_success = false;
        echo "<script>alert('Error uploading Address Proof file.');</script>";
    }

    if (!move_uploaded_file($_FILES['tax_information']['tmp_name'], $tax_information)) {
        $upload_success = false;
        echo "<script>alert('Error uploading Income Proof file.');</script>";
    }

    // Prepare SQL query to insert application
    if ($upload_success) {
        if ($account_type === 'Joint') {
            $sql = "INSERT INTO savings_applications (fullname, gender, dob, marital_status, nic_passport, address, email, postal_code, nationality, contact_number, account_type, joint_fullname, joint_contact_number, id_document, address_proof, tax_information) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ssssssssssssssss", $fullname, $gender, $dob, $marital_status, $nic_passport, $address, $email, $postal_code, $nationality, $contact_number, $account_type, $joint_fullname, $joint_contact_number, $id_document, $address_proof, $tax_information);
        } else {
            $sql = "INSERT INTO savings_applications (fullname, gender, dob, marital_status, nic_passport, address, email, postal_code, nationality, contact_number, account_type, id_document, address_proof, tax_information) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ssssssssssssss", $fullname, $gender, $dob, $marital_status, $nic_passport, $address, $email, $postal_code, $nationality, $contact_number, $account_type, $id_document, $address_proof, $tax_information);
        }

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
    <link rel="stylesheet" href="savings.css">
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
    <div class="savings-section">
        <!-- Add an Image -->
        <img src="Images/Savings.jpg" alt="General Saving Account" class="savings-image">
        <!-- General Saving Account Header -->
        <h1>General Saving Account</h1>
        <p>Our General Saving Account offers a range of benefits for individuals and joint accounts. Enjoy competitive interest rates, secure access to your funds, and personalized services to help you manage your savings effectively.</p>
        <hr>
        <!-- Savings Account Types -->
        <h2>Our Savings Account Types</h2>
        <div class="account-types">
            <div class="account-type">
                <i class="fas fa-piggy-bank fa-3x"></i>
                <h3>Standard Savings Account</h3>
                <p>This account offers competitive interest rates with easy access to your funds. Ideal for those looking for a simple savings account with no frills.</p>
            </div>
            <div class="account-type">
                <i class="fas fa-gem fa-3x"></i>
                <h3>Premium Savings Account</h3>
                <p>Enjoy higher interest rates and personalized services with this account. Premium customers can also access dedicated customer support and additional benefits.</p>
            </div>
            <div class="account-type">
                <i class="fas fa-users fa-3x"></i>
                <h3>Joint Savings Account</h3>
                <p>A joint account for individuals looking to manage savings together. Suitable for families or business partners who want to share financial goals and account access.</p>
            </div>
            <div class="account-type">
                <i class="fas fa-graduation-cap fa-3x"></i>
                <h3>Student Savings Account</h3>
                <p>Specially designed for students, this account offers low fees and higher interest rates. Perfect for managing funds during your education years.</p>
            </div>
        </div>

        <hr>
        <!-- Key Features -->
        <h2>Key Features</h2>
        <div class="key-features">
            <div class="feature">
                <i class="fa-solid fa-percent"></i>
                <p>High interest rates on savings.</p>
            </div>
            <div class="feature">
                <i class="fa-solid fa-unlock-alt"></i>
                <p>Easy access to your savings anytime.</p>
            </div>
            <div class="feature">
                <i class="fa-solid fa-cloud"></i>
                <p>24/7 online banking services.</p>
            </div>
            <div class="feature">
                <i class="fa-solid fa-user-cog"></i>
                <p>Personalized account management services.</p>
            </div>
        </div>
        <hr>
        <!-- Eligibility -->
        <h2>Eligibility</h2>
        <ul>
            <li>Sri Lankan Nationals / Foreigners over 18 years of age.</li>
            <li>Possess a valid National Identity Card or Passport.</li>
            <li>Residing in Sri Lanka.</li>
        </ul>
        <hr>
        <!-- Requirements -->
        <h2>Requirements</h2>
        <ul>
            <li>Minimum deposit of LKR 1000 to open the account.</li>
            <li>Provide proof of residence and identity.</li>
            <li>Complete the application form.</li>
        </ul>
        <hr>
        <!-- Rate and Fees -->
        <h2>Rates and Fees</h2>
        <table class="rates-table">
            <tr>
                <th>Amount</th>
                <th>Interest Rate</th>
            </tr>
            <tr>
                <td>LKR 50,000 - 199,999.99</td>
                <td>3.0%</td>
            </tr>
            <tr>
                <td>LKR 200,000 - 499,999.99</td>
                <td>3.5%</td>
            </tr>
            <tr>
                <td>LKR 500,000 & above</td>
                <td>4.0%</td>
            </tr>
        </table>
        <hr>
        <!-- Apply Now Section -->
        <h2>Apply Now</h2>
        <form method="POST" action="" enctype="multipart/form-data">
            <!-- Form fields -->
            <label for="fullname">Full Name</label>
            <input type="text" id="fullname" name="fullname" value="<?php echo htmlspecialchars($fullname); ?>" readonly required>

            <label for="gender">Gender</label>
            <select name="gender" id="gender" required>
                <option value="Male">Male</option>
                <option value="Female">Female</option>
                <option value="Other">Other</option>
            </select>

            <label for="dob">Date of Birth</label>
            <input type="date" name="dob" id="dob" required>

            <label for="marital_status">Marital Status</label>
            <select name="marital_status" id="marital_status" required>
                <option value="Single">Single</option>
                <option value="Married">Married</option>
                <option value="Divorced">Divorced</option>
            </select>

            <label for="nic_passport">NIC/Passport Number</label>
            <input type="text" id="nic_passport" name="nic_passport" placeholder="e.g., 123456789V" required>

            <label for="address">Address</label>
            <input type="text" id="address" name="address" placeholder="Enter your address" required>

            <label for="email">Email</label>
            <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($email); ?>" readonly required>

            <label for="postal_code">Postal Code</label>
            <input type="text" id="postal_code" name="postal_code" placeholder="Enter your postal code" required>

            <label for="nationality">Nationality</label>
            <input type="text" id="nationality" name="nationality" placeholder="Enter your nationality" required>

            <label for="contact_number">Contact Number</label>
            <input type="tel" id="contact_number" name="contact_number" placeholder="e.g., +1 (234) 567-890" required pattern="^\+?\d{0,1}(\(?\d{1,4}\)?[-\s]?)?(\d{1,3}[-\s]?\d{1,4}[-\s]?\d{1,4})$">

            <label for="id_document">ID Document (e.g., NIC/Passport):</label>
            <input type="file" id="id_document" name="id_document" accept=".jpg,.jpeg,.png,.pdf" required>

            <label for="address_proof">Address Proof (e.g., utility bill):</label>
            <input type="file" id="address_proof" name="address_proof" accept=".jpg,.jpeg,.png,.pdf" required>

            <label for="tax_information">Tax Information (e.g., tax return):</label>
            <input type="file" id="tax_information" name="tax_information" accept=".jpg,.jpeg,.png,.pdf" required>

            <label for="account_type">Account Type</label>
            <select name="account_type" id="account_type" required>
                <option value="Standard">Standard Savings Account</option>
                <option value="Premium">Premium Savings Account</option>
                <option value="Joint">Joint Savings Account</option>
                <option value="Student">Student Savings Account</option>
            </select>

            <!-- Additional fields for Joint Account (if selected) -->
            <div id="joint-account-info" style="display:none;">
                <h3>Joint Account Holder Information</h3>
                <label for="joint_fullname">Joint Account Holder's Full Name</label>
                <input type="text" id="joint_fullname" name="joint_fullname" placeholder="Enter the joint account holder's name">
                
                <label for="joint_contact_number">Joint Account Holder's Contact Number</label>
                <input type="tel" id="joint_contact_number" name="joint_contact_number" placeholder="Enter joint account holder's contact number">
            </div>

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

    <script>
        // Show/Hide Joint Account Fields based on Account Type selection
        document.getElementById('account_type').addEventListener('change', function() {
            const jointFields = document.getElementById('joint-account-info');
            if (this.value === 'Joint') {
                jointFields.style.display = 'block';
            } else {
                jointFields.style.display = 'none';
            }
        });
    </script>

</body>
</html>
