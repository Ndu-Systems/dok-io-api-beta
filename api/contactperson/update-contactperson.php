<?php
include_once '../../config/Database.php';
include_once '../../models/Contactperson.php';
include_once '../../models/Transactionhistory.php';

$data = json_decode(file_get_contents("php://input"));


$ContactPersonId  = $data->ContactPersonId;
$PatientId  = $data->PatientId;
$Name  = $data->Name;
$Relationship  = $data->Relationship;
$CellNumber  = $data->CellNumber;
$ModifyUserId  = $data->ModifyUserId;
$CreateUserId =  $ModifyUserId;
$StatusId  = $data->StatusId;



//connect to db
$database = new Database();
$db = $database->connect();

//Instantiate user object

$user = new Contactperson($db);

$result = $user->update(
    $ContactPersonId ,
    $PatientId,
    $Name,
    $Relationship,
    $CellNumber,
    $CreateUserId,
    $ModifyUserId,
    $StatusId
);

echo json_encode($result);



// log data
$userId = json_encode($result);
$log = new Transactionhistory($db);
$log_result  = $log->add('UPDATE_EMEG_CONT_FOR_PATIENT',  json_encode($data),'',$PatientId, $ModifyUserId, $ModifyUserId, 1);






