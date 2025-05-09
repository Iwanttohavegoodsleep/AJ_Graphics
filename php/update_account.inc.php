<?php 

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	$name = $_POST['username'];
	$password = $_POST['password'];
	$email = $_POST['email'];
	$phone_number = $_POST['phone_number'];

	try {
		require_once "db.inc.php"; // links the file 
		$query = "UPDATE users SET username = ''";

		$stmt = $pdo -> prepare($query);

		$stmt -> execute([$name, $password, $phone_number, $email]);

		$pdo = null; 
		$stmt = null; 

		header('LOCATION: login.php');

		die();
	}

	catch (PDOException $e) {
		die("Query failed: " . $e -> getMessage());
	}

}

else {
	header('LOCATION: signup.php');
}