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
      <script src="form.js"></script>
  </head>
  <body>
  <?php
  session_start();
  include 'header.php';
  ?>
    <section class="main">
        <div class="container">
            <?php
            $name = $_SESSION['name'];
            $sql = "SELECT * from user_notes where name='$name'";
            $query = $obj->conn->prepare($sql);
            if($query->rowCount() > 0) {
                $res = $query->fetchAll();
            }
              for ($i = 0; $i < count($res); $i++) {
                $id = $res[$i]['id'];
                ?>
                <div class="post">
                    <h3><?php $res[$i]['title'] ?></h3>
                    <p><?php echo [$i]['notes'] ?></p>
                    <div class="dropdown">
                        <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"></button>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            <a id="edit" onclick="showPopup(<? $id ?>)" class="dropdown-item">Edit</a>
                            <a id="delete" onclick="deletePost(<? $id ?>)" class="dropdown-item">Delete</a>
                        </div>
                    </div>
                    <p id="posttext"></p>
                    <div class="editpost" id="editpost">
                        <textarea name="edit" cols="30" rows="10"></textarea>
                        <input id="edittext" class="btn btn-primary" type="button" value="Submit" onclick="editPost(this.id)">
                    </div>
                <?php
                }
            ?>
        </div>
    </section>