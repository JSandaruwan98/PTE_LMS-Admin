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
