<?php
// Start session to store user information and error messages
session_start();

// Include database connection file
require 'db_connection.php';

$error = "";

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Check if email exists in the admin_register table
    $stmt = $conn->prepare("SELECT * FROM admin_register WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        // Fetch admin data
        $admin = $result->fetch_assoc();

        // Verify the password
        if (password_verify($password, $admin['password'])) {
            // Store admin data in session and redirect to dashboard
            $_SESSION['admin_id'] = $admin['id'];
            $_SESSION['admin_fullname'] = $admin['fullname'];
            header("Location: Admin Home.php");
            exit;
        } else {
            $error = "Incorrect password. Please try again.";
        }
    } else {
        $error = "No account found with this email.";
    }

    $stmt->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login Page</title>
    <link rel="stylesheet" href="Admin Login Page.css">
</head>
<body>
    <header>
        <nav class="admin-link">
            <a href="login.php">Customer</a>
        </nav>
        <div class="logo">
            <img src="Images/Logo.png" alt="Logo">
        </div>
    </header>
    <main>
        <div class="login-container">
            <div class="login-left"></div>
            <div class="login-right">
                <h2>ADMIN LOGIN</h2>
                <form action="Admin Login.php" method="POST">                    
                    <div class="input-group">
                        <label for="email">Email</label>
                        <input type="email" id="email" name="email" placeholder="Enter your email" required>
                    </div>
                    <div class="input-group">
                        <label for="password">Password</label>
                        <input type="password" id="password" name="password" placeholder="Enter your password" required>
                    </div>
                    <?php if (!empty($error)): ?>
                        <div class="error-message"><?php echo htmlspecialchars($error); ?></div>
                    <?php endif; ?>
                    <br>
                    <button type="submit" class="login-btn">Log In</button>
                </form>
                <p class="signup-link">Don’t have an account? <a href="Admin Register.php">Sign up</a></p>
            </div>
        </div>
    </main>
</body>
</html>