<?php 

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $username = $_POST['username'];
  $password = $_POST['password'];
  $email = $_POST['email'];
  $phone_number = $_POST['phone_number'];
  
  try {
    // get the database 
    require_once "get_db.inc.php";
    $query = "UPDATE users SET username = ':username', password = ':password', email = ':email', phone_number = ':phone_number' WHERE id = ;"
    $stmt = $pdo -> prepare($query); 
    $stmt -> execute([$username, $password, $email, $phone_number]);
    
    $pdo = null;  
    $stmt = null; 
    
    header("Location: signup.php");

    die();
  }
   
  catch (PDOException $e) {
    die("Error: " . $e -> getMessage());
  }


}

else {
  header("Location: signup.php");
}