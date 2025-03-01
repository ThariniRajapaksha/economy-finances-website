<?php
// Include database connection file
include('db_connection.php');

// Handle Add Finance Staff
if (isset($_POST['add_staff'])) {
    $full_name = $_POST['full_name'];
    $email = $_POST['email'];
    $position = $_POST['position'];
    $salary = $_POST['salary'];
    $phone = $_POST['phone'];
    $hire_date = $_POST['hire_date'];
    $address = $_POST['address'];
    $department = $_POST['department'];
    $status = $_POST['status'];
    $profile_picture = $_POST['profile_picture'];
    $dob = $_POST['dob'];
    $gender = $_POST['gender'];

    $query = "INSERT INTO finance_staff (full_name, email, position, salary, phone, hire_date, address, department, status, profile_picture, dob, gender) 
              VALUES ('$full_name', '$email', '$position', '$salary', '$phone', '$hire_date', '$address', '$department', '$status', '$profile_picture', '$dob', '$gender')";
    mysqli_query($conn, $query);
    header("Location: Admin staff-profile.php");
}

// Handle Edit Finance Staff
if (isset($_POST['edit_staff'])) {
    $id = $_POST['id'];
    $full_name = $_POST['full_name'];
    $email = $_POST['email'];
    $position = $_POST['position'];
    $salary = $_POST['salary'];
    $phone = $_POST['phone'];
    $hire_date = $_POST['hire_date'];
    $address = $_POST['address'];
    $department = $_POST['department'];
    $status = $_POST['status'];
    $profile_picture = $_POST['profile_picture'];
    $dob = $_POST['dob'];
    $gender = $_POST['gender'];

    $query = "UPDATE finance_staff SET full_name = '$full_name', email = '$email', position = '$position', salary = '$salary', phone = '$phone', 
              hire_date = '$hire_date', address = '$address', department = '$department', status = '$status', profile_picture = '$profile_picture', 
              dob = '$dob', gender = '$gender' WHERE id = $id";
    mysqli_query($conn, $query);
    header("Location: Admin staff-profile.php");
}

// Handle Delete Finance Staff
if (isset($_GET['delete_id'])) {
    $id = $_GET['delete_id'];
    $query = "DELETE FROM finance_staff WHERE id = $id";
    mysqli_query($conn, $query);
    header("Location: Admin staff-profile.php");
}

// Fetch all finance staff
$query = "SELECT * FROM finance_staff";
$result = mysqli_query($conn, $query);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Enomy-Finances Dashboard</title>
  <link rel="stylesheet" href="Admin staff-profile.css">
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
      <!-- Advice and Guide Card Section -->
        <div class="card">
            <h1>Finance Staff Management</h1><br>
            <p>Here are some useful tips and guidelines for managing the finance staff:</p>
            <ul>
                <li><strong>Staff Profile Management:</strong> Ensure that all staff information is updated regularly for better data integrity.</li>
                <li><strong>Salary Review:</strong> Regularly assess the salary structure to maintain competitive pay and job satisfaction.</li>
                <li><strong>Onboarding New Staff:</strong> Make sure to provide proper orientation to new finance staff to set clear expectations.</li>
                <li><strong>Leave Tracking:</strong> Maintain accurate records of leave requests and balances to avoid discrepancies.</li>
                <li><strong>Profile Picture:</strong> Encourage staff to upload a professional profile picture for a more personal touch.</li>
            </ul>
        </div>



      <!-- Add Staff Form -->
      <form method="POST">
            <h2>Add New Staff Member</h2><br>
            
            <!-- Full Name -->
            <label for="full_name">Full Name</label>
            <input type="text" id="full_name" name="full_name" placeholder="Full Name" required>
            
            <!-- Email -->
            <label for="email">Email</label>
            <input type="email" id="email" name="email" placeholder="Email" required>
            
            <!-- Position -->
            <label for="position">Position</label>
            <select id="position" name="position" required>
                <option value="Finance Manager">Finance Manager</option>
                <option value="Accountant">Accountant</option>
                <option value="Financial Analyst">Financial Analyst</option>
                <option value="Tax Specialist">Tax Specialist</option>
                <option value="Audit Officer">Audit Officer</option>
            </select>
            
            <!-- Salary -->
            <label for="salary">Salary</label>
            <input type="number" id="salary" name="salary" placeholder="Salary" required>
            
            <!-- Phone -->
            <label for="phone">Phone</label>
            <input type="text" id="phone" name="phone" placeholder="Phone" required>
            
            <!-- Hire Date -->
            <label for="hire_date">Hire Date</label>
            <input type="date" id="hire_date" name="hire_date" placeholder="Hire Date" required>
            
            <!-- Address -->
            <label for="address">Address</label>
            <textarea id="address" name="address" placeholder="Address" required></textarea>
            
            <!-- Department -->
            <label for="department">Department</label>
            <select id="department" name="department" required>
                <option value="Accounting">Accounting</option>
                <option value="Audit">Audit</option>
                <option value="Taxation">Taxation</option>
                <option value="Financial Planning">Financial Planning</option>
                <option value="Financial Reporting">Financial Reporting</option>
            </select>
            
            <!-- Status -->
            <label for="status">Status</label>
            <select id="status" name="status" required>
                <option value="Active">Active</option>
                <option value="Inactive">Inactive</option>
                <option value="On Leave">On Leave</option>
            </select>
            
            <!-- Profile Picture -->
            <label for="profile_picture">Profile Picture URL</label>
            <input type="text" id="profile_picture" name="profile_picture" placeholder="Profile Picture URL">
            
            <!-- Date of Birth -->
            <label for="dob">Date of Birth</label>
            <input type="date" id="dob" name="dob" placeholder="Date of Birth" required>
            
            <!-- Gender -->
            <label for="gender">Gender</label>
            <select id="gender" name="gender" required>
                <option value="Male">Male</option>
                <option value="Female">Female</option>
                <option value="Other">Other</option>
            </select>
            
            <!-- Submit Button -->
            <button type="submit" name="add_staff">Add Staff</button>
        </form>


      <!-- Staff Table -->
      <h2>Staff Members Profiles</h2><br>
      <table border="1" cellpadding="10" cellspacing="0">
          <thead>
              <tr>
                  <th>ID</th>
                  <th>Full Name</th>
                  <th>Email</th>
                  <th>Position</th>
                  <th>Salary</th>
                  <th>Phone</th>
                  <th>Actions</th>
              </tr>
          </thead>
          <tbody>
              <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                  <tr>
                      <td><?php echo $row['id']; ?></td>
                      <td><?php echo $row['full_name']; ?></td>
                      <td><?php echo $row['email']; ?></td>
                      <td><?php echo $row['position']; ?></td>
                      <td><?php echo $row['salary']; ?></td>
                      <td><?php echo $row['phone']; ?></td>
                      <td>
                          <a href="#editModal" class="edit-link" onclick="editStaff(<?php echo $row['id']; ?>, '<?php echo $row['full_name']; ?>', '<?php echo $row['email']; ?>', '<?php echo $row['position']; ?>', '<?php echo $row['salary']; ?>', '<?php echo $row['phone']; ?>', '<?php echo $row['hire_date']; ?>', '<?php echo $row['address']; ?>', '<?php echo $row['department']; ?>', '<?php echo $row['status']; ?>', '<?php echo $row['profile_picture']; ?>', '<?php echo $row['dob']; ?>', '<?php echo $row['gender']; ?>')">Edit</a>
                          <a href="?delete_id=<?php echo $row['id']; ?>" class="delete-link" onclick="return confirm('Are you sure?')">Delete</a>
                      </td>
                  </tr>
              <?php } ?>
          </tbody>
      </table>
    </main>
  </div>

  <!-- Edit Staff Modal -->
  <div id="editModal" style="display:none;">
    <form method="POST">
        <h2>Edit Staff</h2><br>
        <input type="hidden" name="id" id="edit_id">
        <input type="text" name="full_name" id="edit_full_name" required>
        <input type="email" name="email" id="edit_email" required>
        <input type="text" name="position" id="edit_position" required>
        <input type="number" name="salary" id="edit_salary" required>
        <input type="text" name="phone" id="edit_phone" required>
        <input type="date" name="hire_date" id="edit_hire_date" required>
        <textarea name="address" id="edit_address" required></textarea>
        <input type="text" name="department" id="edit_department" required>
        <select name="status" id="edit_status" required>
            <option value="Active">Active</option>
            <option value="Inactive">Inactive</option>
            <option value="On Leave">On Leave</option>
        </select>
        <input type="text" name="profile_picture" id="edit_profile_picture">
        <input type="date" name="dob" id="edit_dob" required>
        <select name="gender" id="edit_gender" required>
            <option value="Male">Male</option>
            <option value="Female">Female</option>
            <option value="Other">Other</option>
        </select>
        <button type="submit" name="edit_staff">Update Staff</button>
        <button type="button" onclick="closeEditModal()">Cancel</button>
    </form>
  </div>

  <script>
      function editStaff(id, full_name, email, position, salary, phone, hire_date, address, department, status, profile_picture, dob, gender) {
          document.getElementById('edit_id').value = id;
          document.getElementById('edit_full_name').value = full_name;
          document.getElementById('edit_email').value = email;
          document.getElementById('edit_position').value = position;
          document.getElementById('edit_salary').value = salary;
          document.getElementById('edit_phone').value = phone;
          document.getElementById('edit_hire_date').value = hire_date;
          document.getElementById('edit_address').value = address;
          document.getElementById('edit_department').value = department;
          document.getElementById('edit_status').value = status;
          document.getElementById('edit_profile_picture').value = profile_picture;
          document.getElementById('edit_dob').value = dob;
          document.getElementById('edit_gender').value = gender;
          document.getElementById('editModal').style.display = 'block';
      }

      function closeEditModal() {
          document.getElementById('editModal').style.display = 'none';
      }
  </script>

</body>
</html>
