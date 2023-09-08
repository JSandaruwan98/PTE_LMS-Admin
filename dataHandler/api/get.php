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
    } else {
        $data = array("error" => "Invalid data type");
    }

    header('Content-Type: application/json');
    echo json_encode($data);
} else {
    echo "Specify data_type parameter (batch or class)";
}


$conn->close();
?>
