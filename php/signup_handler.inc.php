<?php 
session_start();
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $username = $_POST['username'];
  $password = $_POST['password'];
  $email = $_POST['email'];
  $phone_number = $_POST['phone_number'];
  
  try {
    // get the database 
    require_once "get_db.inc.php";
    
    // check for duplicates
    $sql = "SELECT * FROM users WHERE username = :username OR email = :email or phone_number = :phone_number";
    $stmt = $pdo -> prepare($sql);
    $stmt -> execute(['username' => $username , 'email' => $email, 'phone_number' => $phone_number]);
    
    if ($stmt -> rowCount() <= 0) {

    $query = "INSERT INTO users (username, password, email, phone_number) VALUES (?, ?, ?, ?)";
    $stmt = $pdo -> prepare($query); 
    $stmt -> execute([$username, $password, $email, $phone_number]);
    
    $pdo = null;  
    $stmt = null; 
    
    header("Location: login.php");

    die();

    }
    
    else {
      $_SESSION['error'] = 'username, email or number already exists';
      header("Location: signup.php");
      die();
    }

  }
   
  catch (PDOException $e) {
    die("Error: " . $e -> getMessage());
  }


}

else {
  header("Location: signup.php");
}