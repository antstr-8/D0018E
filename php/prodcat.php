<?php

  session_start();
  require_once "config.php";

 ?>

 <!DOCTYPE html>
 <html lang="en" dir="ltr">
   <head>
     <meta charset="utf-8">
     <link rel="stylesheet" href="/../css/style.css">
     <title>Product catalog!</title>
   </head>
   <body>
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
   </body>
 </html>
