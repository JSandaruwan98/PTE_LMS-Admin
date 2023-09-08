<?php
class DataHandler {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function getBatchData() {
        $sql = "SELECT * FROM batch";
        $result = $this->conn->query($sql);
        $data = array();

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $data[] = $row;
            }
        }

        return $data;
    }

    public function getClassData() {
        $sql = "SELECT * FROM class";
        $result = $this->conn->query($sql);
        $data = array();

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $data[] = $row;
            }
        }

        return $data;
    }

    public function createBatch($program, $class, $batchname, $timefrom, $timeto) {
        $response = array();

        // Perform data validation
        if (empty($program) || empty($class) || empty($batchname) || empty($timefrom) || empty($timeto)) {
            $response['success'] = false;
            $response['message'] = "All fields are required.";
        } else {
            // Data is valid, proceed with database insertion

            // Insert the batch data into the database (assuming you have a "batch" table)
            $sql = "INSERT INTO batch (name, program, class_id, time_from, time_to) 
                    VALUES ('$batchname', '$program', '$class', '$timefrom', '$timeto')";

            if ($this->conn->query($sql) === TRUE) {
                $response['success'] = true;
                $response['message'] = "Batch '$batchname' created successfully!";
            } else {
                $response['success'] = false;
                $response['message'] = "Batch creation failed. Please try again.";
            }
        }

        return $response;
    }

    public function createEmployee($name, $email, $role, $phone, $address, $qualification, $uname, $pass) {
        $response = array();

        // Define regular expressions for password strength, email, and phone number validation
        $passwordRegex = "/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]+$/";
        $emailRegex = "/^\S+@\S+\.\S+$/";
        $phoneRegex = "/^\d{10}$/"; // Assuming a 10-digit phone number format

        // Perform data validation
        if (empty($name) || empty($email) || empty($role) || empty($phone) || empty($address) || empty($qualification) || empty($uname) || empty($pass)) {
            $response['success'] = false;
            $response['message'] = "All fields are required.";
        } elseif (!preg_match($passwordRegex, $pass)) {
            $response['success'] = false;
            $response['message'] = "Password must contain at least one uppercase letter, one lowercase letter, one number, and one special character.";
        } elseif (!preg_match($emailRegex, $email)) {
            $response['success'] = false;
            $response['message'] = "Invalid email address.";
        } elseif (!preg_match($phoneRegex, $phone)) {
            $response['success'] = false;
            $response['message'] = "Invalid phone number. Please enter a 10-digit number.";
        } else {
                // Data is valid, proceed with database insertion

                // Hash the password before storing it in the database (for security)
                $hashedPassword = password_hash($pass, PASSWORD_DEFAULT);

                // Insert the employee data into the database (assuming you have an "employees" table)
                $sql = "INSERT INTO employee (name, email, role, phone, address, qualification, username, password) 
                        VALUES ('$name', '$email', '$role', '$phone', '$address', '$qualification', '$uname', '$hashedPassword')";

                if ($this->conn->query($sql) === TRUE) {
                    $response['success'] = true;
                    $response['message'] = "Employee '$name' created successfully!";
                } else {
                    $response['success'] = false;
                    $response['message'] = "Employee creation failed. Please try again.";
                }
        }

        return $response;
    }

    public function enrollStudent($program, $class, $batchname, $timefrom, $timeto) {
        $response = array();

        // Perform data validation
        if (empty($program) || empty($class) || empty($batchname) || empty($timefrom) || empty($timeto)) {
            $response['success'] = false;
            $response['message'] = "All fields are required.";
        } else {
            // Data is valid, proceed with database insertion

            // Insert the batch data into the database (assuming you have a "batch" table)
            $sql = "INSERT INTO batch (name, program, class_id, time_from, time_to) 
                    VALUES ('$batchname', '$program', '$class', '$timefrom', '$timeto')";

            if ($this->conn->query($sql) === TRUE) {
                $response['success'] = true;
                $response['message'] = "Batch '$batchname' created successfully!";
            } else {
                $response['success'] = false;
                $response['message'] = "Batch creation failed. Please try again.";
            }
        }

        return $response;
    }
}
?>
