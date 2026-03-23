<?php
require_once "../config/database.php";
require_once "../models/Product.php";

$db = (new Database())->connect();
$product = new Product($db);

echo json_encode($product->alerts());
?>