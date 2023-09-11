<?php
// Check if the request is a POST request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check if 'featureEnabled' is set in the POST data
    if (isset($_POST['featureEnabled'])) {
        // Retrieve the checkbox value
        $featureEnabled = ($_POST['featureEnabled'] === 'true') ? 1 : 0; // Convert to 1 or 0

        // Perform a database update using the $featureEnabled value
        // Replace this section with your actual database update logic
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "lms";

        // Create a database connection
        $conn = new mysqli($servername, $username, $password, $dbname);

        // Check the connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Update the database with the new checkbox value
        $sql = "UPDATE mine SET enable = $featureEnabled WHERE id = 1"; // Replace with your table and conditions
        if ($conn->query($sql) === TRUE) {
            // Database update successful
            echo "Database updated successfully.";
        } else {
            // Error updating database
            echo "Error updating database: " . $conn->error;
        }

        // Close the database connection
        $conn->close();
    } else {
        // 'featureEnabled' is not set in the POST data
        echo "Checkbox value not received.";
    }
} else {
    // Invalid request method
    echo "Invalid request method.";
}
?>
