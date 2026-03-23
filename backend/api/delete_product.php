<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
header('Content-Type: application/json');
require_once '../config/database.php';
require_once '../models/Product.php';

$database = new Database();
$db = $database->connect();

$data = json_decode(file_get_contents("php://input"));

if (empty($data->id)) {
    echo json_encode(['success' => false, 'message' => 'ID manquant']);
    exit;
}

$product = new Product($db);
$product->id = $data->id;

if ($product->delete()) { // Méthode à créer (voir plus haut)
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'message' => 'Erreur de suppression']);
}
?>