<?php

  session_start();

  require_once "config.php";
  if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] == true){
    $sql = "SELECT fname, sname, phone, email, sex, birthdate FROM customer
    WHERE id = :id";

    if($stmt = $pdo->prepare($sql)){
      $stmt->bindParam(":id", $param_id, PDO::PARAM_STR);


    $param_id = $_SESSION["id"];
    if($stmt->execute()){
      $res = $stmt->fetch();

      $fname = $res['fname'];
      $sname = $res['sname'];
      $phone = $res['phone'];
      $email = $res['email'];
      $sex = $res['sex'];
      $birthdate = $res['birthdate'];

      /*
      foreach ($res as $row) {
        $fname =  $row['fname'];
        $sname =  $row['sname'];
        $phone =  $row['phone'];
        $email =  $row['email'];
        $sex =  $row['sex'];
        $birthdate =  $row['birthdate'];
      }
      */
    }
    unset($stmt);
  }
    $phone_err = $sex_err = "";

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
            email = :email WHERE id = $id";


          if($stmt = $pdo->prepare($sql)){
            $stmt->bindParam(":fname", $param_fname, PDO::PARAM_STR);
            $stmt->bindParam(":sname", $param_sname, PDO::PARAM_STR);
            /*$stmt->bindParam(":phone", $param_phone, PDO::PARAM_STR);*/
            $stmt->bindParam(":email", $param_email, PDO::PARAM_STR);

            $param_fname = trim($_POST["fname"]);
            $param_sname = trim($_POST["sname"]);
            /*$param_phone = trim($_POST["phone"]);*/
            $param_email = trim($_POST["email"]);

            if($stmt->execute()){
              header("Refresh:0");
            }
            else{
              echo "Something went wrong.";
            }

          }

    }
  }
  else{
    header("location: /../index.php");
}
 ?>

 <!DOCTYPE html>
 <html lang="en" dir="ltr">
   <head>
     <meta charset="utf-8">
     <title></title>
   </head>
   <body>
     <h2>Update profile information</h2>
     <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
         <div class="form-group">
             <label>First name</label>
             <input type="text" name="fname" class="form-control" value="<?php echo $fname; ?>">
             <span class="help-block"></span>
         </div>
         <div class="form-group">
             <label>Last name</label>
             <input type="text" name="sname" class="form-control" value="<?php echo $sname; ?>">
             <span class="help-block"></span>
         </div>
         <div class="form-group">
             <label>Phone number</label>
             <input type="number" name="phone" class="form-control" value="<?php echo $phone_err; ?>">
             <span class="help-block"><?php echo $phone_err; ?></span>
         </div>
         <div class="form-group">
             <label>E-mail</label>
             <input type="email" name="email" class="form-control" value="<?php echo $email; ?>">
             <span class="help-block"></span>
         </div>
         <div class="form-group">
             <input type="submit" class="btn btn-primary" value="Submit">
             <input type="reset" class="btn btn-default" value="Reset">
         </div>
     </form>
     <a href="/../index.php">Home</a>
   </body>
 </html>
