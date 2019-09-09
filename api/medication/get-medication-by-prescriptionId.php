<?php
include_once '../../config/Database.php';
include_once '../../models/Medication.php';

$prescriptionId = $_GET['PrescriptionId'];

//connect to db
$database = new Database();
$db = $database->connect();

//instantiate the models here
$medication = new Medication($db);

$result= $medication->GetMedicationForPrescription($prescriptionId);

if($result){
    $medication  = $result; 
}
$outPut = Array();
$outPut['PrescriptionMedication'] = $medication;
echo json_encode($outPut);


