
<?php

        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "spa-front-office";

        // Create connection
        $mysqli = new mysqli("localhost", "root", "", "spa-front-office");

        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Retrieve user details and appointments
        $sql = "SELECT u.fname, u.lname, u.email, a.appointment_date, a.appointment_time
                FROM users u
                INNER JOIN appointments a ON u.user_id = a.user_id
                ORDER BY a.appointment_date ASC";

        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            // Output data of each row
            while ($row = $result->fetch_assoc()) {
                echo "<div class='cards'>";
                echo "<p><strong>First Name:</strong> " . $row["first_name"] . "</p>";
                echo "<p><strong>Last Name:</strong> " . $row["last_name"] . "</p>";
                echo "<p><strong>Date:</strong> " . $row["date"] . "</p>";
                echo "<p><strong>Email:</strong> " . $row["email"] . "</p>";
                echo "<p><strong>Age:</strong> " . $row["age"] . "</p>";
                echo "<p><strong>Phone Number:</strong> " . $row["phone"] . "</p>";
                echo "<p><strong>Gender:</strong> " . $row["gender"] . "</p>";
                echo "<p><strong>Service:</strong> " . $row["service"] . "</p>";
                echo "<p><strong>Description:</strong> " . $row["description"] . "</p>";
                 
                echo "</div>";
            }
        } else {
            echo "<tr><td colspan='5'>No appointments found.</td></tr>";
        }

        $conn->close();
        ?>