<?php
// Include database connection file
include('db_connection.php');

// Handle Add Advisor
if (isset($_POST['add_advisor'])) {
    $fullname = $_POST['fullname'];
    $email = $_POST['email'];
    $query = "INSERT INTO advisors (fullname, email) VALUES ('$fullname', '$email')";
    mysqli_query($conn, $query);
    header("Location: Admin advisors.php");
}

// Handle Delete Advisor
if (isset($_GET['delete_id'])) {
    $id = $_GET['delete_id'];
    $query = "DELETE FROM advisors WHERE id = $id";
    mysqli_query($conn, $query);
    header("Location: Admin advisors.php");
}

// Handle Edit Advisor
if (isset($_POST['edit_advisor'])) {
    $id = $_POST['id'];
    $fullname = $_POST['fullname'];
    $email = $_POST['email'];
    $query = "UPDATE advisors SET fullname = '$fullname', email = '$email' WHERE id = $id";
    mysqli_query($conn, $query);
    header("Location: Admin advisors.php");
}

// Fetch all advisors
$query = "SELECT * FROM advisors";
$result = mysqli_query($conn, $query);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Enomy-Finances Dashboard</title>
  <link rel="stylesheet" href="Admin advisors.css">
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
        <!-- User-Friendly Guide -->
            <div class="advice-card">
                <h1>Advisor Management</h1>
                <p>
                    Welcome to the Advisor Management! This page allows you to oversee and manage all personal advisors effectively. 
                    Here's what you can do:
                </p>
                <ul>
                    <li><strong>Add New Advisors:</strong> Use the form below to add details of new advisors to the system.</li>
                    <li><strong>Edit Advisor Details:</strong> Click on the "Edit" link next to an advisor's name to update their information.</li>
                    <li><strong>Delete Advisors:</strong> Remove advisors from the system by clicking the "Delete" link. Ensure this action is intentional, as it cannot be undone.</li>
                    <li><strong>View All Advisors:</strong> The table below displays a complete list of advisors, including their ID, full name, and email address.</li>
                    <li><strong>Maintain Accuracy:</strong> Ensure all data is accurate and up-to-date to support smooth communication and management.</li>
                </ul>
                <p>
                    If you encounter any issues or need further assistance, please contact the technical support team for help. 
                    Thank you for keeping the advisor data organized!
                </p>
            </div>

            <h1>Manage Advisors</h1>
            <table border="1" cellpadding="10" cellspacing="0">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Full Name</th>
                        <th>Email</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                        <tr>
                            <td><?php echo $row['id']; ?></td>
                            <td><?php echo $row['fullname']; ?></td>
                            <td><?php echo $row['email']; ?></td>
                            <td>
                                <a href="?delete_id=<?php echo $row['id']; ?>" class="delete-link" onclick="return confirm('Are you sure?')">Delete</a>
                                <a href="#editModal" class="edit-link" onclick="editAdvisor(<?php echo $row['id']; ?>, '<?php echo $row['fullname']; ?>', '<?php echo $row['email']; ?>')">Edit</a>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>

            <!-- Add Advisor Form -->
            <form method="POST">
                <h2>Add New Advisor</h2>
                <input type="text" name="fullname" placeholder="Full Name" required>
                <input type="email" name="email" placeholder="Email" required>
                <button type="submit" name="add_advisor">Add Advisor</button>
            </form>

            <!-- Edit Modal -->
            <div id="editModal" style="display:none;">
                <form method="POST">
                    <h2>Edit Advisor</h2>
                    <input type="hidden" name="id" id="edit_id">
                    <input type="text" name="fullname" id="edit_fullname" placeholder="Full Name" required>
                    <input type="email" name="email" id="edit_email" placeholder="Email" required>
                    <button type="submit" name="edit_advisor">Update Advisor</button>
                    <button type="button" onclick="closeEditModal()">Cancel</button>
                </form>
            </div>
        </main>
    </div>

    <script>
        function editAdvisor(id, fullname, email) {
            document.getElementById('edit_id').value = id;
            document.getElementById('edit_fullname').value = fullname;
            document.getElementById('edit_email').value = email;
            document.getElementById('editModal').style.display = 'block';
        }
        function closeEditModal() {
            document.getElementById('editModal').style.display = 'none';
        }

    </script>
</body>
</html>
