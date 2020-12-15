<?php

  session_start();

  require_once "config.php";
  if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] == true){
    $sql = "SELECT fname, sname, phone, email, sex, birthdate FROM customer
    WHERE id = :id";

    if($stmt = $pdo->prepare($sql)){
      $stmt->bindParam(":id", $param_id, PDO::PARAM_STR);


    $param_id = $_SESSION["id"];
    if($stmt->execute()){
      $res = $stmt->fetch();

      $fname = $res['fname'];
      $sname = $res['sname'];
      $phone = $res['phone'];
      $email = $res['email'];
      $sex = $res['sex'];
      $birthdate = $res['birthdate'];

      /*
      foreach ($res as $row) {
        $fname =  $row['fname'];
        $sname =  $row['sname'];
        $phone =  $row['phone'];
        $email =  $row['email'];
        $sex =  $row['sex'];
        $birthdate =  $row['birthdate'];
      }
      */
    }
    unset($stmt);
  }
    $phone_err = $sex_err = "";
    //Print out order history
    $sqlOrders = "SELECT * FROM ORDERS where custid=:id";
    $stmtOrders = $pdo->prepare($sqlOrders);
    $stmtOrders->bindParam(':id', $param_id, PDO::PARAM_STR);
    $stmtOrders->execute();

    $sqlOrderInfo = "SELECT * FROM orderinfo where id = :orderid";
    $stmtOrderInfo = $pdo->prepare($sqlOrderInfo);

    $sqlProdinfo = "SELECT * FROM prodinfo where id = :prodid";
    $stmtProdinfo = $pdo->prepare($sqlProdinfo);

    $sqlProdcat = "SELECT * FROM prodcat where id = :prodcatID";
    $stmtProdcat = $pdo->prepare($sqlProdcat);
  }
  else{
    header("location: /../index.php");
}
 ?>

 <!DOCTYPE html>
 <html lang="en" dir="ltr">
   <head>
     <meta charset="utf-8">
     <title><?php echo $_SESSION['username'];?></title>
     <link rel="stylesheet" href="/css/style.css">
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
     <h2>Update profile information</h2>
     <form action="./updateProfile.php" method="post">
         <div>
             <label>First name</label>
             <input type="text" name="fname"  value="<?php echo $fname; ?>">
         </div>
         <div >
             <label>Last name</label>
             <input type="text" name="sname" value="<?php echo $sname; ?>">
         </div>
         <div>
             <label>Phone number</label>
             <input type="text" name="phone" value="<?php echo $phone; ?>">

         </div>
         <div class="form-group">
             <label>E-mail</label>
             <input type="email" name="email"  value="<?php echo $email; ?>">
         </div>
         <div class="form-group">
             <input type="submit" class="btn btn-primary" value="Submit">
             <input type="reset" class="btn btn-default" value="Reset">
         </div>
     </form>
         <div class="orderHistory">
           <h2>Order History</h2>
            <?php
              if($stmtOrders->rowCount()>0){
                $resOrders = $stmtOrders->fetchAll();
                foreach ($resOrders as $row) {
                  $stmtOrderInfo->bindParam(':orderid', $row['id'], PDO::PARAM_STR);
                  $stmtOrderInfo->execute();
                  $resOrderInfo = $stmtOrderInfo->fetchAll();
                  ?>
                    <div class="order">
                      <label>Order id: <?php echo $row['id'];?></label>
                      <label>Total cost: <?php echo $row['cost'];?></label>
                      <p>Items ordered</p>

                  <?php
                  foreach ($resOrderInfo as $row2){
                    /*$stmtProdinfo->bindParam(':prodid', $row2['prodid'], PDO::PARAM_STR);
                    $stmtProdinfo->execute();

                    $resProdinfo = $stmtProdinfo->fetch();*/

                    $stmtProdcat->bindParam(':prodcatID', $row2['prodid'],
                     PDO::PARAM_STR);
                    $stmtProdcat->execute();
                    $resProdcat = $stmtProdcat->fetch();

                    ?>
                    <div class="orderItem">
                      <p><b>Item name: <?php echo $resProdcat['name'];?></b>
                          <br>
                          Color: <?php echo $row2['oldcolor'];?>
                          <br>
                          <a href="productPage?id=<?php echo $row2['prodid'];?>">
                            Link</a></p>
                      <p>Item cost: <?php echo $row2['oldprice'];?>
                        <br>
                        Number of items orderd: <?php echo $row2['quantity']; ?>
                        <br>
                        Total cost for item:
                        <?php echo $row2['oldprice']*$row2['quantity'];?>
                      </p>
                    </div>
                    <?php
                  }
                  ?>
                  </div>
                  <?php
                }
              }else{
                ?>
                <p>Nothing ordered yet...</p>
                <?php
              }
             ?>
         </div>
      </div>
   </body>
 </html>
