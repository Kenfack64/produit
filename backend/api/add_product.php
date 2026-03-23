<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
header('Content-Type: application/json');
require_once '../config/database.php';
require_once '../models/Product.php';

$database = new Database();
$db = $database->connect();

$data = json_decode(file_get_contents("php://input"));

// Validation des données obligatoires
if (empty($data->name) || empty($data->category)) {
    echo json_encode(['success' => false, 'message' => 'Nom et catégorie requis']);
    exit;
}

$product = new Product($db);
$product->name = $data->name;
$product->brand = $data->brand ?? null;
$product->category = $data->category;
$product->shade = $data->shade ?? null;
$product->skin_type = $data->skin_type ?? null;
$product->purchase_price = $data->purchase_price ?? 0;
$product->sale_price = $data->sale_price ?? 0;
$product->expiry_date = $data->expiry_date ?? null;
$product->quantity = $data->quantity ?? 0;
$product->shop_id = 1; // À remplacer par $_SESSION['shop_id'] après authentification

if ($product->create()) {
    echo json_encode(['success' => true, 'message' => 'Produit ajouté']);
} else {
    echo json_encode(['success' => false, 'message' => 'Erreur lors de l\'ajout']);
}
?>