<?php
  require_once "config.php";
  session_start();
  $pictureCheck = false;
  $nameCheck = false;
  $prodid = 0;

  if(isset($_POST['newProduct'])){
    //$filepath = "./../Pictures/" . $_FILES["file"]["name"];
    $sqlQuery1 = "INSERT INTO PRODCAT (name,description)
    VALUES (:name,:description)";
    $sqlQuery2 = "INSERT INTO PRODINFO (prodid,color,stock,url,price)
    VALUES(:prodid,:color,:stock,:url,:price)";

    $stmtIns1 = $pdo->prepare($sqlQuery1);
    $stmtIns2 = $pdo->prepare($sqlQuery2);

    $stmtIns1->bindParam(":name", $_POST['productName'], PDO::PARAM_STR);
    $stmtIns1->bindParam(":description", $_POST['Description'], PDO::PARAM_STR);

    $stmtIns2->bindParam(":color", $_POST['prodcolor'], PDO::PARAM_STR);
    $stmtIns2->bindParam(":stock", $_POST['stock'], PDO::PARAM_STR);
    $stmtIns2->bindParam(":price", $_POST['prodprice'], PDO::PARAM_STR);


    $filepath = "./../Pictures/" . $_FILES["file"]["name"];
    $extension = pathinfo($_FILES["file"]["name"], PATHINFO_EXTENSION);
    $productName = $_POST['productName'];


    if($extension == 'jpeg' || $extension == 'png' || $extension == 'jpg'){
      if(move_uploaded_file($_FILES["file"]["tmp_name"], $filepath)) {
        $pictureCheck = true;
      } else {
        $pictureCheck = false;
      }
    } else{
      echo "You uploaded the wrong kind of file. Only takes png and jpg";
    }

    if($pictureCheck == true){
      $stmtIns1->execute();
      $GetId = $pdo->prepare("SELECT @@identity AS 'id'");
      $GetId->execute();
      $prodid = $GetId->fetch();

      $stmtIns2->bindParam(":url", $filepath, PDO::PARAM_STR);
      $stmtIns2->bindParam(":prodid", $prodid['id'], PDO::PARAM_STR);
      $stmtIns2->execute();


    }else{
      echo "Error with the upload! Check the fields entered";
    }
    header("location: ./../index.php");
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
    echo "Welcome <a href='profile.php'>" . $_SESSION["username"] . "</a>";
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
  <input type="text" name="productName">
  <label>Stock:</label>
  <input type="number" name="stock">
  <br>
  <label>Price:</label>
  <input type="number" name="prodprice">
  <label>Color:</label>
  <input type="text" name="prodcolor">
</form>
<p>Description:</p>
<textarea name="Description" form="newprod" maxlength="250">Description of the item goes here</textarea>
<br>
<input type="submit" value="Submit" name="newProduct" form="newprod">
<!--<div class="productrow">
  <div class="pictures">
    <img src="/../pictures/ingenbild.png" border="1" style='max-width: 100%; max-height: 100%;'>
  </div>
</div>-->

</div>

</body>
</html>
