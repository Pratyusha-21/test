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
  include 'header.php';
  ?>
    <div class="container">
    <form action="/signup" enctype="multipart/form-data" class="container" method="post" name="myForm"> 
        <div class="left">
            <div class="row">
                <textarea name="title" id="title" cols="30" rows="10" placeholder="Title of your note"></textarea>
                <button type="button" onclick="title()" id="addnote" class="btn btn-primary">Add Title</button>
            </div>
        </div>
        <div class="right">
            <div class="row">
                <textarea name="notes" id="notes" cols="30" rows="10" placeholder="Write your notes here"></textarea>
                <button type="button" onclick="post()" id="addnote" class="btn btn-primary">Create a Post</button>
            </div>
        </div>
    </form>
    </div>