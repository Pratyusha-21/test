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
        <form action="newpassword.php" enctype="multipart/form-data" class="container" method="post"> 
            <?php
            if ($flag == 1) {
            ?>
                <p>Password changed.</p>
            <?php
            }
            else {
            ?>    
                <p>Password cannot be changed.</p>
            <?php
            }
            ?>
            <h1>Create New Password</h1>
            <div class="form-group">
                <label for="usr"> New Password:</label>
                <input type="password" class="form-control" id="usr" name="pswd">
            </div>
            <div class="form-group">
                <label for="usr">Confirm New Password:</label>
                <input type="password" class="form-control" id="usr" name="repswd">
            </div>
            <button class="btn btn-outline-success" type="submit" name="change">Change</button>
            <div class="form-group mt-5">
                <p>Don't have an account? <a href="signuph.php">Signup</a></p>
            </div>
            <div class="form-group">
                <p>Already have an account? <a href="loginh.php">Login</a></p>
            </div>
        </form>
  </body>
</html>