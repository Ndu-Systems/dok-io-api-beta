<?php


class Prescription_Drug
{
    //DB Stuff
    private $conn;

    //Return properties
    public $UserId;
    public $Email;
    public $Password;

    //Constructor to DB    

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function add(
        $prescriptionId, 
        $medicationId, 
        $unit, 
        $dosage, 
        $CreateUserId,
        $ModifyUserId ,
        $StatusId
    ) {
     
        $query = "INSERT INTO prescription_medication_drug (
                                        prescriptionMedicationId, 
                                        prescriptionId, 
                                        medicationId, 
                                        unit, 
                                        dosage, 
                                        CreateUserId,
                                        ModifyUserId ,
                                        StatusId)
                    VALUES (UUID(),?, ?, ?, ?, ?, ?, ?)           
                   ";
        try {
            $stmt = $this->conn->prepare($query);
            if($stmt->execute(array(
                $prescriptionId, 
                $medicationId, 
                $unit, 
                $dosage, 
                $CreateUserId,
                $ModifyUserId ,
                $StatusId
            ))){
                // return $this->getUserByEmail($Email);
               // return true;
            }
        } catch (Exception $e) {
            return $e;
        }

    }




}



