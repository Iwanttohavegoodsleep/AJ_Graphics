<?php
session_start();
if ($_SESSION['username'] !== 'admin') {
    header('Location: home.php');
    exit;
}

include_once "get_db.inc.php";

$user_id = $_GET['id'] ?? 0;

$query = "SELECT * FROM users WHERE id = ? AND username != 'admin'";
$stmt = $pdo->prepare($query);
$stmt->execute([$user_id]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user) {
    echo '<div class="alert alert-danger">User not found</div>';
    exit;
}

// Get user's order history
$query = "SELECT * FROM orders WHERE user_id = ? ORDER BY order_date DESC";
$stmt = $pdo->prepare($query);
$stmt->execute([$user_id]);
$orders = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="user-details">
    <div class="mb-4">
        <h4>User Information</h4>
        <p><strong>Username:</strong> <?= htmlspecialchars($user['username']) ?></p>
        <p><strong>Email:</strong> <?= htmlspecialchars($user['email']) ?></p>
        <p><strong>Phone:</strong> <?= htmlspecialchars($user['phone_number']) ?></p>
        <p><strong>Status:</strong> 
            <span class="status-badge status-<?= $user['is_active'] ? 'active' : 'inactive' ?>">
                <?= $user['is_active'] ? 'Active' : 'Inactive' ?>
            </span>
        </p>
    </div>

    <div>
        <h4>Order History</h4>
        <?php if (count($orders) > 0): ?>
            <div class="table-responsive">
                <table class="table table-sm">
                    <thead>
                        <tr>
                            <th>Order ID</th>
                            <th>Date</th>
                            <th>Amount</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($orders as $order): ?>
                        <tr>
                            <td>#<?= htmlspecialchars($order['id']) ?></td>
                            <td><?= htmlspecialchars($order['order_date']) ?></td>
                            <td>₱<?= number_format($order['total_amount'], 2) ?></td>
                            <td>
                                <span class="status-badge status-<?= strtolower($order['status']) ?>">
                                    <?= htmlspecialchars($order['status']) ?>
                                </span>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <p class="text-muted">No orders found for this user.</p>
        <?php endif; ?>
    </div>
</div> 