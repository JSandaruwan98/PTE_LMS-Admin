<?php

class SQLModel{

    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
        
    }


    //Insertion of the Answering table

    public function Answering_Insert($voice, $audioFile, $question_id, $student_id, $content, $word_set_1, $word_set_2){

        try{
            $word_set_1 = mysqli_real_escape_string($this->conn, $word_set_1);
            $word_set_2 = mysqli_real_escape_string($this->conn, $word_set_2);

            $sql = "INSERT INTO answering (question_id, student_id, mp4File, userAnswer, content, additional_words, missed_words) 
                VALUES ($question_id, $student_id, '$audioFile', '$voice', '$content', '$word_set_1', '$word_set_2')";

       

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


    public function QuestionAdd($audioFile, $Solution, $key_words, $Question, $type){
        try{
            
            $sql = "INSERT INTO question (question, mp4File, solution, key_words, type, test_id) 
                VALUES ('$Question', '$audioFile', '$Solution', '$key_words', '$type', 10)";


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


    public function test_select($student_id){
       

            $sql = "SELECT DISTINCT ta.test_id, t.name  FROM assignstudent AS astu, testass AS ta, test AS t WHERE astu.student_id = $student_id AND t.test_id = ta.test_id";
            $result = $this->conn->query($sql);
            $data = array();
            while ($row = $result->fetch_assoc()) {
                $data[] = array(
                    'name' => $row['name'],
                    'test_id' => $row['test_id']
                );
            }

            
            
            
       

        return $data;
    }

}