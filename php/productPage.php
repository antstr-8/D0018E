
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
     <meta charset="utf-8">
     <title></title>
   </head>
   <body>
     <p>Productname: <?php echo $res2['name']?></p>
     <p>Description: <br> <?php echo $res2['description']?></p>
     <p>Price: <?php echo $res1['price']?></p>
     <p>In stock: <?php echo $res1['stock']?></p>
     <p>Color: <?php echo $res1['color']?></p>
     <img src="<?php echo $res1['url']?>">
     <form class="" action="comment.php" method="post" id ="commentForm">

       Raiting: <input type="number" name="rating" value="5">
       <input type="hidden" name="prodid" value="<?php echo $prodid;?>">
       <br>
     </form>
      <textarea name="comment" rows="4" cols="50" form="commentForm"
      axlength="250">Enter comment here..</textarea>
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
         <div class="commentDiscription">
           Comment: <br>
           <?php echo $row['comment'];?>
         </div>
       </div>

       <?php
     }
      ?>
   </body>
 </html>
