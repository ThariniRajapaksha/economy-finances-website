<?php
// Start the session
session_start();

// Unset all session variables to log the user out
session_unset();

// Destroy the session
session_destroy();

// Display the Thank You message in a styled box
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Font Awesome CDN link -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <title>Logout - Thank You</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            background-color: #f0f0f0;
        }
        .thank-you-box {
            width: 80%;
            max-width: 500px;
            padding: 20px;
            background-color: #4CAF50;
            color: white;
            text-align: center;
            border-radius: 8px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
        }
        .thank-you-box h1 {
            font-size: 24px;
            margin-bottom: 10px;
        }
        .thank-you-box p {
            font-size: 16px;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>

    <div class="thank-you-box">
        <h1>Thank you for visiting Enomy-Finances!  <i class="fa-solid fa-handshake"></i></h1>
        <p>You have been logged out successfully.</p>
        <p>Redirecting you to the login page...</p>
    </div>

    <?php
    // Redirect the user to the login page after 3 seconds
    header("refresh:3; url=login.php");
    exit;
    ?>

</body>
</html>
