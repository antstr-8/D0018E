<?php
session_start();
require_once "config.php";
$total = 0;
$clear = true;
$id = $_SESSION['id'];

$sqlCart = "SELECT * FROM CART WHERE custid =:id";
$GetCart = $pdo->prepare($sqlCart);
$GetCart->bindParam(":id", $id, PDO::PARAM_STR);
$GetCart->execute();

$result = $GetCart->fetchAll();

foreach ($result as $row) {
  $sqlGetProd = "SELECT stock, price FROM PRODINFO WHERE id=:prodid";
  $GetSql = $pdo->prepare($sqlGetProd);
  $GetSql->bindParam(':prodid', $row['prodid'], PDO::PARAM_STR);
  $GetSql->execute();
  $output = $GetSql->fetch();
  $price = $output['price'];
  $total = $total + $price*$row['quantity']; // Gångra med antal produkter
  if(($output['stock'] - $row['quantity']) < 0){
    $clear = false;
    $total = 0;
    break;
  }



}
if($clear == true){
  try{
    $pdo->beginTransaction();
    $sqlOrder = "INSERT INTO ORDERS (custid, cost)
     VALUES (:id , :total)";
     //Skapa ny post i order tabellen
    $OrderCommit = $pdo->prepare($sqlOrder);
    $OrderCommit->bindParam(':id', $id, PDO::PARAM_STR);
    $OrderCommit->bindParam(':total', $total, PDO::PARAM_STR);
    $OrderCommit->execute();
    /*//Hämta order id
    $GetId = $pdo->prepare("SELECT @@identity AS 'id'");
    $GetId->execute();

    $orderid = $GetId->fetch();
    //Flytta producterna från cart tabell till orderinfo tabell
    //Variabler för att flytta
    $sqlInsert = "INSERT INTO ORDERINFO (id, prodid, quantity)
    VALUES (:orderid, :prodid, :quantity)";
    $insert = $pdo->prepare($sqlInsert);

    //Variabler för att ta bort
    $sqlDelete = "DELETE FROM cart WHERE custid=:id";
    $delete = $pdo->prepare($sqlDelete);
    $delete->bindParam(":id", $id, PDO::PARAM_STR);
    //Loop för att stoppa in i orderinfo
    foreach ($result as $row) {
      $insert->bindParam(":orderid", $orderid['id'], PDO::PARAM_STR);
      $insert->bindParam(":prodid", $row['prodid'], PDO::PARAM_STR);
      $insert->bindParam(":quantity", $row['quantity'], PDO::PARAM_STR);
      $insert->execute();

    }
    $delete->execute();*/

    $pdo->commit();
  }
  catch(Exception $e){
    $pdo->rollback();
  }
  /*
  //Remove from stock
  $sqlGetProd = "SELECT stock FROM PRODINFO WHERE id=:prodid";
  $GetSql = $pdo->prepare($sqlGetProd);



  foreach ($result as $row) {
    $GetSql->bindParam(':prodid', $row['prodid'], PDO::PARAM_STR);
    $GetSql->execute();
    $resultStock = $GetSql->fetch();
    $sqlStockUpdate = "UPDATE PRODINFO SET stock =:quantity
    WHERE id = :prodid";
    $sqlUpdate = $pdo->prepare($sqlStockUpdate);
    $updatedStock = ($resultStock['stock'] - $row['quantity']);
    $sqlUpdate->bindParam(":prodid", $row['prodid'], PDO::PARAM_STR);
    $sqlUpdate->bindParam(":quantity", $updatedStock, PDO::PARAM_STR);

    $sqlUpdate->execute();
  }
  */
  header("location: orderconfirm.php");
}
else{
  header("location: cart.php");
}
?>
