<?php
require_once "../config/database.php";

$db = (new Database())->connect();

$revenue = $db->query("SELECT SUM(total) as total FROM sales")->fetch(PDO::FETCH_ASSOC);
$topProducts = $db->query("
    SELECT p.name, SUM(s.quantity) as total
    FROM sales s
    JOIN products p ON p.id = s.product_id
    GROUP BY p.id
    ORDER BY total DESC LIMIT 5
")->fetchAll(PDO::FETCH_ASSOC);

echo json_encode([
    "revenue"=>$revenue['total'],
    "topProducts"=>$topProducts
]);
?>