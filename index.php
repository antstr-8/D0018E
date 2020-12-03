<?php

  session_start();

  require_once "php/config.php";

  if(isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true){
      if($_SERVER["REQUEST_METHOD"] == "POST"){

        $prodid = $_POST['prodid'];
        $quantity = $_POST['quantity'];

        $sql2 = "SELECT quantity FROM cart WHERE custid = :custid AND prodid = :prodid";

        if($stmt2 = $pdo->prepare($sql2)){
          $stmt2->bindParam(":custid", $_SESSION['id'], PDO::PARAM_STR);
          $stmt2->bindParam(":prodid", $prodid, PDO::PARAM_STR);

          if($stmt2->execute()){
              if($stmt2->rowCount() >= 1){
                $res = $stmt2->fetch();
                $quantity = $res['quantity'] + $quantity;

                $sql = "UPDATE cart SET quantity = :quantity
                WHERE prodid = :prodid and custid = :custid";
              }
              else{
                $sql = "INSERT INTO cart (custid, prodid, quantity)
                VALUES (:custid, :prodid, :quantity)";
              }
            }
          }

        if($stmt = $pdo->prepare($sql)){
          $stmt->bindParam(":custid", $_SESSION['id'], PDO::PARAM_STR);
          $stmt->bindParam(":prodid", $prodid , PDO::PARAM_STR);
          $stmt->bindParam(":quantity", $quantity , PDO::PARAM_STR);

          if($stmt->execute()){

          }
        }
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
     <a class="logout" href="php/cart.php">Cart</a>
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
              foreach($res as $row2){ ?>


                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
                <div class='product_row'>
                  <div class='pictures'>
                    <img src="<?php echo $row2['url'];?>" style='max-width: 100%; max-height: 100%;'>
                <!-- echo "testbild"-->
                   </div>
                   <div class='description'>
                     <?php echo $row['description']; ?>
                   </div>
                   <div class='price'>
                   <div class='artname'>
                    <?php echo $row['name']; ?>
                   </div>
                <?php echo $row2['price']; ?>
                <br>
                <?php echo $row2['stock'];?>
                <br>
                <?php echo $row2['color'];?>
                </div>
                </div>
                  <input type="number" name="quantity" value="1">
                  <input type="hidden" name="prodid" value="<?php echo $row['id'];?>">
                  <input type="submit" value="Add to cart">
                </form>
              <?php
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
