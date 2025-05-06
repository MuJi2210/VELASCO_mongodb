<?php

header('Content-Type: application/json');
require 'config.php';

$data = json_decode(file_get_contents('php://input'), true);

if (!$data || empty($data['id']) || empty($data['make']) || empty($data['model']) || empty($data['year'])) {
    http_response_code(400);
    echo json_encode(['error' => 'ID, Make, Model, and Year are required']);
    exit;
}

try {
    $updateResult = $collection->updateOne(
        ['_id' => new MongoDB\BSON\ObjectId($data['id'])],
        ['$set' => [
            'make' => $data['make'],
            'model' => $data['model'],
            'year' => (int)$data['year'],
            'updated_at' => new MongoDB\BSON\UTCDateTime()
        ]]
    );

    echo json_encode(['message' => 'Car updated successfully']);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Failed to update car', 'details' => $e->getMessage()]);
}
?>
