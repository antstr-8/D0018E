<?php
  session_start();
  require_once "config.php";

  if($_SERVER["REQUEST_METHOD"] == "POST"){
    $sqlInfoDelete = "DELETE FROM PRODINFO WHERE id = :id";
    $sqlProdinfoGet = "SELECT * FROM PRODINFO WHERE prodid = :prodcatid";
    $sqlCartDelete = "DELETE FROM CART WHERE prodid = :id";

    $stmtInfoDelete = $pdo->prepare($sqlInfoDelete);
    $stmtProdinfoGet = $pdo->prepare($sqlProdinfoGet);
    $stmtCartDelete = $pdo->prepare($sqlCartDelete);

    $stmtInfoDelete->bindParam(":id", $_POST['prodid'], PDO::PARAM_STR);
    $stmtProdinfoGet->bindParam(":prodcatid", $_POST['prodCatid'], PDO::PARAM_STR);
    $stmtCartDelete->bindParam(":id", $_POST['prodid'], PDO::PARAM_STR);

    $stmtProdinfoGet->execute();
    if($stmtProdinfoGet->rowCount() == 1){
      $sqlProdcatDelete = "DELETE FROM PRODCAT WHERE id = :id";
      $stmtProdcatDelete = $pdo->prepare($sqlProdcatDelete);
      $stmtProdcatDelete->bindParam(":id", $_POST['prodCatid'], PDO::PARAM_STR);
      $stmtProdcatDelete->execute();
    }

    $stmtInfoDelete->execute();
    $stmtCartDelete->execute();
}
  header("location: ./../index.php");
?>
