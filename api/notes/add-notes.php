<?php
include_once '../../config/Database.php';
include_once '../../models/Note.php';

$data = json_decode(file_get_contents("php://input"));


$NoteId = time();

$PatientId = $data->PatientId;
$Notes =  $data->Notes;
$CreateUserId =  $data->CreateUserId;
$ModifyUserId =  $CreateUserId;
$StatusId =  $data->StatusId;
$prescriptionGiven =  $data->prescriptionGiven;

//connect to db
$database = new Database();
$db = $database->connect();

//Instantiate user object

$notes = new Note($db);

$result = $notes->add(
    $NoteId,
    $PatientId,
    $Notes,
    $CreateUserId,
    $ModifyUserId,
    $StatusId,
    $prescriptionGiven
);

echo json_encode($result);







