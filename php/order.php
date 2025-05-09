<?php 
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    include 'get_db.inc.php';
    
    $user_id = $_SESSION['user_id'];

    // Insert a new order
    $query = 'INSERT INTO orders (user_id, status) VALUES (?, ?)';
    $stmt = $pdo->prepare($query); 
    $stmt->execute([$user_id, 'pending']);

    // Get the ID of the newly created order
    $order_id = $pdo->lastInsertId(); // Better and safer than re-querying

    $total = 0; 
    
    foreach ($_SESSION['cart_items']['items'] as $item) {
        $item_id = $item['item_id'];
        $qty = $item['qty'];
        $price = $item['price'];
        $total_price = $qty * $price;

        $query = 'INSERT INTO order_items (order_id, item_id, quantity, price, total_price) VALUES (?, ?, ?, ?, ?)';
        $stmt = $pdo->prepare($query); 
        $stmt->execute([$order_id, $item_id, $qty, $price, $total_price]);

        $total += $total_price;
    }

    $query = 'UPDATE orders SET total_amount = ? WHERE id = ?';
    $stmt = $pdo -> prepare($query);
    $stmt -> execute([$total, $order_id]);
    
    $_SESSION['success'] = 'Order placed successfully';
    unset($_SESSION['cart_items']);
    header('Location: cart.php');
    die();
} else {
    header('Location: home.php');
    die();
}
