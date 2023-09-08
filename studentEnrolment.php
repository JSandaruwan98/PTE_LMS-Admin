<?php
// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data and perform basic sanitation
    $name = trim($_POST["name"]);
    $phone = trim($_POST["phone"]);
    $program = trim($_POST["program"]);
    $batchname = trim($_POST["batchname"]);
    $starton = trim($_POST["starton"]);
    $days = $_POST["days"];

    // Define regular expressions for password strength, email, and phone number validation
    $phoneRegex = "/^\d{10}$/"; // Assuming a 10-digit phone number format

    $response = array();

    // Perform data validation
    if (empty($name) || empty($email) || empty($role) || empty($phone) || empty($address) || empty($qualification) || empty($uname) || empty($pass)) {
        $response['success'] = false;
        $response['message'] = "All fields are required.";
    } elseif (!preg_match($phoneRegex, $phone)) {
        $response['success'] = false;
        $response['message'] = "Invalid phone number. Please enter a 10-digit number.";
    } else {
        // Data is valid, proceed with database insertion

        include 'conn.php';

        // Hash the password before storing it in the database (for security)
        $hashedPassword = password_hash($pass, PASSWORD_DEFAULT);

        // Insert the employee data into the database (assuming you have an "employees" table)
        $sql = "INSERT INTO employee (name, email, role, phone, address, qualification, username, password) 
                VALUES ('$name', '$email', '$role', '$phone', '$address', '$qualification', '$uname', '$hashedPassword')";

        if ($conn->query($sql) === TRUE) {
            $response['success'] = true;
            $response['message'] = "Employee '$name' created successfully!";
        } else {
            $response['success'] = false;
            $response['message'] = "Employee creation failed. Please try again.";
        }

        // Close the database connection
        $conn->close();
    }

    header('Content-Type: application/json');
    echo json_encode($response);
}
?>
