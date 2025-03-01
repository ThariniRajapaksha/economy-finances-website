<?php
session_start();
require 'db_connection.php';

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

// Fetch exchange rates from the database
$exchangeRates = [];
$query = "SELECT * FROM currency_exchange_rates";
$result = mysqli_query($conn, $query);

if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $exchangeRates[$row['from_currency']][$row['to_currency']] = $row['exchange_rate'];
    }
} else {
    die("Error fetching exchange rates: " . mysqli_error($conn));
}

// Currency conversion function
function convertCurrency($amount, $fromCurrency, $toCurrency, $exchangeRates) {
    // Check if the amount is within valid transaction range
    if ($amount < 300 || $amount > 5000) {
        return "Amount must be between 300 and 5000.";
    }

    // Ensure exchange rate exists for the fromCurrency to toCurrency pair
    if (isset($exchangeRates[$fromCurrency][$toCurrency])) {
        $conversionRate = $exchangeRates[$fromCurrency][$toCurrency];  // Get the correct conversion rate
        $convertedAmount = $amount * $conversionRate;  // Apply conversion
        return $convertedAmount;
    } else {
        return "Exchange rate not available for this currency pair.";
    }
}

// Fee calculation function
function calculateFee($amount) {
    if ($amount <= 500) {
        return $amount * 0.035;  // 3.5% for up to 500
    } elseif ($amount <= 1500) {
        return $amount * 0.027;  // 2.7% for up to 1500
    } elseif ($amount <= 2500) {
        return $amount * 0.020;  // 2.0% for up to 2500
    } else {
        return $amount * 0.015;  // 1.5% for above 2500
    }
}

// Handle form submission
$convertedAmount = null;
$fee = null;
$fromCurrency = '';
$toCurrency = '';
$amount = 0;
$finalAmount = 0;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $amount = $_POST['amount'];
    $fromCurrency = $_POST['fromCurrency'];
    $toCurrency = $_POST['toCurrency'];

    // Convert currency
    if ($amount >= 300 && $amount <= 5000) {
        $convertedAmount = convertCurrency($amount, $fromCurrency, $toCurrency, $exchangeRates);

        // Calculate the fee
        if (is_numeric($convertedAmount)) {
            $fee = calculateFee($amount);
            // Ensure fee is deducted from the converted amount
            $finalAmount = $convertedAmount - $fee; // Subtract fee from converted amount
            // Ensure final amount is non-negative (if the fee is larger than the converted amount, set it to 0)
            if ($finalAmount < 0) {
                $finalAmount = 0;
            }
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
    <link rel="stylesheet" href="currency-exchange.css">
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
    <img src="Images/Curruncy.jpg" alt="General Saving Account" class="savings-image">
    <div class="currency-conversion-container">
        <!-- Form Container -->
        <div class="form-container">
            <h2><i class="fa-solid fa-circle-dollar-to-slot"></i> Currency Conversion</h2>
            <form action="currency-exchange.php" method="POST">
                <label for="amount">Amount:</label>
                <input type="number" id="amount" name="amount" min="300" max="5000" required>

                <label for="fromCurrency">From Currency:</label>
                <select name="fromCurrency" id="fromCurrency" required>
                    <option value="GBP">GBP</option>
                    <option value="USD">USD</option>
                    <option value="EUR">EUR</option>
                    <option value="BRL">BRL</option>
                    <option value="JPY">JPY</option>
                    <option value="TRY">TRY</option>
                </select>

                <label for="toCurrency">To Currency:</label>
                <select name="toCurrency" id="toCurrency" required>
                    <option value="GBP">GBP</option>
                    <option value="USD">USD</option>
                    <option value="EUR">EUR</option>
                    <option value="BRL">BRL</option>
                    <option value="JPY">JPY</option>
                    <option value="TRY">TRY</option>
                </select>

                <button type="submit">Convert</button>
            </form>

            <!-- Conversion result below the form -->
            <?php if ($convertedAmount !== null): ?>
                <div class="conversion-result">
                    <h3>Conversion Result:</h3>
                    <p>Converted Amount: <?php echo number_format($convertedAmount, 2); ?> <?php echo $toCurrency; ?></p>
                    <p>Transaction Fee: <?php echo number_format($fee, 2); ?> <?php echo $fromCurrency; ?></p>
                    <p>Final Amount After Fee: <?php echo number_format($finalAmount, 2); ?> <?php echo $toCurrency; ?></p>
                </div>
            <?php endif; ?>
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
