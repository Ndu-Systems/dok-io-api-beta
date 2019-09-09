<?php
include_once '../../config/Database.php';
include_once '../../models/Medication.php';

//connect to db
$database = new Database();
$db = $database->connect();

//instantiate the models here
$medication = new Medication($db);

$result= $medication->getMedications();

if($result){
    $medication  = $result; 
}
echo json_encode($medication);


