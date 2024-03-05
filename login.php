<?php
// Database connection
$servername = "localhost"; // Assuming the database is hosted locally
$username = "root"; // Your MySQL username
$password = ""; // Your MySQL password (if any)
$dbname = "spa-front-office"; // Name of your database

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Form data
$email = $_POST['email'];
$password = $_POST['password'];

// Retrieve redirect URL
$redirect_url = isset($_POST['redirect_url']) ? $_POST['redirect_url'] : 'default_page.php'; // Set a default page in case redirect_url is not provided

// SQL query to fetch user from database
$sql = "SELECT * FROM users WHERE email='$email' AND password='$password'";
$result = $conn->query($sql);

// Check if user exists
if ($result->num_rows > 0) {
    // User found, redirect to desired page
    header("Location: $redirect_url");
    exit();
} else {
    // User not found or incorrect credentials
    echo "Invalid email or password. Please try again.";
}

// Close connection
$conn->close();
