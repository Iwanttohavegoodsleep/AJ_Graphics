<?php 
  session_start(); 
  $category = $_GET['type'] ?? '';
  $category = trim($category);

  include_once('get_db.inc.php');
  
  $query = "SELECT * FROM item WHERE category = ?";
  $stmt = $pdo -> prepare($query);
  $stmt -> execute([$category]);
  $items = $stmt -> fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>AJ Graphics - <?= ucfirst($category) ?></title>
  <link rel="stylesheet" href="category.css">
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet" />
  <script src="https://kit.fontawesome.com/eedbcd0c96.js" crossorigin="anonymous"></script>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background: #f8f9fa;
      min-height: 100vh;
      margin: 0;
      padding: 0;
    }

    .page-title {
      text-align: center;
      color: #2c3e50;
      margin: 2rem 0;
      font-size: 2.5rem;
      font-weight: 600;
    }

    .items-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
      gap: 2rem;
      padding: 2rem;
      max-width: 1400px;
      margin: 0 auto;
    }

    .item-card {
      background: white;
      border-radius: 15px;
      box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
      overflow: hidden;
      transition: all 0.3s ease;
      cursor: pointer;
    }

    .item-card:hover {
      transform: translateY(-10px);
      box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
    }

    .item-image {
      width: 100%;
      height: 250px;
      object-fit: cover;
      transition: transform 0.3s ease;
    }

    .item-card:hover .item-image {
      transform: scale(1.05);
    }

    .item-content {
      padding: 1.5rem;
    }

    .item-title {
      font-size: 1.3rem;
      font-weight: 600;
      color: #2c3e50;
      margin-bottom: 0.5rem;
    }

    .item-price {
      font-size: 1.2rem;
      color: #00CED1;
      font-weight: 600;
      margin-bottom: 1rem;
    }

    /* Modal Styling */
    .modal-content {
      border-radius: 15px;
      border: none;
    }

    .modal-header {
      background: #f8f9fa;
      border-bottom: none;
      padding: 1.5rem;
    }

    .modal-title {
      color: #2c3e50;
      font-weight: 600;
      font-size: 1.5rem;
    }

    .modal-body {
      padding: 2rem;
    }

    .modal-body img {
      max-height: 400px;
      object-fit: contain;
      margin-bottom: 1.5rem;
      border-radius: 10px;
    }

    .modal-body p {
      color: #2c3e50;
      font-size: 1.1rem;
      margin: 1rem 0;
    }

    .modal-body strong {
      color: #2c3e50;
    }

    .btn-primary {
      background: #00CED1;
      border: none;
      padding: 0.8rem 2rem;
      font-size: 1.1rem;
      transition: all 0.3s ease;
    }

    .btn-primary:hover {
      background: #32CD32;
      transform: translateY(-2px);
    }

    .quantity-input {
      max-width: 100px;
      margin: 1rem auto;
    }

    @media (max-width: 768px) {
      .page-title {
        font-size: 2rem;
        margin: 1.5rem 0;
      }

      .items-grid {
        padding: 1rem;
        gap: 1rem;
      }

      .item-image {
        height: 200px;
      }

      .modal-body {
        padding: 1.5rem;
      }

      .modal-body img {
        max-height: 300px;
      }
    }
  </style>
</head>
<body>
  <?php include_once "navbar.php"?>

  <h1 class="page-title"><?= ucfirst($category) ?></h1>

  <div class="items-grid">
  <?php foreach ($items as $item): ?>
      <div class="item-card" data-bs-toggle="modal" data-bs-target="#itemModal<?= $item['id'] ?>">
        <img src="/uploads/<?= htmlspecialchars($item['image']) ?>" class="item-image" alt="<?= htmlspecialchars($item['name']) ?>">
        <div class="item-content">
          <h2 class="item-title"><?= htmlspecialchars($item['name']) ?></h2>
          <p class="item-price">₱<?= number_format($item['price'], 2) ?></p>
        </div>
    </div>
  <?php endforeach; ?>
</div>

<?php foreach ($items as $item): ?>
  <div class="modal fade" id="itemModal<?= $item['id'] ?>" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title"><?= htmlspecialchars($item['name']) ?></h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>

        <div class="modal-body text-center">
          <img src="/uploads/<?= htmlspecialchars($item['image']) ?>" class="img-fluid mb-3">
            <p class="item-price">₱<?= number_format($item['price'], 2) ?></p>
          <p><?= htmlspecialchars($item['description']) ?></p>

          <form action="add_cart.php" method="POST">
            <input type="hidden" name="item_id" value="<?= $item['id'] ?>">
            <input type="hidden" name="redirect_url" value="<?= htmlspecialchars($_SERVER['HTTP_REFERER'])?>">
              
              <div class="form-group">
            <label for="quantity">Quantity</label>
                <input type="number" name="quantity" value="1" min="1" class="form-control quantity-input">
              </div>

              <button type="submit" class="btn btn-primary mt-3">Add to Cart</button>
          </form>
        </div>
      </div>
    </div>
  </div>
<?php endforeach; ?>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"></script>
  <?php include_once "footer.php"?>
</body>
</html>