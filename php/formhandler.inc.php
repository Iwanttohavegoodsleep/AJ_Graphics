<?php
	session_start(); 

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['username'];
    $password = $_POST['password'];
    $email = $_POST['email'];
    $phone_number = $_POST['phone_number'];

    try {
        require_once "db.inc.php"; // Links the database connection file

        // First, check if the phone number or email already exists in the database
        $checkQuery = "SELECT * FROM users WHERE phone_number = ? OR email = ?";
        $stmt = $pdo->prepare($checkQuery);
        $stmt->execute([$phone_number, $email]);

        // If a record with the same phone number or email exists, show an error
        if ($stmt->rowCount() > 0) {
            $_SERVER['error'] = 'The phone or email has been already used, please use another'; 
            header('LOCATION: signup.php');
            die();
        }

        // If phone number and email are unique, proceed with the insert
        $query = "INSERT INTO users (
            name, 
            password, 
            phone_number, 
            email        
        ) VALUES (
            ?, ?, ?, ?
        );";

        $stmt = $pdo->prepare($query);
        $stmt->execute([$name, $password, $phone_number, $email]);

        // Close the database connection
        $pdo = null; 
        $stmt = null; 

        // Redirect to the login page after successful registration
        header('LOCATION: login.php');
        die();

    } catch (PDOException $e) {
        die("Query failed: " . $e->getMessage());
    }

} else {
    header('LOCATION: signup.php');
}
