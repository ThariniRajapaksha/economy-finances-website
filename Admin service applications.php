<?php
// Include database connection
include('db_connection.php');

// Handle table selection and status filter
$table = isset($_POST['table']) ? $_POST['table'] : 'savings_applications'; // Default table
$status_filter = isset($_POST['status_filter']) ? $_POST['status_filter'] : ''; // Default filter (all statuses)

// Validate the table name (to prevent SQL injection)
$valid_tables = ['savings_applications', 'mortgage_applications', 'loan_applications', 'investment_data'];
if (!in_array($table, $valid_tables)) {
    $table = 'savings_applications'; // Default to 'savings_applications' if invalid table selected
}

// Prepare the query to fetch data from the selected table with the status filter
$query = "SELECT * FROM $table";
if ($status_filter) {
    $query .= " WHERE status = '$status_filter'";
}

// Fetch data for the selected table
$result = $conn->query($query);

// Get column names dynamically
$columns_query = "SHOW COLUMNS FROM $table";
$columns_result = $conn->query($columns_query);
$columns = [];
while ($column = $columns_result->fetch_assoc()) {
    $columns[] = $column['Field'];
}

// Handle status update
if (isset($_POST['update_status'])) {
    $id = $_POST['id'];
    $new_status = $_POST['status'];

    // Validate the status
    $valid_statuses = ['Pending', 'Approved', 'Rejected'];
    if (!in_array($new_status, $valid_statuses)) {
        // If the status is invalid, set it to Pending by default
        $new_status = 'Pending';
    }

    // Define update queries for each table
    switch ($table) {
        case 'savings_applications':
            $update_query = "UPDATE savings_applications SET status = ? WHERE id = ?";
            break;
        case 'mortgage_applications':
            $update_query = "UPDATE mortgage_applications SET status = ? WHERE id = ?";
            break;
        case 'loan_applications':
            $update_query = "UPDATE loan_applications SET status = ? WHERE id = ?";
            break;
        case 'investment_data':
            $update_query = "UPDATE investment_data SET status = ? WHERE id = ?";
            break;
        default:
            // Default to savings_applications if the table is invalid
            $update_query = "UPDATE savings_applications SET status = ? WHERE id = ?";
            break;
    }

    // Execute the update query
    $stmt = $conn->prepare($update_query);
    $stmt->bind_param('si', $new_status, $id);
    if ($stmt->execute()) {
    } else {
        echo "Error: " . $stmt->error;
    }

    // Redirect to refresh the page
    header("Location: " . $_SERVER['PHP_SELF']); 
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Enomy-Finances Dashboard</title>
  <link rel="stylesheet" href="Admin service applications.css">
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
        <div class="admin-guide-card">
            <h3>Service Applications</h3>
            <p> Use the filter options below to manage and update the status of various applications efficiently. Make sure to review each application thoroughly before making updates.</p>
            <ul>
                <li><strong>Select Table:</strong> Choose the application table you want to work with.</li>
                <li><strong>Filter by Status:</strong> Narrow down applications by their current status (e.g., Pending, Approved).</li>
                <li><strong>Update Status:</strong> You can update the status of any application directly from the table.</li>
            </ul>
        </div>

        <!-- Filter Bar -->
        <form method="POST">
            <label for="table">Select Table:</label>
            <select name="table" id="table" onchange="this.form.submit()">
                <option value="savings_applications" <?php echo ($table == 'savings_applications') ? 'selected' : ''; ?>>Savings Applications</option>
                <option value="mortgage_applications" <?php echo ($table == 'mortgage_applications') ? 'selected' : ''; ?>>Mortgage Applications</option>
                <option value="loan_applications" <?php echo ($table == 'loan_applications') ? 'selected' : ''; ?>>Loan Applications</option>
                <option value="investment_data" <?php echo ($table == 'investment_data') ? 'selected' : ''; ?>>Investment Data</option>
            </select>

            <label for="status_filter">Filter by Status:</label>
            <select name="status_filter" id="status_filter" onchange="this.form.submit()">
                <option value="" <?php echo ($status_filter == '') ? 'selected' : ''; ?>>All</option>
                <option value="Pending" <?php echo ($status_filter == 'Pending') ? 'selected' : ''; ?>>Pending</option>
                <option value="Approved" <?php echo ($status_filter == 'Approved') ? 'selected' : ''; ?>>Approved</option>
            </select>
        </form>

        <h2>Application Data: <?php echo ucfirst(str_replace('_', ' ', $table)); ?></h2>

        <table>
            <thead>
                <tr>
                    <!-- Dynamically generate table headers -->
                    <?php foreach ($columns as $column): ?>
                        <th><?php echo ucfirst(str_replace('_', ' ', $column)); ?></th>
                    <?php endforeach; ?>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <!-- Dynamically generate table rows -->
                        <?php foreach ($columns as $column): ?>
                            <td><?php echo $row[$column]; ?></td>
                        <?php endforeach; ?>
                        <td>
                            <form method="POST">
                                <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                                <input type="hidden" name="table" value="<?php echo $table; ?>"> <!-- Hidden field for the selected table -->
                                <select name="status">
                                    <option value="Pending" <?php echo ($row['status'] == 'Pending') ? 'selected' : ''; ?>>Pending</option>
                                    <option value="Approved" <?php echo ($row['status'] == 'Approved') ? 'selected' : ''; ?>>Approved</option>
                                    <option value="Rejected" <?php echo ($row['status'] == 'Rejected') ? 'selected' : ''; ?>>Rejected</option>
                                </select>
                                <button type="submit" name="update_status">Update</button>
                            </form>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </main>
  </div>

     

</body>
</html>
