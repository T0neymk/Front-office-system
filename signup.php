<?php
// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Establish connection to the database
    $servername = "localhost"; // Change if your database server is on a different host
    $username = "root"; // Change if you have a different username for the database
    $password = ""; // Change if you have set a password for the database
    $dbname = "spa-front-office"; // Name of the database

    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Prepare and bind parameters
    $stmt = $conn->prepare("INSERT INTO users (fname, lname, email, password) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $fname, $lname, $email, $hashed_password);

    // Set parameters and execute
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Hash the password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    if ($stmt->execute() === TRUE) {
        // Redirect user to services.html
        header("Location: services.html");
        exit(); // Ensure script stops execution after redirection
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>
