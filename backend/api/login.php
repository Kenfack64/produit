<?php
header('Content-Type: application/json');

require_once '../config/Database.php';
require_once '../controllers/AuthController.php';

$database = new Database();
$db = $database->connect();

$auth = new AuthController($db);
$data = json_decode(file_get_contents("php://input"));

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $result = $auth->login($data);
    echo json_encode($result);
} else {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Méthode non autorisée']);
}