<?php
include_once '../../config/Database.php';
include_once '../../models/User.php';
include_once '../../models/Transactionhistory.php';
include_once '../../models/Practice.php';

$data = json_decode(file_get_contents("php://input"));

$Name= $data->Name;
$Address= $data->Address;
$CreateUserId= $data->CreateUserId;
$ModifyUserId= $CreateUserId;
$StatusId = $data->StatusId;

//connect to db
$database = new Database();
$db = $database->connect();

//Instantiate user object

$practice = new Practice($db);

$result = $practice->add(
    $Name,
    $Address,
    $CreateUserId,
    $ModifyUserId,
    $StatusId
);
echo json_encode($result);
// log data
$log = new Transactionhistory($db);
if(isset($result['PracticeId'])){
    $adduserpractice = $practice->adduserpractice($CreateUserId, $result['PracticeId'],$CreateUserId, $ModifyUserId,1);
    $log_result  = $log->add('ADD_PRACTICE',  json_encode($data),'', $result['PracticeId'], $CreateUserId, $ModifyUserId, 1);
}else{
    $log_result  = $log->add('ADD_PRACTICE',  json_encode($data),'ADD PRACTICE FAILED', 'ADD_PRACTICE', $CreateUserId, $ModifyUserId, 1);
}








