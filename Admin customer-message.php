<?php
// Include database connection file
include('db_connection.php');

// Check if a filter is applied
$status_filter = isset($_GET['status']) ? $_GET['status'] : '';

// Handle message status update
if (isset($_POST['update_status'])) {
    $message_id = $_POST['message_id'];
    $new_status = $_POST['status'];

    // Update the message status in the database
    $update_query = "UPDATE contact_form SET status = '$new_status' WHERE id = $message_id";
    mysqli_query($conn, $update_query);
}

// Prepare the query to fetch the messages based on the selected status filter
$query = "SELECT * FROM contact_form";
if ($status_filter) {
    $query .= " WHERE status = '$status_filter'";
}

$result = mysqli_query($conn, $query);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Enomy-Finances Dashboard</title>
  <link rel="stylesheet" href="Admin customer-message.css">
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
<main>
    <!-- Admin Guide for Managing Customer Messages -->
    <section class="admin-guide">
        <h1>Customer Messages</h1>
        <p><strong>Admin Guide for Managing Customer Messages</strong></p>
        <p>Welcome to the Customer Messages Management section of the Enomy-Finances Dashboard! This page is designed to help you efficiently handle customer inquiries submitted through the contact form. Below are some key features and tips to help you navigate the system:</p>
        
        <ul>
            <li><strong>Filter by Status:</strong> Use the "Filter by Status" dropdown to view messages based on their current status (Unread or Read). This helps you prioritize messages that need your attention. Simply select a status and click "Apply Filter" to see the corresponding messages.</li>
            <li><strong>Message Overview:</strong> Each message is displayed with key details such as the sender's name, email, message content, and the date it was created. This provides a quick overview to help you assess the urgency of each message.</li>
            <li><strong>Update Message Status:</strong> After reviewing a message, you can update its status to "Read" or "Unread" to keep track of your progress. This is particularly useful for maintaining an organized inbox and ensuring no messages are missed.</li>
            <li><strong>Actionable Insights:</strong> You can easily update the status of multiple messages as needed, ensuring that customer inquiries are handled in a timely manner. If a message requires follow-up or further action, consider marking it as "Unread" until it has been addressed.</li>
        </ul>
        
        <p>We recommend regularly checking this page to stay on top of customer inquiries and ensuring all messages are responded to promptly. Your timely updates and attention to detail contribute to providing an excellent customer experience!</p>
    </section>
      <!-- Filter Bar -->
      <div class="filter-bar">
        <form method="GET" action="Admin customer-message.php">
          <label for="status">Filter by Status:</label>
          <select name="status" id="status">
            <option value="">All</option>
            <option value="unread" <?php echo ($status_filter == 'unread') ? 'selected' : ''; ?>>Unread</option>
            <option value="read" <?php echo ($status_filter == 'read') ? 'selected' : ''; ?>>Read</option>
          </select>
          <button type="submit">Apply Filter</button>
        </form>
      </div>

      <!-- Table Displaying Customer Messages -->
      <table>
        <thead>
          <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Email</th>
            <th>Message</th>
            <th>Created At</th>
            <th>Status</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          <?php
          // Display messages
          while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>";
            echo "<td>" . $row['id'] . "</td>";
            echo "<td>" . $row['name'] . "</td>";
            echo "<td>" . $row['email'] . "</td>";
            echo "<td>" . $row['message'] . "</td>";
            echo "<td>" . $row['created_at'] . "</td>";
            echo "<td>" . $row['status'] . "</td>";
            echo "<td>
                    <form method='POST' action='Admin customer-message.php'>
                      <input type='hidden' name='message_id' value='" . $row['id'] . "'>
                      <select name='status'>
                        <option value='unread' " . ($row['status'] == 'unread' ? 'selected' : '') . ">Unread</option>
                        <option value='read' " . ($row['status'] == 'read' ? 'selected' : '') . ">Read</option>
                      </select>
                      <button type='submit' name='update_status'>Update</button>
                    </form>
                  </td>";
            echo "</tr>";
          }
          ?>
        </tbody>
      </table>
    </main>
  </div>
    

</body>
</html>
