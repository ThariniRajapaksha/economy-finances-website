<?php
// Include database connection file
include('db_connection.php');

// Fetch data for client_register
$registerQuery = "SELECT * FROM client_register";
$result = mysqli_query($conn, $registerQuery);

if (!$result) {
    die("Error fetching client_register data: " . mysqli_error($conn));
}

// Fetch data for client_profiles
$profileQuery = "SELECT * FROM client_profiles";
$profileResult = mysqli_query($conn, $profileQuery);

if (!$profileResult) {
    die("Error fetching client_profiles data: " . mysqli_error($conn));
}

// Handle updates for client_register
if (isset($_POST['update_register'])) {
  $id = $_POST['id'];
  $fullname = $_POST['fullname'];
  $email = $_POST['email'];
  $account_status = $_POST['account_status'];

  // Begin a transaction to ensure both updates happen together
  $conn->begin_transaction();

  try {
      // Update client_register
      $updateRegisterQuery = "UPDATE client_register SET fullname = ?, email = ?, account_status = ? WHERE id = ?";
      $stmt1 = $conn->prepare($updateRegisterQuery);
      $stmt1->bind_param("sssi", $fullname, $email, $account_status, $id);
      $stmt1->execute();

      // Update account_status in client_profiles
      $updateProfileQuery = "UPDATE client_profiles SET account_status = ? WHERE user_id = ?";
      $stmt2 = $conn->prepare($updateProfileQuery);
      $stmt2->bind_param("si", $account_status, $id);
      $stmt2->execute();

      // Commit transaction
      $conn->commit();
  } catch (Exception $e) {
      // Rollback transaction on error
      $conn->rollback();
      echo "Error updating records: " . $e->getMessage();
  }
}

// Handle updates for client_profiles
if (isset($_POST['update_profiles'])) {
  $id = $_POST['id'];
  $phone = $_POST['phone'];
  $address = $_POST['address'];
  $city = $_POST['city'];
  $zip = $_POST['zip'];
  $account_status = $_POST['account_status'];

  // Begin a transaction to ensure both updates happen together
  $conn->begin_transaction();

  try {
      // Update client_profiles
      $updateProfileQuery = "UPDATE client_profiles SET phone = ?, address = ?, city = ?, zip = ?, account_status = ? WHERE user_id = ?";
      $stmt1 = $conn->prepare($updateProfileQuery);
      $stmt1->bind_param("sssssi", $phone, $address, $city, $zip, $account_status, $id);
      $stmt1->execute();

      // Update account_status in client_register
      $updateRegisterQuery = "UPDATE client_register SET account_status = ? WHERE id = ?";
      $stmt2 = $conn->prepare($updateRegisterQuery);
      $stmt2->bind_param("si", $account_status, $id);
      $stmt2->execute();

      // Commit transaction
      $conn->commit();
  } catch (Exception $e) {
      // Rollback transaction on error
      $conn->rollback();
      echo "Error updating records: " . $e->getMessage();
  }
}

// Handle delete for both tables
if (isset($_POST['delete'])) {
    $id = $_POST['id'];
    $table = $_POST['table']; // Indicates the table to delete from

    $deleteQuery = "DELETE FROM $table WHERE " . ($table === 'client_register' ? 'id' : 'user_id') . " = ?";
    $stmt = $conn->prepare($deleteQuery);
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
    } else {
        echo "Error: " . $stmt->error;
    }
}

// Handle updates for client_register
if (isset($_POST['update_register'])) {
  $id = $_POST['id'];
  $fullname = $_POST['fullname'];
  $email = $_POST['email'];
  $account_status = $_POST['account_status'];

  $updateRegisterQuery = "UPDATE client_register SET fullname = ?, email = ?, account_status = ? WHERE id = ?";
  $stmt = $conn->prepare($updateRegisterQuery);
  $stmt->bind_param("sssi", $fullname, $email, $account_status, $id);

  if ($stmt->execute()) {
  } else {
      echo "Error updating Client Register: " . $stmt->error;
  }
}

// Handle updates for client_profiles
if (isset($_POST['update_profiles'])) {
  $id = $_POST['id'];
  $phone = $_POST['phone'];
  $address = $_POST['address'];
  $city = $_POST['city'];
  $zip = $_POST['zip'];
  $account_status = $_POST['account_status'];

  $updateProfileQuery = "UPDATE client_profiles SET phone = ?, address = ?, city = ?, zip = ?, account_status = ? WHERE user_id = ?";
  $stmt = $conn->prepare($updateProfileQuery);
  $stmt->bind_param("sssssi", $phone, $address, $city, $zip, $account_status, $id);

  if ($stmt->execute()) {
  } else {
      echo "Error updating Client Profile: " . $stmt->error;
  }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Enomy-Finances Dashboard</title>
  <link rel="stylesheet" href="Admin customer-profile.css">
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

<main class="main-content">
      <div class="admin-guide">
        <h2>Customer Profiles</h2>
          <p>Welcome to the admin dashboard! Here, you can efficiently manage client data, including their registration details and profiles. To help you navigate and use the system effectively, here are a few tips:</p>
          <hr>
          <h3><i class="fas fa-folder-open"></i>  Viewing Client Data</h3>
          <p>The dashboard displays client information in two sections: <b>Client Register</b> and <b>Client Profiles</b>. Use these tables to quickly view key details, such as full names, emails, account statuses, phone numbers, and addresses.</p>
          <h3><i class="fas fa-edit"></i>  Editing Client Information</h3>
          <p>To edit a client's details, simply click the <b>Edit</b> button in the corresponding row of the table. A form will appear where you can update the required fields. After making changes, click <b>Update</b> to save the modifications. If you accidentally open the edit form, click <b>Cancel</b> to close it without saving.</p>
          <h3><i class="fas fa-trash-alt"></i>  Deleting Client Records</h3>
          <p>If you need to remove a client's data, use the <b>Delete</b> button in the table. Be careful when performing this action, as it permanently removes the record.</p>
          <h3><i class="fas fa-sync-alt"></i>  Maintaining Data Consistency</h3>
          <p>When updating information, account statuses in both the <b>Client Register</b> and <b>Client Profiles</b> sections are synced automatically to ensure consistency. Changes made in one table will reflect in the other, so no manual double-updating is needed.</p>
          <h3><i class="fas fa-bars"></i>  Using the Sidebar</h3>
          <p>The sidebar navigation helps you easily switch between different sections of the dashboard, such as customer messages, currency exchange, or staff management. Explore all features to make the most of the admin tools available!</p>
          <h3><i class="fas fa-lightbulb"></i>  Pro Tip</h3>
          <p>Before performing any edits or deletions, double-check the information to ensure accuracy. This will help maintain the integrity of client data.</p>
          <p><i>This system is designed to make your workflow smooth and efficient. If you have any questions or encounter issues, reach out to your technical support team for assistance.</i></p>
      </div> 
<!-- Client Register Cards -->
<div class="cards-container">
    <div class="card">
        <div class="table-container">
          <h2>Client Register</h2><br>
            <div class="table-wrapper">
                <table>
                    <thead>
                        <tr>
                            <th>Full Name</th>
                            <th>Email</th>
                            <th>Account Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($client = mysqli_fetch_assoc($result)) { ?>
                            <tr>
                                <td><?php echo $client['fullname']; ?></td>
                                <td><?php echo $client['email']; ?></td>
                                <td><?php echo $client['account_status']; ?></td> <!-- Display Account Status -->
                                <td>
                                    <button type="button" class="edit-btn" onclick="openEditForm(
                                        'client_register',
                                        '<?php echo $client['id']; ?>', 
                                        '<?php echo $client['fullname']; ?>', 
                                        '<?php echo $client['email']; ?>', 
                                        '<?php echo $client['account_status']; ?>', 
                                        '', '', '', '' 
                                    )">Edit</button>
                                    <form method="POST" action="" style="display:inline;">
                                        <input type="hidden" name="id" value="<?php echo $client['id']; ?>">
                                        <input type="hidden" name="table" value="client_register">
                                        <button type="submit" class="delete-btn" name="delete">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Client Profiles Cards -->
<div class="cards-container">
    <div class="card">
        <div class="table-container">
          <h2>Client Profiles</h2><br>
            <div class="table-wrapper">
                <table>
                    <thead>
                        <tr>
                            <th>Client ID</th>
                            <th>Phone</th>
                            <th>Address</th>
                            <th>City</th>
                            <th>Zip</th>
                            <th>Account Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($profile = mysqli_fetch_assoc($profileResult)) { ?>
                            <tr>
                                <td><?php echo $profile['user_id']; ?></td>
                                <td><?php echo $profile['phone']; ?></td>
                                <td><?php echo $profile['address']; ?></td>
                                <td><?php echo $profile['city']; ?></td>
                                <td><?php echo $profile['zip']; ?></td>
                                <td><?php echo $profile['account_status']; ?></td> <!-- Display Account Status -->
                                <td>
                                    <button type="button" class="edit-btn" onclick="openEditForm(
                                        'client_profiles',
                                        '<?php echo $profile['user_id']; ?>', 
                                        '', '', 
                                        '<?php echo $profile['account_status']; ?>', 
                                        '<?php echo $profile['phone']; ?>', 
                                        '<?php echo $profile['address']; ?>', 
                                        '<?php echo $profile['city']; ?>', 
                                        '<?php echo $profile['zip']; ?>'
                                    )">Edit</button>
                                    <form method="POST" action="" style="display:inline;">
                                        <input type="hidden" name="id" value="<?php echo $profile['user_id']; ?>">
                                        <input type="hidden" name="table" value="client_profiles">
                                        <button type="submit" class="delete-btn" name="delete">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>



    <!-- Edit Form for Client Register -->
<div id="editFormRegister" style="display:none;">
  <h2>Edit Client Register</h2>
  <form method="POST" action="">
    <input type="hidden" name="id" id="edit_id_register">
    <label for="fullname_register">Full Name</label>
    <input type="text" name="fullname" id="edit_fullname_register" required><br>

    <label for="email_register">Email</label>
    <input type="email" name="email" id="edit_email_register" required><br>

    <label for="account_status_register">Account Status</label>
    <select name="account_status" id="edit_account_status">
      <option value="Active">Active</option>
      <option value="Deactivated">Deactivated</option>
      <option value="Suspended">Suspended</option>
    </select><br>

    <button type="submit" name="update_register">Update Client Register</button>
    <button type="button" onclick="closeEditForm('editFormRegister')">Cancel</button>
  </form>
</div>

<!-- Edit Form for Client Profiles -->
<div id="editFormProfiles" style="display:none;">
  <h2>Edit Client Profiles</h2>
  <form method="POST" action="">
    <input type="hidden" name="id" id="edit_id_profiles">
    <label for="phone_profiles">Phone</label>
    <input type="text" name="phone" id="edit_phone_profiles" required><br>

    <label for="address_profiles">Address</label>
    <textarea name="address" id="edit_address_profiles" required></textarea><br>

    <label for="city_profiles">City</label>
    <input type="text" name="city" id="edit_city_profiles" required><br>

    <label for="zip_profiles">Zip</label>
    <input type="text" name="zip" id="edit_zip_profiles" required><br>

    <label for="account_status_profiles">Account Status</label>
    <select name="account_status" id="edit_account_status">
      <option value="Active">Active</option>
      <option value="Deactivated">Deactivated</option>
      <option value="Suspended">Suspended</option>
    </select><br>

    <button type="submit" name="update_profiles">Update Client Profiles</button>
    <button type="button" onclick="closeEditForm('editFormProfiles')">Cancel</button>
  </form>
</div>

<script>
function openEditForm(table, id, fullname, email, account_status, phone, address, city, zip) {
    if (table === 'client_register') {
        document.getElementById('edit_id_register').value = id;
        document.getElementById('edit_fullname_register').value = fullname;
        document.getElementById('edit_email_register').value = email;
        document.getElementById('edit_account_status').value = account_status;
        document.getElementById('editFormRegister').style.display = 'block';
    } else if (table === 'client_profiles') {
        document.getElementById('edit_id_profiles').value = id;
        document.getElementById('edit_phone_profiles').value = phone;
        document.getElementById('edit_address_profiles').value = address;
        document.getElementById('edit_city_profiles').value = city;
        document.getElementById('edit_zip_profiles').value = zip;
        document.getElementById('edit_account_status').value = account_status;
        document.getElementById('editFormProfiles').style.display = 'block';
    }
}

function closeEditForm(formId) {
    document.getElementById(formId).style.display = 'none';
}
</script>

</body>
</html>
