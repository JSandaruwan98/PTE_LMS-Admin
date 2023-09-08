<?php
include 'conn.php';

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// SQL query to get the last entered student's ID
$sql = "SELECT student_id FROM student ORDER BY student_id DESC LIMIT 1";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Fetch the result as an associative array
    $row = $result->fetch_assoc();
    $lastStudentID = $row["id"];
    echo "The last entered student's ID is: " . $lastStudentID;
} else {
    echo "STU202300" . 1;
}

// Close the database connection
$conn->close();
?>
