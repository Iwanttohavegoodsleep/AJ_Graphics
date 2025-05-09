<?php
session_start();
if ($_SESSION['username'] !== 'admin') {
    header('Location: home.php');
    exit;
}

include_once "get_db.inc.php";

$order_id = $_GET['id'] ?? 0;

// Get order details
$query = "SELECT o.*, u.username, u.email, u.phone_number 
          FROM orders o 
          JOIN users u ON o.user_id = u.id 
          WHERE o.id = ?";
$stmt = $pdo->prepare($query);
$stmt->execute([$order_id]);
$order = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$order) {
    echo '<div class="alert alert-danger">Order not found</div>';
    exit;
}

// Get order items
$query = "SELECT oi.*, i.name, i.image 
          FROM order_items oi 
          JOIN items i ON oi.item_id = i.id 
          WHERE oi.order_id = ?";
$stmt = $pdo->prepare($query);
$stmt->execute([$order_id]);
$items = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="order-details">
    <div class="mb-4">
        <h4>Order Information</h4>
        <p><strong>Order ID:</strong> #<?= htmlspecialchars($order['id']) ?></p>
        <p><strong>Date:</strong> <?= htmlspecialchars($order['order_date']) ?></p>
        <p><strong>Status:</strong> 
            <span class="status-badge status-<?= strtolower($order['status']) ?>">
                <?= ucfirst(htmlspecialchars($order['status'])) ?>
            </span>
        </p>
        <p><strong>Total Amount:</strong> ₱<?= number_format($order['total_amount'], 2) ?></p>
    </div>

    <div class="mb-4">
        <h4>Customer Information</h4>
        <p><strong>Name:</strong> <?= htmlspecialchars($order['username']) ?></p>
        <p><strong>Email:</strong> <?= htmlspecialchars($order['email']) ?></p>
        <p><strong>Phone:</strong> <?= htmlspecialchars($order['phone_number']) ?></p>
    </div>

    <div>
        <h4>Order Items</h4>
        <div class="table-responsive">
            <table class="table table-sm">
                <thead>
                    <tr>
                        <th>Item</th>
                        <th>Quantity</th>
                        <th>Price</th>
                        <th>Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($items as $item): ?>
                    <tr>
                        <td>
                            <div class="d-flex align-items-center">
                                <img src="uploads/<?= htmlspecialchars($item['image']) ?>" 
                                     alt="<?= htmlspecialchars($item['name']) ?>" 
                                     class="img-thumbnail me-2" style="width: 50px;">
                                <?= htmlspecialchars($item['name']) ?>
                            </div>
                        </td>
                        <td><?= htmlspecialchars($item['quantity']) ?></td>
                        <td>₱<?= number_format($item['price'], 2) ?></td>
                        <td>₱<?= number_format($item['quantity'] * $item['price'], 2) ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="3" class="text-end"><strong>Total:</strong></td>
                        <td><strong>₱<?= number_format($order['total_amount'], 2) ?></strong></td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div> 