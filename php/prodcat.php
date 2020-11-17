<?php

  session_start();
  require_once "config.php";

 ?>

 <!DOCTYPE html>
 <html lang="en" dir="ltr">
   <head>
     <meta charset="utf-8">
     <link rel="stylesheet" href="/css/style.css">
     <title>Product catalog!</title>
   </head>
   <body>
     <div id="products">
       <div class="product row">
         <?php
           $stmt = $pdo->prepare("SELECT name FROM prodcat");
           $stmt->execute();
           $result = $stmt->fetchAll();
           foreach($result as $row){
             echo $row['name'];
           }
         ?>
       </div>
     </div>
   </body>
 </html>
