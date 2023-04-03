<?php
include 'User.php';
$obj = new User();
if (isset($_POST['signup'])) {
    $email = $_POST['email'];
    $pswd = $_POST['pswd'];
    $otp = $_POST['otp'];

    if ($obj->checkConnection()) {
        $password = $obj->validatePassword($pswd);
        $name = $obj->getName();
        $query = "SELECT * FROM user_otp where email = '$email'";
        $stmt = $obj->conn->prepare($query);
        $stmt->execute();
        $res = $stmt->fetchAll();
        print_r($res);
        $inputotp = 0;
        $inputotp = $res[0]['otp'];
        if ($name != TRUE) {
            $message = $name; 
        }
        elseif ($password != TRUE) {
            $message = $password;
        }
        elseif ($inputotp != $otp) {
            $message = "Enter Correct Otp";
        }
        else {
            $obj->sendMail($email,0,"NULL");
            $obj->storeLoginDetails();
            $message = TRUE;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="styleform.css">
</head>
<body>
    <?php
    if ($message != TRUE) {
    ?>
        <h1><?php echo $message; ?></h1>
    <?php
    }
    else {
        include 'notelist.php';
    }
    ?>
</body>
</html>