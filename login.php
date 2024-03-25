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

// Prepare statement to fetch user from database
$stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

// Check if user exists
if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
    // Verify hashed password
    if (password_verify($password, $user['password'])) {
        // Password matches, set login status in localStorage
        echo "Login successful";
        echo "<script>localStorage.setItem('isLoggedIn', 'true');</script>";
        
        // Redirect to services.html
        echo "<script>window.location.href = 'services.html';</script>";
    } else {
        // Incorrect password
        echo "Invalid email or password. Please try again.";
    }
} else {
    // User not found
    echo "Invalid email or password. Please try again.";
}

// Close statement and connection
$stmt->close();
$conn->close();
?>
