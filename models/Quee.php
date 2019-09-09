<?php


class Quee
{
    //DB Stuff
    private $conn;
    //Constructor to DB    

    public function __construct($db)
    {
        $this->conn = $db;
    }


    public function getActive()
    {

        $query = "SELECT * FROM que WHERE Status =? ORDER BY QuiID";

        //Prepare statement
        $stmt = $this->conn->prepare($query);

        //Execute query
        $stmt->execute(array(1));

        return $stmt;
    }

    public function getQueByPatientId($PatientId)
    {

        $query = "SELECT * FROM que WHERE PatientId = ? and Status = ?";

        $stmt = $this->conn->prepare($query);
        $stmt->execute(array($PatientId, 1));

        return $stmt->rowCount();
    }

    //Add  
    public function add(
        $PatientId,
        $PatientName,
        $Status,
        $CreateUserId
    ) {
        if ($this->getQueByPatientId($PatientId) > 0) {
            return $PatientName . "is  already in the que";
        }
        $query = "INSERT INTO que (
                                        PatientId,
                                        PatientName,
                                        Status,
                                        CreateUserId
                                        )
                    VALUES (?, ?, ?, ?)           
                   ";
        try {
            $stmt = $this->conn->prepare($query);
            if ($stmt->execute(array(
                $PatientId,
                $PatientName,
                $Status,
                $CreateUserId
            ))) {
                return $this->conn->lastInsertId();
            }
        } catch (Exception $e) {
            return $e;
        }
    }

    //update  
    public function update(
        $QuiID
    ) {
        $query = "UPDATE que SET Status = ? Where QuiID=? ";
        try {
            $stmt = $this->conn->prepare($query);
            return $stmt->execute(array(2, $QuiID));
        } catch (Exception $e) {
            return $e;
        }
    }
}
