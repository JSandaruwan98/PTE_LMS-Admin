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






$query = "SELECT * FROM mine";
$result = mysqli_query($conn, $query);

$data = array();
while ($row = mysqli_fetch_assoc($result)) {
    $data[] = $row;
}




$response = $data;
echo json_encode($response);
header('Content-Type: application/json');
?>
