<?php
    
    

class Controlers{

    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
        
    }

    //audio saved
    public function save_audio($audio){

        $uploadDirectory = '../../';
        $audioFile = 'audio/audio-' . date('YmdHis') . '.wav';
        $filename = $uploadDirectory . $audioFile;

        move_uploaded_file($audio, $filename);

        $uploadDirectory1 = '.';
        $audioFile1 = $uploadDirectory1 . 'recording.wav';
        
        copy($filename, $audioFile1);
        

        $response['message'] = "success";
        $response['audioFile1'] = $audioFile;
        $response['audioFile2'] = $audioFile1;

        
        
        return $response;
    }


    //----------------------------------------------------------------------------------------------------------------------------------


    //Question Add
    public function question_add($perPage, $offset) {
        

        // Fetch data from the database with pagination
        $sql = "SELECT type, question, solution, imageFile, question_id, mp4File, key_words FROM question LIMIT $offset, $perPage";
        $result = $this->conn->query($sql);

        $data = array();

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $data[] = array(
                    'type' => $row['type'],
                    'question' => $row['question'],
                    'solution' => $row['solution'],
                    'imageFile' => $row['imageFile'],
                    'question_id' => $row['question_id'],
                    'key_words' => $row['key_words'],
                );
            }
        }
    
        return $data;
    }


    //-------------------------------------------------------------------------------------------------------------------------

    //Student want to select the exams
    public function selectExam($test_id, $student_id){
        $sql = "INSERT INTO evaluation (student_id, test_id, attempted_on) 
                VALUES ($student_id, $test_id, CURDATE())";

       

        if ($this->conn->query($sql) === TRUE) {
            $response['success'] = true;
            $response['message'] = "data updated successfully!";
        } else {
            $response['success'] = false;
            $response['message'] = "data updataion failed. Please try again.";
        }

        return $response;
    }
    
    
}
    

?>