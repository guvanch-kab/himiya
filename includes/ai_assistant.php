<?php
header("Content-Type: application/json");

// OpenAI API Key (sk- ile başlamaly)
$apiKey = "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";

// API URL (GPT-4o-mini üçin)
$apiUrl = "https://api.openai.com/v1/chat/completions";

// Ulanyjy sorusy
$userQuestion = isset($_POST['question']) ? trim($_POST['question']) : '';

if (empty($userQuestion)) {
    echo json_encode(["status" => "error", "message" => "Sorag giriziň!"]);
    exit;
}

// API üçin maglumatlar
$data = [
    "model" => "gpt-4o", // GPT-4o-mini modeli üçin model adyny üýtgediň
    "messages" => [
        ["role" => "system", "content" => "Siz ussat bir assistant."],
        ["role" => "user", "content" => $userQuestion]
    ],
    "temperature" => 0.7,
    "max_tokens" => 500
];

// cURL işlemi
$ch = curl_init($apiUrl);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    "Content-Type: application/json",
    "Authorization: Bearer " . $apiKey
]);

$response = curl_exec($ch);

if (curl_errno($ch)) {
    echo json_encode(["status" => "error", "message" => "cURL ýalňyşlygy: " . curl_error($ch)]);
    curl_close($ch);
    exit;
}
curl_close($ch);

$responseData = json_decode($response, true);

// Jogaby barla
if (isset($responseData['choices'][0]['message']['content'])) {
    echo json_encode([
        "status" => "success",
        "response" => $responseData['choices'][0]['message']['content']
    ]);
} else {
    echo json_encode([
        "status" => "error",
        "message" => "Jogap alynmady",
        "debug" => $responseData
    ]);
}
