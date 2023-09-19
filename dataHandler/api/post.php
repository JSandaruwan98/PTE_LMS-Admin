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
        }elseif ($task === 'assignTest') {
            if (isset($_POST['test']) && is_array($_POST['test']) && isset($_POST['batchid'])) {
                $batchId = $_POST['batchid'];
                
                try {
                    $conn->autocommit(false); // Start a transaction
                    
                    foreach ($_POST['test'] as $testId => $isPresent) {
                        // Sanitize inputs and perform error checking as needed
                        $testId = intval($testId);
                        $isPresent = intval($isPresent);
        
                        $response = $dataHandler->assignTest($batchId, $testId, $isPresent);
                    }
        
                     // Commit the transaction
                } catch (Exception $e) {
                    $conn->rollback();// Rollback the transaction in case of an error
                } finally {
                    $conn->autocommit(true);// Restore autocommit mode
                }
            }else{
                $response['success'] = false;
                $response['message'] = "All students Absent";
            }
            
        }elseif ($task === 'mark_attendance_stu') {
            if (isset($_POST['attendance']) && is_array($_POST['attendance']) && isset($_POST['attendanceDate'])) {
                $attendanceDate = $_POST['attendanceDate'];
                
                try {
                    $conn->autocommit(false); // Start a transaction
                    
                    foreach ($_POST['attendance'] as $studentId => $isPresent) {
                        // Sanitize inputs and perform error checking as needed
                        $studentId = intval($studentId);
                        $isPresent = intval($isPresent);
        
                        $response = $dataHandler->mark_attendance_stu($attendanceDate, $studentId, $isPresent);
                    }
        
                     // Commit the transaction
                } catch (Exception $e) {
                    $conn->rollback();// Rollback the transaction in case of an error
                } finally {
                    $conn->autocommit(true);// Restore autocommit mode
                }
            }else{
                $response['success'] = false;
                $response['message'] = "All students Absent";
            }
            
        }elseif ($task === 'mark_attendance_emp') {
            if (isset($_POST['attendance']) && is_array($_POST['attendance']) && isset($_POST['attendanceDate'])) {
                $attendanceDate = $_POST['attendanceDate'];
                
                try {
                    $conn->autocommit(false); // Start a transaction
                    
                    foreach ($_POST['attendance'] as $employeeId => $isPresent) {
                        // Sanitize inputs and perform error checking as needed
                        $employeeId = intval($employeeId);
                        $isPresent = intval($isPresent);
        
                        $response = $dataHandler->mark_attendance_emp($attendanceDate, $employeeId, $isPresent);
                    }
        
                     // Commit the transaction
                } catch (Exception $e) {
                    $conn->rollback();// Rollback the transaction in case of an error
                } finally {
                    $conn->autocommit(true);// Restore autocommit mode
                }
            }else{
                $response['success'] = false;
                $response['message'] = "All employee Absent";
            }
            
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
        }
        
    }
}

header('Content-Type: application/json');
echo json_encode($response);

$conn->close();
?>
