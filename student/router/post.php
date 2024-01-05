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
            $word_set_2 = implode(', ', $result['missed_words']);

            $count =  count($result['additional_words'] + $result['missed_words']);

            
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


            $response = $sql_model->Answering_Insert($voice, $audioFile, $question_id, $student_id, $content, $word_set_1, $word_set_2);


        }elseif($_POST['task'] == 'ai_analysis'){
            
            $voice = $ExamAI->VoiceToTest(); // voice to test convert

            //Assigned the variables
            $audioFile = $_POST['audioFile'];
            $Solution = $_POST['Solution'];
            $question_id = $_POST['question_id'];
            $student_id = $_POST['student_id'];
            $key_words = $_POST['key_words'];
            //$type = $_POST['type']

            if($_POST['type'] == 'Answer Short Question'){

                $Question ="Question : `".$key_words."`  and Answer: `".$voice."`  this answer is only give a correct or incorrect not any other";
                $result = $ExamAI->AiComparison($Question);

                if (stripos($result, 'incorrect') !== false) {
                    $value = 0; // Set $value to 1
                } elseif (stripos($result, 'correct') !== false) {
                    $value = 1; // Set $value to 0 if 'incorrect' is found
                }

            }elseif($_POST['type'] == 'Describe image' || $_POST['type'] == 'Re-tell Lecture'){

                $Question = "`".$voice."` and the key word  `".$key_words."` give only overall precentage of include the key words";
                $value = $ExamAI->AiComparison($Question);

            }

         
            
            //$response['message'] = $value;

            $response = $sql_model->Answering_Insert($voice, $audioFile, $question_id, $student_id, $value, NAN, NAN);
            

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