<?php

include 'conn.php';
include '../controler/controler.php';
include '../model/ExamAI.php';
include '../model/SQLModel.php';

//call the controler class
$controler = new Controlers($conn);
$sql_model = new SQLModel($conn);
$ExamAI = new ExamAI();

$response = array();


if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if(isset($_POST['task'])){

        //audio save task
        if($_POST['task'] == 'save_audio'){
            $audio = $_FILES['audio']['tmp_name'];

            $response = $controler->save_audio($audio);

        }elseif($_POST['task'] == 'normal_comparison'){
            
            $voice = $ExamAI->VoiceToTest(); //voice to test convert

            //Assigned the variables
            $audioFile = $_POST['audioFile'];
            $Solution = $_POST['Solution'];
            $question_id = $_POST['question_id'];
            $student_id = $_POST['student_id'];

            $result = $ExamAI->compareSentences($Solution, $voice);

            $serialized_additional_words = serialize($result['additional_words']);
            $serialized_missed_words = serialize($result['missed_words']);

            $word_set_1 = implode(', ', $result['additional_words']);

            $count =  count($result['additional_words']);

            
            $content = 0;
            if($count > 5){
                $content = 0;
            }elseif($count > 4){
                $content = 1;
            }elseif($count > 3){
                $content = 2;
            }elseif($count > 1){
                $content = 3;
            }elseif($count > 0){
                $content = 4;
            }elseif($count > -1){
                $content = 5;
            }


            $response = $sql_model->Answering_Insert($voice, $audioFile, $question_id, $student_id, $content, $word_set_1);


        }elseif($_POST['task'] == 'ai_analysis'){
            
            $voice = $ExamAI->VoiceToTest(); // voice to test convert

            //Assigned the variables
            $audioFile = $_POST['audioFile'];
            $Solution = $_POST['Solution'];
            $question_id = $_POST['question_id'];
            $student_id = $_POST['student_id'];
            $key_words = $_POST['key_words'];


            //`a1` The sentence described by this student `a2` Briefly comment on the sentence review
            $Question = "`".$voice."` and the key word  `".$key_words."` give only overall precentage of include the key words";
            $result = $ExamAI->AiComparison($Question);

            $response = $sql_model->Answering_Insert($voice, $audioFile, $question_id, $student_id, $result, NAN);
            

        }elseif($_POST['task'] == 'select-exam'){
            
            $test_id = $_POST['test_id'];
            $student_id = $_POST['student_id'];

            $response = $controler->selectExam($test_id, $student_id);
            //$response['message'] = $student_id;
            
        }
    }    

}

header('Content-Type: application/json');
echo json_encode($response);

$conn->close();

?>