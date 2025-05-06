<?php

header('Content-Type: application/json');
require 'config.php';

$data = json_decode(file_get_contents('php://input'), true);

if (!$data || empty($data['id'])) {
    http_response_code(400);
    echo json_encode(['error' => 'ID is required']);
    exit;
}

try {
    $deleteResult = $collection->deleteOne([
        '_id' => new MongoDB\BSON\ObjectId($data['id'])
    ]);

    echo json_encode(['message' => 'Car deleted successfully']);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Failed to delete car', 'details' => $e->getMessage()]);
}
?>
