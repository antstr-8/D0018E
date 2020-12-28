<?php session_start();

require_once "config.php";
$tempQuantity = 0;
if(isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true){
    if($_SERVER["REQUEST_METHOD"] == "POST"){

      $prodid = $_POST['prodid'];
      $quantity = $_POST['quantity'];

      $sql2 = "SELECT quantity FROM cart WHERE custid = :custid AND prodid = :prodid";

      if($stmt2 = $pdo->prepare($sql2)){
        $stmt2->bindParam(":custid", $_SESSION['id'], PDO::PARAM_STR);
        $stmt2->bindParam(":prodid", $prodid, PDO::PARAM_STR);

        if($stmt2->execute()){
            if($stmt2->rowCount() >= 1){



              $res = $stmt2->fetch();
              $quantity = $res['quantity'] + $quantity;
              if($res['quantity'] > 0){
                $tempQuantity = 1;

              }
              $sql = "UPDATE cart SET quantity = :quantity
              WHERE prodid = :prodid and custid = :custid";
            }
            else{
              $sql = "INSERT INTO cart (custid, prodid, quantity)
              VALUES (:custid, :prodid, :quantity)";
            }
          }
        }
          if($stmt = $pdo->prepare($sql)){
            $stmt->bindParam(":custid", $_SESSION['id'], PDO::PARAM_STR);
            $stmt->bindParam(":prodid", $prodid , PDO::PARAM_STR);
            $stmt->bindParam(":quantity", $quantity , PDO::PARAM_STR);

            if($stmt->execute()){

            }

        }
    }
}
header("location: productPage.php?id=".$prodid);
?>
