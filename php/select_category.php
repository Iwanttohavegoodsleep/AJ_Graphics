<?php 
  session_start(); 
  include_once "get_db.inc.php";
  $query = "SELECT DISTINCT category FROM item";
  $categories = $pdo->query($query)->fetchAll(PDO::FETCH_COLUMN);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>AJ Graphics - Categories</title>
  <link rel="stylesheet" href="select_category.css">
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

    .category-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
      gap: 2rem;
      padding: 2rem;
      max-width: 1200px;
      margin: 0 auto;
    }

    .category-card {
      background: white;
      border-radius: 15px;
      box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
      padding: 2rem;
      text-align: center;
      transition: all 0.3s ease;
      cursor: pointer;
      position: relative;
      overflow: hidden;
    }

    .category-card::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 5px;
      background: linear-gradient(to right, lightgreen, cyan);
      transform: scaleX(0);
      transition: transform 0.3s ease;
    }

    .category-card:hover {
      transform: translateY(-10px);
      box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
    }

    .category-card:hover::before {
      transform: scaleX(1);
    }

    .category-card a {
      text-decoration: none;
      color: inherit;
      display: block;
      height: 100%;
    }

    .category-card h2 {
      font-size: 1.5rem;
      font-weight: 600;
      color: #2c3e50;
      margin: 0;
      transition: color 0.3s ease;
    }

    .category-card:hover h2 {
      color: #00CED1;
    }

    .category-icon {
      font-size: 3rem;
      color: #e9ecef;
      margin-bottom: 1rem;
      transition: all 0.3s ease;
    }

    .category-card:hover .category-icon {
      color: #00CED1;
      transform: scale(1.1);
    }

    @media (max-width: 768px) {
      .page-title {
        font-size: 2rem;
        margin: 1.5rem 0;
      }

      .category-grid {
        padding: 1rem;
        gap: 1rem;
      }

      .category-card {
        padding: 1.5rem;
      }
    }
  </style>
</head>
<body>
  <?php include_once "navbar.php"?>

  <h1 class="page-title">Browse Categories</h1>

  <div class="category-grid">
    <?php foreach ($categories as $cat): ?>
      <div class="category-card">
        <a href="category.php?type=<?= urlencode($cat) ?>">
          <i class="fas fa-folder category-icon"></i>
          <h2><?= ucfirst(htmlspecialchars($cat)) ?></h2>
        </a>
      </div>
    <?php endforeach; ?>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"></script>
  <?php include_once "footer.php"?>
</body>
</html>