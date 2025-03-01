<?php
$servername = "localhost";  // Your database server (usually localhost)
$username = "root";         // Your database username (usually root)
$password = "";             // Your database password (leave empty if not set)
$dbname = "enomyfinances";  // The name of your database

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
