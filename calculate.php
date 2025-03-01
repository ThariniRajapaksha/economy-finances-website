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
    <title>Ecomy Finance</title>
    <link rel="stylesheet" href="calculate.css">
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
    <div class="calculator-container">
        <h2>Financial Calculators</h2>
        
        <!-- Dropdown to select calculation type -->
        <label for="calculator-select">What would you like to calculate?</label>
        <select id="calculator-select" onchange="toggleCalculator()">
            <option value="" selected disabled>Select an option</option>
            <option value="mortgage">Mortgage</option>
            <option value="loan">Loan</option>
            <option value="savings">Savings</option>
        </select>

        <!-- Mortgage Calculator -->
        <section id="mortgage-calculator" style="display: none;">
            <h3>Mortgage Calculator</h3>
            <form id="mortgage-form">
                <label for="home-price">Home Price ($):</label>
                <input type="number" id="home-price" required>
                
                <label for="down-payment">Down Payment ($):</label>
                <input type="number" id="down-payment" required>
                
                <label for="loan-term">Loan Term (Years):</label>
                <input type="number" id="loan-term" required>
                
                <label for="interest-rate">Interest Rate (%):</label>
                <input type="number" id="interest-rate" step="0.01" required>
                
                <button type="button" onclick="calculateMortgage()">Calculate</button>
                <p id="mortgage-result"></p>
            </form>
        </section>

        <!-- Loan Calculator -->
        <section id="loan-calculator" style="display: none;">
            <h3>Loan Calculator</h3>
            <form id="loan-form">
                <label for="loan-amount">Loan Amount ($):</label>
                <input type="number" id="loan-amount" required>
                
                <label for="loan-term-loan">Loan Term (Years):</label>
                <input type="number" id="loan-term-loan" required>
                
                <label for="interest-rate-loan">Interest Rate (%):</label>
                <input type="number" id="interest-rate-loan" step="0.01" required>
                
                <button type="button" onclick="calculateLoan()">Calculate</button>
                <p id="loan-result"></p>
            </form>
        </section>

        <!-- Savings Calculator -->
        <section id="savings-calculator" style="display: none;">
            <h3>Savings Calculator</h3>
            <form id="savings-form">
                <label for="initial-amount">Initial Amount ($):</label>
                <input type="number" id="initial-amount" required>
                
                <label for="monthly-deposit">Monthly Deposit ($):</label>
                <input type="number" id="monthly-deposit" required>
                
                <label for="savings-term">Term (Years):</label>
                <input type="number" id="savings-term" required>
                
                <label for="savings-rate">Annual Interest Rate (%):</label>
                <input type="number" id="savings-rate" step="0.01" required>
                
                <button type="button" onclick="calculateSavings()">Calculate</button>
                <p id="savings-result"></p>
            </form>
        </section>
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
        function toggleCalculator() {
            // Hide all calculators
            document.getElementById('mortgage-calculator').style.display = 'none';
            document.getElementById('loan-calculator').style.display = 'none';
            document.getElementById('savings-calculator').style.display = 'none';

            // Get the selected calculator
            const selectedCalculator = document.getElementById('calculator-select').value;

            // Show the relevant calculator
            if (selectedCalculator === 'mortgage') {
                document.getElementById('mortgage-calculator').style.display = 'block';
            } else if (selectedCalculator === 'loan') {
                document.getElementById('loan-calculator').style.display = 'block';
            } else if (selectedCalculator === 'savings') {
                document.getElementById('savings-calculator').style.display = 'block';
            }
        }

        // Mortgage calculation logic
        function calculateMortgage() {
            const price = parseFloat(document.getElementById('home-price').value);
            const downPayment = parseFloat(document.getElementById('down-payment').value);
            const loanTerm = parseInt(document.getElementById('loan-term').value);
            const interestRate = parseFloat(document.getElementById('interest-rate').value) / 100;

            const loanAmount = price - downPayment;
            const monthlyRate = interestRate / 12;
            const numberOfPayments = loanTerm * 12;

            const monthlyPayment = loanAmount * monthlyRate / (1 - Math.pow(1 + monthlyRate, -numberOfPayments));
            document.getElementById('mortgage-result').textContent = `Monthly Payment: $${monthlyPayment.toFixed(2)}`;
        }

        // Loan calculation logic
        function calculateLoan() {
            const amount = parseFloat(document.getElementById('loan-amount').value);
            const term = parseInt(document.getElementById('loan-term-loan').value);
            const rate = parseFloat(document.getElementById('interest-rate-loan').value) / 100;

            const monthlyRate = rate / 12;
            const numberOfPayments = term * 12;

            const monthlyPayment = amount * monthlyRate / (1 - Math.pow(1 + monthlyRate, -numberOfPayments));
            document.getElementById('loan-result').textContent = `Monthly Payment: $${monthlyPayment.toFixed(2)}`;
        }

        // Savings calculation logic
        function calculateSavings() {
            const initialAmount = parseFloat(document.getElementById('initial-amount').value);
            const monthlyDeposit = parseFloat(document.getElementById('monthly-deposit').value);
            const term = parseInt(document.getElementById('savings-term').value);
            const rate = parseFloat(document.getElementById('savings-rate').value) / 100;

            const months = term * 12;
            let totalSavings = initialAmount;

            for (let i = 0; i < months; i++) {
                totalSavings += monthlyDeposit;
                totalSavings += totalSavings * rate / 12;
            }

            document.getElementById('savings-result').textContent = `Total Savings: $${totalSavings.toFixed(2)}`;
        }
    </script>
</body>
</html>
