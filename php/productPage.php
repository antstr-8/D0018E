<?php
  if(isset($_GET['id'])){
    echo $_GET['id'];
  }else{
    header("location: /../index.php");
  }

 ?>
