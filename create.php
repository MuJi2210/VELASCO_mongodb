<?php

header('Content-Type: application/json');
require 'config.php';

$data = json_decode(file_get_contents('php://input'), true);

if (!$data || empty($data['make']) || empty($data['model']) || empty($data['year'])) {
    http_response_code(400);
    echo json_encode(['error' => 'Make, Model, and Year are required']);
    exit;
}

try {
    $insertResult = $collection->insertOne([
        'make' => $data['make'],
        'model' => $data['model'],
        'year' => (int)$data['year'],
        'created_at' => new MongoDB\BSON\UTCDateTime()
    ]);

    echo json_encode([
        'message' => 'Car created successfully',
        'id' => (string) $insertResult->getInsertedId()
    ]);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Failed to create car', 'details' => $e->getMessage()]);
}
?>
