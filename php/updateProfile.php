<?php
require_once "config.php";
session_start();
if($_SERVER["REQUEST_METHOD"] == "POST"){
  if(isset($_POST["phone"]) == NULL){
    $phone = "0";
    $phone_err = "Satt";
  }
  /*
  if($_SERVER["sex"] < 6){
    $sex_err = "To long string.";
  }*/


    $id = $_SESSION["id"];
      $sql = "UPDATE customer SET fname = :fname, sname = :sname,
        email = :email, phone=:phone WHERE id = $id";


      if($stmt = $pdo->prepare($sql)){
        $stmt->bindParam(":fname", $param_fname, PDO::PARAM_STR);
        $stmt->bindParam(":sname", $param_sname, PDO::PARAM_STR);
        /*$stmt->bindParam(":phone", $param_phone, PDO::PARAM_STR);*/
        $stmt->bindParam(":email", $param_email, PDO::PARAM_STR);
        $stmt->bindParam(":phone", $param_phone, PDO::PARAM_STR);

        $param_fname = trim($_POST["fname"]);
        $param_sname = trim($_POST["sname"]);
        /*$param_phone = trim($_POST["phone"]);*/
        $param_email = trim($_POST["email"]);
        $param_phone = trim($_POST["phone"]);

        if($stmt->execute()){
          header("location: ./profile.php");
        }
        else{
          echo "Something went wrong.";
        }

      }

}

?>
