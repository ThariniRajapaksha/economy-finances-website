<?php
session_start();

// Include database connection file
require 'db_connection.php';

$error = ""; // To store error messages

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve and sanitize input
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    // Validate email and password
    if (empty($email) || empty($password)) {
        $error = "Email and Password are required.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Invalid email format.";
    } else {
        // Prepare a statement to find the user by email
        $stmt = $conn->prepare("SELECT * FROM client_register WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows == 1) {
            $user = $result->fetch_assoc();
            
            // Check if the account is active
            if ($user['account_status'] === "Active") {
                // Verify the password
                if (password_verify($password, $user['password'])) {
                    // Store user info in the session
                    $_SESSION['user_id'] = $user['id'];
                    $_SESSION['fullname'] = $user['fullname'];
                    $_SESSION['email'] = $user['email'];

                    // Redirect to the dashboard or homepage
                    header("Location: home.php");
                    exit;
                } else {
                    $error = "Invalid password. Please try again.";
                }
            } else {
                $error = "Your account is currently " . htmlspecialchars($user['account_status']) . ". Please contact support.";
            }
        } else {
            $error = "No account found with that email.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <link rel="stylesheet" href="login.css">
</head>
<body>
    <header>
        <nav class="admin-link">
            <a href="Admin Login.php">Administrator</a>
        </nav>
        <h1>Welcome to Enomy-Finances</h1>
        <div class="logo">
            <img src="Images/Logo.png" alt="Logo">
        </div>
    </header>
    <main>
        <div class="login-container">
            <div class="login-right">
                <h2>LOGIN</h2>
                <form action="login.php" method="POST">                    
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
                <p class="signup-link">Don’t have an account? <a href="register.php">Sign up</a></p>
            </div>
        </div>
    </main>
</body>
</html>