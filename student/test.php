<?php

http_response_code(400);

$token = 'AIzaSyB-nCbTp4OrEcM3aFGDP2VtUWa6H8Nic6w';
$url = 'https://generativelanguage.googleapis.com/v1beta3/models/text-bison-001:generateText?key=' .$token;
$ch = curl_init($url);

$json_data = '{"prompt": {text: "Question : `Who developed the theory of relativity?`  and Answer: `Albert Einstein`  this answer is only give a correct or incorrect not any other"} }';

curl_setopt(
    $ch,
    CURLOPT_HTTPHEADER,
    array(
        'Content-Type: application/json'
    )
);

curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

curl_setopt($ch, CURLOPT_POSTFIELDS, $json_data);

$result = curl_exec($ch);

$response = json_decode($result, true);

curl_close($ch);

if ($response === null) {
    //echo 'Error decoding JSON: ' . json_last_error_msg();
    exit('There was error generating description. Please try again');
}

print_r($response);

if (isset($response['candidates'][0]['output'])) {
    $values = $response['candidates'][0]['output'];
    http_response_code(200);
    exit($values);
} else {
    exit('There was error generating description. Please try again');
}

function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}
?>