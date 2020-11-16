<?php
  session_start();


  if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
  }
 ?>

 <!DOCTYPE html>
 <html lang="en" dir="ltr">
   <head>
     <meta charset="utf-8">
     <link rel="stylesheet" href="/css/style.css">
     <title>Welcome!</title>
   </head>
   <body>
     <div class="content">
       <h1>Logged in!</h1>
       <p>Welcome <?php echo htmlspecialchars($_SESSION ["username"]) ?>!</p>
       <a href="logout.php">Sign out</a>
     </div>
   </body>
 </html>
