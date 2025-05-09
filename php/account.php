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
   </form endif; ?>


   <h1 style="text-align: center; margin-top: 2rem;">My Orders</h1>

<div class="orders-container">
  <table class="orders-table">
    <thead>
      <tr>
        <th>Order #</th>
        <th>Date</th>
        <th>Status</th>
        <th>Total</th>
      </tr>
    </thead>
    <tbody>
      <?php 
        include_once "get_db.inc.php";
        $user_id = $_SESSION['user_id'];
        $sql = 'SELECT * FROM orders WHERE user_id = ?';
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
          <td>₱<?= number_format($order['total_amount'], 2) ?></td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</div>


    <?php else: ?>
      <?= "you are not logged in!" ?>
    <?php endif; ?> 
  
  </div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js" integrity="sha384-k6d4wzSIapyDyv1kpU366/PK5hCdSbCRGRCMv+eplOQJWyd1fbcAu9OCUj5zNLiq" crossorigin="anonymous"></script>
<?php include_once "footer.php"?>
</body>
</html>