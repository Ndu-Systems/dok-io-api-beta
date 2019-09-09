<?php
include_once '../../config/Database.php';
include_once '../../models/User.php';
include_once '../../models/Transactionhistory.php';
include_once '../../models/Userroles.php';

$data = json_decode(file_get_contents("php://input"));

$Email= $data->Email;
$Password= $data->Password;
$FirstName= $data->FirstName;
$Surname= $data->Surname;
$Title= $data->Title;
$Gender= $data->Gender;
$PhoneNumber= $data->PhoneNumber;
$IdNumber= $data->IdNumber;
$CreateUserId= $data->CreateUserId;
$ModifyUserId= $data->ModifyUserId;
$StatusId = $data->StatusId;

//Encrypt password
$hashPassword = password_hash($Password, PASSWORD_BCRYPT);

//connect to db
$database = new Database();
$db = $database->connect();

//Instantiate user object

$user = new user($db);
$userroles = new Userroles($db);

$result = $user->signUp(
    $Email, 
    $hashPassword, 
    $FirstName, 
    $Surname, 
    $Title, 
    $Gender, 
    $PhoneNumber, 
    $IdNumber, 
    $CreateUserId, 
    $ModifyUserId, 
    $StatusId,
    ''
);
echo json_encode($result);
// log data
$log = new Transactionhistory($db);
if(isset($result['UserId'])){
    $userrolescreate = $userroles->add($result['UserId'],2,$CreateUserId,$ModifyUserId,1);
    $log_result  = $log->add('USER_REG_WEB',  json_encode($data),'', $result['UserId'], $CreateUserId, $CreateUserId, 1);
}else{
    $log_result  = $log->add('USER_REG_WEB',  json_encode($data),'', $result, $CreateUserId, $CreateUserId, 1);
}








