<?php
include 'dataHandler/conn.php';

function upload_file($api_token, $path) {
    $url = 'https://api.assemblyai.com/v2/upload';
    $data = file_get_contents($path);

    $options = [
        'http' => [
            'method' => 'POST',
            'header' => "Content-type: application/octet-stream\r\nAuthorization: $api_token",
            'content' => $data
        ]
    ];

    $context = stream_context_create($options);
    $response = file_get_contents($url, false, $context);

    if ($http_response_header[0] == 'HTTP/1.1 200 OK') {
        $json = json_decode($response, true);
        return $json['upload_url'];
    } else {
        echo "Error: " . $http_response_header[0] . " - $response";
        return null;
    }
}

function create_transcript($api_token, $audio_url) {
    $url = "https://api.assemblyai.com/v2/transcript";

    $headers = array(
        "authorization: " . $api_token,
        "content-type: application/json"
    );

    $data = array(
        "audio_url" => $audio_url
    );

    $curl = curl_init($url);

    curl_setopt($curl, CURLOPT_POST, true);
    curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data));
    curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

    $response = json_decode(curl_exec($curl), true);

    curl_close($curl);

    $transcript_id = $response['id'];

    $polling_endpoint = "https://api.assemblyai.com/v2/transcript/" . $transcript_id;

    while (true) {
        $polling_response = curl_init($polling_endpoint);

        curl_setopt($polling_response, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($polling_response, CURLOPT_RETURNTRANSFER, true);

        $transcription_result = json_decode(curl_exec($polling_response), true);

        if ($transcription_result['status'] === "completed") {
            return $transcription_result;
        } else if ($transcription_result['status'] === "error") {
            throw new Exception("Transcription failed: " . $transcription_result['error']);
        } else {
            sleep(3);
        }
    }
}

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check if a file was uploaded
    if (isset($_FILES['audio_file']) && $_FILES['audio_file']['error'] === UPLOAD_ERR_OK) {

        try{
            $path = $_FILES['audio_file']['name'];
            $audio_data = file_get_contents($_FILES['audio_file']['tmp_name']);

            $api_token = "f1cfd7e1831e4261abf419a74c60aab5";
            $upload_url = upload_file($api_token, "audio/$path");
            $transcript = create_transcript($api_token, $upload_url);

            $value = $transcript['text'];

            $sql = "INSERT INTO audio_files (file_name, audio_data, user_solution) 
                    VALUES ('$path', 'ada', '$value')";
            

            if ($conn->query($sql) === TRUE) {
                echo "Audio file uploaded successfully!";
            } else {
                $response['success'] = false;
                $response['message'] = "Batch creation failed. Please try again.";
            }


        }catch(Exception $e){
            echo 'Error: ' . $e->getMessage();
        }

        
    } else {
        echo "Error uploading file.";
    }

    // Close the database connection
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload Audio File</title>
</head>
<body>
    <h2>Upload Audio File</h2>
    <form method="post" enctype="multipart/form-data">
        <label for="audio_file">Select Audio File:</label>
        <input type="file" name="audio_file" accept=".mp3, .wav, .m4a">
        <br>
        <input type="submit" value="Upload">
    </form>
</body>
</html>
