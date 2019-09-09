<?php
include_once '../../config/Database.php';
include_once '../../models/Quee.php';

$data = json_decode(file_get_contents("php://input"));


$PatientId  = $data->PatientId;
$PatientName  = $data->PatientName;
$Status  = $data->Status;
$CreateUserId  = $data->CreateUserId;

//connect to db
$database = new Database();
$db = $database->connect();

//Instantiate user object

$quee = new Quee($db);

$result = $quee->add(
    $PatientId,
    $PatientName,
    $Status,
    $CreateUserId
);

echo json_encode($result);







