<?php
  require_once "config.php";
  session_start();

  if($_SERVER["REQUEST_METHOD"] == "POST"){
     $sqlUpdateProductInfo = "UPDATE prodinfo SET color = :color,
     stock = :stock, price = :price, url =:url WHERE id = :id";

     $sqlUpdateProductCat = "UPDATE prodcat SET name = :name,
      description = :description WHERE id = :prodcatid";

     $filepath = "./../Pictures/" . $_FILES["file"]["name"];
     $extension = pathinfo($_FILES["file"]["name"], PATHINFO_EXTENSION);

     $stmtUpdateProdinfo = $pdo->prepare($sqlUpdateProductInfo);

     $stmtUpdadeProdcat = $pdo->prepare($sqlUpdateProductCat);

     $productName = trim($_POST["productName"]);
     $productDescription = trim($_POST["productDescription"]);
     $productPrice = trim($_POST["productPrice"]);
     $productStock = trim($_POST["productStock"]);
     $productColor = trim($_POST["productColor"]);
     $prodid = trim($_POST["prodid"]);
     $prodCatid = trim($_POST["prodCatid"]);

     if($productPrice >= 0 && $productStock >= 0){

       move_uploaded_file($_FILES["file"]["tmp_name"], $filepath);

       $stmtUpdateProdinfo->bindParam(":color", $productColor, PDO::PARAM_STR);
       $stmtUpdateProdinfo->bindParam(":stock", $productStock, PDO::PARAM_STR);
       $stmtUpdateProdinfo->bindParam(":price", $productPrice, PDO::PARAM_STR);
       $stmtUpdateProdinfo->bindParam(":url", $filepath, PDO::PARAM_STR);
       $stmtUpdateProdinfo->bindParam(":id", $prodid, PDO::PARAM_STR);


       $stmtUpdadeProdcat->bindParam(":name", $productName, PDO::PARAM_STR);
       $stmtUpdadeProdcat->bindParam(":description", $productDescription, PDO::PARAM_STR);
       $stmtUpdadeProdcat->bindParam(":prodcatid", $prodCatid, PDO::PARAM_STR);

       $stmtUpdateProdinfo->execute();
       $stmtUpdadeProdcat->execute();
     }
    }
    header("location: productPage.php?id=".$prodid);
?>
