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
      <link rel="stylesheet" href="stylenotes.css">
  </head>
  <body>
    <nav class="navbar">
        <div class="container">
            <a class="navbar-brand" href="#">
                <img src="data:image/png;base64,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" alt="Logo" width="100" height="50" class="d-inline-block align-text-top">
            </a>
            <div class="button">
                <i class="fa-solid fa-bell" id="notify" style="color: #131416;"></i>
                <div class="notifications" id="notifications">
                </div>
                <a class="btn btn-primary" href="/editprofile">Edit Profile</a>
                <button class="btn btn-outline-success" id="logout" onclick="logout()" type="submit">Logout</button>
            </div>
        </div>
    </nav>
 </body>
</html>