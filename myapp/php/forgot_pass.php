<?php
error_reporting(0);
include_once("dbconnect.php");
$email = $_POST['email'];
$sqll = "SELECT * FROM User WHERE email = '$email' AND verify ='1'";

function newpassword(){
    $randpass = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%&*_';
    return substr(str_shuffle($randpass),0,8);
}

$pass = newpassword();
$temppass= sha1($pass);

$sql = "UPDATE User SET password='$temppass' WHERE email= '$email' ";
    
$sqls = "SELECT * FROM User WHERE email = '$email' AND verify = '1'";
$result = $conn->query($sqls);
    
if($result->num_rows>0 && $conn->query($sql)===TRUE){
    sendEmail($email,$pass);
    echo "success";
}else{
    echo"failed";
}


function sendEmail($useremail,$pass) {
    $to      = $useremail; 
    $subject = 'Verification for Reset Password'; 
    $message = 'Your temporary password is: '.$pass. "\nPlease use the temporary password to change your own password."; 
    $headers = 'From: noreply@myapp.com.my' . "\r\n" . 
    'Reply-To: '.$useremail . "\r\n" . 
    'X-Mailer: PHP/' . phpversion(); 
    mail($to, $subject, $message, $headers); 
}

?>

