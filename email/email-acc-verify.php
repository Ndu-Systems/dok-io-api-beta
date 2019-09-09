<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PATCH, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token');
$data = json_decode(file_get_contents("php://input"));

$name = $data->name;
$email= $data->email;
$link= $data->link;

 $msg = "
 <div
 style='position:relative;width:80%;font-family:Trebuchet MS;background-color:#ecf0f1;box-sizing: border-box;margin: auto; padding: 3%;'>
 <h2 style='text-align: center;width:100%;'>
   Welcome to Dok-IO
 </h2>
 <div style='width:100%;padding:3%;padding-bottom: 1%;'>
   <p style='text-align:left;width:80%;'>


     Hello $name <br>
     <br>
     We’re excited to have you as our newest Dok-IO member.
     Please confirm your account with us by clicking the button below:
     <div style='width:100%; text-align: left;padding:1%;margin: 2rem 0;
     '>
       <a  style='background-color: #03A9F4;border: none;color: white; padding: 12px 16px;font-size: 16px;cursor: pointer;box-sizing: border-box;border-radius: 30px;text-transform: capitalize;' href=$link>Confirm my account</a>
     </div>


     If you believe you received this email by mistake or have any questions,
     feel free to shoot us an email at support@dok-io.net.

     All the best,
     The Dok-IO Team
   </p>
   <p class='left'
     style='width:100%;text-align:left;padding-top:2%;border-top-width:1px;border-top-style:solid;border-top-color:rgb(199, 199, 199);'>
     Regrads <br>
     Dok-Io Team <br>
     account@dok-io.net
   </p>
 </div>
</div>
      
";

$to = "mrnnmthembu@gmail.com ,Freedom.Khanyile1@gmail.com, ".$email;
$subject = 'Dok-IO new account Confirmation';
$from = 'ndumiso@ndu-systems.net';
 
$headers  = 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

$headers .= 'From: '.$from."\r\n".
    'Reply-To: '.$from."\r\n" .
    'X-Mailer: PHP/' . phpversion();
if(isset($name)){    
if(mail($to, $subject, $msg, $headers)){
    echo 1;
}else{
    echo 0;
}
}else{
  echo 3;
}

?>