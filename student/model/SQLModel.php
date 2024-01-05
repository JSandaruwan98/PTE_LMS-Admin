<?php

class SQLModel{

    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
        
    }


    //Insertion of the Answering table

    public function Answering_Insert($voice, $audioFile, $question_id, $student_id, $content, $word_set_1){

        try{

            $sql = "INSERT INTO answering (question_id, student_id, mp4File, userAnswer, content, additional_words) 
                VALUES ($question_id, $student_id, '$audioFile', '$voice', '$content', '$word_set_1')";

       

            if ($this->conn->query($sql) === TRUE) {
                $response['success'] = true;
                $response['message'] = "data updated successfully!";
            } else {
                $response['success'] = false;
                $response['message'] = "data updataion failed. Please try again.";
            }
            
        }catch (Exception $e) {
            // Handle database connection or query errors here
            $response['success'] = false;
            $response['message'] = "Error: " . $e->getMessage();
        }

        return $response;

    }
}