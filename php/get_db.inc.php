<?php
// gets the database

$dsn = "mysql:host=localhost;dbname=db";
$dbpass = "";
$dbuser = "root";

try {
  $pdo = new PDO($dsn, $dbuser, $dbpass);
  $pdo -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}

catch (PDOException $e) {
  echo "connection failed: " . $e -> getMessage();
}