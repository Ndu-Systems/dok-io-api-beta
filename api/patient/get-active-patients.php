<?php
include_once '../../config/Database.php';
include_once '../../models/Patient.php';
$DocId = $_GET['docId'];
//connect to db
$database = new Database();
$db = $database->connect();

//Instantiate user object

$patients = new Patient($db);

$result = $patients->read($DocId,1);

if($result->rowCount()){
    $patients = $result->fetchAll(PDO::FETCH_ASSOC);
}
$outPut = Array();
$outPut['patients']=$patients;
echo json_encode($outPut);





