<?php
include_once '../../config/Database.php';
include_once '../../models/Practice.php';

$data = json_decode(file_get_contents("php://input"));
$UserId = $_GET['UserId'];

//connect to db
$database = new Database();
$db = $database->connect();

//Instantiate user object

$practice = new Practice($db);

$result = $practice->getPracticeByUserId($UserId);
$outputList = Array();

if($result->rowCount()){
    $outputList = $result->fetchAll(PDO::FETCH_ASSOC);
}
echo json_encode($outputList);




