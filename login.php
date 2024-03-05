<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "spa-front-office";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Form data
$email = $_POST['email'];
$password = $_POST['password'];

// SQL query to fetch user from database
$sql = "SELECT * FROM users WHERE email='$email' AND password='$password'";
$result = $conn->query($sql);

// Check if user exists
if ($result->num_rows > 0) {
    // User found, set login status in localStorage
    echo "Login successful";
    echo "<script>localStorage.setItem('isLoggedIn', 'true');</script>";
    
    // Redirect to services.html
    echo "<script>window.location.href = 'services.html';</script>";
} else {
    // User not found or incorrect credentials
    echo "Invalid email or password. Please try again.";
}

// Close connection
$conn->close();
?>
