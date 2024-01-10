<?php
include 'conn.php';
include '../controler/controler.php';
include '../model/SQLModel.php';



$controler = new Controlers($conn);
$getModel = new SQLModel($conn);



if (isset($_GET['data_type'])) {
    $data_type = $_GET['data_type'];

    if ($data_type === 'question_add') {

        // Pagination parameters
        $page = isset($_GET['page']) ? $_GET['page'] : 1;
        $perPage = isset($_GET['per_page']) ? $_GET['per_page'] : 5;
        $offset = ($page - 1) * $perPage;
        $test_id = $_GET['test_id'];

        $data = $controler->question_add($perPage, $offset, $test_id);
    }elseif($data_type === 'test_select') {

        $student_id = $_GET['student_id'];
        $data = $getModel->test_select($student_id);
    }

    header('Content-Type: application/json');
    echo json_encode($data);

}else{
    echo "Specify data_type parameter (batch or class)";
}



$conn->close();