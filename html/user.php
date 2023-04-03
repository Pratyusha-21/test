<?php
// session_start();
//Load Composer's autoloader
require 'vendor/autoload.php';

//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
use GuzzleHttp\Client;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

/**
 * Checks for the validation of email.
 * Checks whether the email exist or not at the time og log in.
 * Checks whether the entered password is correct or not at tha time of lig in.
 * Send mail according to the condition.
 * Checks for the validation of the password.
 * Checks whether the name contains any digit or not.
 * Checks the otp.
 * Stores the otp in user_otp table.
 * Sends otp.
 * Stores user login details in user_login table.
 */
class User {
  /**
   *  @var string
   *    stores the servername.
   */
  private $servername = "localhost";
  
  /**
   *  @var string 
   *    stores the username.
   */
  private $username = "Pratyusha";
  
  /**
   *  @var string 
   *    stores the password.
   */
  private $password = "Pg*12345";
  
  /**
   *  @var string 
   *    stores the database name.
   */
  private $dbname = "mydb";
  
  /**
   *  @var string
   *      stores first name.
   */
  public $name;

  /**
   *   @var string 
   *      stores last name.
   */
  public $uname;

  /**
   *  @var string 
   *      stores user's email.
   */
  public $email;

  /**
   *  @var int
   *      stores phone number.
   */
  public $pswd;

  /**
   *  @var object
   *      stores the instance of PDO.
   */
  public $conn;

  /**
   * Checks connection is made or not.
   * 
   *  @return bool
   *      returns true if connected or else returns false.
   */
  public function checkConnection() {
      try {
        $this->conn = new PDO("mysql:host=$this->servername;dbname=$this->dbname", $this->username, $this->password);
        $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return TRUE;
      } 
      catch(PDOException $e) {
        return FALSE;
      }
  }

  /**
   * Constructor to assign the values to the class variables.
   */
  public function __construct() {
    if(isset($_POST['signup'])) {
      $this->name = $_POST['name'];
      $this->uname = $_POST['uname'];
      $this->email = $_POST['email'];
      $this->pswd = $_POST['pswd'];
    }
  } 

  /**
   * Stores user login details in a table.
   */
  public function storeLoginDetails() {
    $encryptPswd = password_hash($this->pswd, PASSWORD_BCRYPT);
    $loginTable = "INSERT INTO user_login (firstname,lastname,email,password)
    VALUES ('$this->name','$this->uname','$this->email','$encryptPswd')";
    $this->conn->exec($loginTable);
  }
  
  /**
   * Checks whether password for the entered email is correct or not.
   * 
   *    @param string $password
   *        stores the password.
   *    @return mixed 
   *        returns a message if the password is incorrect else returns true.
   */
  public function checkPassword(string $password) {
    $pswd = 99;
    $qry = "SELECT password FROM user_login where email = '$this->email'";
    $st = $this->conn->prepare($qry);
    $st->execute();
    if ($st->rowCount() > 0) {
      $res = $st->fetchAll();
      $pswd = $res[0]['password'];
    }
    if ($pswd != $password) {
      return "Incorrect Password";
    }
    return TRUE;
  }

  /** 
  * Function to check whether the name contains any number or not.
  *
  *     @return string mixed
  *         returns message or returns true.
  *
  */
  public function getName() {
    $message = "TRUE";
    // Checks whether the fields are filled.
    if (empty($this->name) || empty($this->uname)) {
        $message = "Field should not be empty";
    } 
    // Checks whether any number input is taken.
    elseif ((is_numeric($this->name) == 1) || (is_numeric($this->uname) == 1)) {
        $message = "number is not allowed";
    }
    // Checks whether name contains any number.
    elseif (preg_match("~[0-9]+~", $this->name) || (preg_match("~[0-9]+~", $this->uname))) {
        $message = "name should not contain numbers";  
    }
    return $message;
  }

  /**
   * Checks whether password is valid or not.
   * 
   *    @param string $password
   *        stores the password.
   * 
   *    @return mixed 
   *        returns a string if the password is invalid or returns true.
   */
  public function validatePassword(string $password) {
    // Validate password strength
    $uppercase = preg_match("@[A-Z]@", $password);
    $lowercase = preg_match("@[a-z]@", $password);
    $number    = preg_match("@[0-9]@", $password);
    $specialChars = preg_match("@[^\w]@", $password);
    if (!$uppercase || !$lowercase || !$number || !$specialChars || strlen($password) < 8) {
      return "Password should be at least 8 characters in length and should include at least one upper case letter, one number, and one special character.";
    }
    return TRUE;
  }

  /**
   * Checks whether email exists or not.
   * 
   *    @param string $mail
   *        stores the email.
   * 
   *    @return mixed
   *        returns true if account exist or else returns a message.    
   */
  public function emailExists(string $mail) {
    $sql = "SELECT * from user_login where email='$mail'";
    $smtp = $this->conn->prepare($sql);
    $smtp->execute();
    if($smtp->rowCount() > 0) {      
      return TRUE;
    }
    return "Account doesn't exist";
  } 

  /**
   *Send mail or otp or resend password link to recipient.
   * 
   *    @param string $email
   *        stores the email.
   * 
   *    @param int $otp
   *        stores the otp.
   * 
   *    @param string $link
   *        stores the link to reset password.
   * 
   *    @return mixed 
   *        returns true if mail is sent else returns a message.   
   */
  public function sendMail(string $email, int $otp, string $link) {
    try {

      // echo "<script>console.log('$otp') </script>";


      $mail = new PHPMailer(true);
      //Send using SMTP
      //$mail->SMTPDebug = TRUE;
      $mail->isSMTP(); 
      //Set the SMTP server to send through                                       
      $mail->Host       = 'smtp.gmail.com'; 
      //Enable SMTP authentication                    
      $mail->SMTPAuth   = true;                                  
      $mail->Username   = '2000pgoswami@gmail.com';              
      $mail->Password   = 'kjtenbzxwkwhrnjh';
      $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;        
      $mail->Port       = 465;                                   
      $mail->setFrom('2000pgoswami@gmail.com', 'Innoraft');
      $mail->addAddress($email);                    
      $mail->isHTML(true);                    
      if ($otp == 0 and $link == NULL) {
        $mail->Subject = 'Welcome to Innoraft!';
        $mail->Body    = 'Thank you for signing up.';
      }
      elseif ($otp == 0) {
        $mail->Subject = 'Link to reset password';
        $mail->Body    =  $link;
      }
      else {
        $mail->Subject = 'Enter the OTP to signup';
        $mail->Body    =  $otp;
      }
      if($mail->send()) {
        echo "<script>console.log('$otp') </script>";
        return TRUE;
      } 
    }
    catch (Exception $e) {
      return "Email could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
  }

  /**
   * Stores the OTP generated.
   * 
   *  @param string $email
   *      stores the email where the otp is sent.
   * 
   *  @param int $otp
   *      stores the otp.
   * 
   *  @param bool $flag
   *      stores boolean value for checking.
   */
  public function storeOtp(string $email, int $otp, bool $flag) {
    if ($flag) {
      $qry = "UPDATE user_otp set otp = '$otp' where email = '$email'";
      $this->conn->exec($qry);
    }
    else {
      $qry = "INSERT INTO user_otp (email,otp) VALUES ('$email','$otp')";
      $this->conn->exec($qry); 
    }
  }

  /**
   * Checks whether the otp already exists or not.
   *  
   *    @param int otp
   *        stores the otp.
   * 
   *    @return bool
   *        returns true if the otp exist.
   */
  public function checkOtp(int $otp) {
    $sql = "SELECT * from user_otp where otp='$otp'";
    $smtp = $this->conn->prepare($sql);
    $smtp->execute();
    if($smtp->rowCount() > 0) {      
      return TRUE;
    }
    return FALSE;
  } 
}
?>