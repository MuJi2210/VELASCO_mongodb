<?php

header('Content-Type: application/json');
require 'config.php';

try {
    $cars = $collection->find()->toArray();

    $response = array_map(function($car) {
        $car['_id'] = (string) $car['_id'];
        if (isset($car['created_at'])) {
            $car['created_at'] = $car['created_at']->toDateTime()->format('Y-m-d H:i:s');
        }
        return $car;
    }, $cars);

    echo json_encode($response);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Failed to fetch cars', 'details' => $e->getMessage()]);
}
?>
