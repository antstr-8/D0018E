<?php

  session_start();

  require_once "php/config.php";

 ?>

<!DOCTYPE html>
<html>
<head>
  <link rel="stylesheet" href="/css/style.css">
</head>
<body>
  <div class="content">
      <h1>BIG HTML</h1>
  <p>
    <?php
    if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
      echo $_SESSION["username"];
    }
     ?>
     <br>
     <a href="php/login.php">Login</a>
     <a href="php/logout.php">Sign out</a>
     <br>
     <a href="php/prodcat.php">Product catalog</a>
  </p>
</div>
</body>
</html>
