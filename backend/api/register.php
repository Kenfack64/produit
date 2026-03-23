<?php
header('Content-Type: application/json');

require_once '../controllers/RegisterController.php';

$data = json_decode(file_get_contents("php://input"));

$controller = new RegisterController();
$result = $controller->register($data);

echo json_encode($result);