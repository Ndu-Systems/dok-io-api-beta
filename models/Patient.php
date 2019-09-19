<?php


class Patient
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
    public function read($DocId, $statusId)
    {
        $query = "
        select 
        p.patientid,
        p.title, 
        p.dob,
        p.statusid, 
        p.province, 
        p.firstname, 
        p.surname,
        p.idnumber,
        p.email,
        p.cellphone,
        p.gender,
        p.createdate,
        p.addressline1,
        p.city ,
        p.postcode ,
        med.MedicalaidId, 
        med.MedicalaidName, 
        med.MedicalaidType, 
        med.MemberShipNumber, 
        med.PrimaryMember, 
        med.PrimaryMemberId
        from patient AS p
             LEFT OUTER JOIN medicalaid AS med on med.PatientId = p.PatientId
             LEFT OUTER JOIN patient_doctor_practice AS pdp on pdp.PatientId = p.PatientId
             LEFT OUTER JOIN user AS u on u.UserId = pdp.DoctorId
             LEFT OUTER JOIN practice AS pc on pc.PracticeId = pdp.PracticeId
       WHERE p.StatusId = ?
       AND u.UserId = ?
       ORDER BY CreateDate Desc        
        ";
        //Prepare statement
        $stmt = $this->conn->prepare($query);

        //Execute query
        $stmt->execute(array($statusId, $DocId));

        return $stmt;
    }

    public function getById($PatientId)
    {

        $query = "
        select patient.PatientId, 
        patient.Title, 
        patient.FirstName, 
        patient.DOB, 
        patient.Surname,
        patient.IdNumber,
        patient.Email,
        patient.Cellphone,
        patient.Gender,
        patient.CreateDate,
        patient.AddressLine1,
        patient.City,
        patient.PostCode,
        medicalaid.MedicalaidId, 
        medicalaid.MedicalaidName, 
        medicalaid.MedicalaidType, 
        medicalaid.MemberShipNumber, 
        medicalaid.PrimaryMember, 
        medicalaid.PrimaryMemberId,
        count(appointment.AppointmentId) as NumAppointments,

        contactperson.ContactPersonId,
        contactperson.Name as ContactName,
        contactperson.CellNumber  as ContactCell,
        contactperson.Relationship  as ContactRelationship
        
        from patient 
        left join  medicalaid on medicalaid.PatientId = patient.PatientId   
        left join appointment on appointment.PatientId = patient.PatientId 
        left join contactperson on contactperson.PatientId = patient.PatientId               
        where patient.PatientId = ?		
		GROUP by patient.PatientId
        ";

        //Prepare statement
        $stmt = $this->conn->prepare($query);

        //Execute query
        $stmt->execute(array($PatientId));

        return $stmt;
    }


    public function FunctionName(Type $var = null)
    {
        $query = "SELECT * FROM patient WHERE Email = ?";

        $stmt = $this->conn->prepare($query);
        $stmt->execute(array($email));

        return $stmt->rowCount();
    }
    //Get recently added user
    public function getUserByEmail($email)
    {

        $query = "SELECT * FROM patient WHERE Email = ?";

        $stmt = $this->conn->prepare($query);
        $stmt->execute(array($email));

        if ($stmt->rowCount()) {
            return $patient = $stmt->fetch(PDO::FETCH_ASSOC);
        }
    }

    //Get user by Id number
    public function getByIdNumber($IdNumber)
    {

        $query = "SELECT * FROM patient WHERE IdNumber = ?";

        $stmt = $this->conn->prepare($query);
        $stmt->execute(array($IdNumber));
        if ($stmt->rowCount()) {
            return $patient = $stmt->fetch(PDO::FETCH_ASSOC);
        }
    }
    //Add user 
    public function add(
        $Title,
        $FirstName,
        $Surname,
        $IdNumber,
        $DOB,
        $CreateUserId,
        $ModifyUserId,
        $StatusId
    ) {
        if ($this->getByIdNumber($IdNumber) > 0) {
            return "User with IdNumber number (" . $IdNumber . ") already exists";
        }

        $query = "INSERT INTO patient (     
                                        PatientId
                                        ,Title                                                                           
                                        ,FirstName
                                        ,Surname
                                        ,IdNumber
                                        ,DOB                                         
                                        ,CreateUserId
                                        ,ModifyUserId
                                        ,StatusId)
                    VALUES (UUID(),?,?, ?, ?, ?, ?, ?, ?)           
                   ";
        try {
            $stmt = $this->conn->prepare($query);
            if ($stmt->execute(array(
                $Title,
                $FirstName,
                $Surname,
                $IdNumber,
                $DOB,
                $CreateUserId,
                $ModifyUserId,
                $StatusId
            ))) {
                return $this->getByIdNumber($IdNumber);
            }
        } catch (Exception $e) {
            return $e;
        }
    }

    //Add Update User 
    public function update(
        $Title,
        $FirstName,
        $Surname,
        $IdNumber,
        $DOB,
        $Gender,
        $Email,
        $Cellphone,
        $AddressLine1,
        $City,
        $Province,
        $PostCode,
        $CreateUserId,
        $ModifyUserId,
        $StatusId,
        $PatientId
    ) {
        // I need to check if u not taking someones email
        $query = "UPDATE  patient  SET
                                        Title = ?
                                        ,FirstName = ?
                                        ,Surname = ?
                                        ,IdNumber = ?
                                        ,DOB = ?
                                        ,Gender = ?
                                        ,Email = ?
                                        ,Cellphone = ?
                                        ,AddressLine1 = ?
                                        ,City = ?
                                        ,Province = ?
                                        ,PostCode = ?
                                        ,CreateUserId = ?
                                        ,ModifyUserId = ?
                                        ,StatusId = ?
                                        WHERE PatientId=?

                             
                   ";
        try {
            $stmt = $this->conn->prepare($query);
            if ($stmt->execute(array(
                $Title,
                $FirstName,
                $Surname,
                $IdNumber,
                $DOB,
                $Gender,
                $Email,
                $Cellphone,
                $AddressLine1,
                $City,
                $Province,
                $PostCode,
                $CreateUserId,
                $ModifyUserId,
                $StatusId,
                $PatientId
            ))) {
                return $this->getByIdNumber($IdNumber);
            }
        } catch (Exception $e) {
            return $e;
        }
    }

    public function AddPatientDoctorPractice(
        $UserId,
        $patientId,
        $practiseId,
        $statusId
    ) {
        $query = "INSERT INTO patient_doctor_practice(
                    Id, 
                    PatientId, 
                    DoctorId, 
                    PracticeId,  
                    CreateUserId, 
                    ModifyUserId, 
                    StatusId) 
                    VALUES 
                    (uuid(),?, ?,?, ?,?,?)";

        try {
            $stmt = $this->conn->prepare($query);

            if ($stmt->execute(array(
                $patientId,
                $UserId,
                $practiseId,
                $UserId,
                $UserId,
                $statusId
            ))) {
                return 1;
            }
        } catch (Exception $e) {
            return $e;
        }
    }
}
