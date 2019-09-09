<?php
include_once '../../config/Database.php';
include_once '../../models/Quee.php';

$data = json_decode(file_get_contents("php://input"));

//connect to db
$database = new Database();
$db = $database->connect();

//Instantiate user object

$quee = new Quee($db);

$result = $quee->getActive();
$outputList = Array();

if($result->rowCount()){
    $outputList = $result->fetchAll(PDO::FETCH_ASSOC);
}
echo json_encode($outputList);




