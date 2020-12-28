<?php

  session_start();

  if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
      header("location: index.php");
      exit;
  }

  require_once "config.php";

  $username = $password = "";
  $username_err = $password_err = "";


  if($_SERVER["REQUEST_METHOD"] == "POST"){
    if(empty(trim($_POST["username"]))){
      $username_err = "Please enter username.";
    }
    else{
      $username = trim($_POST["username"]);
    }

    if(empty(trim($_POST["password"]))){
       $password_err = "Please enter your password.";
    }
    else{
      $password = trim($_POST["password"]);
    }



  if(empty($username_err) && empty($password_err)){
    $sql = "SELECT id, uname, psword, admin FROM customer WHERE uname = :uname";

    if( $stmt = $pdo->prepare($sql)){
      $stmt->bindParam(":uname", $param_username, PDO::PARAM_STR);

      $param_username = trim($_POST["username"]);

      if($stmt->execute()){
        if($stmt->rowCount() == 1){
          if($row = $stmt->fetch()){
            $id = $row["id"];
            $username = $row["uname"];
            $hashed_password = $row["psword"];
            $admin = $row['admin'];
            if($password === $hashed_password){
              session_start();

              $_SESSION["loggedin"] = true;
              $_SESSION["id"] = $id;
              $_SESSION["username"] = $username;
              $_SESSION["admin"] = $admin;
              header("location: /../index.php");
            }
            else{
              $password_err = "The password you entered was not valid.";
            }
          }
        }
        else{
          $username_err = "No account found with that username.";
        }
      }
      else{
        echo "Oops! Something went wrong. Please try again later.";
      }
        unset($stmt);
    }
  }
  unset($pdo);
}
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <link rel="stylesheet" href="/css/style.css">
    <meta charset="utf-8">
    <title></title>
  </head>
  <body>
    <!--HEADER STARTS HERE-->
    <div class="header">
      <a href="/../index.php">Home</a>
      <div class="logBox">
      <?php
      if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
        echo "Welcome <a href='php/profile.php'>" . $_SESSION["username"] . "</a>";
        echo '<style type="text/css">
                .login {
                  display:none;
                }
              </style>';
        if($_SESSION["admin"] == 1){
          echo '<style type="text/css">
                  .admin {
                    display: inline;
                  }
                </style>';
        }
      }

      else{
        echo '<style type="text/css">
                .logout {
                  display:none;
                }
              </style>';
      }
      ?>
       <a class="login" href="login.php">Login</a>
       <a class="login" href="register.php">Sign up</a>
       <a class="logout" href="cart.php">Cart</a>
       <a class="logout" href="logout.php">Sign out</a>
       <a class="admin" href="admin.php">Admin</a>
     </div>
    </div>

    <!--HEADER ENDS HERE-->
    <div class="content">
      <h2>Login</h2>
      <p>Please fill in your credentials to login.</p>
      <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>"
        method="post">
        <div class="form-group <?php echo (!empty($username_err)) ? 'has-error'
         : ''; ?>">

          <label>Username</label>
          <input type="text" name="username" class="form-control" value="<?php
           echo $username; ?>">
           <span class="help-block"><?php echo $username_err; ?></span>
        </div>
        <div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
                <label>Password</label>
                <input type="password" name="password" class="form-control">
                <span class="help-block"><?php echo $password_err; ?></span>
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Login">
            </div>
            <p>Don't have an account? <a href="register.php">Sign up now</a>.</p>
      </form>
    </div>
  </body>
</html>
