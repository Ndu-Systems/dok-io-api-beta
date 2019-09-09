<?php


class Note
{
    //DB Stuff
    private $conn;
    //Constructor to DB    

    public function __construct($db)
    {
        $this->conn = $db;
    }


    public function getPatientNotes($PatientId)
    {

        $query = "SELECT * FROM notes WHERE PatientId =?";

        //Prepare statement
        $stmt = $this->conn->prepare($query);

        //Execute query
        $stmt->execute(array($PatientId));

        return $stmt;
    }

    //Add  
    public function add(
        $NoteId,
        $PatientId,
        $Notes,
        $CreateUserId,
        $ModifyUserId,
        $StatusId,
        $prescriptionGiven
    ) {
        $query = "INSERT INTO notes (
                                NoteId,
                                PatientId,
                                Notes,
                                CreateUserId,
                                ModifyUserId,
                                StatusId,
                                prescriptionGiven
                                        )
                    VALUES (?, ?, ?, ?, ? ,? ,?)           
                   ";
        try {
            $stmt = $this->conn->prepare($query);
            if ($stmt->execute(array(
                $NoteId,
                $PatientId,
                $Notes,
                $CreateUserId,
                $ModifyUserId,
                $StatusId,
                $prescriptionGiven
            ))) {
                return $NoteId;
            }
        } catch (Exception $e) {
            return $e;
        }
    }

    //update  
    public function update(
        $NoteId,
        $PatientId,
        $Notes,
        $CreateUserId,
        $ModifyUserId,
        $StatusId,
        $prescriptionGiven
    ) {
        $query = "UPDATE notes SET 
               
               PatientId =?
               Notes =?
               CreateUserId =?
               ModifyUserId =?
               StatusId =?
               prescriptionGiven =?
         Where NoteId =? ";
        try {
            $stmt = $this->conn->prepare($query);
            return $stmt->execute(array(
                $PatientId,
                $Notes,
                $CreateUserId,
                $ModifyUserId,
                $StatusId,
                $prescriptionGiven, $NoteId
            ));
        } catch (Exception $e) {
            return $e;
        }
    }
}
