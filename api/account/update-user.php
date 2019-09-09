<?php
include_once '../../config/Database.php';
include_once '../../models/User.php';
include_once '../../models/Transactionhistory.php';

$data = json_decode(file_get_contents("php://input"));

$UserId= $data->UserId;
$Email= $data->Email;
$Password= $data->Password;
$FirstName= $data->FirstName;
$Surname= $data->Surname;
$Title= $data->Title;
$Gender= $data->Gender;
$PhoneNumber= $data->PhoneNumber;
$IdNumber= $data->IdNumber;
$CreateUserId= $data->ModifyUserId;
$ModifyUserId= $CreateUserId;
$StatusId = $data->StatusId;

//connect to db
$database = new Database();
$db = $database->connect();

//Instantiate user object

$user = new user($db);

$result = $user->UpdateUser(
    $UserId, 
    $Email, 
    $Password, 
    $FirstName, 
    $Surname, 
    $Title, 
    $Gender, 
    $PhoneNumber, 
    $IdNumber, 
    $CreateUserId, 
    $ModifyUserId, 
    $StatusId,
    $CreateUserId

);
echo json_encode($result);
// log data
$log = new Transactionhistory($db);
$log_result  = $log->add('UPDATE_USER',  json_encode($data),json_encode($result), $UserId, $CreateUserId, $ModifyUserId, 1);







