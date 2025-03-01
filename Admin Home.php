<?php
// Include database connection file
include('db_connection.php');

// Query to get the total number of investment applications
$investment_query = "SELECT COUNT(*) AS total_investments FROM investment_data";
$investment_result = mysqli_query($conn, $investment_query);
$investment_data = mysqli_fetch_assoc($investment_result);
$total_investments = $investment_data['total_investments'];

// Query to get the total number of loan applications
$loan_query = "SELECT COUNT(*) AS total_loans FROM loan_applications";
$loan_result = mysqli_query($conn, $loan_query);
$loan_data = mysqli_fetch_assoc($loan_result);
$total_loans = $loan_data['total_loans'];

// Query to get the total number of savings applications
$savings_query = "SELECT COUNT(*) AS total_savings FROM savings_applications";
$savings_result = mysqli_query($conn, $savings_query);
$savings_data = mysqli_fetch_assoc($savings_result);
$total_savings = $savings_data['total_savings'];

// Query to get the total income from approved loan applications
$total_income_query = "SELECT SUM(loan_amount) AS total_income FROM loan_applications WHERE status = 'approved'";
$total_income_result = mysqli_query($conn, $total_income_query);
$total_income_data = mysqli_fetch_assoc($total_income_result);
$total_income = (float) str_replace(',', '', $total_income_data['total_income'] ?? 0); // Handle no income case


// Query to get recent activities from investment_data and contact_form
$recent_activity_query = "SELECT * FROM investment_data ORDER BY created_at DESC LIMIT 5";
$recent_activity_result = mysqli_query($conn, $recent_activity_query);

// Query to get the count of each loan type
$loan_types_query = "SELECT loan_type, COUNT(*) AS count FROM loan_applications GROUP BY loan_type";
$loan_types_result = mysqli_query($conn, $loan_types_query);

// Prepare data for chart
$loan_types = [];
$loan_counts = [];

while ($row = mysqli_fetch_assoc($loan_types_result)) {
    $loan_types[] = $row['loan_type'];
    $loan_counts[] = (int) $row['count'];
}

// Updated query for the sum of approved mortgage applications
$loan_details_query = "SELECT SUM(loan_amount) AS total_loan_amount, SUM(down_payment) AS total_down_payment 
                       FROM mortgage_applications WHERE status = 'approved'";

// Execute the query
$loan_details_result = mysqli_query($conn, $loan_details_query);

// Fetch the result
$loan_details = mysqli_fetch_assoc($loan_details_result);
$total_loan_amount = (float) $loan_details['total_loan_amount'];
$total_down_payment = (float) $loan_details['total_down_payment'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Enomy-Finances Dashboard</title>
  <link rel="stylesheet" href="Admin Home.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
  <div class="dashboard-container">
    <!-- Sidebar -->
    <aside class="sidebar">
    <div class="logo">
        <a href="Admin Home.php"> 
            <img src="Images/Logo.png" alt="Logo">
        </a>
    </div>
  <nav>
    <ul>
      <li><a href="Admin Home.php"><i class="fas fa-home"></i> Dashboard</a></li>
      <li><a href="Admin customer-message.php"><i class="fas fa-envelope"></i> Customer Message</a></li>
      <li><a href="Admin currency-exchange.php"><i class="fas fa-exchange-alt"></i> Currency Exchange</a></li>
      <li><a href="Admin customer-profile.php"><i class="fas fa-user"></i> Customer Profile</a></li>
      <li><a href="Admin personal-advisors.php"><i class="fas fa-user-tie"></i> Personal Advisors</a></li>
      <li><a href="Admin service applications.php"><i class="fas fa-clipboard-list"></i> Service Applications</a></li>
      <li class="dropdown">
        <a href="#"><i class="fas fa-users-cog"></i> Staff Management</a>
        <ul class="submenu">
          <li><a href="Admin advisors.php"><i class="fas fa-user-tie"></i> Advisors</a></li>
          <li><a href="Admin staff-profile.php"><i class="fas fa-id-card"></i> Staff Profile</a></li>
        </ul>
      </li>
      <li><a href="Admin logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
    </ul>
  </nav>
</aside>

    <!-- Main Content -->
    <main class="main-content">
      <header class="header">
        <h1>Enomy-Finances Dashboard</h1>
        <div class="search-container">
          <input type="text" placeholder="Search" />
          <button><i class="fas fa-plus"></i></button>
        </div>
      </header>

      <!-- Top Cards -->
      <section class="top-cards">
        <div class="card loan">
          <div class="card-content">
            <p class="label">Total Investment Applications</p>
            <p class="value"><?php echo $total_investments; ?></p>
          </div>
          <div class="card-icon">
            <i class="fas fa-file-alt"></i>
          </div>
        </div>
        <div class="card savings">
          <div class="card-content">
            <p class="label">Total Savings Applications</p>
            <p class="value"><?php echo $total_savings; ?></p>
          </div>
          <div class="card-icon">
            <i class="fas fa-piggy-bank"></i>
          </div>
        </div>
        <div class="card income">
          <div class="card-content">
            <p class="label">Total Loan Income</p>
            <p class="value">£<?php echo number_format($total_income, 2); ?></p>
          </div>
          <div class="card-icon">
            <i class="fas fa-pound-sign"></i>
          </div>
        </div>
      </section>


      <!-- Chart Section -->
      <section class="chart-section">
          <h2>Loans & Mortgages Application</h2><br>
          <div class="chart-container">
              <!-- Card for the Doughnut Chart -->
              <div class="chart-card">
                  <h3>Loan Types Overview</h3>
                  <div class="chart">
                      <canvas id="loanTypeChart"></canvas>
                  </div>
              </div>
              
              <!-- Card for the Bar Chart -->
              <div class="chart-card">
                  <h3>Mortgages Application Overview</h3>
                  <div class="chart">
                      <canvas id="loanTypeBarChart"></canvas>
                  </div>
              </div>
          </div>
      </section>



      <!-- Recent Activities -->
      <section class="recent-activities">
        <h2>Recent Activities</h2><br>
        <table>
          <thead>
            <tr>
              <th>Investment Name</th>
              <th>Amount</th>
              <th>Date</th>
            </tr>
          </thead>
          <tbody>
            <?php while ($row = mysqli_fetch_assoc($recent_activity_result)) { ?>
              <tr>
                <td><?php echo $row['investment_type']; ?></td>
                <td>£<?php echo number_format($row['profit'], 2); ?></td>
                <td><?php echo date('M d, Y', strtotime($row['created_at'])); ?></td>
              </tr>
            <?php } ?>
          </tbody>
        </table>
      </section>
    </main>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <script>
    var ctx = document.getElementById('loanTypeChart').getContext('2d');

// Create gradient for the pie chart
var gradientColors = [
    ctx.createLinearGradient(0, 0, 0, 400),
    ctx.createLinearGradient(0, 0, 0, 400),
    ctx.createLinearGradient(0, 0, 0, 400),
    ctx.createLinearGradient(0, 0, 0, 400),
    ctx.createLinearGradient(0, 0, 0, 400)
];

// Define colors for the gradients
gradientColors[0].addColorStop(0, '#FF6A88');
gradientColors[0].addColorStop(1, '#FF8E8F');

gradientColors[1].addColorStop(0, '#57C5D1');
gradientColors[1].addColorStop(1, '#5AD0E1');

gradientColors[2].addColorStop(0, '#2EC5A0');
gradientColors[2].addColorStop(1, '#6DD2B2');

gradientColors[3].addColorStop(0, '#FF9F45');
gradientColors[3].addColorStop(1, '#FFC06F');

gradientColors[4].addColorStop(0, '#5A57FF');
gradientColors[4].addColorStop(1, '#786DFF');

// Updated pie chart configuration
var loanTypeChart = new Chart(ctx, {
    type: 'doughnut', // Change to 'doughnut' for a donut-style chart
    data: {
        labels: <?php echo json_encode($loan_types); ?>, // Loan types as labels
        datasets: [{
            label: 'Loan Applications',
            data: <?php echo json_encode($loan_counts); ?>, // Loan counts as data
            backgroundColor: gradientColors, // Apply gradients as background colors
            hoverOffset: 10, // Add space when hovered
            borderColor: 'white',
            borderWidth: 2
        }]
    },
    options: {
        responsive: true,
        cutout: '60%', // Adjust the cutout size for the donut chart
        plugins: {
            legend: {
                display: true,
                position: 'bottom',
                labels: {
                    font: {
                        size: 14,
                        family: 'Arial'
                    },
                    color: '#333'
                }
            },
            tooltip: {
                callbacks: {
                    label: function(tooltipItem) {
                        let label = tooltipItem.label || '';
                        let value = tooltipItem.raw;
                        let total = <?php echo array_sum($loan_counts); ?>; // Total loan counts
                        let percentage = ((value / total) * 100).toFixed(2);
                        return `${label}: ${value} (${percentage}%)`;
                    }
                }
            }
        },
        layout: {
            padding: {
                top: 20,
                bottom: 20
            }
        }
    }
});

</script>
<script>
// Bar chart data
var ctxBar = document.getElementById('loanTypeBarChart').getContext('2d');

var loanTypeBarChart = new Chart(ctxBar, {
    type: 'bar',
    data: {
        labels: ['Total Loan Amount', 'Total Down Payment'], // Labels for the two bars
        datasets: [{
            label: 'Amount (£)',
            data: [<?php echo $total_loan_amount; ?>, <?php echo $total_down_payment; ?>], // The two values for loan and down payment
            backgroundColor: ['#FF6A88', '#2EC5A0'], // Different colors for each bar
            borderColor: ['#FF8E8F', '#6DD2B2'],
            borderWidth: 1,
            barThickness: 30 // Adjust this value to control the bar width (lower value for thinner bars)
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: {
                display: false // Hide legend as it's not necessary for just two bars
            },
            tooltip: {
                callbacks: {
                    label: function(tooltipItem) {
                        let value = tooltipItem.raw;
                        return `£${value.toFixed(2)}`; // Show the value in the tooltip as currency
                    }
                }
            }
        },
        scales: {
            y: {
                beginAtZero: true,
                ticks: {
                    stepSize: 5000 // Adjust step size for better display
                }
            }
        }
    }
});
</script>

</body>
</html>
