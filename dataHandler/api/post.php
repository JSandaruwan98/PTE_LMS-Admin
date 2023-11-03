<?php
include '../conn.php';
include '../datahandler.php';

$dataHandler = new DataHandler($conn);

$response = array();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['task'])) {
        $task = $_POST['task'];

        if ($task === 'create_batch') {
            $program = $_POST['program'];
            $class = $_POST['class'];
            $batchname = $_POST['batchname'];
            $timefrom = $_POST['timefrom'];
            $timeto = $_POST['timeto'];

            $response = $dataHandler->createBatch($program, $class, $batchname, $timefrom, $timeto);
        } elseif ($task === 'create_employee') {
            $name = $_POST['name'];
            $email = $_POST['email'];
            $role = $_POST['role'];
            $phone = $_POST['phone'];
            $address = $_POST['address'];
            $qualification = $_POST['qualification'];
            $uname = $_POST['uname'];
            $pass = $_POST['pass'];

            $response = $dataHandler->createEmployee($name, $email, $role, $phone, $address, $qualification, $uname, $pass);
        } elseif ($task === 'enroll_student') {
            $studentid = $_POST['studentid'];
            $name = $_POST['name'];
            $phone = $_POST['phone'];
            $program = $_POST['program'];
            $batchid = $_POST['batchid'];
            $starton = $_POST['starton'];
             

            $response = $dataHandler->enrollStudent($studentid, $name, $phone, $program, $batchid, $starton);
        }elseif ($task === 'ticketCheck') {
            $ticketId = $_POST['ticketId'];
            $comment = $_POST['comment'];
            $status = $_POST['status'];
            $rating = $_POST['rating'];
            $response = $dataHandler->ticketCheck($ticketId, $comment, $status, $rating);
            
        }elseif ($task === 'test_video_Assigning') {
            if (isset($_POST['test']) && is_array($_POST['test'])) {
                $batchId = $_POST['batchId'];
                $table = $_POST['table'];
                $itemId = $_POST['itemId'];
                $item = $_POST['item'];
                try {
                    $conn->autocommit(false); // Start a transaction
                    
                    foreach ($_POST['test'] as $testId => $isPresent) {
                        // Sanitize inputs and perform error checking as needed
                        $test1Id = intval($testId);
                        $isPresent = intval($isPresent);
        
                        $response = $dataHandler->test_video_Assigning($batchId, $test1Id, $isPresent, $table, $itemId, $item);
                    }
        
                     // Commit the transaction
                } catch (Exception $e) {
                    $conn->rollback();// Rollback the transaction in case of an error
                } finally {
                    $conn->autocommit(true);// Restore autocommit mode
                }
            }else{
                
            }
            
        }elseif ($task === 'mark_attendance') {
            $attendanceDate = $_POST['attendanceDate'];
            $personId = $_POST['personId'];
            $personIdName = $_POST['$personIdName'];

            $response = $dataHandler->mark_attendance($attendanceDate, $personId, $personIdName);
        }elseif ($task === 'bactcheckbox') {
            $featureEnabled = ($_POST['featureEnabled'] === 'true') ? 1 : 0; // Convert to 1 or 0
            $id = $_POST['id'];
            $response = $dataHandler->bactcheckbox($featureEnabled, $id);
        }elseif ($task === 'studentcheckbox') {
            $featureEnabled = ($_POST['featureEnabled'] === 'true') ? 1 : 0; // Convert to 1 or 0
            $id = $_POST['id'];
            $response = $dataHandler->studentcheckbox($featureEnabled, $id);
        }elseif ($task === 'employeecheckbox') {
            $featureEnabled = ($_POST['featureEnabled'] === 'true') ? 1 : 0; // Convert to 1 or 0
            $id = $_POST['id'];
            $response = $dataHandler->employeecheckbox($featureEnabled, $id);
        }elseif ($task === 'evalupdate') {
            $id = $_POST['id'];
            $response = $dataHandler->evalupdate($id);
        }elseif ($task === 'test_video_Removing') {
            $batchId = $_POST['batchId'];
            $itemId = $_POST['testId'];
            
            $response = $dataHandler->test_video_Removing($batchId, $itemId);
        }elseif ($task === 'Attendance_Removing') {
            $attendanceId = $_POST['attendanceId'];
            
            $response = $dataHandler->Attendance_Removing($attendanceId);
        }elseif ($task === 'removeTheAssigning') {
            $batchId = $_POST['batchId'];
            $studentId = $_POST['studentId'];
            $testId = $_POST['testId'];
            $response = $dataHandler->removeTheAssigning($batchId, $studentId, $testId);
        }elseif ($task === 'login') {
            $name = $_POST['name'];
            $password = $_POST['password'];
           
            $response = $dataHandler->login($name, $password);
        }elseif ($task === 'removeNotification') {
            $id = $_POST['itemId'];
           
            $response = $dataHandler->removeNotification($id);
        }
        
    }
}

header('Content-Type: application/json');
echo json_encode($response);

$conn->close();
?>
