<?php
include_once '../../config/Database.php';
include_once '../../models/Medication.php';

$data = json_decode(file_get_contents("php://input"));

$drugs = $data->drugs;
$medicationId = time();



//connect to db
$database = new Database();
$db = $database->connect();

//output
$output = Array();

foreach ($drugs as $drug) {
    $medication = new Medication($db);
    $medicationId = time();
    $medication->add(
        $medicationId, 
        $drug->name,
        $drug->description,
        $drug->CreateUserId,
        $drug->CreateUserId,
        $drug->StatusId
    );
    $med = new Med();
    $med->medicationId = $medicationId;
    $med->unit = $drug->unit;
    $med->dosage = $drug->dosage;
    $output[] = $med;
}
echo json_encode($output);



class Med {
   public $medicationId;
   public $unit;
   public $dosage;
}