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



$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
$itemsPerPage = 2; // Number of items to display per page
$offset = ($page - 1) * $itemsPerPage;

$query = "SELECT * FROM courses LIMIT $offset, $itemsPerPage";
$result = mysqli_query($conn, $query);

$data = [];
while ($row = mysqli_fetch_assoc($result)) {
    $data[] = $row;
}

$totalItemsQuery = "SELECT COUNT(*) as total FROM courses";
$totalItemsResult = mysqli_query($conn, $totalItemsQuery);
$totalItems = mysqli_fetch_assoc($totalItemsResult)['total'];


$response = [
    'data' => $data,
    'totalItems' => $totalItems
];
echo json_encode($response);

?>
