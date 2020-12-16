
<?php
  session_start();
  require_once "config.php";

  if(isset($_GET['id'])){
    $prodid= "";
    $prodid = $_GET['id'];


    $sql1 = "SELECT * FROM prodinfo where id = :prodid";
    $stmt1 = $pdo->prepare($sql1);
    $stmt1->bindParam(':prodid', $prodid, PDO::PARAM_STR);
    $stmt1->execute();
    $res1 = $stmt1->fetch();


    $sql2 = "SELECT * FROM prodcat where id=:prodid";
    $stmt2 = $pdo->prepare($sql2);
    $stmt2->bindParam(':prodid', $res1['prodid'], PDO::PARAM_STR);
    $stmt2->execute();
    $res2 = $stmt2->fetch();

    $sqlComment = "SELECT * FROM COMMENTRATING WHERE prodid=:prodid";

    $stmtComment = $pdo->prepare($sqlComment);
    $stmtComment->bindParam(':prodid', $prodid, PDO::PARAM_STR);
    $stmtComment->execute();

    $commentResult = $stmtComment->fetchAll();

    $sqlCommentName = "SELECT uname FROM CUSTOMER where id = :id";
    $stmtCommentName = $pdo->prepare($sqlCommentName);



  }else{
    header("location: /../index.php");
  }

 ?>

 <!DOCTYPE html>
 <html lang="en" dir="ltr">
   <head>
       <link rel="stylesheet" href="/css/style.css">
     <meta charset="utf-8">
     <title>Product waow</title>
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


     <div class="normieInfo">
       <p>Productname: <?php echo $res2['name']?></p>
       <p>Description: <br> <?php echo $res2['description']?></p>
       <p>Price: <?php echo $res1['price']?></p>
       <p>In stock: <?php echo $res1['stock']?></p>
       <p>Color: <?php echo $res1['color']?></p>
       <form action="updateCart.php" method="post">
         <input type="number" name="quantity" value="1" min="1" max="<?php echo $res1['stock']?>">
         <input type="hidden" name="prodid" value="<?php echo $prodid;?>">
         <input type="submit" value="Add to cart">
       </form>
       <img src="<?php echo $res1['url']?>">
     </div>

     <form class="adminInfo" action="updateproduct.php" enctype="multipart/form-data" method="post">
       <label>Productname:</label>
       <input type="text" name="productName" value="<?php echo $res2['name']?>">
       <br>
       <label>Description:</label>
       <input type="text" name="productDescription" value="<?php echo $res2['description']?>">
       <br>
       <label>Price:</label>
       <input type="number" name="productPrice" value="<?php echo $res1['price']?>">
       <br>
       <label>Stock:</label>
       <input type="number" name="productStock" value="<?php echo $res1['stock']?>">
       <br>
       <label>Color:</label>
       <input type="text" name="productColor" value="<?php echo $res1['color']?>">
       <br>
       <label>New picture:</label>
       <input type="file" name="file">
       <br>
       <input type="submit" value="Update product">
       <br>
       <img src="<?php echo $res1['url']?>" style="max-width:50%; max-height:50%;">
       <input type="hidden" name="orgPic" value="<?php echo $res1['url']?>">
       <input type="hidden" name="prodid" value="<?php echo $prodid ?>">
       <input type="hidden" name="prodCatid" value="<?php echo $res1['prodid'] ?>">
     </form>

     <form class="adminInfo" action="deleteproduct.php" method="post">
       <input type="submit" value="Delete product">
       <input type="hidden" name="prodid" value="<?php echo $prodid ?>">
       <input type="hidden" name="prodCatid" value="<?php echo $res1['prodid'] ?>">
     </form>

     <br>
     <form  action="comment.php" method="post" id ="commentForm">
       Rating: <input type="number" name="rating" value="5" min="1" max="10">
       <input type="hidden" name="prodid" value="<?php echo $prodid;?>">
       <br>
     </form>
     <br>
      <textarea name="comment" rows="4" cols="50" form="commentForm"
      axlength="250" placeholder="Enter comment"></textarea>
      <input type="submit" form="commentForm">
     <?php

     foreach ($commentResult as $row ) {
       $stmtCommentName->bindParam(':id', $row['custid'], PDO::PARAM_STR);
       $stmtCommentName->execute();
       $uname = $stmtCommentName->fetch()['uname'];
       ?>
       <div class="commentRow">
         <div class="commentName">
           Username:<?php echo $uname;?>
         </div>
         <div class="commentRating">
           Rating:
           <?php echo $row['rating'];?>
         </div>
         <div class="commentDiscription">
           Comment: <br>
           <?php echo $row['comment'];?>
         </div>
         <br>
       </div>

       <?php
     }
      ?>
      </div>
   </body>
 </html>
