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

    public function notification(){
        $sql = "SELECT * FROM notification";
        $result = $this->conn->query($sql);
        $data = array();

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $data[] = $row;
            }
        }
        $data = 'asas';
        return $data;
    }


    // get the batch id and name for the drop down input field of batches  
    public function balance() {
        $page = isset($_GET['page']) ? intval($_GET['page']) : 1;
        $itemsPerPage = 10;
        $offset = ($page - 1) * $itemsPerPage;
        $sql = "SELECT
                    total_credits - total_other_transactions AS balance
                FROM
                    (SELECT
                        SUM(CASE WHEN transactiontype = 'credit' THEN amount ELSE 0 END) AS total_credits,
                        SUM(CASE WHEN transactiontype <> 'credit' THEN amount ELSE 0 END) AS total_other_transactions
                    FROM
                        transaction) AS subquery
                LIMIT $offset, $itemsPerPage";        ;

        $result = $this->conn->query($sql);
        $data = array();
        $i=1;
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $row['serial_number'] = ($page - 1) * $itemsPerPage + $i;
                $data[] = $row;
                $i++;
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

        $sql = "SELECT *,
                        CASE
                            WHEN student_id IS NOT NULL THEN CONCAT('STU ', LPAD(CAST(student_id AS CHAR), 4, '0'))
                            ELSE CONCAT('EMP ', LPAD(CAST(employee_id AS CHAR), 4, '0'))
                        END AS person_id
                FROM ticket
                LIMIT $offset, $itemsPerPage";
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

        $sql = "SELECT DISTINCT ta.assigned_on, e.student_id, e.attempted_on,t.name AS test_name,s.name AS student_name 
                FROM evaluation AS e, testass AS ta, test AS t, student AS s 
                WHERE e.test_id = ta.test_id AND t.test_id = e.test_id AND s.student_id = e.student_id 
                LIMIT $offset, $itemsPerPage";
        $result = $this->conn->query($sql);
        $data = array();
        $i=1;
        while ($row = $result->fetch_assoc()) {
            $row['serial_number'] = ($page - 1) * $itemsPerPage + $i;
            $data[] = $row;
            $i++;
        }

        $totalItemsQuery = "SELECT COUNT(*) AS total FROM `evaluation`";
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

        $sql = "SELECT DISTINCT s.student_id, s.name AS student_name, e.attempted_on AS attempted_on, t.name AS test_name, ta.assigned_on AS assigned_on, e.evaluation_on AS evaluation_on
                FROM evaluation AS e
                JOIN student AS s ON s.student_id = e.student_id
                JOIN test AS t ON t.test_id = e.test_id
                JOIN assignstudent AS sa ON sa.student_id = e.student_id
                JOIN testass AS ta ON ta.batch_id = sa.batch_id
                WHERE e.evaluation_on IS NOT NULL
                LIMIT $offset, $itemsPerPage";
        $result = $this->conn->query($sql);
        $data = array();
        $i=1;
        while ($row = $result->fetch_assoc()) {
            $row['serial_number'] = ($page - 1) * $itemsPerPage + $i;
            $data[] = $row;
            $i++;
        }

        $totalItemsQuery = "SELECT COUNT(*) AS total 
                            FROM `evaluation` AS e 
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
        $i=1;
        while ($row = $result->fetch_assoc()) {
            $row['serial_number'] = ($page - 1) * $itemsPerPage + $i;
            $data[] = $row;
            $i++;
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


    public function login($name, $password){
        if (empty($name) && empty($password)) {
            $response['success'] = false;
            $response['message'] = "All fields are required.";
        }elseif(empty($name)){
            $response['success'] = false;
            $response['message'] = "All fields are required.";
        }elseif(empty($password)){
            $response['success'] = false;
            $response['message'] = "User Password is required.";
        }else{
    
            $sql ="SELECT * FROM user WHERE name='$name' AND password ='$password'";
            $result = $this->conn->query($sql);
    
            if(mysqli_num_rows($result) === 1){
                $row =mysqli_fetch_assoc($result);
                if($row['name'] === $name && $row['password'] === $password){
                    $response['success'] = true;
                    $response['message'] = "index.html";
                    session_start();
                    $_SESSION['user'] = $_POST['name'];
                }else{
                    $response['success'] = false;
                    $response['message'] = "Incorect User name or password";
                }
            }else{
                $response['success'] = false;
                $response['message'] = "Incorect User name or password";
            }
    
        }
        return $response;
    }


    //created the batch table
    public function createBatch($program, $class, $batchname, $timefrom, $timeto) {
        $response = array();

        //checked the batch name exist or not
        function batchnameExists($batchname_to_check, $conn) {
            $name_to_check = mysqli_real_escape_string($conn, $batchname_to_check);
            $sql = "SELECT * FROM batch WHERE name='$name_to_check'";
            $result = mysqli_query($conn, $sql);
            return mysqli_num_rows($result) > 0;
        }

        $batchname_to_check = $batchname;

        // Perform data validation
        if (empty($program) || empty($class) || empty($batchname) || empty($timefrom) || empty($timeto)) {
            $response['success'] = false;
            $response['message'] = "All fields are required.";
        } elseif(batchnameExists($batchname_to_check, $this->conn)){
            $response['success'] = false;
            $response['message'] = "Batch name already exists";
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


        //checked the user name exist or not
        function usernameExists($username_to_check, $conn) {
            $username_to_check = mysqli_real_escape_string($conn, $username_to_check);
            $sql = "SELECT * FROM employee WHERE username='$username_to_check'";
            $result = mysqli_query($conn, $sql);
            return mysqli_num_rows($result) > 0;
        }

        $username_to_check = $uname;

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
        } elseif(usernameExists($username_to_check, $this->conn)){
            $response['success'] = false;
            $response['message'] = "username already exists";
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

    public function ticketCheck($ticketId, $comment, $status, $rating) {
        
        $sql = "UPDATE ticket SET comments = '$comment', status = '$status', rating = '$rating'  WHERE ticket_no = $ticketId";
        if ($this->conn->query($sql) === TRUE) {
            $response['success'] = true;
            $response['message'] = "data updated successfully!";
        } else {
            $response['success'] = false;
            $response['message'] = "data updataion failed. Please try again.";
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
        $personId = $_GET['personId'];
        $date = $_GET['date'];
        $itemsPerPage = 10; // Number of items to display per page
        $offset = ($page - 1) * $itemsPerPage;

        $sql = "SELECT s.$personId, s.name, a.attendance_id,
                    CASE WHEN a.$personId IS NOT NULL THEN 1 ELSE 0 END AS present
                FROM $table AS s
                LEFT JOIN attendance AS a ON s.$personId = a.$personId AND a.attendance_date = '$date'
                WHERE s.activation = 1 
                LIMIT $offset, $itemsPerPage";
        $result = $this->conn->query($sql);
        $data = array();
        $i=1;
        while ($row = $result->fetch_assoc()) {
            $row['serial_number'] = ($page - 1) * $itemsPerPage + $i;
            $data[] = $row;
            $i++;
        }

        $totalItemsQuery = "SELECT COUNT(*) AS total
                            FROM $table AS s
                            LEFT JOIN attendance AS a ON s.$personId = a.$personId AND a.attendance_date = '$date'";
        $totalItemsResult = mysqli_query($this->conn, $totalItemsQuery);
        $totalItems = mysqli_fetch_assoc($totalItemsResult)['total'];


        $response = [
            'data' => $data,
            'totalItems' => $totalItems
        ];

        return $response;
    }


    public function mark_attendance($attendanceDate, $personId, $personIdName) {

        $sql = "INSERT IGNORE INTO attendance ($personIdName, attendance_date) 
                    VALUES ($personId, '$attendanceDate')";

            if ($this->conn->query($sql) === TRUE) {
                $response['success'] = true;
                $response['message'] = "Batch created successfully!";
            } else {
                $response['success'] = false;
                $response['message'] = "Batch creation failed. Please try again.";
            }
        
        
        return $response;
    }

    
    public function Attendance_Removing($AttendanceId) {
        // Insert the employee data into the database (assuming you have an "employees" table)
        $sql = "DELETE FROM attendance WHERE attendance_id = $AttendanceId";

        if ($this->conn->query($sql) === TRUE) {
            $response['success'] = true;
            $response['message'] = "Employee '$AttendanceId' created successfully!";
        } else {
            $response['success'] = false;
            $response['message'] = "Employee creation failed. Please try again.";
        }
        
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
    public function test_video_Removing($batchId, $itemId) {
        // Insert the employee data into the database (assuming you have an "employees" table)
        $sql = "DELETE FROM assignvideo WHERE batch_id = $batchId AND video_id = $itemId";

        if ($this->conn->query($sql) === TRUE) {
            $response['success'] = true;
            $response['message'] = "Employee '$batchId' created successfully!";
        } else {
            $response['success'] = false;
            $response['message'] = "Employee creation failed. Please try again.";
        }
        
    }


    public function removeTheAssigning($batchId, $studentId, $testId) {
        // Insert the employee data into the database (assuming you have an "employees" table)
        $sql = "DELETE FROM testass WHERE batch_id = $batchId AND test_id = $testId";
        $this->conn->query($sql);

        $sql1 = "DELETE FROM evaluation
                 WHERE student_id IN (
                    SELECT s.student_id
                    FROM assignstudent AS s
                    JOIN evaluation AS e ON s.student_id = e.student_id
                    WHERE s.batch_id = $batchId AND e.test_id = $testId)";
        $this->conn->query($sql1);        
        
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
        $i=1;
        while ($row = $result->fetch_assoc()) {
            $row['serial_number'] = ($page - 1) * $itemsPerPage + $i;
            $data[] = $row;
            $i++;
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
