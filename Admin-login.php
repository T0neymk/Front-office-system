<?php
// Start session to store admin login status
session_start();

$host = "localhost";
$username = "root";
$password = "";
$database = "spa-front-office";

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if the email and password are set
    if (isset($_POST['emlog']) && isset($_POST['passlog'])) {
        // Retrieve email and password from the form
        $email = $_POST['emlog'];
        $password = $_POST['passlog'];
        
        // Your database connection code (replace with your actual connection code)
        $mysqli = new mysqli("localhost", "root", "", "spa-front-office");

        // Check connection
        if ($mysqli->connect_error) {
            die("Connection failed: " . $mysqli->connect_error);
        }

        // Prepare and execute query to check if admin credentials are correct
        $stmt = $mysqli->prepare("SELECT * FROM admin_table WHERE email = ? AND password = ?");
        $stmt->bind_param("ss", $email, $password);
        $stmt->execute();
        $result = $stmt->get_result();

        // If admin credentials are correct, redirect to dashboard
        if ($result->num_rows == 1) {
            // Set session variable to indicate admin is logged in
            $_SESSION['admin_loggedin'] = true;
            header("Location: dashboard.php"); // Redirect to dashboard page
            exit(); // Prevent further execution
        } else {
            // If credentials are incorrect, display error message
            echo "Invalid email or password.";
        }

        // Close database connection
        $mysqli->close();
    } else {
        echo "Invalid request.";
    }
}
?>
