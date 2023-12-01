<?php

$apiKey = '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'; // Replace with your actual OpenAI API key

function generateModelResponse($prompt) {
    global $apiKey;

    $url = 'https://api.openai.com/v1/engines/text-davinci-003/completions';
    $headers = [
        'Content-Type: application/json',
        'Authorization: Bearer ' . $apiKey,
    ];

    $data = [
        'prompt' => $prompt,
        'max_tokens' => 100, // Adjust as needed
    ];

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

    $response = curl_exec($ch);
    $statusCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    if ($statusCode !== 200) {
        echo "Error: Unexpected response code - {$statusCode}\n";
        return null;
    }

    $jsonResponse = json_decode($response, true);

    if (!isset($jsonResponse['choices']) || !is_array($jsonResponse['choices']) || empty($jsonResponse['choices'])) {
        echo "Error: 'choices' key not found or empty in the response\n";
        return null;
    }

    return $jsonResponse['choices'][0]['text'];
}

function compareText($text1, $text2) {
    $prompt = "Text 1: '{$text1}'\nText 2: '{$text2}'\nWhich text is more relevant or better?";
    return generateModelResponse($prompt);
}

// Example usage
$text1 = "The quick brown fox jumps over the lazy dog.";
$text2 = "A lazy dog is jumped over by the quick brown fox.";

$comparisonResult = compareText($text1, $text2);

if ($comparisonResult !== null) {
    echo "Comparison Result: {$comparisonResult}\n";
}
