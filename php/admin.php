<?php

  session_start();
  $pictureCheck = false;
  $nameCheck = false;

  if(isset($_POST['newProduct'])){
    //$filepath = "./../Pictures/" . $_FILES["file"]["name"];
    $filepath = "E:\wamp64\www\Pictures/" . $_FILES["file"]["name"];
    $extension = pathinfo($_FILES["file"]["name"], PATHINFO_EXTENSION);
    echo $extension;
    echo "<br/>";
    if($extension == 'jpeg' || $extension == 'png' || $extension == 'jpg'){
      if(move_uploaded_file($_FILES["file"]["tmp_name"], $filepath)) {
        $pictureCheck = true;
        //echo "<img src=".$filepath." height=200 width=300 />";
        echo "working";
      } else {
        echo $filepath;
        echo "<br/>";
        echo "not working";
        $pictureCheck = false;
      }
    } else{
      echo "You uploaded the wrong kind of file you pepega baboon.";
    }
}
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
    echo "Welcome <a href='php/profile.php'>" . $_SESSION["username"] . "</a>";
    echo '<style type="text/css">
            .login {
              display:none;
            }
          </style>';
    if($_SESSION["admin"] == 1){
      echo '<style type="text/css">
              .admin {
                display: inline;
              }
            </style>';
    }
  }

  else{
    echo '<style type="text/css">
            .logout {
              display:none;
            }
          </style>';
  }
  ?>
   <a class="login" href="login.php">Login</a>
   <a class="login" href="register.php">Sign up</a>
   <a class="logout" href="cart.php">Cart</a>
   <a class="logout" href="logout.php">Sign out</a>
   <a class="admin" href="admin.php">Admin</a>
 </div>
</div>
<div class="content">
<!--Functionality to add new products-->
<h1>Add a new product</h1>
<form id="newprod" action="admin.php" enctype="multipart/form-data" method="post">
  <h3>Select image :</h3>
  <input type="file" name="file"><br/>
  <label>Product name:</label>
  <input type="text" name="productName"><br/>
</form>
<p>Description:</p>
<textarea name="Description" form="newprod" maxlength="250">Description of the item goes here</textarea><br/>
<input type="submit" value="Submit" name="newProduct" form="newprod">
<!--<div class="productrow">
  <div class="pictures">
    <img src="/../pictures/ingenbild.png" border="1" style='max-width: 100%; max-height: 100%;'>
  </div>
</div>-->

</div>

</body>
</html>
