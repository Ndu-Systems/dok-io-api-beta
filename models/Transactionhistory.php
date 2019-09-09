<?php
class Transactionhistory
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

    //Get a user
    public function read($email, $password)
    {

        $query = "SELECT 
        *
        FROM 
        transactionhistory 
        WHERE 
       1
        ";

        //Prepare statement
        $stmt = $this->conn->prepare($query);

        //Execute query
        $stmt->execute(array($email, $password));

        return $stmt;
    }


    public function  add(
                    $Action, 
                    $PayLoad, 
                    $Outcome, 
                    $UserId, 
                    $CreateUserId, 
                    $ModifyUserId, 
                    $StatusId
    ) {
        $query = "INSERT INTO transactionhistory (
                                TransactionHistoryId, 
                                Action, 
                                PayLoad, 
                                Outcome, 
                                UserId, 
                                CreateUserId, 
                                ModifyUserId, 
                                StatusId
                                    )
                    VALUES (uuid(),?, ?, ?, ?,?,?,?)           
                   ";
        try {
            $stmt = $this->conn->prepare($query);
            if ($stmt->execute(array(
                $Action, 
                $PayLoad, 
                $Outcome, 
                $UserId, 
                $CreateUserId, 
                $ModifyUserId, 
                $StatusId
            ))) {
                // return $this->conn->lastInsertId();
                return true;
            }
        } catch (Exception $e) {
            return $e;
        }
    }
}
