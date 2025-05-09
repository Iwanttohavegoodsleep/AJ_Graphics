<?php session_start(); ?>

<?php if (isset($_SESSION['logged_in']) && $_SESSION['username'] == 'admin'): ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>AJ Graphics - Manage Items</title>
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

    .items-container {
      max-width: 1200px;
      margin: 2rem auto;
      padding: 0 1rem;
      padding-bottom: 2rem;
    }

    .items-header {
      text-align: center;
      margin-bottom: 2rem;
    }

    .items-table {
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

    .item-image {
      width: 100px;
      height: 100px;
      object-fit: cover;
      border-radius: 8px;
    }

    .add-item-btn {
      margin-bottom: 1.5rem;
    }
  </style>
</head>
<body>
<?php include_once "navbar.php"?>

<div class="items-container">
  <div class="items-header">
    <h1>Manage Items</h1>
    <p>Add, edit, or remove products from your catalog</p>
  </div>

  <button type="button" class="btn btn-primary add-item-btn" data-bs-toggle="modal" data-bs-target="#addItemModal">
    <i class="fas fa-plus"></i> Add New Item
  </button>

  <div class="filter-section">
    <form class="filter-form" method="GET">
      <input type="text" name="search" class="form-control" 
             value="<?= $_GET['search'] ?? '' ?>" placeholder="Search by name...">
      <button type="submit" class="btn btn-primary">Search</button>
      <a href="manage_items.php" class="btn btn-secondary">Reset</a>
    </form>
  </div>

  <div class="items-table">
    <table class="table">
      <thead>
        <tr>
          <th>Image</th>
          <th>Name</th>
          <th>Category</th>
          <th>Price</th>
          <th>Description</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php 
        include_once "get_db.inc.php";
        
        $where = [];
        $params = [];
        
        if (!empty($_GET['search'])) {
            $where[] = "(name LIKE ? OR description LIKE ?)";
            $params[] = "%{$_GET['search']}%";
            $params[] = "%{$_GET['search']}%";
        }
        
        $query = "SELECT * FROM item";
        if (!empty($where)) {
            $query .= " WHERE " . implode(" AND ", $where);
        }
        $query .= " ORDER BY id DESC";
        
        try {
            $stmt = $pdo->prepare($query);
            $stmt->execute($params);
            $items = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            if (empty($items)) {
                echo "<!-- Debug: No items found in database -->";
            } else {
                echo "<!-- Debug: Found " . count($items) . " items -->";
            }
        } catch (PDOException $e) {
            echo "<!-- Debug: Database error: " . htmlspecialchars($e->getMessage()) . " -->";
            $items = [];
        }
        
        foreach($items as $item): 
        ?>
        <tr>
          <td>
            <img src="uploads/<?= htmlspecialchars($item['image']) ?>" alt="<?= htmlspecialchars($item['name']) ?>" class="item-image">
          </td>
          <td><?= htmlspecialchars($item['name']) ?></td>
          <td><?= ucfirst(htmlspecialchars($item['category'])) ?></td>
          <td>₱<?= number_format($item['price'], 2) ?></td>
          <td><?= htmlspecialchars($item['description']) ?></td>
          <td>
            <button type="button" class="btn btn-primary btn-action" 
                    onclick="editItem(<?= $item['id'] ?>)">Edit</button>
            <button type="button" class="btn btn-danger btn-action" 
                    onclick="deleteItem(<?= $item['id'] ?>)">Delete</button>
          </td>
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</div>

<!-- Add Item Modal -->
<div class="modal fade" id="addItemModal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Add New Item</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <form id="addItemForm" action="create_item_handler.inc.php" method="POST" enctype="multipart/form-data">
          <div class="mb-3">
            <label class="form-label">Item Name</label>
            <input type="text" class="form-control" name="item_name" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Category</label>
            <input type="text" class="form-control" name="category" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Price</label>
            <input type="number" class="form-control" name="price" step="0.01" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Stock</label>
            <input type="number" class="form-control" name="stock" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Description</label>
            <textarea class="form-control" name="description" rows="3" required></textarea>
          </div>
          <div class="mb-3">
            <label class="form-label">Image</label>
            <input type="file" class="form-control" name="image" accept="image/*" required>
          </div>
          <button type="submit" class="btn btn-primary">Add Item</button>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- Edit Item Modal -->
<div class="modal fade" id="editItemModal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Edit Item</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body" id="editItemContent">
        <!-- Content will be loaded dynamically -->
      </div>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"></script>
<script>
function editItem(itemId) {
  fetch(`get_item.php?id=${itemId}`)
    .then(response => response.text())
    .then(html => {
      document.getElementById('editItemContent').innerHTML = html;
      new bootstrap.Modal(document.getElementById('editItemModal')).show();
    });
}

function deleteItem(itemId) {
  if (confirm('Are you sure you want to delete this item? This action cannot be undone.')) {
    fetch('delete_item.php', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/x-www-form-urlencoded',
      },
      body: `id=${itemId}`
    })
    .then(response => response.json())
    .then(data => {
      if (data.success) {
        location.reload();
      } else {
        alert('Error deleting item: ' + data.message);
      }
    });
  }
}
</script>
</body>
</html>

<?php else: ?>
<?php header('Location: home.php'); ?>
<?php endif; ?> 