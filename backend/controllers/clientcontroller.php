<?php
require_once "../config/database.php";
require_once "../models/Client.php";

$db = (new Database())->connect();
$client = new Client($db);

if($_SERVER['REQUEST_METHOD']=="GET"){
    echo json_encode($client->read());
}

if($_SERVER['REQUEST_METHOD']=="POST"){
    $data = json_decode(file_get_contents("php://input"));

    $client->name = $data->name;
    $client->phone = $data->phone;
    $client->skin_type = $data->skin_type;

    echo json_encode(["success"=>$client->create()]);
}
?>