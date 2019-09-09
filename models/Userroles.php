<?php


class Userroles
{
    //DB Stuff
    private $conn;
    //Constructor to DB    

    public function __construct($db)
    {
        $this->conn = $db;
    }


    public function add(
        $UserId,
        $RoleId,
        $CreateUserId,
        $ModifyUserId,
        $StatusId
    ) {
        $query = "INSERT INTO userroles (
                                        UserId,
                                        RoleId,
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
                $RoleId,
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
}
