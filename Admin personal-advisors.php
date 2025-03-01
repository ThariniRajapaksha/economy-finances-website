<?php
// Include database connection file
include('db_connection.php');

// Handle the form submission to update the is_informed column
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_informed'])) {
    $booking_id = $_POST['booking_id'];
    $is_informed = $_POST['is_informed'];

    // Update the is_informed column in the database
    $stmt = $conn->prepare("UPDATE advisor_bookings SET is_informed = ? WHERE id = ?");
    $stmt->bind_param("si", $is_informed, $booking_id);
    if ($stmt->execute()) {
        $message = "Record updated successfully.";
    } else {
        $message = "Error updating record: " . $conn->error;
    }
}

// Fetch all bookings from the database
$result = $conn->query("SELECT * FROM advisor_bookings");
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Enomy-Finances Dashboard</title>
  <link rel="stylesheet" href="Admin personal-advisors.css">
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
    <!-- Guide and Advice Card -->
        <div class="guide-card">
            <h2>Advisor Bookings</h2>
            <ul>
                <li>To update the <strong>Is Informed</strong> status:
                    <ul>
                        <li>Select "Yes" or "No" from the dropdown in the "Action" column.</li>
                        <li>Click the "Update" button to save changes.</li>
                    </ul>
                </li>
                <li>Use the table headers to identify specific booking details such as <strong>ID, User ID, Full Name, Email</strong>, and more.</li>
                <li>If you encounter any errors while updating, the message will display at the top of the page for troubleshooting.</li>
                <li>Hover over rows for better visibility and quick access.</li>
            </ul>
        </div>

            <div class="card">

                <!-- Display message -->
                <?php if (isset($message)): ?>
                    <div class="message"><?php echo htmlspecialchars($message); ?></div>
                <?php endif; ?>
                <div class="table-container">
                    <h2>Advisor Applications</h2><br>
                    <div class="table-wrapper">
                        <table>
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>User ID</th>
                                    <th>Full Name</th>
                                    <th>Email</th>
                                    <th>Advisor ID</th>
                                    <th>Appointment Date</th>
                                    <th>Appointment Time</th>
                                    <th>Message</th>
                                    <th>Is Informed</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php while ($row = $result->fetch_assoc()): ?>
                                    <tr>
                                        <td><?php echo $row['id']; ?></td>
                                        <td><?php echo $row['user_id']; ?></td>
                                        <td><?php echo htmlspecialchars($row['fullname']); ?></td>
                                        <td><?php echo htmlspecialchars($row['email']); ?></td>
                                        <td><?php echo $row['advisor_id']; ?></td>
                                        <td><?php echo $row['appointment_date']; ?></td>
                                        <td><?php echo $row['appointment_time']; ?></td>
                                        <td><?php echo htmlspecialchars($row['message']); ?></td>
                                        <td><?php echo htmlspecialchars($row['is_informed']); ?></td>
                                        <td>
                                            <form method="POST" class="form-actions">
                                                <input type="hidden" name="booking_id" value="<?php echo $row['id']; ?>">
                                                <select name="is_informed">
                                                    <option value="No" <?php echo $row['is_informed'] == 'No' ? 'selected' : ''; ?>>No</option>
                                                    <option value="Yes" <?php echo $row['is_informed'] == 'Yes' ? 'selected' : ''; ?>>Yes</option>
                                                </select>
                                                <button type="submit" name="update_informed">Update</button>
                                            </form>
                                        </td>
                                    </tr>
                                <?php endwhile; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </main>
    </div>
    
</body>
</html>
