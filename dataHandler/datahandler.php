<?php
class DataHandler {
    private $conn;

    //connect the database
    public function __construct($conn) {
        $this->conn = $conn;
    }

    // get the batch id and name for the drop down input field of batches  
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

    //View all batch details
    public function batchView() {
        $page = isset($_GET['page']) ? intval($_GET['page']) : 1;

        $itemsPerPage = 10; // Number of items to display per page
        $offset = ($page - 1) * $itemsPerPage;

        $sql = "SELECT *,CONCAT(DATE_FORMAT(time_from, '%h:%i %p'), ' - ' , DATE_FORMAT(time_to, '%h:%i %p')) AS duration FROM batch LIMIT $offset, $itemsPerPage";
        $result = $this->conn->query($sql);
        $data = array();

        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }

        $totalItemsQuery = "SELECT COUNT(*) as total FROM batch";
        $totalItemsResult = mysqli_query($this->conn, $totalItemsQuery);
        $totalItems = mysqli_fetch_assoc($totalItemsResult)['total'];


        $response = [
            'data' => $data,
            'totalItems' => $totalItems
        ];

        return $response;
    }

    // get the class id and name for the drop down input field of classes
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

    // generate the student id for the student enrollment form that add the student id field
    function generateStudentID() {
        $query = "SELECT MAX(student_id) as max_id FROM student";
        $result = $this->conn->query($query);
    
        if ($result->num_rows == 1) {
            $row = $result->fetch_assoc();
            $maxID = $row["max_id"];
            $nextID = "STU" . str_pad(($maxID + 1), 4, "0", STR_PAD_LEFT);
            return $nextID;
        } else {
            return "STU0001";
        }
    }

    //created the batch table
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

    //created the employee table
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

    //created the student enrollement
    public function enrollStudent($studentid, $name, $phone, $program, $batchid, $starton) {
        $response = array();

        // Define regular expressions for password strength, email, and phone number validation
        $phoneRegex = "/^\d{10}$/"; // Assuming a 10-digit phone number format

        // Perform data validation
        if (empty($name) || empty($phone) || empty($program) || empty($batchid) || empty($starton)) {
            $response['success'] = false;
            $response['message'] = "All fields are required.";
        } elseif (!preg_match($phoneRegex, $phone)) {
            $response['success'] = false;
            $response['message'] = "Invalid phone number. Please enter a 10-digit number.";
        } else {

                $numericPart = preg_replace('/[^0-9]/', '', $studentid);
                $stu_id=(int)$numericPart;

                // Insert the employee data into the database (assuming you have an "employees" table)
                $sql = "INSERT INTO student (name, phone) 
                VALUES ('$name', '$phone')";
                $sqlnext = "INSERT INTO assignstudent (batch_id, student_id, enrollment_date) 
                VALUES ('$batchid', '$stu_id','$starton')";

                if ($this->conn->query($sql) === TRUE) {
                    if($this->conn->query($sqlnext) === TRUE){
                        $response['success'] = true;
                        $response['message'] = "Student '$name' created successfully!";
                    }    
                } else {
                    $response['success'] = false;
                    $response['message'] = "Employee creation failed. Please try again.";
                }
        }

        return $response;
    }
}
?>