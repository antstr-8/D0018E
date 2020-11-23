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
      <div class="products">
          <?php
            $stmt = $pdo->prepare("SELECT id,name,description FROM prodcat");
            $stmt->execute();
            $result = $stmt->fetchAll();
            foreach($result as $row){
              $stht = $pdo->prepare("SELECT color,stock,url,price FROM prodinfo WHERE id=$row[id]");
              $stht->execute();
              $res = $stht->fetchAll();
              foreach($res as $row2){
                echo "<div class='product_row'>";
                echo "<div class='pictures'>";
                echo "<img src=" . $row2['url'] . " style='max-width: 100%;max-height: 100%;'>";
                /*echo "testbild";*/
                echo "</div>";
                echo "<div class='description'>";
                echo $row['description'];
                echo "</div>";
                echo "<div class='price'>";
                 echo "<div class='artname'>";
                   echo $row['name'];
                 echo "</div>";
                echo $row2['price'];
                echo "<br>";
                echo $row2['stock'];
                echo "<br>";
                echo $row2['color'];
                echo "</div>";
                echo "</div>";
             }
            }
          ?>
       </div>
       <br>
  <!--<p>
     <a href="php/prodcat.php">Product catalog</a>
  </p>-->
  <a href="php/profile.php">Profile</a>
</div>
</body>
</html>
