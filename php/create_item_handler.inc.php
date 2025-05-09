<?php
session_start();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  include_once "get_db.inc.php";
  $item_name = $_POST['item_name'];
  $price = $_POST['price'];  
  $stock = $_POST['stock'];  
  $category = $_POST['category'];  
  $description = $_POST['description'];  
  
  // file handling 
  $image_name = $_FILES['image']['name']; 
  $target_dir = 'uploads/';
  $target_file = $target_dir . $image_name; 


  if (move_uploaded_file($_FILES['image']['tmp_name'], $target_file)) {
    $query = "INSERT INTO item (name, description, price, stock, image, category) VALUES (?,?,?,?,?,?)";
    $stmt = $pdo -> prepare($query);  
    $stmt -> execute([$item_name, $description, $price, $stock, $image_name, $category]);
    $_SESSION['success'] = 'item created'; 
    header('Location: manage_items.php');
    die();
  }
  
  else {
    $_SESSION['error'] = 'Could not create item';
    header("Location: manage_items.php");
    die();
  }
   


}
else {
  header("Location: create_item.php");
}