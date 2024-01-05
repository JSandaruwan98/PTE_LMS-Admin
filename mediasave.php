<?php
// Check if the request contains audio data and URL
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['audioBlob']) && isset($_POST['audioUrl'])) {
    // Get the audio data and URL
    $audioData = $_POST['audioBlob'];
    $audioUrl = $_POST['audioUrl'];

    // Specify the path where you want to save the audio file
    $savePath = 'audio/media.m4a';

    // Save the audio data to a file
    if (file_put_contents($savePath, $audioData) !== false) {
        echo 'Audio file saved successfully. URL: ' . $audioUrl;
    } else {
        echo 'Failed to save audio file.';
    }
} else {
    echo 'Invalid request.';
}
?>
