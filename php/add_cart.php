<?php
  session_start();
  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_SESSION['logged_in'])) { 
     $item_id = $_POST['item_id'] ?? null;
     $qty = $_POST['quantity'] ?? 1;
     $url = $_POST['redirect_url'] ?? '/home.php';
    
     // get the data
     include_once "get_db.inc.php"; 
     $query = 'SELECT * FROM item WHERE id = ?';
     $stmt = $pdo -> prepare($query);
     $stmt -> execute([$item_id]);
      $row = $stmt -> fetch(PDO::FETCH_ASSOC);
    
      $item_name = $row['name'];
      $price = $row['price'];

      $_SESSION['cart_items']['count'] += 1; 
      $_SESSION['cart_items']['items'][] = ['item_id' => $item_id, 'qty' => $qty, 'item_name' => $item_name, 'price' => $price];
      $_SESSION['success'] = 'Item added successfuly';

      header('Location: cart.php');
      die();
    }
    else {
      $_SESSION['error'] = 'You need to be logged in to order';
      header('Location: login.php');
      die();
    }

  }
  
  else {
    header('Location: home.php');
    die();
  }
