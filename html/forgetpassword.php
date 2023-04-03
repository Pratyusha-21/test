<?php
include 'User.php';
$obj = new User();
$obj->checkConnection();
if (isset($_POST['link'])) {
    $email = $_POST['email'];
    if ($obj->emailExists($email) == TRUE) {
        $encryptEmail = password_hash($email, PASSWORD_BCRYPT);
        $link = "http://local-notepad-app.com/resetpassword.php/" . $encryptEmail;
        $send = $obj->sendMail($email,0,$link);
    }
}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
      <meta charset="UTF-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>Login Page</title>
      <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css"
          integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

              <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
        <link rel="stylesheet" href="style.css">

  </head>
  <body>
        <form action="forgetpassword.php" enctype="multipart/form-data" class="container" method="post"> 
            <h1>Reset Password</h1>
            <div class="form-group">
                <label for="usr"> Email:</label>
                <input type="text" class="form-control" id="usr" name="email">
            </div>
            <?php
            if (isset($_POST['link'])) {
                if ($send == TRUE) {
                ?>
                    <p>Email has been sent.</p>
                <?php
                }
                else {
                ?>
                    <p>Email has not been sent.</p>
                <?php
                }
            }
            ?>
            <button class="btn btn-outline-success" type="submit" name="link">Send Link</button>
            <div class="form-group mt-5">
                <p>Don't have an account?<a href="signuph.php">Signup</a></p>
            </div>
        </form>
  </body>
</html>