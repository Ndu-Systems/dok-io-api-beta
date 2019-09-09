<?php


class Practice
{
    //DB Stuff
    private $conn;
    //Constructor to DB    

    public function __construct($db)
    {
        $this->conn = $db;
    }


    public function add(
        $Name,
        $Address,
        $CreateUserId,
        $ModifyUserId,
        $StatusId

    ) {
        if ($this->getPractiveByUserandName($CreateUserId, $Name) > 0) {
            return $Name . "is  already exist";
        }
        $query = "INSERT INTO practice (
                            PracticeId,
                            Name,
                            Address,
                            CreateUserId,
                            ModifyUserId,
                            StatusId
                                  )
                    VALUES (uuid(), ?, ?, ?, ?,?)           
                   ";
        try {
            $stmt = $this->conn->prepare($query);
            if ($stmt->execute(array(
                $Name,
                $Address,
                $CreateUserId,
                $ModifyUserId,
                $StatusId
            ))) {
                return $this->getPractiveByUserandNameFull($CreateUserId, $Name);
            }
        } catch (Exception $e) {
            return $e;
        }
    }
    public function getPractiveByUserandName($CreateUserId, $Name)
    {

        $query = "SELECT * FROM practice WHERE CreateUserId = ? and Name = ?";

        $stmt = $this->conn->prepare($query);
        $stmt->execute(array($CreateUserId, $Name));

        return $stmt->rowCount();
    }
    public function getPractiveByUserandNameFull($CreateUserId, $Name)
    {

        $query = "SELECT * FROM practice WHERE CreateUserId = ? and Name =?";

        $stmt = $this->conn->prepare($query);
        $stmt->execute(array($CreateUserId, $Name));

        if ($stmt->rowCount()) {
            $practice = $stmt->fetch(PDO::FETCH_ASSOC);
            return  $practice;
        }

        return null;
    }

    public function adduserpractice(
        $UserId,
        $PracticeId,
        $CreateUserId,
        $ModifyUserId,
        $StatusId
    ) {
        $query = "INSERT INTO userpractice (
                                        UserId,
                                        PracticeId,
                                        CreateUserId,
                                        ModifyUserId,
                                        StatusId
                                        )
                    VALUES (?, ?, ?, ?,?)           
                   ";
        try {
            $stmt = $this->conn->prepare($query);
            if ($stmt->execute(array(
                $UserId,
                $PracticeId,
                $CreateUserId,
                $ModifyUserId,
                $StatusId
            ))) {
                return $this->conn->lastInsertId();
            }
        } catch (Exception $e) {
            return $e;
        }
    }

    public function getPracticeByUserId($UserId)
    {

        $query = "
        SELECT u.UserId, p.Name, p.Address, p.PracticeId FROM practice p 
        INNER JOIN userpractice up on p.PracticeId = up.PracticeId inner join user u
         on up.UserId = u.UserId
         where   u.UserId = ?
        ";

        //Prepare statement
        $stmt = $this->conn->prepare($query);

        //Execute query
        $stmt->execute(array($UserId));

        return $stmt;
    }
}
