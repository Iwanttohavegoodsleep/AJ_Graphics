<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>AJ Graphics</title>
  <link rel="stylesheet" href="account.css">
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link
      href="https://fonts.googleapis.com/css2?family=Poppins&display=swap"
      rel="stylesheet"
    />
    <script
      src="https://kit.fontawesome.com/eedbcd0c96.js"
      crossorigin="anonymous"
    ></script>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous">
</head>
<body>

<?php include_once "navbar.php"?>

  <div class="container">
    <?php if(isset($_SESSION['logged_in'])): ?>
    <h1>Account</h1>

   <div id="content">
    <p><strong>Name: </strong> <?=htmlspecialchars($_SESSION['username'])?></p>
    <p><strong>Email: </strong> <?=htmlspecialchars($_SESSION['email'])?></p>
    <p><strong>Phone Number: </strong> <?=htmlspecialchars($_SESSION['phone_number'])?></p>
   </div>

   <form action="logout.inc.php" method="post">
      <input type="submit" value="Logout">
   </form>


   <h1 style="text-align: center; margin-top: 2rem;">My Orders</h1>

<div class="orders-container">
  <table class="orders-table">
    <thead>
      <tr>
        <th>Order #</th>
        <th>Date</th>
        <th>Status</th>
        <th>Total</th>
        <th>Actions</th>
      </tr>
    </thead>
    <tbody>
      <?php 
        include_once "get_db.inc.php";
        $user_id = $_SESSION['user_id'];
        $sql = 'SELECT o.*, COALESCE(SUM(oi.total_price), 0) as total 
                FROM orders o 
                LEFT JOIN order_items oi ON o.id = oi.order_id 
                WHERE o.user_id = ? 
                GROUP BY o.id 
                ORDER BY o.order_date DESC';
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$user_id]);
        $user_orders = $stmt->fetchAll(PDO::FETCH_ASSOC);
      ?>
      <?php $num = 1 ?>

      <?php foreach ($user_orders as $order): ?>
        <tr>
          <td>#<?= htmlspecialchars($num++) ?></td>
          <td><?= htmlspecialchars($order['order_date']) ?></td>
          <td><?= ucfirst(htmlspecialchars($order['status'])) ?></td>
          <td>₱<?= number_format($order['total'], 2) ?></td>
          <td>
            <button class="btn btn-info btn-sm" type="button" data-bs-toggle="collapse" 
                    data-bs-target="#items-<?= $order['id'] ?>" aria-expanded="false">
              View Items
            </button>
          </td>
        </tr>
        <tr>
          <td colspan="5" class="p-0">
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

<style>
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
</style>

    <?php else: ?>
      <?= "you are not logged in!" ?>
    <?php endif; ?> 
  
  </div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js" integrity="sha384-k6d4wzSIapyDyv1kpU366/PK5hCdSbCRGRCMv+eplOQJWyd1fbcAu9OCUj5zNLiq" crossorigin="anonymous"></script>
<?php include_once "footer.php"?>
</body>
</html>