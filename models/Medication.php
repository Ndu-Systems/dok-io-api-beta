<?php

class Medication
{

  //DB stuff
  private $conn;

  //return properties
  public $medicationId;
  public $name;
  public $description;
  public $unit;
  public $dosage;
  public $createdate;
  public $CreateUserId;
  public $ModifyDate;
  public $ModifyUserId;
  public $StatusId;


  //Constructor required for Dependency Injection
  public function __construct($db)
  {
    $this->conn = $db;
  }

  //Get medication that were prescribed for a prescription
  public function GetMedicationForPrescription($prescriptionId)
  {
    $query = "
        SELECT med.medicationId, med.name, med.description, pmd.unit, pmd.dosage
        FROM medication med
        LEFT JOIN prescription_medication_drug pmd ON med.medicationId = pmd.medicationId
        WHERE pmd.prescriptionId = ?
        ORDER BY med.createdate 
       ";

    //prepare query statement
    $stmt = $this->conn->prepare($query);

    //Execute query
    $stmt->execute(array($prescriptionId));
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $result;
  }
  public function getMedications()
  {
    $query = "Select * from medication where StatusId = ?";

    //prepare query statement
    $stmt = $this->conn->prepare($query);

    //Execute query
    $stmt->execute(array(1));
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $result;
  }


  //Add  
  public function add(
    $medicationId,
    $name,
    $description,
    $CreateUserId,
    $ModifyUserId,
    $StatusId
  ) {
    $query = "INSERT INTO medication (
                medicationId ,
                name ,
                description ,
                CreateUserId ,
                ModifyUserId ,
                StatusId
                          )
                  VALUES (?, ?, ?, ?,?,?)           
                 ";
    try {
      $stmt = $this->conn->prepare($query);
      return $stmt->execute(array(
        $medicationId,
        $name,
        $description,
        $CreateUserId,
        $ModifyUserId,
        $StatusId
      ));
    } catch (Exception $e) {
      return $e;
    }
  }
}
