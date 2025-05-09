<?php 	
// data 
$dsn = 'mysql:host=localhost; dbname=db';
$dbname = 'root';
$dbpassword = '';

try {
	$pdo = new PDO($dsn, $dbname, $dbpassword); // params (dsn, username, password)
	$pdo -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} 

catch (PDOException $e) {
	echo "Connection failed: " . $e -> getMessage();
}


