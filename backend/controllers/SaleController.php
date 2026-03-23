<?php
require_once "../config/database.php";
require_once "../models/Sale.php";

$db = (new Database())->connect();
$sale = new Sale($db);

if($_SERVER['REQUEST_METHOD']=="POST"){
    $data = json_decode(file_get_contents("php://input"));

    $sale->product_id = $data->product_id;
    $sale->client_id = $data->client_id;
    $sale->quantity = $data->quantity;
    $sale->total = $data->total;

    echo json_encode(["success"=>$sale->create()]);
}
?>