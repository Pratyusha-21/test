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
    <form action="/userlogin" enctype="multipart/form-data" class="container" method="post"> 
        <h1>LOGIN</h1>
        <div class="form-group">
            <label for="usr"> Email:</label>
            <input type="email" class="form-control" id="email" name="email">
        </div>
        <div class="form-group">
            <label for="usr">Password:</label>
            <input type="password" class="form-control" id="pswd" name="pswd"><br>
        </div>
        <div class="form-group">
            <a href="/forget">Forgot your password?</a>
        </div>
        <button class="btn btn-outline-success" type="submit" name="login">Login</button>
        <div class="form-group mt-5">
            <p>Don't have an account? <a href="/register">Signup</a></p>
        </div>
    </form>
  </body>
</html>