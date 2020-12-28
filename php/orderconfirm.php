<?php
  session_start();
  require_once "config.php";

  $sqlGetOrder = "SELECT id, cost FROM ORDERS WHERE custid = :id ORDER BY id DESC";

  $stmtGetOrder = $pdo->prepare($sqlGetOrder);

  $stmtGetOrder->bindParam(':id', $_SESSION['id'], PDO::PARAM_STR);
  $stmtGetOrder->execute();

  $resOrder = $stmtGetOrder->fetch();
  $id = $resOrder['id'];
  $cost = $resOrder['cost'];


  $sqlGetOrderRow = "SELECT * FROM ORDERINFO WHERE id = $id";
  $stmtGetOrderRow = $pdo->prepare($sqlGetOrderRow);
  $stmtGetOrderRow->execute();
  $resOrderRow = $stmtGetOrderRow->fetchAll();

  $sqlGetProd = "SELECT name, description FROM PRODCAT WHERE id = :id";
  $stmtGetProd = $pdo->prepare($sqlGetProd);
  $sqlGetProdInfo = "SELECT prodid, color, url FROM PRODINFO WHERE id = :id";
  $stmtGetProdInfo = $pdo->prepare($sqlGetProdInfo);

?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <link rel="stylesheet" href="../css/style.css">
    <meta charset="utf-8">
    <title></title>
  </head>
  <body>
    <!--HEADER STARTS HERE-->
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
        else{
          echo '<style type="text/css">
                  .adminInfo{
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

    <!--HEADER ENDS HERE-->
    <div class="content">
      <h1>Order confirmation</h1>
    <label>Order id: <?php echo $id;?></label>
    <label>Total cost: <?php echo $cost;?></label>
    <p>Items ordered</p>
<?php
    foreach($resOrderRow as $row){
      $stmtGetProdInfo->bindParam(':id', $row['prodid'], PDO::PARAM_STR);
      $stmtGetProdInfo->execute();
      $resProdInfo = $stmtGetProdInfo->fetch();
      $stmtGetProd->bindParam(':id', $resProdInfo['prodid'], PDO::PARAM_STR);
      $stmtGetProd->execute();
      $resProdcat = $stmtGetProd->fetch();
?>
      <div class="orderItem">
        <p><b>Item name: <?php echo $resProdcat['name'];?></b>
            <br>
            Color: <?php echo $row['oldcolor'];?>
            <br>
            <a href="productPage?id=<?php echo $row['prodid'];?>">
              Link</a></p>
        <p>Item cost: <?php echo $row['oldprice'];?>
          <br>
          Number of items orderd: <?php echo $row['quantity']; ?>
          <br>
          Total cost for item:
          <?php echo $row['oldprice']*$row['quantity'];?>
        </p>
      </div>
<?php
    }


?>

</div>

  </body>
</html>
