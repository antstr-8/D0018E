<!DOCTYPE html>
<html>
<body>
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
$username = "";
$password = "";
$dbname = "";

try {
  $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  $stmt = $conn->prepare("SELECT id,CustomerName FROM Customers");
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
</body>
</html>
