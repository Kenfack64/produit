<?php
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
$product->name = $data->name;
$product->brand = $data->brand ?? null;
$product->category = $data->category;
$product->shade = $data->shade ?? null;
$product->skin_type = $data->skin_type ?? null;
$product->purchase_price = $data->purchase_price ?? 0;
$product->sale_price = $data->sale_price ?? 0;
$product->expiry_date = $data->expiry_date ?? null;
$product->quantity = $data->quantity ?? 0;

if ($product->update()) { // Méthode à créer
    echo json_encode(['success' => true, 'message' => 'Produit mis à jour']);
} else {
    echo json_encode(['success' => false, 'message' => 'Erreur de mise à jour']);
}
?>