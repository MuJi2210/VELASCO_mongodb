<?php

require 'vendor/autoload.php'; 

try {
    
    $client = new MongoDB\Client("mongodb://localhost:27017");

    
    $db = $client->selectDatabase('testdb');
    $collection = $db->selectCollection('cars'); 
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Could not connect to MongoDB', 'details' => $e->getMessage()]);
    exit;
}
?>
