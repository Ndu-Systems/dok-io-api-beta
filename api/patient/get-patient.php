<?php
include_once '../../config/Database.php';
include_once '../../models/Patient.php';
include_once '../../models/Transactionhistory.php';

 $PatientId = $_GET['PatientId'];
//connect to db
$database = new Database();
$db = $database->connect();

//Instantiate user object

$patients = new Patient($db);

$result = $patients->getById($PatientId);

if($result->rowCount()){
    $patient = $result->fetch(PDO::FETCH_ASSOC);
    echo json_encode($patient);
    // log data
    $userId ='todo';
    $log = new Transactionhistory($db);
    $log_result  = $log->add('GET_PATIENT_INFO',  json_encode($patient),'',$PatientId, $userId, $userId, 1);
}
else {
    echo ('patient not found');
}








