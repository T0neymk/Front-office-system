<?php
session_start(); // Start the session to use session variables

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "userdb";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Retrieve data
$fname = $_POST['fname'];
$lname = $_POST['lname'];
$email = $_POST['email'];
$password = $_POST['password'];

// SQL query to insert the data into the 'users' table
$sql = "INSERT INTO users (first_name, last_name, email, password) VALUES ('$fname', '$lname', '$email', '$password')";

// Check if the SQL query has been executed successfully
if ($conn->query($sql) === TRUE) {
    echo "Signup successful";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

// Close connection
$conn->close();

header("Location: services.html");
exit();
?>
