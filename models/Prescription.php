<?php

class Prescription{

     //DB Stuff
     private $conn;

     //Properties here
    public $prescriptionId;
    public $patientId;
    public $symptoms;
    public $diagnosis;
    public $boolPreasure;
    public $pulseRate;
    public $createdate;
    public $CreateUserId;
    public $ModifyDate;
    public $ModifyUserId;
    public $StatusId;
    public $drugs;


     //Constructor to DB

        public function __construct($db)
        {
            $this->conn = $db;
        }



    //Get all prescriptions
    public function GetAll()
    {
       $query = "       
       SELECT * 
       FROM prescription
       WHERE StatusId = ?
       ORDER BY createdate
       ";
       //prepare query statement PDO
       $stmt = $this->conn->prepare($query);

       //Execute query
       $stmt->execute(array(1));

       return $stmt;
    }

    //Get a prescription 
    public function GetById($prescriptionId)
    {
        $query = "
            SELECT * 
            FROM prescription
            WHERE prescriptionId = ?
        ";

        //prepare query statemnet PDO
        $stmt = $this->conn->prepare($query);

        //execute the prepare statement
        $stmt->execute(array($prescriptionId));

        return $stmt;
    }
    //Get prescriptions for a single patient
    public function GetPatientPrescriptions($PatientId)
    {
            $query = "            
                SELECT * 
                FROM prescription
                WHERE patientId = ?
                ORDER BY createdate desc
            ";

            //prepare the query statement PDO
            $stmt = $this->conn->prepare($query);

            //Executed the prepared statement
            $stmt->execute(array($PatientId));

            return $stmt;
    }

    public function AddPrescription(
        $prescriptionId, 
        $patientId, 
        $symptoms,
        $diagnosis,
        $boolPreasure ,
        $pulseRate,
        $CreateUserId,
        $ModifyUserId,      
        $StatusId
    )
    {
        $query= "INSERT INTO prescription(prescriptionId, patientId, symptoms, diagnosis, boolPreasure, pulseRate, CreateUserId, ModifyUserId, StatusId) 
                              VALUES (?,?,?,?,?,?,?,?,?)";

        try {

            //prepare query statement PDO
            $stmt = $this->conn->prepare($query);

           if($stmt->execute(array(
                $prescriptionId, 
                $patientId, 
                $symptoms,
                $diagnosis,
                $boolPreasure ,
                $pulseRate,
                $CreateUserId,
                $ModifyUserId,      
                $StatusId
            ))){
                return $prescriptionId;
            }

        } catch (Exception $ex) {
            return $ex;
        }

    }



}