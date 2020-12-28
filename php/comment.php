<?php
  session_start();
  require_once "config.php";

  echo $_SESSION['id'];
  echo $_POST['prodid'];
  echo $_POST['comment'];


  if(isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true){
    if(strlen($_POST['comment']) < 250){
      $sqlComment = "INSERT INTO commentrating (custid, prodid, comment, rating)
       VALUES (:custid, :prodid, :comment, :rating);";
       $stmtComment = $pdo->prepare($sqlComment);


       $stmtComment->bindParam(':custid', $_SESSION['id'], PDO::PARAM_STR);
       $stmtComment->bindParam(':prodid', $_POST['prodid'], PDO::PARAM_STR);
       $stmtComment->bindParam(':comment', $_POST['comment'], PDO::PARAM_STR);
       $stmtComment->bindParam(':rating', $_POST['rating'], PDO::PARAM_STR);

       $stmtComment->execute();

       echo "Done";

    }
  }
    header("location: productPage.php?id=" . $_POST['prodid']);

?>
