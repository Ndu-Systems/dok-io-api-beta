<?php


class User
{
    //DB Stuff
    private $conn;
    private $table = 'user';

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
    public function read($email)
    {

        $query = "SELECT         
        u.UserId,  
        u.ParentId,     
        r.RoleId as Role,
        u.Password
        FROM 
        user u JOIN 
        userroles ur on u.UserId = ur.UserId 
        LEFT JOIN roles r on ur.RoleId = r.RoleId
        WHERE 
        Email =  ?        
        ";

        //Prepare statement
        $stmt = $this->conn->prepare($query);

        //Execute query
        $stmt->execute(array($email));

        return $stmt;
    }

    //get user by email
    public function getByIdEmail($email)
    {

        $query = "SELECT * FROM user WHERE Email = ?";

        $stmt = $this->conn->prepare($query);
        $stmt->execute(array($email));

        if ($stmt->rowCount()) {
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
            return  $user;
        }

        return null;
    }
    //get user by email
    public function getByUserParentId($ParentId)
    {

        $query = "SELECT * FROM user WHERE ParentId = ?";

        $stmt = $this->conn->prepare($query);
        $stmt->execute(array($ParentId));

        if ($stmt->rowCount()) {
            $user = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return  $user;
        }

        return null;
    }
    //get user by email
    public function getByUserId($UserId)
    {

        $query = "SELECT * FROM user WHERE UserId = ?";

        $stmt = $this->conn->prepare($query);
        $stmt->execute(array($UserId));

        if ($stmt->rowCount()) {
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
            return  $user;
        }

        return null;
    }


    public function  signUp(
        $Email,
        $Password,
        $FirstName,
        $Surname,
        $Title,
        $Gender,
        $PhoneNumber,
        $IdNumber,
        $CreateUserId,
        $ModifyUserId,
        $StatusId,
        $ParentId
    ) {
        if ($this->getByIdEmail($Email) > 0) {
            return "User with email address (" . $Email . ") already exists";
        }
        $query = "INSERT INTO user (
                                        UserId, 
                                        Email, 
                                        Password, 
                                        FirstName, 
                                        Surname, 
                                        Title, 
                                        Gender, 
                                        PhoneNumber, 
                                        IdNumber, 
                                        CreateUserId, 
                                        ModifyUserId, 
                                        StatusId,
                                        ParentId
                                    )
                    VALUES (uuid(),?, ?, ?, ?,?, ?, ?,?, ?, ?, ?,?)           
                   ";
        try {
            $stmt = $this->conn->prepare($query);
            if ($stmt->execute(array(
                $Email,
                $Password,
                $FirstName,
                $Surname,
                $Title,
                $Gender,
                $PhoneNumber,
                $IdNumber,
                $CreateUserId,
                $ModifyUserId,
                $StatusId,
                $ParentId
            ))) {
                return $this->getByIdEmail($Email);
            }
        } catch (Exception $e) {
            return $e;
        }
    }

    public function  UpdateUser(
        $UserId,
        $Email,
        $Password,
        $FirstName,
        $Surname,
        $Title,
        $Gender,
        $PhoneNumber,
        $IdNumber,
        $CreateUserId,
        $ModifyUserId,
        $StatusId,
        $ParentId
    ) {
    
        $query = "UPDATE user SET 
                                        Email =?, 
                                        Password=?, 
                                        FirstName=?, 
                                        Surname=?, 
                                        Title=?, 
                                        Gender=?, 
                                        PhoneNumber=?, 
                                        IdNumber=?, 
                                        CreateUserId=?, 
                                        ModifyUserId=?, 
                                        StatusId=?,
                                        ParentId=?
                                        WHERE UserId = ?
                                        
                                             
                   ";
        try {
            $stmt = $this->conn->prepare($query);
            if ($stmt->execute(array(
                $Email,
                $Password,
                $FirstName,
                $Surname,
                $Title,
                $Gender,
                $PhoneNumber,
                $IdNumber,
                $CreateUserId,
                $ModifyUserId,
                $StatusId,
                $ParentId,
                $UserId,

            ))) {
                return $this->getByIdEmail($Email);
            }
        } catch (Exception $e) {
            return $e;
        }
    }
}
