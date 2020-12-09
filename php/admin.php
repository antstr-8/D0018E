<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title></title>
  </head>
  <body>
    <div class="header">
      <div class="logBox">
    <?php
    if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
      echo "Welcome <a href='php/profile.php'>" . $_SESSION["username"] . "</a>";
      echo '<style type="text/css">
              .login {
                display:none;
              }
            </style>';
      if($_SESSION["admin"] | 1){
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
     <a class="login" href="php/login.php">Login</a>
     <a class="login" href="php/register.php">Sign up</a>
     <a class="logout" href="php/cart.php">Cart</a>
     <a class="logout" href="php/logout.php">Sign out</a>
     <a class="admin" href="php/admin.php">Admin</a>
   </div>
  </div>
  <div class="content">

  </div>
  </body>
</html>
