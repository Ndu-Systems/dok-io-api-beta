<?php
include_once '../../config/Database.php';
include_once '../../models/Patient.php';
include_once '../../models/Transactionhistory.php';

$data = json_decode(file_get_contents("php://input"));

$Title  = $data->Title;
$FirstName  = $data->FirstName;
$Surname  = $data->Surname;
$IdNumber  = $data->IdNumber;
$DOB  = $data->DOB;
$Gender  = $data->Gender;
$Email  = $data->Email;
$Cellphone  = $data->Cellphone;
$AddressLine1  = $data->AddressLine1;
$City  = $data->City;
$Province  = $data->Province;
$PostCode  = $data->PostCode;
$CreateUserId  = $data->CreateUserId;
$ModifyUserId  = $data->CreateUserId;
$StatusId  = $data->StatusId;
$PatientId  = $data->PatientId;



//connect to db
$database = new Database();
$db = $database->connect();

//Instantiate user object

$user = new Patient($db);

$result = $user->update(
    $Title,
    $FirstName,
    $Surname,
    $IdNumber,
    $DOB,
    $Gender,
    $Email,
    $Cellphone,
    $AddressLine1,
    $City,
    $Province,
    $PostCode,
    $CreateUserId,
    $ModifyUserId,
    $StatusId,
    $PatientId
);

echo json_encode($result);



// log data
$userId = json_encode($result);
$log = new Transactionhistory($db);
$log_result  = $log->add('UPDATE_PATIENT',  json_encode($data),'',$PatientId, $CreateUserId, $CreateUserId, 1);



