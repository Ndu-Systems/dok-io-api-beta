<?php
include_once '../../config/Database.php';
include_once '../../models/Quee.php';

$data = json_decode(file_get_contents("php://input"));


$QuiID  = $data->QuiID;

//connect to db
$database = new Database();
$db = $database->connect();

//Instantiate user object

$quee = new Quee($db);

$result = $quee->update(
    $QuiID
);

echo json_encode($result);







