<?php
  $servername = "localhost";
  $username = "beeway";
  $password = "qwerty";

  try {
    $conn = new PDO("mysql:host=$servername;dbname=beeway", $username, $password);
  } catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
    die();
  }
?>


<?php
  // $dbhost = 'localhost';
  // $dbport = '3306';
  // $dbname = 'beeway2023_Beeway';
  // $dbuser = 'beeway2023';
  // $dbpass = 'Duiven/2023!';
  //
  // $dsn = "mysql:host=$dbhost;port=$dbport;dbname=$dbname;charset=utf8mb4";
  //
  // try {
  //     $conn = new PDO($dsn, $dbuser, $dbpass);
  //     $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  //
  //     // Verbinding is succesvol. Je kunt nu queries uitvoeren.
  //     // Bijvoorbeeld: $result = $conn->query('SELECT * FROM table_name');
  // } catch (PDOException $e) {
  //     echo "Failed to connect to MySQL: " . $e->getMessage();
  // }
?>
