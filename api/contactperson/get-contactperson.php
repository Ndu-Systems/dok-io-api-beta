<?php
include_once '../../config/Database.php';
include_once '../../models/Contactperson.php';

$data = json_decode(file_get_contents("php://input"));

if(!isset($_GET['PatientId'])){
    echo json_encode("Patient Id Not Provided");
    return null;
}
$PatientId  = $_GET['PatientId'];





//connect to db
$database = new Database();
$db = $database->connect();

//Instantiate user object

$user = new Contactperson($db);

$result = $user->getById($PatientId);
$outputList = Array();
if($result->rowCount()){
    $outputList = $result->fetchAll(PDO::FETCH_ASSOC);

}

echo json_encode($outputList);







