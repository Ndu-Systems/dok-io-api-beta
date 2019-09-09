<?php
include_once '../../config/Database.php';
include_once '../../models/Prescription.php';
include_once '../../models/Prescription_Drug.php';


$data = json_decode(file_get_contents("php://input"));

//if there is a patient then add prescription
if (isset($data->patientId)) {

    $patientId = $data->patientId;
    $symptoms = $data->symptoms;
    $diagnosis = $data->diagnosis;
    $boolPreasure = $data->boolPreasure;
    $pulseRate = $data->pulseRate;
    $CreateUserId = $data->CreateUserId;
    $ModifyUserId = $CreateUserId;
    $drugs = $data->drugs;
    $StatusId = 1;
    // $prescriptionId = md5(time());
    $prescriptionId = time();

    // echo json_encode($data);
    //connect to db
    $database = new Database();
    $db = $database->connect();

    //Instantiate user object

    $prescriptionObj = new Prescription($db);

    $result = $prescriptionObj->AddPrescription(
        $prescriptionId,
        $patientId,
        $symptoms,
        $diagnosis,
        $boolPreasure,
        $pulseRate,
        $CreateUserId,
        $ModifyUserId,
        $StatusId
    );

    if ($result == $prescriptionId) {
        // push the drugs to the db
        foreach ($drugs as $drug) {
            $result_drug =new Prescription_Drug($db);
            $result_drug->add(
                $prescriptionId, 
                $drug->medicationId, 
                $drug->unit, 
                $drug->dosage, 
                $CreateUserId,
                $ModifyUserId ,
                $StatusId
            );
        }
        echo json_encode($prescriptionId);
    }
} else {
    echo json_encode("500 - internal server error");
}
