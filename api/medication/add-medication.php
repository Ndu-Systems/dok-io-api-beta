<?php
include_once '../../config/Database.php';
include_once '../../models/Medication.php';

$data = json_decode(file_get_contents("php://input"));

$name  = $data->name;
$description  = $data->description;
$CreateUserId  = $data->CreateUserId;
$ModifyUserId  = $CreateUserId;
$StatusId  = $data->StatusId;
// $medicationId = md5(time());
$medicationId = time();



//connect to db
$database = new Database();
$db = $database->connect();

//instantiate the models here
$medication = new Medication($db);

$result = $medication->add(
    $medicationId,
    $name,
    $description,
    $CreateUserId,
    $ModifyUserId,
    $StatusId
);

if ($result) {
   echo json_encode($medicationId);
}else{
    echo json_encode($result);

}
