<?php
namespace App\Services;

use GuzzleHttp\Client;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

/**
 * Sends otp or link to the user for signing up or resetting password.
 */
class Otp {
  
  /**
   *   @var string
   *     Stores the email id from where the mail will be sent.
   */
  private $mailUserName;
  /**
   *   @var string
   *     Stores the email id's password from where the mail will be sent.
   */
  private $mailPassword;
  
  /**
   * Constructor used to store the email id and password to class variables.
   *
   *   @param string $mailUserName
   *     Stores the email id.
   *   @param string $mailPassword
   *     Stores the password.
   * 
   *   @return void
   */
  public function __construct(string $mailUserName, string $mailPassword) {
      $this->mailUserName = $mailUserName;
      $this->mailPassword = $mailPassword;
  }

  /**
   *Send otp to recipient for signup or reset password.
   * 
   *    @param string $email
   *        stores the email.
   * 
   *    @param int $otp
   *        stores the otp.
   * 
   *    @param string $link
   *       stores the link.
   * 
   *    @return mixed 
   *        returns true if mail is not sent else returns an error message.   
   */
  public function sendMail(string $email, int $otp, string $link) {
    try {
      $mail = new PHPMailer(true);
      //Send using SMTP
      //$mail->SMTPDebug = TRUE;
      $mail->isSMTP(); 
      //Set the SMTP server to send through                                       
      $mail->Host       = 'smtp.gmail.com'; 
      //Enable SMTP authentication                    
      $mail->SMTPAuth   = true;                                  
      $mail->Username   = $this->mailUserName;              
      $mail->Password   = $this->mailPassword;
      $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;        
      $mail->Port       = 465;                                   
      $mail->setFrom('2000pgoswami@gmail.com', 'Buzz');
      $mail->addAddress($email);                    
      $mail->isHTML(true);  
      if ($link == "send") {
        $mail->Subject = 'Enter the OTP to signup';
        $mail->Body    =  $otp;     
      }   
      else {
        $user = substr($link, 26);
        $encryptLink = password_hash($user, PASSWORD_BCRYPT);
        $mail->Subject = 'Reset Password';
        $mail->Body    =  "http://example.com/resetpassword/" . $encryptLink;
      }         
      if (!$mail->send()) {
        return TRUE;
      } 
    }
    catch (Exception $e) {
      return "Email could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
  }
}