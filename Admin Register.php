<?php
session_start();

require 'db_connection.php';
$error = ''; // Initialize error message

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Retrieve form data
    $fullname = $_POST['fullname'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm-password'];

    // Basic validation
    if (empty($fullname) || empty($email) || empty($password) || empty($confirm_password)) {
        $error = "All fields are required.";
    } elseif ($password !== $confirm_password) {
        $error = "Passwords do not match.";
    } else {
        // Hash the password before storing it
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Check if the email already exists in the database
        $sql = "SELECT * FROM admin_register WHERE email = '$email'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $error = "Email is already registered.";
        } else {
            // Insert the new admin data into the database
            $sql = "INSERT INTO admin_register (fullname, email, password, created_at)
                    VALUES ('$fullname', '$email', '$hashed_password', NOW())";

            if ($conn->query($sql) === TRUE) {
                // Redirect to login page after successful registration
                header("Location: Admin Login.php");
                exit();
            } else {
                $error = "Error: " . $conn->error;
            }
        }
    }
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Page</title>
    <link rel="stylesheet" href="Admin Register.css">
</head>
<body>
    <header>
        <div class="logo">
            <img src="Images/Logo.png" alt="Logo">
        </div>
    </header>
    <br>
    <main>
        <div class="login-container">
            <div class="login-left"></div>
            <div class="login-right">
                <h2>ADMIN REGISTER</h2>
                <form action="Admin Register.php" method="POST">
                    <div class="input-group">
                        <label for="fullname">Full Name</label>
                        <input type="text" id="fullname" name="fullname" placeholder="Enter your full name" 
                               value="<?php echo htmlspecialchars($_POST['fullname'] ?? ''); ?>" required>
                    </div>
                    <div class="input-group">
                        <label for="email">Email</label>
                        <input type="email" id="email" name="email" placeholder="Enter your email" 
                               value="<?php echo htmlspecialchars($_POST['email'] ?? ''); ?>" required>
                    </div>
                    <div class="input-group">
                        <label for="password">Password</label>
                        <input type="password" id="password" name="password" placeholder="Enter your password" required>
                    </div>
                    <div class="input-group">
                        <label for="confirm-password">Confirm Password</label>
                        <input type="password" id="confirm-password" name="confirm-password" placeholder="Confirm your password" required>
                    </div>
                    <?php if (!empty($error)): ?>
                        <div class="error-message"><?php echo htmlspecialchars($error); ?></div>
                    <?php endif; ?>
                    <br>
                    <button type="submit" class="login-btn">Register</button>
                </form>
                
                <p class="signup-link">Already have an account? <a href="Admin Login.php">Log in</a></p>
            </div>
        </div>
    </main>
</body>
</html>