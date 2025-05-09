<?php
session_start();
if ($_SESSION['username'] !== 'admin') {
    header('Location: home.php');
    exit;
}

include_once "get_db.inc.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $order_id = intval($_POST['order_id']);
        $status = trim($_POST['status']);
        
        // Validate status
        $allowedStatuses = ['pending', 'processing', 'completed', 'cancelled'];
        if (!in_array($status, $allowedStatuses)) {
            throw new Exception('Invalid status');
        }
        
        // Update order status
        $query = "UPDATE orders SET status = ? WHERE id = ?";
        $stmt = $pdo->prepare($query);
        $stmt->execute([$status, $order_id]);
        
        if ($stmt->rowCount() > 0) {
            header('Location: manage_orders.php?success=1');
        } else {
            throw new Exception('Order not found or no changes made');
        }
        
    } catch (Exception $e) {
        header('Location: manage_orders.php?error=' . urlencode($e->getMessage()));
    }
} else {
    header('Location: manage_orders.php');
}
exit; 