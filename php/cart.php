<?php

  session_start();
  require_once "config.php";
  if($_SERVER["REQUEST_METHOD"] == "POST"){
    if(isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true){

      $id = $_SESSION['id'];
      $prodid = $_POST['prodid'];
      $quantity = $_POST['quantity'];

      $sqlUpdate = "SELECT * FROM cart WHERE custid = :custid AND prodid = :prodid";
      if($updateStmt = $pdo->prepare($sqlUpdate)){
        $updateStmt->bindParam(":prodid", $prodid, PDO::PARAM_STR);
        $updateStmt->bindParam(":custid", $id, PDO::PARAM_STR);

        if($updateStmt->execute()){
          if($updateStmt->rowCount() == 1){
            $res = $updateStmt->fetch();
            if($res['quantity'] >= $quantity){
              $updatedQuantity =  $res['quantity'] - $quantity;
              if($updatedQuantity == 0){
                $sqlUpdate2 = "DELETE FROM cart WHERE custid = :custid
                AND prodid = :prodid";
                if($updateStmt2 = $pdo->prepare($sqlUpdate2)){
                  $updateStmt2->bindParam(":custid", $id, PDO::PARAM_STR);
                  $updateStmt2->bindParam(":prodid", $prodid , PDO::PARAM_STR);
                }
              }
              elseif($updatedQuantity > 0){
                $sqlUpdate2 = "UPDATE cart SET quantity = :quantity
                WHERE prodid = :prodid AND custid = :custid";
                if($updateStmt2 = $pdo->prepare($sqlUpdate2)){
                  $updateStmt2->bindParam(":custid", $id, PDO::PARAM_STR);
                  $updateStmt2->bindParam(":prodid", $prodid , PDO::PARAM_STR);
                  $updateStmt2->bindParam(":quantity", $updatedQuantity , PDO::PARAM_STR);
                }
              }
              $updateStmt2->execute();
            }
          }
        }
      }
    }
      unset($updateStmt);
      unset($updateStmt2);
  }
 ?>


<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <link rel="stylesheet" href="/css/style.css">
    <meta charset="utf-8">
    <title></title>
  </head>
  <body>
    <div class="header">
      <a href="/../index.php">Home</a>
      <div class="logBox">
      <?php
      if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
        echo "Welcome <a href='profile.php'>" . $_SESSION["username"] . "</a>";
        echo '<style type="text/css">
                .login {
                  display:none;
                }
                .admin {
                  display: none;
                }
              </style>';
        if($_SESSION["admin"] == 1){
          echo '<style type="text/css">
                  .admin {
                    display: inline;
                  }
                  .normieInfo{
                    display:none;
                  }
                </style>';
        }
      }

      else{
        echo '<style type="text/css">
                .logout {
                  display:none;
                }
                .adminInfo{
                  display:none;
                }
                .admin {
                  display: none;
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
      <div class="products">
          <?php
          if(isset($_SESSION['loggedin'])&&$_SESSION['loggedin']==true){
            $sql = "SELECT custid,prodid,quantity FROM cart WHERE custid= :custid";
              $stmt = $pdo->prepare($sql);
              $stmt ->bindParam(":custid",$_SESSION['id'],PDO::PARAM_STR);
              $stmt->execute();
              $result = $stmt->fetchAll();
              foreach($result as $row){
                $stht = $pdo->prepare("SELECT id,color,stock,url,price FROM prodinfo WHERE id=$row[prodid]");
                $stht->execute();
                $res = $stht->fetchAll();
                foreach($res as $row2){
                  $newstmt = $pdo->prepare("SELECT name,description FROM prodcat WHERE id=$row2[id]");
                  $newstmt->execute();
                  $newres = $newstmt->fetchAll();
                  foreach($newres as $row3){ ?>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">


                    <div class='product_row'>
                      <div class='pictures'>
                        <img src="<?php echo $row2['url'];?>" style='max-width: 100%; max-height: 100%;'>
                    <!-- echo "testbild"-->
                       </div>
                       <div class='description'>
                         <?php echo $row3['description']; ?>
                       </div>
                       <div class='price'>
                       <div class='artname'>
                        <?php echo $row3['name']; ?>
                       </div>
                    <?php echo $row2['price']; ?>
                    <br>
                    <?php echo $row['quantity'];?>
                    <br>
                    <?php echo $row2['color'];?>
                    </div>
                    </div>
                      <input type="number" name="quantity" value="1" min="1" max="<?php echo $row['quantity'];?>">
                      <input type="hidden" name="prodid" value="<?php echo $row2['id'];?>">
                      <input type="submit" value="Remove from cart">
                    </form>

                    <?php
               }
              }
            }
            unset($stmt);
            unset($stht);
            unset($newstmt);
        }else{
          header("location: /../index.php");
        }
          ?>
          <a href="/../index.php">Home</a>
          <form action="checkout.php" method="post">
              <button type="submit" name="button">Checkout</button>
          </form>
    </div>
  </body>
</html>
