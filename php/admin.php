<?php session_start(); ?>

<?php if (isset($_SESSION['logged_in']) && $_SESSION['username'] == 'admin'): ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>AJ Graphics - Admin Dashboard</title>
  <link rel="stylesheet" href="account.css">
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet" />
  <script src="https://kit.fontawesome.com/eedbcd0c96.js" crossorigin="anonymous"></script>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background: linear-gradient(135deg, #00CED1, #32CD32);
      min-height: 100vh;
      margin: 0;
      padding: 0;
    }

    .admin-container {
      max-width: 1200px;
      margin: 2rem auto;
      padding: 0 1rem;
      padding-bottom: 2rem;
    }

    .admin-header {
      text-align: center;
      margin-bottom: 2rem;
    }

    .stats-container {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
      gap: 1.5rem;
      margin-bottom: 2rem;
    }

    .stat-card {
      background: white;
      border-radius: 15px;
      padding: 1.5rem;
      box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
      text-align: center;
    }

    .stat-card i {
      font-size: 2.5rem;
      margin-bottom: 1rem;
      color: #00CED1;
    }

    .stat-card h3 {
      font-size: 2rem;
      margin: 0.5rem 0;
      color: #2c3e50;
    }

    .stat-card p {
      color: #666;
      margin: 0;
    }

    .quick-actions {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
      gap: 1.5rem;
      margin-bottom: 2rem;
    }

    .action-card {
      background: white;
      border-radius: 15px;
      padding: 1.5rem;
      box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
      text-align: center;
      transition: transform 0.3s ease;
      cursor: pointer;
      text-decoration: none;
      color: inherit;
    }

    .action-card:hover {
      transform: translateY(-5px);
    }

    .action-card i {
      font-size: 2.5rem;
      margin-bottom: 1rem;
      color: #00CED1;
    }

    .action-card h3 {
      color: #2c3e50;
      margin-bottom: 0.5rem;
    }

    .action-card p {
      color: #666;
      margin: 0;
    }

    .recent-orders {
      background: white;
      border-radius: 15px;
      padding: 1.5rem;
      box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
    }

    .recent-orders h2 {
      color: #2c3e50;
      margin-bottom: 1.5rem;
    }

    .table {
      width: 100%;
      border-collapse: collapse;
    }

    .table th,
    .table td {
      padding: 1rem;
      text-align: left;
      border-bottom: 1px solid #eee;
    }

    .table th {
      background: #f8f9fa;
      font-weight: 600;
      color: #2c3e50;
    }

    .status-badge {
      padding: 0.25rem 0.5rem;
      border-radius: 20px;
      font-size: 0.875rem;
    }

    .status-pending {
      background: #fff3cd;
      color: #856404;
    }

    .status-completed {
      background: #d4edda;
      color: #155724;
    }

    .status-cancelled {
      background: #f8d7da;
      color: #721c24;
    }
  </style>
</head>
<body>
<?php include_once "navbar.php"?>

<div class="admin-container">
  <div class="admin-header">
    <h1>Admin Dashboard</h1>
    <p>Welcome back, <?= htmlspecialchars($_SESSION['username']) ?>!</p>
  </div>

  <div class="stats-container">
    <?php
    include_once "get_db.inc.php";
    
    try {
        // Total Orders
        $query = "SELECT COUNT(*) FROM orders";
        $totalOrders = $pdo->query($query)->fetchColumn();
        
        // Pending Orders
        $query = "SELECT COUNT(*) FROM orders WHERE status = 'pending'";
        $pendingOrders = $pdo->query($query)->fetchColumn();
        
        // Total Revenue
        $query = "SELECT COALESCE(SUM(total_amount), 0) FROM orders WHERE status = 'completed'";
        $totalRevenue = $pdo->query($query)->fetchColumn();
        
        // Active Users
        $query = "SELECT COUNT(*) FROM users WHERE username != 'admin'";
        $activeUsers = $pdo->query($query)->fetchColumn();
    } catch (PDOException $e) {
        // Log error and set default values
        error_log("Database error: " . $e->getMessage());
        $totalOrders = 0;
        $pendingOrders = 0;
        $totalRevenue = 0;
        $activeUsers = 0;
    }
    ?>
    
    <div class="stat-card">
      <i class="fas fa-shopping-cart"></i>
      <h3><?= $totalOrders ?></h3>
      <p>Total Orders</p>
    </div>
    
    <div class="stat-card">
      <i class="fas fa-clock"></i>
      <h3><?= $pendingOrders ?></h3>
      <p>Pending Orders</p>
    </div>
    
    <div class="stat-card">
      <i class="fas fa-money-bill-wave"></i>
      <h3>₱<?= number_format($totalRevenue, 2) ?></h3>
      <p>Total Revenue</p>
    </div>
    
    <div class="stat-card">
      <i class="fas fa-users"></i>
      <h3><?= $activeUsers ?></h3>
      <p>Active Users</p>
    </div>
  </div>

  <div class="quick-actions">
    <a href="manage_items.php" class="action-card">
      <i class="fas fa-box"></i>
      <h3>Manage Items</h3>
      <p>Add, edit, or remove products from your catalog</p>
    </a>
    
    <a href="manage_orders.php" class="action-card">
      <i class="fas fa-shopping-bag"></i>
      <h3>Manage Orders</h3>
      <p>View and update order statuses</p>
    </a>
    
    <a href="manage_users.php" class="action-card">
      <i class="fas fa-user-cog"></i>
      <h3>Manage Users</h3>
      <p>View and manage user accounts</p>
    </a>
  </div>

  <div class="recent-orders">
    <h2>Recent Orders</h2>
    <table class="table">
      <thead>
        <tr>
          <th>Order ID</th>
          <th>Customer</th>
          <th>Date</th>
          <th>Amount</th>
          <th>Status</th>
        </tr>
      </thead>
      <tbody>
        <?php
        try {
            $query = "SELECT o.*, u.username 
                     FROM orders o 
                     JOIN users u ON o.user_id = u.id 
                     ORDER BY o.order_date DESC 
                     LIMIT 5";
            $stmt = $pdo->query($query);
            $recentOrders = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            if (count($recentOrders) > 0) {
                foreach($recentOrders as $order):
                ?>
                <tr>
                  <td>#<?= htmlspecialchars($order['id']) ?></td>
                  <td><?= htmlspecialchars($order['username']) ?></td>
                  <td><?= htmlspecialchars($order['order_date']) ?></td>
                  <td>₱<?= number_format($order['total_amount'], 2) ?></td>
                  <td>
                    <span class="status-badge status-<?= strtolower($order['status']) ?>">
                      <?= htmlspecialchars($order['status']) ?>
                    </span>
                  </td>
                </tr>
                <?php endforeach;
            } else {
                echo '<tr><td colspan="5" class="text-center">No recent orders found</td></tr>';
            }
        } catch (PDOException $e) {
            error_log("Database error: " . $e->getMessage());
            echo '<tr><td colspan="5" class="text-center">Error loading recent orders</td></tr>';
        }
        ?>
      </tbody>
    </table>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php else: ?>
<?php header('Location: home.php'); ?>
<?php endif; ?>