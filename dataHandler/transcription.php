<?php

// Welcome to AssemblyAI! Get started with the API by transcribing
// a file using PHP.
//
// In this example, we'll transcribe a local file. Get started by
// downloading the snippet, then update the 'filename' variable
// to point to the local path of the file you want to upload and
// use the API to transcribe.
//
// IMPORTANT: Update line 101 to point to a local file.
//
// Have fun!

// Function to upload a local file to the AssemblyAI API
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

// Function to create a transcript using AssemblyAI API
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

if($_SERVER['REQUEST_METHOD'] == "POST"){

    $solution = $_POST["solution"];
    $audio = $_POST["audio"];

    try {
        // Your API token is already set in this variable
        $api_token = "f1cfd7e1831e4261abf419a74c60aab5";
    
        // -----------------------------------------------------------------------------
        // Update the file path here, pointing to a local audio or video file.
        // If you don't have one, download a sample file: https://storage.googleapis.com/aai-web-samples/espn-bears.m4a
        // You may also remove the upload step and update the 'audio_url' parameter in the
        // 'create_transcript' function to point to a remote audio or video file.
        // -----------------------------------------------------------------------------
        $sentence2 = "Update the file path  pointing to a local audio or video file.";
        
        $path = "Media7.m4a";
        $upload_url = upload_file($api_token, $path);
    
        $transcript = create_transcript($api_token, $upload_url);
        echo $transcript['text'];
    
        $value = $transcript['text'];
    
        $words1 = explode(' ', strtolower($value));
        $words2 = explode(' ', strtolower($solution));
    
        $commonWords = array_intersect($words1, $words2);
    
        // Calculate similarity percentage
        $similarityPercentage = (count($commonWords) / count($words1)) * 100;
    
        // Function to highlight common words in green
        function highlightCommonWords($paragraph, $commonWords) {
            foreach ($commonWords as $commonWord) {
                $paragraph = preg_replace("/\b$commonWord\b/i", '<span style="color: green;">' . $commonWord . '</span>', $paragraph);
            }
            return $paragraph;
        }
    
        // Highlight common words in the second paragraph
        $highlightedParagraph2 = highlightCommonWords($solution, $commonWords);
    
        // Output the paragraphs with common words highlighted and similarity score
        echo "Paragraph 1: $solution\n\n";
        echo "Paragraph 2: $highlightedParagraph2\n\n";
        echo "Similarity Score: $similarityPercentage%\n";
            
    } catch (Exception $e) {
        echo 'Error: ' . $e->getMessage();
    }
    

}

// Upload a file and create a transcript using the AssemblyAI API

?>