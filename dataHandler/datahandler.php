<?php
class DataHandler {
    private $conn;

    //connect the database
    public function __construct($conn) {
        $this->conn = $conn;
    }

    // get the batch id and name for the drop down input field of batches  
    public function getBatchData() {
        $sql = "SELECT *,CONCAT(DATE_FORMAT(time_from, '%h:%i %p'), ' - ' , DATE_FORMAT(time_to, '%h:%i %p')) AS duration FROM batch WHERE activation = 1";
        $result = $this->conn->query($sql);
        $data = array();

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $data[] = $row;
            }
        }

        return $data;
    }


    // get the batch id and name for the drop down input field of batches  
    public function balance() {
        $sql = "SELECT
                    total_credits - total_other_transactions AS balance
                FROM
                    (SELECT
                        SUM(CASE WHEN transactiontype = 'credit' THEN amount ELSE 0 END) AS total_credits,
                        SUM(CASE WHEN transactiontype <> 'credit' THEN amount ELSE 0 END) AS total_other_transactions
                    FROM
                        transaction) AS subquery";
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
        $page=0;
    }

    //View all Ticket details
    public function support() {
        $page = isset($_GET['page']) ? intval($_GET['page']) : 1;

        $itemsPerPage = 10; // Number of items to display per page
        $offset = ($page - 1) * $itemsPerPage;

        $sql = "SELECT * FROM ticket LIMIT $offset, $itemsPerPage";
        $result = $this->conn->query($sql);
        $data = array();

        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }

        $totalItemsQuery = "SELECT COUNT(*) as total FROM ticket";
        $totalItemsResult = mysqli_query($this->conn, $totalItemsQuery);
        $totalItems = mysqli_fetch_assoc($totalItemsResult)['total'];


        $response = [
            'data' => $data,
            'totalItems' => $totalItems
        ];

        return $response;
        $page=0;
    }

    //View all transaction details
    public function transaction() {
        $page = isset($_GET['page']) ? intval($_GET['page']) : 1;

        $itemsPerPage = 10; // Number of items to display per page
        $offset = ($page - 1) * $itemsPerPage;

        $sql = "SELECT * FROM transaction LIMIT $offset, $itemsPerPage";
        $result = $this->conn->query($sql);
        $data = array();

        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }

        $totalItemsQuery = "SELECT COUNT(*) as total FROM transaction";
        $totalItemsResult = mysqli_query($this->conn, $totalItemsQuery);
        $totalItems = mysqli_fetch_assoc($totalItemsResult)['total'];


        $response = [
            'data' => $data,
            'totalItems' => $totalItems
        ];

        return $response;
        $page=0;
    }


    //View all employee details
    public function pendingEvaluation() {
        $page = isset($_GET['page']) ? intval($_GET['page']) : 1;

        $itemsPerPage = 10; // Number of items to display per page
        $offset = ($page - 1) * $itemsPerPage;

        $sql = "SELECT DISTINCT e.evaluation_id AS id, stu.name AS student_name, te.name AS test_name, e.attempted_on AS attempted_on, t.assigned_on AS assigned_on
                FROM assignstudent AS s
                JOIN evaluation AS e ON s.student_id = e.student_id
                JOIN testass AS t ON t.test_id = e.test_id
                JOIN student AS stu ON s.student_id = stu.student_id
                JOIN test AS te ON te.test_id = t.test_id
                WHERE e.attempted_on IS NOT NULL";
        $result = $this->conn->query($sql);
        $data = array();

        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }

        $totalItemsQuery = "SELECT COUNT(*) as total FROM assignstudent AS s
                            JOIN evaluation AS e ON s.student_id = e.student_id
                            JOIN testass AS t ON t.test_id = e.test_id
                            JOIN student AS stu ON s.student_id = stu.student_id
                            JOIN test AS te ON te.test_id = t.test_id;";
        $totalItemsResult = mysqli_query($this->conn, $totalItemsQuery);
        $totalItems = mysqli_fetch_assoc($totalItemsResult)['total'];


        $response = [
            'data' => $data,
            'totalItems' => $totalItems
        ];

        return $response;
    }


    //View all employee details
    public function evaluationHistory() {
        $page = isset($_GET['page']) ? intval($_GET['page']) : 1;

        $itemsPerPage = 10; // Number of items to display per page
        $offset = ($page - 1) * $itemsPerPage;

        $sql = "SELECT DISTINCT e.evaluation_id AS id, e.evaluation_on AS evaluation_on, stu.name AS student_name, te.name AS test_name, e.attempted_on AS attempted_on, t.assigned_on AS assigned_on
                FROM assignstudent AS s
                JOIN evaluation AS e ON s.student_id = e.student_id
                JOIN testass AS t ON t.test_id = e.test_id
                JOIN student AS stu ON s.student_id = stu.student_id
                JOIN test AS te ON te.test_id = t.test_id
                WHERE e.evaluation_on IS NOT NULL";
        $result = $this->conn->query($sql);
        $data = array();

        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }

        $totalItemsQuery = "SELECT COUNT(*) as total FROM assignstudent AS s
                            JOIN evaluation AS e ON s.student_id = e.student_id
                            JOIN testass AS t ON t.test_id = e.test_id
                            JOIN student AS stu ON s.student_id = stu.student_id
                            JOIN test AS te ON te.test_id = t.test_id
                            WHERE e.evaluation_on IS NOT NULL";
        $totalItemsResult = mysqli_query($this->conn, $totalItemsQuery);
        $totalItems = mysqli_fetch_assoc($totalItemsResult)['total'];


        $response = [
            'data' => $data,
            'totalItems' => $totalItems
        ];

        return $response;
    }

    

    //View all employee details
    public function employeeView() {
        $page = isset($_GET['page']) ? intval($_GET['page']) : 1;

        $itemsPerPage = 10; // Number of items to display per page
        $offset = ($page - 1) * $itemsPerPage;

        $sql = "SELECT * FROM employee LIMIT $offset, $itemsPerPage";
        $result = $this->conn->query($sql);
        $data = array();

        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }

        $totalItemsQuery = "SELECT COUNT(*) as total FROM employee";
        $totalItemsResult = mysqli_query($this->conn, $totalItemsQuery);
        $totalItems = mysqli_fetch_assoc($totalItemsResult)['total'];


        $response = [
            'data' => $data,
            'totalItems' => $totalItems
        ];

        return $response;
    }

    //View all batch details
    public function studentView() {
        $page = isset($_GET['page']) ? intval($_GET['page']) : 1;

        $itemsPerPage = 10; // Number of items to display per page
        $offset = ($page - 1) * $itemsPerPage;

        $sql = "SELECT S.activation AS activation,S.student_id AS student_id, S.name AS student_name, S.phone AS phone, B.program AS program, B.name AS batch_name
                FROM student AS S, assignstudent AS SB, batch AS B 
                WHERE S.student_id = SB.student_id AND B.batch_id = SB.batch_id
                LIMIT $offset, $itemsPerPage";
        $result = $this->conn->query($sql);
        $data = array();

        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }

        $totalItemsQuery = "SELECT COUNT(*) as total 
                            FROM student AS S, assignstudent AS SB, batch AS B 
                            WHERE S.student_id = SB.student_id AND B.batch_id = SB.batch_id";
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
                $sql = "INSERT INTO employee (name, email, role, phone, address, qualification, username, password, activation) 
                        VALUES ('$name', '$email', '$role', '$phone', '$address', '$qualification', '$uname', '$hashedPassword', 1)";

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

    //check boxsess
    public function evalupdate($id) {
        $sql = "UPDATE evaluation SET evaluation_on = CURDATE() WHERE evaluation_id = $id";
        $this->conn->query($sql);
    }
    public function bactcheckbox($featureEnabled, $id) {
        $sql = "UPDATE batch SET activation = $featureEnabled WHERE batch_id = $id";
        $this->conn->query($sql);
    }
    public function studentcheckbox($featureEnabled, $id) {
        $sql = "UPDATE student SET activation = $featureEnabled WHERE student_id = $id";
        $this->conn->query($sql);
    }
    public function employeecheckbox($featureEnabled, $id) {
        $sql = "UPDATE employee SET activation = $featureEnabled WHERE employee_id = $id";
        $this->conn->query($sql);
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



    //Attendance Section

    //View all student and employee details for Mark the attendance
    public function View_markTheAttendance() {
        $page = isset($_GET['page']) ? intval($_GET['page']) : 1;
        $table = $_GET['table'];
        $itemsPerPage = 10; // Number of items to display per page
        $offset = ($page - 1) * $itemsPerPage;

        $sql = "SELECT * FROM $table LIMIT $offset, $itemsPerPage";
        $result = $this->conn->query($sql);
        $data = array();

        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }

        $totalItemsQuery = "SELECT COUNT(*) as total FROM $table";
        $totalItemsResult = mysqli_query($this->conn, $totalItemsQuery);
        $totalItems = mysqli_fetch_assoc($totalItemsResult)['total'];


        $response = [
            'data' => $data,
            'totalItems' => $totalItems
        ];

        return $response;
    }
    

    
    //Created the Mark the attendace
    public function mark_attendance($attendanceDate, $personId, $isPresent, $personIdName) {
        
        // Update the attendance for the student
        $sql = "INSERT INTO attendance ($personIdName, attendance_date, ispresent) VALUES (?, ?, ?) ON DUPLICATE KEY UPDATE ispresent = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param('issi', $personId, $attendanceDate, $isPresent, $isPresent);
        $stmt->execute();

        if ($stmt->error) {
            throw new Exception("Error adding attendance for student ID: $personId");
        }else{
            $response['success'] = true;
            $response['message'] = "Attendance in '$attendanceDate' created successfully!";
        }
        return $response;
    }

    //End the Section

    
    //Test and Video Presenting, Assigning and Removing Section

    //Assigning
    public function test_video_Assigning($batchId, $test1Id, $isPresent, $test, $itemId, $item) {
        try{
            // Update the attendance for the student
            $sql = "INSERT INTO $test (batch_id, $itemId, assigned_on, ispresent) VALUES (?, ?, CURDATE(), ?) ON DUPLICATE KEY UPDATE ispresent = ?";
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param('issi', $batchId, $test1Id, $isPresent, $isPresent);
            $stmt->execute();

            if ($stmt->error) {
                throw new Exception("Error adding test or video data");
            }else{
                $response['success'] = true;
                $response['message'] = "The inserted of $item of batches has been completed";
            }
            return $response;
        }catch( Exception $e){
            $response['success'] = false;
            $response['message'] = "Something went wrong";
        }
        
    }


    //Presenting
    public function test_video_Presenting() {
        $page = isset($_GET['page']) ? intval($_GET['page']) : 1;
        $id = $_GET['id'];
        $table1 = $_GET['table1'];
        $table2 = $_GET['table2'];
        $itemId = $_GET['itemId'];

        $itemsPerPage = 10; // Number of items to display per page
        $offset = ($page - 1) * $itemsPerPage;

        $sql = "SELECT t.*, CASE 
                        WHEN ta.$itemId IS NOT NULL THEN 1
                            ELSE 0
                        END AS isIn
                FROM $table1 t
                LEFT JOIN $table2 ta ON t.$itemId = ta.$itemId AND ta.batch_id = $id
                ORDER BY t.$itemId ASC
                LIMIT $offset, $itemsPerPage";
        $result = $this->conn->query($sql);
        $data = array();

        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }

        $totalItemsQuery = "SELECT COUNT(*) as total FROM $table1";
        $totalItemsResult = mysqli_query($this->conn, $totalItemsQuery);
        $totalItems = mysqli_fetch_assoc($totalItemsResult)['total'];


        $response = [
            'data' => $data,
            'totalItems' => $totalItems
        ];

        return $response;
    }


    //Removing 
    public function test_video_Removing($batchId, $itemId, $table, $itemIdName) {
        // Insert the employee data into the database (assuming you have an "employees" table)
        $sql = "DELETE FROM $table WHERE batch_id = $batchId AND $itemIdName = $itemId";

        if ($this->conn->query($sql) === TRUE) {
            $response['success'] = true;
            $response['message'] = "Employee '$batchId' created successfully!";
        } else {
            $response['success'] = false;
            $response['message'] = "Employee creation failed. Please try again.";
        }
        
    }

    //End the Section


    //View all batch details
    public function attendance() {
        $page = isset($_GET['page']) ? intval($_GET['page']) : 1;
        $personId = $_GET['personId'];
        $table =$_GET['table'];
        $itemsPerPage = 10; // Number of items to display per page
        $offset = ($page - 1) * $itemsPerPage;

        $sql = "SELECT 
                    s.$personId,
                    s.name,
                    CASE 
                        WHEN COUNT(CASE WHEN a.attendance_date = CURDATE() AND a.leave_id IS NOT NULL THEN 1 ELSE NULL END) > 'absent' THEN 'leave'
                        WHEN COUNT(CASE WHEN a.attendance_date = CURDATE() AND a.$personId IS NOT NULL THEN 1 ELSE NULL END) > 'absent' THEN 'present'
                        ELSE 'absent'
                    END AS day1,
                    CASE 
                        WHEN COUNT(CASE WHEN a.attendance_date = CURDATE() - INTERVAL 1 DAY AND a.leave_id IS NOT NULL THEN 1 ELSE NULL END) > 0 THEN 'leave'
                        WHEN COUNT(CASE WHEN a.attendance_date = CURDATE() - INTERVAL 1 DAY AND a.$personId IS NOT NULL THEN 1 ELSE NULL END) > 0 THEN 'present'
                        ELSE 'absent'
                    END AS day2,
                    CASE 
                        WHEN COUNT(CASE WHEN a.attendance_date = CURDATE() - INTERVAL 2 DAY AND a.leave_id IS NOT NULL THEN 1 ELSE NULL END) > 0 THEN 'leave'
                        WHEN COUNT(CASE WHEN a.attendance_date = CURDATE() - INTERVAL 2 DAY AND a.$personId IS NOT NULL THEN 1 ELSE NULL END) > 0 THEN 'present'
                        ELSE 'absent'
                    END AS day3,
                    CASE 
                        WHEN COUNT(CASE WHEN a.attendance_date = CURDATE() - INTERVAL 3 DAY AND a.leave_id IS NOT NULL THEN 1 ELSE NULL END) > 0 THEN 'leave'
                        WHEN COUNT(CASE WHEN a.attendance_date = CURDATE() - INTERVAL 3 DAY AND a.$personId IS NOT NULL THEN 1 ELSE NULL END) > 0 THEN 'present'
                        ELSE 'absent'
                    END AS day4,
                    CASE 
                        WHEN COUNT(CASE WHEN a.attendance_date = CURDATE() - INTERVAL 4 DAY AND a.leave_id IS NOT NULL THEN 1 ELSE NULL END) > 0 THEN 'leave'
                        WHEN COUNT(CASE WHEN a.attendance_date = CURDATE() - INTERVAL 4 DAY AND a.$personId IS NOT NULL THEN 1 ELSE NULL END) > 0 THEN 'present'
                        ELSE 'absent'
                    END AS day5,
                    CASE 
                        WHEN COUNT(CASE WHEN a.attendance_date = CURDATE() - INTERVAL 5 DAY AND a.leave_id IS NOT NULL THEN 1 ELSE NULL END) > 0 THEN 'leave'
                        WHEN COUNT(CASE WHEN a.attendance_date = CURDATE() - INTERVAL 5 DAY AND a.$personId IS NOT NULL THEN 1 ELSE NULL END) > 0 THEN 'present'
                        ELSE 'absent'
                    END AS day6,
                    CASE 
                        WHEN COUNT(CASE WHEN a.attendance_date = CURDATE() - INTERVAL 6 DAY AND a.leave_id IS NOT NULL THEN 1 ELSE NULL END) > 0 THEN 'leave'
                        WHEN COUNT(CASE WHEN a.attendance_date = CURDATE() - INTERVAL 6 DAY AND a.$personId IS NOT NULL THEN 1 ELSE NULL END) > 0 THEN 'present'
                        ELSE 'absent'
                    END AS day7
                FROM
                    $table AS s
                LEFT JOIN
                    attendance AS a
                ON
                    s.$personId = a.$personId
                WHERE
	                s.activation = 1    
                GROUP BY
                    s.$personId, s.name
                LIMIT 
                    $offset, $itemsPerPage";

        $result = $this->conn->query($sql);
        $data = array();

        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }

        $totalItemsQuery = "SELECT COUNT(*) as total 
                            FROM $table";
        $totalItemsResult = mysqli_query($this->conn, $totalItemsQuery);
        $totalItems = mysqli_fetch_assoc($totalItemsResult)['total'];


        $response = [
            'data' => $data,
            'totalItems' => $totalItems
        ];

        return $response;
    }
    

    
}
?>
