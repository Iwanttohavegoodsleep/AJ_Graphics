<?php session_start(); ?>

<?php if (isset($_SESSION['logged_in']) && $_SESSION['username'] == 'admin'): ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>AJ Graphics - Manage Orders</title>
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

    .orders-container {
      max-width: 1200px;
      margin: 2rem auto;
      padding: 0 1rem;
      padding-bottom: 2rem;
    }

    .orders-header {
      text-align: center;
      margin-bottom: 2rem;
    }

    .orders-table {
      background: white;
      border-radius: 15px;
      padding: 1.5rem;
      box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
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

    .btn-action {
      padding: 0.25rem 0.5rem;
      font-size: 0.875rem;
      margin: 0 0.25rem;
    }

    .filter-section {
      background: white;
      border-radius: 15px;
      padding: 1.5rem;
      margin-bottom: 1.5rem;
      box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
    }

    .filter-form {
      display: flex;
      gap: 1rem;
      align-items: center;
      flex-wrap: wrap;
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

    .status-processing {
      background: #cce5ff;
      color: #004085;
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

<div class="orders-container">
  <div class="orders-header">
    <h1>Manage Orders</h1>
    <p>View and update order statuses</p>
  </div>

  <div class="filter-section">
    <form class="filter-form" method="GET">
      <select name="status" class="form-select">
        <option value="">All Statuses</option>
        <option value="pending" <?= ($_GET['status'] ?? '') === 'pending' ? 'selected' : '' ?>>Pending</option>
        <option value="processing" <?= ($_GET['status'] ?? '') === 'processing' ? 'selected' : '' ?>>Processing</option>
        <option value="completed" <?= ($_GET['status'] ?? '') === 'completed' ? 'selected' : '' ?>>Completed</option>
        <option value="cancelled" <?= ($_GET['status'] ?? '') === 'cancelled' ? 'selected' : '' ?>>Cancelled</option>
      </select>
      <input type="date" name="date" class="form-control" 
             value="<?= $_GET['date'] ?? '' ?>" placeholder="Filter by date">
      <button type="submit" class="btn btn-primary">Filter</button>
      <a href="manage_orders.php" class="btn btn-secondary">Reset</a>
    </form>
  </div>

  <div class="orders-table">
    <table class="table">
      <thead>
        <tr>
          <th>Order ID</th>
          <th>Customer</th>
          <th>Date</th>
          <th>Amount</th>
          <th>Status</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php 
        include_once "get_db.inc.php";
        
        $where = [];
        $params = [];
        
        if (!empty($_GET['status'])) {
            $where[] = "o.status = ?";
            $params[] = $_GET['status'];
        }
        
        if (!empty($_GET['date'])) {
            $where[] = "DATE(o.order_date) = ?";
            $params[] = $_GET['date'];
        }
        
        $query = "SELECT o.*, u.username 
                 FROM orders o 
                 JOIN users u ON o.user_id = u.id";
        if (!empty($where)) {
            $query .= " WHERE " . implode(" AND ", $where);
        }
        $query .= " ORDER BY o.order_date DESC";
        
        $stmt = $pdo->prepare($query);
        $stmt->execute($params);
        $orders = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        foreach($orders as $order): 
        ?>
        <tr>
          <td>#<?= htmlspecialchars($order['id']) ?></td>
          <td><?= htmlspecialchars($order['username']) ?></td>
          <td><?= htmlspecialchars($order['order_date']) ?></td>
          <td>₱<?= number_format($order['total_amount'], 2) ?></td>
          <td>
            <span class="status-badge status-<?= strtolower($order['status']) ?>">
              <?= ucfirst(htmlspecialchars($order['status'])) ?>
            </span>
          </td>
          <td>
            <button type="button" class="btn btn-primary btn-action" 
                    onclick="viewOrderDetails(<?= $order['id'] ?>)">View Details</button>
            <button type="button" class="btn btn-warning btn-action" 
                    onclick="updateOrderStatus(<?= $order['id'] ?>)">Update Status</button>
          </td>
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</div>

<!-- Order Details Modal -->
<div class="modal fade" id="orderDetailsModal" tabindex="-1">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Order Details</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body" id="orderDetailsContent">
        <!-- Content will be loaded dynamically -->
      </div>
    </div>
  </div>
</div>

<!-- Update Status Modal -->
<div class="modal fade" id="updateStatusModal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Update Order Status</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <form id="updateStatusForm" action="update_order_status.php" method="POST">
          <input type="hidden" name="order_id" id="orderId">
          <div class="mb-3">
            <label class="form-label">Status</label>
            <select class="form-select" name="status" required>
              <option value="pending">Pending</option>
              <option value="processing">Processing</option>
              <option value="completed">Completed</option>
              <option value="cancelled">Cancelled</option>
            </select>
          </div>
          <button type="submit" class="btn btn-primary">Update Status</button>
        </form>
      </div>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"></script>
<script>
function viewOrderDetails(orderId) {
  fetch(`get_order_details.php?id=${orderId}`)
    .then(response => response.text())
    .then(html => {
      document.getElementById('orderDetailsContent').innerHTML = html;
      new bootstrap.Modal(document.getElementById('orderDetailsModal')).show();
    });
}

function updateOrderStatus(orderId) {
  document.getElementById('orderId').value = orderId;
  new bootstrap.Modal(document.getElementById('updateStatusModal')).show();
}
</script>
</body>
</html>

<?php else: ?>
<?php header('Location: home.php'); ?>
<?php endif; ?> 