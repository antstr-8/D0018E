<!DOCTYPE html>
<html>
<head>
  <link rel="stylesheet" href="/css/style.css">
</head>
<body>
  <div class="content">
      <h1>BIG HTML</h1>

  <?php
  echo "Customers";
  echo "<table style='border: solid 1px black;'>";
  echo "<tr><th>Id</th><th>Name</th></tr>";

  class TableRows extends RecursiveIteratorIterator {
    function construct($it) {
      parent::construct($it, self::LEAVES_ONLY);
    }

    function current() {
      return "<td style='width:150px;border:1px solid black;'>" . parent::current(). "</td>";
    }

    function beginChildren() {
      echo "<tr>";
    }

    function endChildren() {
      echo "</tr>" . "\n";
    }
  }
  $servername = "127.0.0.1";
  $username = "root";
  $password = "";
  $dbname = "shop";

  try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $stmt = $conn->prepare("SELECT customer.id,customer.fname,customer.sname FROM Customer");
    $stmt->execute();

    $results = $stmt->setFetchMode(PDO::FETCH_ASSOC);
    foreach(new TableRows(new RecursiveArrayIterator($stmt->fetchAll())) as $k=>$v) {
      echo $v;
    }
  echo "</table>";
  } catch(PDOException $e) {
    echo "Error: " . $e->getMessage();
  }

  ?>

  <p>TROLL</p>
  <?php
  echo "troll2";
  ?>
</div>
</body>
</html>
