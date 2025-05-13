<?php
session_start();
if ($_SESSION['username'] !== 'admin') {
    header('Location: home.php');
    exit;
}

include_once "get_db.inc.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Orders - AJ Graphics</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="styles.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/eedbcd0c96.js" crossorigin="anonymous"></script>
    <style>
        .orders-container {
            max-width: 1200px;
            margin: 2rem auto;
            padding: 2rem;
            background: white;
            border-radius: 15px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }
        .order-items {
            margin-top: 1rem;
            padding: 1rem;
            background: #f8f9fa;
            border-radius: 8px;
        }
        .order-item {
            display: flex;
            align-items: center;
            padding: 0.5rem;
            border-bottom: 1px solid #dee2e6;
        }
        .order-item:last-child {
            border-bottom: none;
        }
        .order-item img {
            width: 50px;
            height: 50px;
            object-fit: cover;
            border-radius: 4px;
            margin-right: 1rem;
        }
        .status-form select {
            padding: 0.5rem;
            border-radius: 4px;
            border: 1px solid #dee2e6;
        }
    </style>
</head>
<body>
    <?php include_once "navbar.php"?>

    <div class="orders-container">
        <h1 class="mb-4">Manage Orders</h1>

        <?php if (isset($_SESSION['success'])): ?>
            <div class="alert alert-success">
                <?= $_SESSION['success'] ?>
                <?php unset($_SESSION['success']); ?>
            </div>
        <?php endif; ?>

        <?php if (isset($_SESSION['error'])): ?>
            <div class="alert alert-danger">
                <?= $_SESSION['error'] ?>
                <?php unset($_SESSION['error']); ?>
            </div>
        <?php endif; ?>

        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>Order #</th>
                        <th>Customer</th>
                        <th>Date</th>
                        <th>Status</th>
                        <th>Total</th>
                        <th>Items</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $sql = 'SELECT o.*, u.username, COALESCE(SUM(oi.total_price), 0) as total 
                            FROM orders o 
                            LEFT JOIN users u ON o.user_id = u.id 
                            LEFT JOIN order_items oi ON o.id = oi.order_id 
                            GROUP BY o.id 
                            ORDER BY o.order_date DESC';
                    $stmt = $pdo->prepare($sql);
                    $stmt->execute();
                    $orders = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    $num = 1;
                    ?>

                    <?php foreach ($orders as $order): ?>
                        <tr>
                            <td>#<?= htmlspecialchars($num++) ?></td>
                            <td><?= htmlspecialchars($order['username']) ?></td>
                            <td><?= htmlspecialchars($order['order_date']) ?></td>
                            <td><?= ucfirst(htmlspecialchars($order['status'])) ?></td>
                            <td>₱<?= number_format($order['total'], 2) ?></td>
                            <td>
                                <button class="btn btn-info btn-sm" type="button" data-bs-toggle="collapse" 
                                        data-bs-target="#items-<?= $order['id'] ?>" aria-expanded="false">
                                    View Items
                                </button>
                            </td>
                            <td>
                                <form action="update_order_status.php" method="POST" class="status-form">
                                    <input type="hidden" name="order_id" value="<?= $order['id'] ?>">
                                    <select name="status" onchange="this.form.submit()">
                                        <option value="pending" <?= $order['status'] === 'pending' ? 'selected' : '' ?>>Pending</option>
                                        <option value="shipped" <?= $order['status'] === 'shipped' ? 'selected' : '' ?>>Shipped</option>
                                        <option value="completed" <?= $order['status'] === 'completed' ? 'selected' : '' ?>>Completed</option>
                                        <option value="cancelled" <?= $order['status'] === 'cancelled' ? 'selected' : '' ?>>Cancelled</option>
                                    </select>
                                </form>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="7" class="p-0">
                                <div class="collapse" id="items-<?= $order['id'] ?>">
                                    <div class="order-items">
                                        <?php
                                        $items_sql = 'SELECT oi.*, i.name as item_name, i.image 
                                                    FROM order_items oi 
                                                    LEFT JOIN item i ON oi.item_id = i.id 
                                                    WHERE oi.order_id = ?';
                                        $items_stmt = $pdo->prepare($items_sql);
                                        $items_stmt->execute([$order['id']]);
                                        $items = $items_stmt->fetchAll(PDO::FETCH_ASSOC);
                                        ?>
                                        <?php foreach ($items as $item): ?>
                                            <div class="order-item">
                                                <img src="/uploads/<?= htmlspecialchars($item['image'] ?? 'default.jpg') ?>" 
                                                     alt="<?= htmlspecialchars($item['item_name']) ?>">
                                                <div>
                                                    <h6 class="mb-0"><?= htmlspecialchars($item['item_name']) ?></h6>
                                                    <small>Quantity: <?= $item['quantity'] ?> x ₱<?= number_format($item['price'], 2) ?></small>
                                                </div>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html> 