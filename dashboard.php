<?php
// Handle delete action if the request is POST
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["delete_booking"])) {
    // Database connection
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "spa-front-office";

    // Create connection
    $mysqli = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($mysqli->connect_error) {
        die("Connection failed: " . $mysqli->connect_error);
    }

    // Get the booking ID to delete
    $bookingIdToDelete = $_POST["delete_booking"];

    // Prepare and execute DELETE query
    $sql = "DELETE FROM booking WHERE id = ?";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("i", $bookingIdToDelete);
    $stmt->execute();

    // Close statement and connection
    $stmt->close();
    $mysqli->close();

    // Redirect to refresh the page after deletion
    header("Location: dashboard.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="dashboard.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>
<body>
    <div class="container">
        <h1>Admin Dashboard</h1>
        <div class="cards-container">
            <?php
            // Database connection
            $servername = "localhost";
            $username = "root";
            $password = "";
            $dbname = "spa-front-office";

            // Create connection
            $mysqli = new mysqli($servername, $username, $password, $dbname);

            // Check connection
            if ($mysqli->connect_error) {
                die("Connection failed: " . $mysqli->connect_error);
            }

            // Retrieve user details and appointments
            $sql = "SELECT * FROM booking";

            $result = $mysqli->query($sql);

            if ($result->num_rows > 0) {
                // Output data of each row
                while ($row = $result->fetch_assoc()) {
                    echo "<div class='card'>";
                    echo "<p><strong>First Name:</strong> " . $row["first_name"] . "</p>";
                    echo "<p><strong>Last Name:</strong> " . $row["last_name"] . "</p>";
                    echo "<p><strong>Date:</strong> " . $row["date"] . "</p>";
                    echo "<p><strong>Email:</strong> " . $row["email"] . "</p>";
                    echo "<p><strong>Age:</strong> " . $row["age"] . "</p>";
                    echo "<p><strong>Phone Number:</strong> " . $row["phone"] . "</p>";
                    echo "<p><strong>Gender:</strong> " . $row["gender"] . "</p>";
                    echo "<p><strong>Service:</strong> " . $row["service"] . "</p>";
                    echo "<p><strong>Description:</strong> " . $row["description"] . "</p>";
                    echo "<button class='delete-btn' data-id='" . $row["id"] . "'><i class='fas fa-trash'></i> Delete</button>";
                    echo "</div>";
                }
            } else {
                echo "<div class='card'>No bookings found.</div>";
            }

            $mysqli->close();
            ?>
        </div>
    </div>
    <script>
         // JavaScript to handle delete button click
         document.addEventListener('DOMContentLoaded', function () {
            var deleteButtons = document.querySelectorAll('.delete-btn');
            deleteButtons.forEach(function (button) {
                button.addEventListener('click', function () {
                    var bookingId = button.getAttribute('data-id');
                    if (confirm("Are you sure you want to delete this booking?")) {
                        // Redirect or perform AJAX request to delete the booking with the ID bookingId
                        // For demonstration, let's just log the ID to console
                        console.log("Deleting booking with ID:", bookingId);
                    }
                });
            });
        });
    </script>
    </script>
</body>
</html>
