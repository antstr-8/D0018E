<?php

require_once "config.php";

$username = $password = $confirm_password = "";
$username_err = $password_err = $confirm_password_err = "";

if($_SERVER["REQUEST_METHOD"] == "POST"){

  if(empty(trim($_POST["username"]))){
    $username_err = "Please enter a username.";
  }
  else{
    $sql = "SELECT id FROM customer WHERE uname = :username";

    if($stmt = $pdo->prepare($sql)){

      $stmt->bindParam(":username", $param_username, PDO::PARAM_STR);

      $param_username = trim($_POST["username"]);

      if($stmt->execute()){
        if($stmt->rowCount() == 1){
          $username_err = "This username is already taken.";
        }
        else{
          $username = trim($_POST["username"]);
        }
      }
      else{
        echo "Oops! Something went wrong!";
      }
      unset($stmt);
    }
  }

  if(empty(trim($_POST["password"]))){
    $password_err = "Please enter a password.";
  }
  elseif(strlen(trim($_POST["password"]))< 6){
    $password_err = "Password has to be atleast 6 char.";
  }
  else{
    $password = trim($_POST["password"]);
  }

  if(empty(trim($_POST["confirm_password"]))){
    $confirm_password_err = "Please confirm password.";
  }
  else{
    $confirm_password = trim($_POST["confirm_password"]);
    if(empty($password_err) && ($password != $confirm_password)){
      $confirm_password_err = "Password did not match.";
    }
  }

  if(empty($username_err) && empty($password_err) &&
  empty($confirm_password_err)){
    $sql = "INSERT INTO customer (uname, psword) VALUES(:username, :password)";

    if($stmt = $pdo->prepare($sql)){
      $stmt->bindParam(":username", $param_username, PDO::PARAM_STR);
      $stmt->bindParam(":password", $param_password, PDO::PARAM_STR);

      $param_username = $username;
      $param_password = $password;

      if($stmt->execute()){
        header("location: login.php");
      }
      else{
        echo "Something went wrong.";
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
    <meta charset="utf-8">
    <title>Sign up</title>
    <link rel="stylesheet" href="/css/style.css">
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
      <h2>Sign Up</h2>
      <p>Please fill this form to create an account.</p>
      <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
          <div class="form-group <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
              <label>Username</label>
              <input type="text" name="username" class="form-control" value="<?php echo $username; ?>">
              <span class="help-block"><?php echo $username_err; ?></span>
          </div>
          <div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
              <label>Password</label>
              <input type="password" name="password" class="form-control" value="<?php echo $password; ?>">
              <span class="help-block"><?php echo $password_err; ?></span>
          </div>
          <div class="form-group <?php echo (!empty($confirm_password_err)) ? 'has-error' : ''; ?>">
              <label>Confirm Password</label>
              <input type="password" name="confirm_password" class="form-control" value="<?php echo $confirm_password; ?>">
              <span class="help-block"><?php echo $confirm_password_err; ?></span>
          </div>
          <div class="form-group">
              <input type="submit" class="btn btn-primary" value="Submit">
              <input type="reset" class="btn btn-default" value="Reset">
          </div>
          <p>Already have an account? <a href="login.php">Login here</a>.</p>
      </form>
    </div>
  </body>
</html>
