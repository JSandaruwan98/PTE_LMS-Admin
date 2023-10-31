<?php
include '../conn.php';
include '../datahandler.php';

$dataHandler = new DataHandler($conn);

if (isset($_GET['data_type'])) {
    $data_type = $_GET['data_type'];

    if ($data_type === 'batch') {
        $data = $dataHandler->getBatchData();
    } elseif ($data_type === 'class') {
        $data = $dataHandler->getClassData();
    }elseif ($data_type === 'stuid') {
        $data = $dataHandler->generateStudentID();
    }elseif ($data_type === 'batchView') {
        $data = $dataHandler->batchView();
    }elseif ($data_type === 'studentView') {
        $data = $dataHandler->studentView();
    }elseif ($data_type === 'employeeView') {
        $data = $dataHandler->employeeView();
    }elseif ($data_type === 'View_markTheAttendance') {
        $data = $dataHandler->View_markTheAttendance();
    }elseif ($data_type === 'test_video_Presenting') {
        $data = $dataHandler->test_video_Presenting();
    }elseif ($data_type === 'attendance') {
        $data = $dataHandler->attendance();
    }elseif ($data_type === 'pendingEvaluation') {
        $data = $dataHandler->pendingEvaluation();
    }elseif ($data_type === 'evaluationHistory') {
        $data = $dataHandler->evaluationHistory();
    }elseif ($data_type === 'support') {
        $data = $dataHandler->support();
    }elseif ($data_type === 'transaction') {
        $data = $dataHandler->transaction();
    }elseif ($data_type === 'balance') {
        $data = $dataHandler->balance();
    }elseif ($data_type === 'notification') {
        $data = $dataHandler->notification();
        
    }elseif ($data_type === 'logout') {
        session_start();
        session_destroy();
        $data = "success";
    }elseif ($data_type === 'check_login') {
        session_start();
        if (isset($_SESSION['user'])) {
            $data = "success";
        } else {
            $data = "error";
        }
    }else {
        $data = array("error" => "Invalid data type");
    }
    
    header('Content-Type: application/json');
    echo json_encode($data);
} else {
    echo "Specify data_type parameter (batch or class)";
}


$conn->close();
?>
