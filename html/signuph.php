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
      <script src="login.js"></script>
      <script src="index.js"></script>
  </head>
  <body>
    <form action="signup.php" enctype="multipart/form-data" class="container" method="post" name="myForm" onsubmit="return validateForm()"> 
            <h1>SIGNUP</h1>
            <div class="form-group">
                <label for="usr"> Name:</label>
                <input type="text" class="form-control" id="name" name="name" required><b><span class="formerror"> </span></b>
            </div>
            <div class="form-group">
                <label for="usr"> Username:</label>
                <input type="text" class="form-control" id="uname" name="uname" required><b><span class="formerror"> </span></b>
            </div>
            <div class="form-group">
                <label for="usr"> Email:</label>
                <input type="email" class="form-control" id="emailid" name="email" required><b><span class="formerror"> </span></b>
                <a onclick="otp()">Send OTP</a>
            </div>
            <div class="form-group" id="otp">
                <label for="otp"> OTP:</label>
                <input type="number" class="form-control" id="otpinput" name="otp" required>
                <a onclick="otp()">Resend OTP</a>
            </div>
            <div class="form-group">
                <label for="usr">Password:</label>
                <input type="password" class="form-control" id="pswd" name="pswd" required><br><b><span class="formerror"> </span></b>
            </div>
            <div class="form-group">
                <label for="usr">Re-enter Password:</label>
                <input type="password" class="form-control" id="repswd" name="repswd" required><br><b><span class="formerror"> </span></b>
            </div> 
            <button class="btn btn-outline-success" type="submit" name="signup">Signup</button>
            <div class="form-group mt-5">
                <p>Have an account? <a href="/login">Signin</a></p>
            </div>
        </form>
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
        integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo"
        crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js"
        integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1"
        crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js"
        integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM"
        crossorigin="anonymous"></script>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"
        integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    </body>
</html>