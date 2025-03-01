<?php
session_start();
require 'db_connection.php'; // Include the database connection

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    $_SESSION['error'] = 'You must be logged in to view your investment quote.';
    header('Location: login.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Capture form data
    $fullname = $_SESSION['fullname']; // Taken from session, cannot be changed by client
    $email = $_SESSION['email']; // Taken from session, cannot be changed by client
    $contact_number = $_POST['contact_number'];
    $address = $_POST['address'];
    $monthly_income = $_POST['monthly_income'];
    $guarantor_name = $_POST['guarantor_name'];
    $guarantor_contact = $_POST['guarantor_contact'];
    $client_id = $_SESSION['user_id'];
    $lump_sum = $_POST['lump_sum'];
    $monthly_investment = $_POST['monthly_investment'];
    $investment_type = $_POST['investment_type'];

    // Calculate quote (you can add more logic here based on the investment type)
    $one_year_min = $lump_sum + ($lump_sum * 0.012); // Example calculation for Basic Savings
    $one_year_max = $lump_sum + ($lump_sum * 0.024);
    $five_year_min = $lump_sum + ($lump_sum * 0.06);
    $five_year_max = $lump_sum + ($lump_sum * 0.10);
    $ten_year_min = $lump_sum + ($lump_sum * 0.12);
    $ten_year_max = $lump_sum + ($lump_sum * 0.23);

    // Example profit, fees, and tax calculation
    $profit = $five_year_max - $lump_sum;
    $fees = $profit * 0.0025; // Assuming a fee percentage
    $tax = $profit > 12000 ? ($profit - 12000) * 0.10 : 0; // Simple tax calculation

    // Insert data into the database
    $query = "INSERT INTO investment_data (fullname, email, contact_number, address, monthly_income, guarantor_name, guarantor_contact, client_id, lump_sum, monthly_investment, investment_type, one_year_min, one_year_max, five_year_min, five_year_max, ten_year_min, ten_year_max, profit, fees, tax) 
              VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($query);
    $stmt->bind_param("sssssssiddsdddddisss", $fullname, $email, $contact_number, $address, $monthly_income, $guarantor_name, $guarantor_contact, $client_id, $lump_sum, $monthly_investment, $investment_type, $one_year_min, $one_year_max, $five_year_min, $five_year_max, $ten_year_min, $ten_year_max, $profit, $fees, $tax);

    if ($stmt->execute()) {
        $message = "Your investment quote has been generated successfully.";
    } else {
        $message = "An error occurred while generating the quote.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ecomy Finance</title>
    <link rel="stylesheet" href="investments.css">
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

<!-- Main Section -->
<main>
    <div class="investment-form-container">
        <img src="Images/Invest.jpg" alt="General Saving Account" class="savings-image">
        <h1>Savings and Investments</h1>
        <p>An investment is the allocation of money or capital to an asset, venture, or financial product with the expectation of generating income or profit over time. Investments can range from stocks, bonds, mutual funds, real estate, and savings plans, to more complex assets like derivatives or private equity. The goal of any investment is to achieve returns, either in the form of capital gains (profit from asset appreciation) or income (such as dividends or interest). However, investments inherently carry a risk—the value of the asset may fluctuate, and the investor may not receive the expected returns.</p>
        
        <p>When it comes to investment plans, there are several options depending on the level of risk the investor is willing to take, the time frame, and the desired returns. Below are three common types of investment plans:</p>

        <h3>1. Basic Savings Plan</h3>
        <p>A Basic Savings Plan is a straightforward investment product that allows individuals to save money regularly and earn a fixed or variable interest over time. The primary objective of this plan is to preserve capital and provide a modest return. These plans typically have lower risks because they are less exposed to market fluctuations. The money invested in a basic savings plan is generally kept in a savings account or low-risk investment vehicle like certificates of deposit (CDs). This plan is ideal for individuals looking for a safe place to store their money while earning minimal interest. Returns from such investments are usually lower but offer a high level of security.</p>

        <h3>2. Savings Plan Plus</h3>
        <p>The Savings Plan Plus offers a more structured approach to savings and investments, usually combining both saving and growth elements. These plans are designed to offer higher returns than a basic savings plan by providing access to a wider range of financial products, such as low-risk stocks, bonds, or even real estate investments. While they still prioritize capital preservation, they offer greater potential for growth through diversified investments. This type of plan is ideal for individuals who want a balance between safety and growth potential. It might also include features such as higher interest rates, tax benefits, or additional services like financial advice and portfolio management.</p>

        <h3>3. Managed Stock Investments</h3>
        <p>Managed Stock Investments involve a more hands-on approach, where a professional fund manager or investment firm actively manages a portfolio of stocks, bonds, or other securities to achieve higher returns. These plans are suitable for individuals who are looking to invest in the stock market or other growth-oriented assets but do not have the time or expertise to manage the investments themselves. The investment manager analyzes market trends, selects investments, and adjusts the portfolio to maximize returns while managing risk. Managed stock investments carry a higher level of risk compared to basic savings plans or savings plan plus because stock markets can be volatile, but they also offer the potential for higher returns. This option is ideal for investors who are comfortable with market risk and are looking for long-term growth.</p>

        <h3>Investment Strategy and Risk Levels:</h3>
        <ul>
            <li>Basic Savings Plan: Low risk, low return</li>
            <li>Savings Plan Plus: Moderate risk, moderate return</li>
            <li>Managed Stock Investments: Higher risk, potential for higher return</li>
        </ul>

        <p>Investors choose between these options based on their financial goals, risk tolerance, and time horizon. A basic savings plan may be the best option for someone who wants security and predictable, though small, returns. In contrast, more aggressive investors may opt for a managed stock investment strategy, seeking higher returns over time despite the greater volatility and risk involved.</p>

        <p>Each type of investment has its advantages and disadvantages, and the right choice depends on the individual’s financial situation, goals, and willingness to accept risk. Diversifying investments across multiple plans can also help balance risk and reward.</p>

        <hr>
        <h1>Investment Quote</h1>
            <?php if (isset($message)): ?>
                <div class="message"><?php echo $message; ?></div>
            <?php endif; ?>

            <form method="POST" action="">
                <div class="form-group">
                    <label for="fullname">Full Name</label>
                    <input type="text" id="fullname" name="fullname" value="<?php echo htmlspecialchars($_SESSION['fullname']); ?>" readonly>
                </div>

                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($_SESSION['email']); ?>" readonly>
                </div>

                <div class="form-group">
                    <label for="contact_number">Contact Number</label>
                    <input type="text" id="contact_number" name="contact_number" required>
                </div>

                <div class="form-group">
                    <label for="address">Address</label>
                    <input type="text" id="address" name="address" required>
                </div>

                <div class="form-group">
                    <label for="monthly_income">Monthly Income</label>
                    <input type="number" id="monthly_income" name="monthly_income" required>
                </div>

                <div class="form-group">
                    <label for="guarantor_name">Guarantor Name</label>
                    <input type="text" id="guarantor_name" name="guarantor_name" required>
                </div>

                <div class="form-group">
                    <label for="guarantor_contact">Guarantor Contact</label>
                    <input type="text" id="guarantor_contact" name="guarantor_contact" required>
                </div>

                <div class="form-group">
                    <label for="lump_sum">Initial Lump Sum Investment</label>
                    <input type="number" id="lump_sum" name="lump_sum" required>
                </div>

                <div class="form-group">
                    <label for="monthly_investment">Monthly Investment</label>
                    <input type="number" id="monthly_investment" name="monthly_investment" required>
                </div>

                <div class="form-group">
                    <label for="investment_type">Investment Type</label>
                    <select id="investment_type" name="investment_type">
                        <option value="basicSavings">Basic Savings Plan</option>
                        <option value="savingsPlus">Savings Plan Plus</option>
                        <option value="managedStock">Managed Stock Investments</option>
                    </select>
                </div>

                <button type="submit">Get Quote</button>
            </form>


            <?php if ($_SERVER['REQUEST_METHOD'] == 'POST'): ?>
                <h3>Your Investment Quote:</h3>
                <p><strong>1 Year Min Return:</strong> £<?php echo number_format($one_year_min, 2); ?></p>
                <p><strong>1 Year Max Return:</strong> £<?php echo number_format($one_year_max, 2); ?></p>
                <p><strong>5 Year Min Return:</strong> £<?php echo number_format($five_year_min, 2); ?></p>
                <p><strong>5 Year Max Return:</strong> £<?php echo number_format($five_year_max, 2); ?></p>
                <p><strong>10 Year Min Return:</strong> £<?php echo number_format($ten_year_min, 2); ?></p>
                <p><strong>10 Year Max Return:</strong> £<?php echo number_format($ten_year_max, 2); ?></p>
                <p><strong>Profit:</strong> £<?php echo number_format($profit, 2); ?></p>
                <p><strong>Fees:</strong> £<?php echo number_format($fees, 2); ?></p>
                <p><strong>Tax:</strong> £<?php echo number_format($tax, 2); ?></p>
            <?php endif; ?>
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
