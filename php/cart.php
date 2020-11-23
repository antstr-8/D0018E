<?php

  session_start();
  require_once "config.php";

 ?>


<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <link rel="stylesheet" href="/css/style.css">
    <meta charset="utf-8">
    <title></title>
  </head>
  <body>
    <div class="content">
      <div class="products">
          <?php
          if(isset($_SESSION['loggedin'])&&$_SESSION['loggedin']==true){
            $sql = ("SELECT custid,prodid,quantity FROM cart WHERE custid= :custid");
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
                  foreach($newres as $row3){
                    echo "<div class='product_row'>";
                    echo "<div class='pictures'>";
                    echo "<img src=" . $row2['url'] . " style='max-width: 100%;max-height: 100%;'>";
                    /*echo "testbild";*/
                    echo "</div>";
                    echo "<div class='description'>";
                    echo $row3['description'];
                    echo "</div>";
                    echo "<div class='price'>";
                     echo "<div class='artname'>";
                       echo $row3['name'];
                     echo "</div>";
                    echo $row2['price'];
                    echo "<br>";
                    echo $row['quantity'];
                    echo "<br>";
                    echo $row2['color'];
                    echo "</div>";
                    echo "</div>";
               }
              }
            }
        }else{
          header("location: /../index.php");
        }
          ?>
    </div>
  </body>
</html>
