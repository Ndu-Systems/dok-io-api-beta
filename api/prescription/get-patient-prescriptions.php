<?php
include_once '../../config/Database.php';
include_once '../../models/Prescription.php';
include_once '../../models/Medication.php';

//PatientId parameter
$PatientId = $_GET['PatientId'];

//connect to the database
$database = new Database();
$db = $database->connect();

//Instatiate the models object here
$prescriptions = new Prescription($db);

//Call the method to return all patient prescriptions
$result = $prescriptions->GetPatientPrescriptions($PatientId);
$outPut = Array();
//Associat your results
if($result->rowCount()){
    $prescriptions  = $result->fetchAll(PDO::FETCH_ASSOC); 
}

$outPut = Array();
$outPut['PatientPrescriptions'] = $prescriptions;
echo json_encode($outPut);