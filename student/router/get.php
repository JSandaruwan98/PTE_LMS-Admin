<?php
include 'conn.php';
include '../controler/controler.php';



$controler = new Controlers($conn);



if (isset($_GET['data_type'])) {
    $data_type = $_GET['data_type'];

    if ($data_type === 'question_add') {

        // Pagination parameters
        $page = isset($_GET['page']) ? $_GET['page'] : 1;
        $perPage = isset($_GET['per_page']) ? $_GET['per_page'] : 5;
        $offset = ($page - 1) * $perPage;
        

        $data = $controler->question_add($perPage, $offset);
    }

    header('Content-Type: application/json');
    echo json_encode($data);

} else{
    echo "Specify data_type parameter (batch or class)";
}



$conn->close();