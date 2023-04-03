<?php
session_start();
include 'User.php';
$obj = new User();
if (isset($_POST['login'])) {
    $mail = $_POST['email'];
    $pswd = $_POST['pswd'];
    if ($obj->checkConnection()) {
        $email = $obj->emailExists($mail);
        $password = $obj->checkPassword($pswd);
        if ($email != TRUE) {
            $message = $email;
        }
        elseif ($password != TRUE) {
            $message = $password;
        }
        else {
            $sql = "SELECT * from user_login where email='$mail'";
            $smtp = $obj->conn->prepare($sql);
            if($smtp->execute()){
                echo "done";
            }
            else{
                echo "not done";
            }
            if($smtp->rowCount() > 0) {
                $message = TRUE;         
                $res = $smtp->fetchAll();
                $_SESSION['name'] = $res[0]['name'];
                $_SESSION['uname'] = $res[0]['uname'];
                $_SESSION['email'] = $res[0]['email'];   
                header('location:index.php');
            }
        }
    }
    else {
        $message = "CONNECTION LOST";
        include 'loginh.php';
    }
}