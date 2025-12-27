<?php
$servername = "127.0.0.1";
$username = "root";
$password = "";
// remplace juste le nom de la database que tu as 
$dbName = "Host";

try {
  $conn = new PDO("mysql:host=$servername;dbname=Host", $username, $password);
  // set the PDO error mode to exception
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
//   echo "Connected successfully";
} catch(PDOException $e) {
  echo "Connection failed: " . $e->getMessage();
}

// var_dump($conn);
// ping sql208.infinityfree.com