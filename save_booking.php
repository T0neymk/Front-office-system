<?php
// Establish database connection (replace with your database credentials)
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

// Get form data
$firstName = $_POST['firstName'];
$lastName = $_POST['lastName'];
$date = $_POST['date'];
$email = $_POST['email'];
$age = $_POST['age'];
$phone = $_POST['phone'];
$gender = $_POST['gender'];
$service = $_POST['service'];
$description = $_POST['description'];

// SQL query to insert data into 'booking' table
$sql = "INSERT INTO booking (first_name, last_name, date, email, age, phone, gender, service, description)
        VALUES ('$firstName', '$lastName', '$date', '$email', '$age', '$phone', '$gender', '$service', '$description')";

if ($conn->query($sql) === TRUE) {
    // Redirect to pay.html after successful submission
    header("Location: pay.php");
    exit();
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

// Close connection
$conn->close();
?>
