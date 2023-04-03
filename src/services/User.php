<?php
namespace App\Services;

use App\Entity\UserDetails;
use GuzzleHttp\Client;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

/**
 * Checks for the validation of the password.
 * Checks for the validation of the user's name and password.
 */
class User {

    /**
     *  @var string
     *      stores name of the user.
     */
    public $name;

    /**
     *   @var string 
     *      stores user name of the user.
     */
    public $uname;

    /**
     *  @var string 
     *      stores user's email.
     */
    public $email;

    /**
     *   @var string
     *      stores user's password.
     */
    public $pswd;

    /**
     *   @var int
     *      stores otp entered by the user.
     */
    
    public $otp;

    /**
    *  @var object
    *     object of Entity Manager Interface class.
    */
    private $em;

    /**
     * Constructor to assign the values to the class variables.
     */
     public function __construct(string $fn, string $un, string $mail, string $pswd, int $otp, object $em) {
      $this->name = $fn;
      $this->uname = $un;
      $this->email = $mail;
      $this->otp = $otp;
      $this->pswd = $pswd;
      $this->em = $em;
    } 

    /**
     * Function to validate user's name and password.
     * 
     *   @return string
     *      returns a statement according to the validation of user's name and password.
     */   
    public function validateForm() {
        // Checks whether any number input is taken.
        if ((is_numeric($this->name))) {
            return "number is not allowed";
        }
        // Checks whether name contains any number.
        elseif (preg_match("~[0-9]+~", $this->name)) {
            return "name should not contain numbers";  
        }
        // Checks whether name contains any number.
        elseif ($this->validatePassword()) {
            return "Password should be at least 8 characters in length and should include at least one upper case letter, one number, and one special character."; 
        }
        return "valid";
    }

  /**
   * Checks whether password is valid or not.
   *
   *    @return bool
   *        returns true if the password is not according to the validation rules.
   */
  public static function validatePassword(string $pswd) {
    $uppercase = preg_match("@[A-Z]@", $pswd);
    $lowercase = preg_match("@[a-z]@", $pswd);
    $number    = preg_match("@[0-9]@", $pswd);
    $specialChars = preg_match("@[^\w]@", $pswd);
    if (!$uppercase || !$lowercase || !$number || !$specialChars || strlen($pswd) < 8) {
      return TRUE;
    }
  }

  /**
   * Store the user details in the database.
   */
  public function userDetails() {
    $user = new UserDetails();
    $user->setName($this->name);
    $user->setUserName($this->uname);
    $user->setEmail($this->email);
    $user->setPassword($this->pswd);
    $user->setOtp($this->otp);
    $user->setActive(0);
    $this->em->persist($user);
    $this->em->flush();
  }
}
