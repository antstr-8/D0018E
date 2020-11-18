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

  <!--HEADER STARTS HERE-->
  <div class="header">
    <div class="logBox">

    <?php
    if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
      echo "Welcome " . $_SESSION["username"];
      echo '<style type="text/css">
              .login {
                display:none;
              }
            </style>';
    }
    else{
      echo '<style type="text/css">
              .logout {
                display:none;
              }
            </style>';
    }

     ?>
     <a class="login" href="php/login.php">Login</a>
     <a class="login" href="php/register.php">Sign up</a>
     <a class="logout" href="php/logout.php">Sign out</a>
   </div>
  </div>

  <!--HEADER ENDS HERE-->
  <div class="content">
      <h1>BIG HTML</h1>
  <p>

     <br>

     <br>
     <a href="php/prodcat.php">Product catalog</a>
  </p>
</div>
</body>
</html>
