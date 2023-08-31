<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "lms";

// Create a connection
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch data from the database
$query = "SELECT * FROM courses";
$result = $conn->query($query);

$data = array();
while ($row = $result->fetch_assoc()) {
    $data[] = $row;
}

// Close the connection
$conn->close();

// Return data as JSON
header("Content-Type: application/json");
echo json_encode($data);
?>
