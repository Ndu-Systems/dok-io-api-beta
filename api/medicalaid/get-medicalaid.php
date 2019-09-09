<?php
include_once '../../config/Database.php';
include_once '../../models/MedicalAid.php';

$data = json_decode(file_get_contents("php://input"));
$PatientId = $_GET['PatientId'];

//connect to db
$database = new Database();
$db = $database->connect();

//Instantiate user object

$data = new MedicalAid($db);

$result = $data->getById($PatientId);
$outputList = Array();

if($result->rowCount()){
    $outputList = $result->fetchAll(PDO::FETCH_ASSOC);
}
echo json_encode($outputList);




