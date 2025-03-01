<?php
// Include database connection file
include('db_connection.php');
// Handle form submission to update exchange rates
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  foreach ($_POST['rates'] as $id => $exchange_rate) {
      $exchange_rate = floatval($exchange_rate); // Sanitize input
      $stmt = $conn->prepare("UPDATE currency_exchange_rates SET exchange_rate = ?, last_updated = NOW() WHERE id = ?");
      $stmt->bind_param("di", $exchange_rate, $id);
      $stmt->execute();
  }
  echo "<script>alert('Exchange rates updated successfully!');</script>";
}

// Fetch currency exchange rates
$result = $conn->query("SELECT * FROM currency_exchange_rates");
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Enomy-Finances Dashboard</title>
  <link rel="stylesheet" href="Admin currency-exchange.css">
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
      <h1>Currency Exchange Rates</h1><br>
      <div class="admin-guide">
        <p>
          Welcome to the Currency Exchange Management section. This area allows you to update and manage the currency exchange rates used across the system. 
          Maintaining accurate exchange rates is crucial for delivering reliable financial services to our clients. Below are some key points to consider:
        </p>
        <ul>
          <li><strong>Verify Accuracy:</strong> Double-check all exchange rates before submitting to ensure there are no errors.</li>
          <li><strong>Regular Updates:</strong> Update the rates frequently to reflect current market trends and fluctuations.</li>
          <li><strong>Consult Experts:</strong> If you're uncertain about specific rates, consult the financial team or refer to trusted financial sources.</li>
          <li><strong>Impact Awareness:</strong> Remember that these rates directly affect transactions, so even minor inaccuracies can lead to significant discrepancies.</li>
          <li><strong>Compliance:</strong> Ensure the rates comply with financial regulations and organizational policies.</li>
        </ul>
        <p>
          Once you’ve updated the rates, the changes will be applied instantly across the system. If you encounter any issues or have questions, 
          please reach out to the IT or finance team for assistance. Thank you for your diligence in keeping our system reliable and accurate!
        </p>
      </div>
      <form method="POST" action="">
        <table>
          <thead>
            <tr>
              <th>From Currency</th>
              <th>To Currency</th>
              <th>Exchange Rate</th>
              <th>Last Updated</th>
            </tr>
          </thead>
          <tbody>
            <?php while ($row = $result->fetch_assoc()): ?>
              <tr>
                <td><?= htmlspecialchars($row['from_currency']) ?></td>
                <td><?= htmlspecialchars($row['to_currency']) ?></td>
                <td>
                  <input type="number" step="0.000001" name="rates[<?= $row['id'] ?>]" value="<?= htmlspecialchars($row['exchange_rate']) ?>" required>
                </td>
                <td><?= htmlspecialchars($row['last_updated']) ?></td>
              </tr>
            <?php endwhile; ?>
          </tbody>
        </table>
        <div class="button-container">
          <button type="submit" class="btn-update">Update Rates</button>
        </div>

      </form>
    </main>
  </div>

</body>
</html>
