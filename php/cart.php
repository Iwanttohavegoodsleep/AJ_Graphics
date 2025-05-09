<?php session_start() ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>AJ Graphics - Cart</title>
  <link rel="stylesheet" href="styles.css">
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet" />
  <script src="https://kit.fontawesome.com/eedbcd0c96.js" crossorigin="anonymous"></script>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    .cart-container {
      max-width: 1000px;
      margin: 2rem auto;
      padding: 2rem;
      background: white;
      border-radius: 15px;
      box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    }

    .cart-item {
      display: flex;
      align-items: center;
      padding: 1rem;
      border-bottom: 1px solid #eee;
      margin-bottom: 1rem;
    }

    .cart-item img {
      width: 100px;
      height: 100px;
      object-fit: cover;
      border-radius: 8px;
      margin-right: 1rem;
    }

    .item-details {
      flex-grow: 1;
    }

    .item-price {
      font-weight: bold;
      color: #2ecc71;
    }

    .cart-summary {
      margin-top: 2rem;
      padding-top: 1rem;
      border-top: 2px solid #eee;
    }

    .total-amount {
      font-size: 1.5rem;
      font-weight: bold;
      color: #2ecc71;
    }

    .btn-order {
      background: #2ecc71;
      color: white;
      padding: 0.8rem 2rem;
      border: none;
      border-radius: 8px;
      font-size: 1.1rem;
      transition: all 0.3s ease;
    }

    .btn-order:hover {
      background: #27ae60;
      transform: translateY(-2px);
    }

    .empty-cart {
      text-align: center;
      padding: 3rem;
      color: #666;
    }

    .empty-cart i {
      font-size: 4rem;
      color: #ddd;
      margin-bottom: 1rem;
    }
  </style>
</head>
<body>
  <?php include_once "navbar.php"?>

  <div class="cart-container">
    <h1 class="text-center mb-4">Shopping Cart</h1>

    <?php if (isset($_SESSION['success'])): ?>
      <div class="alert alert-success">
        <?=$_SESSION['success']?>
        <?php unset($_SESSION['success']); ?>
      </div>
    <?php endif; ?>

    <?php $total = 0?>
    <?php if(isset($_SESSION['cart_items']) && $_SESSION['cart_items']['count'] > 0): ?>
      <?php foreach($_SESSION['cart_items']['items'] as $item): ?>
        <?php $total += $item['price'] * $item['qty']?>
        <div class="cart-item">
          <img src="/uploads/<?= htmlspecialchars($item['image'] ?? 'default.jpg') ?>" alt="<?= htmlspecialchars($item['item_name']) ?>">
          <div class="item-details">
            <h3><?= htmlspecialchars($item['item_name']) ?></h3>
            <p>Quantity: <?= $item['qty'] ?></p>
            <p class="item-price">₱<?= number_format($item['qty'] * $item['price'], 2) ?></p>
          </div>
        </div>
      <?php endforeach; ?>

      <div class="cart-summary text-end">
        <h3>Total: <span class="total-amount">₱<?= number_format($total, 2) ?></span></h3>
        <form action="order.php" method="POST" class="mt-3">
          <button type="submit" class="btn-order">Place Order</button>
        </form>
      </div>

    <?php else: ?>
      <div class="empty-cart">
        <i class="fas fa-shopping-cart"></i>
        <h2>Your cart is empty</h2>
        <p>Add some items to your cart to see them here</p>
        <a href="select_category.php" class="btn btn-primary mt-3">Continue Shopping</a>
      </div>
    <?php endif; ?>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"></script>
  <?php include_once "footer.php"?>
</body>
</html>