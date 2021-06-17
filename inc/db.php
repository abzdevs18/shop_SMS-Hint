<?php
      $password = "C{aI!d5Biv7+bKY7";
      $username = "id16197085_shop_app_usr";
      $db = "id16197085_shop_app";
      $conn = mysqli_connect("localhost",$username, $password, $db);
      if(!$conn){
        die("Unable to connect to DB: ". mysqli_connect_error());
      }
 ?>
