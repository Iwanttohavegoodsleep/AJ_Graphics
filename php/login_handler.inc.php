<?php
session_start();
if ($_SERVER["REQUEST_METHOD"] === 'POST') {
  include_once "get_db.inc.php";
  $username = $_POST['username'];
  $password = $_POST['password'];
  
  $sql = "SELECT * FROM users WHERE username = :username";
  $stmt = $pdo -> prepare($sql);
  $stmt -> execute(['username' => $username]);
  $row = $stmt -> fetch(PDO::FETCH_ASSOC);
  
  if ($row) {

    if ($password === $row['password']) {
      $_SESSION['user_id'] = $row['id'];
      $_SESSION['username'] = $row['username'];
      $_SESSION['email'] = $row['email'];
      $_SESSION['phone_number'] = $row['phone_number'];
      if ($username === 'admin') {
       $_SESSION['role'] = 'admin';  
      }
      else {
       $_SESSION['role'] = 'user';  
      }
      $_SESSION['logged_in'] = 'logged_in';
      $_SESSION['cart_items'] = [
        'items' => [], 
        'count' => 0,
      ];

      header("Location: home.php");
      die();
    }
    
    else {
      $_SESSION['error'] = 'wrong password';
      header("Location: login.php");
      die();
    }

  }
  
  else {
    $_SESSION['error'] = 'user not found';
    header("Location: login.php");
    die();
  }
  
  $pdo = null; 
}
else {
  header("Location: login.php");
}