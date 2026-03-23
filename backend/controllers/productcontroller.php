<?php
require_once "../config/database.php";
require_once "../models/Product.php";

$db = (new Database())->connect();
$product = new Product($db);

$method = $_SERVER['REQUEST_METHOD'];

if($method == "GET"){
    echo json_encode($product->read());
}

if($method == "POST"){
    $data = json_decode(file_get_contents("php://input"));

    $product->name = $data->name;
    $product->brand = $data->brand;
    $product->category = $data->category;
    $product->shade = $data->shade;
    $product->skin = $data->skin;
    $product->expiry = $data->expiry;
    $product->quantity = $data->quantity;

    echo json_encode(["success"=>$product->create()]);
}
?>