<?php
include 'User.php';
/**
 * Add the notes created by the user in user_notes table.
 */

    $notes = $_POST['notes'];
    $obj = new User();
    $obj->checkConnection();
    $name = $_SESSION['name'];
    $query = "INSERT INTO user_login (name, notes) VALUES ('$name','$notes')";
    $obj->conn->exec($query);
?>