<?php
include_once '../../config/Database.php';
include_once '../../models/User.php';
include_once '../../models/Transactionhistory.php';


$data = json_decode(file_get_contents("php://input"));
 $email    = $data->email;
 $password = $data->password;
//connect to db
$database = new Database();
$db = $database->connect();

//Instantiate user object

$user = new User($db);
$log = new Transactionhistory($db);


$result = $user->read($email);

if($result->rowCount()){
    $user = $result->fetch(PDO::FETCH_OBJ);
    if($user){        
        // even encrypted API must return an null Password parameter for the user Object
        $user->Password = NULL;
        echo json_encode($user);
    } 
    else {
        echo json_encode(error("Invalid Email or Password"));
        $log_result  = $log->add('USER_LOGIN',  json_encode($data),'INCORRECT_PASSWORD', $email, 'SYS', 'SYS', 1);
    }

    $log_result  = $log->add('USER_LOGIN',  json_encode($data),'LOGIN_SUCESS', $email, 'SYS', 'SYS', 1);
}else{
    echo json_encode(error("Invalid User"));
    $log_result  = $log->add('USER_LOGIN',  json_encode($data),'LOGIN_FAILED', $email, 'SYS', 'SYS', 1);

}





