<?php
require 'vendor/autoload.php';
//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
use GuzzleHttp\Client;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

include 'User.php';

$email = $_POST['emailid'];
$obj = new User();
$obj->checkConnection();
$flag = TRUE;
while ($flag) {
    $otp = random_int(100000,999999);
    if (!$obj->checkOtp($otp)) {
       $flag = $obj->emailExists($email);
        $obj->sendMail($email, $otp, "NULL");
        $obj->storeOtp($email, $otp, $flag);
        $flag = FALSE;
    }
 }
?>