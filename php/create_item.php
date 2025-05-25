<?php session_start() ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>AJ Graphics</title>
  <link rel="stylesheet" href="create_item.css">
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

  <?php 
    if (isset($_SESSION['error'])) {
      echo '<p style="color: red; text-align: center;">' . $_SESSION['error'] . '</p>' ;
      unset($_SESSION['error']);
    }
    if (isset($_SESSION['success'])) {
      echo '<p style="color: black; text-align: center;">' . $_SESSION['success'] . '</p>' ;
      unset($_SESSION['success']);
    }
  ?>


  <div class="create_item_area">
    <h3 style="text-align: center;"> Create Item </h3>  
    <form action="create_item_handler.inc.php" method="post" enctype="multipart/form-data">
    
      <label class="form-label">Item Name </label>           
      <input class="form-control" type="text" name="item_name" required>

      <label class="form-label">Price </label>           
      <input class="form-control" type="number" name="price" required>

      <label class="form-label">Stock </label>           
      <input class="form-control" type="number" name="stock" required>

      <label class="form-label">Category </label>           
      <input class="form-control" type="text" name="category" required>

      <div class="form-check mb-3">
        <input class="form-check-input" type="checkbox" name="has_size" id="hasSize">
        <label class="form-check-label" for="hasSize">
          This item requires size specification
        </label>
      </div>

      <div id="sizeFields" style="display: none;">
        <label class="form-label">Size Unit (e.g., sq ft, inches, etc.) </label>           
        <input class="form-control" type="text" name="size_unit" placeholder="e.g., sq ft">

        <label class="form-label">Default Size (optional) </label>           
        <input class="form-control" type="text" name="default_size" placeholder="e.g., 2x3">
      </div>

      <label class="form-label">Image </label>           
      <input class="form-control" type="file" name="image" required>

      <label class="form-label">Description </label>           
      <textarea class="form-control" name="description" required> </textarea>

      <input class="btn btn-primary" type="submit">

    </form> 

  </div>

  
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js" integrity="sha384-k6d4wzSIapyDyv1kpU366/PK5hCdSbCRGRCMv+eplOQJWyd1fbcAu9OCUj5zNLiq" crossorigin="anonymous"></script>
<script>
document.getElementById('hasSize').addEventListener('change', function() {
  const sizeFields = document.getElementById('sizeFields');
  sizeFields.style.display = this.checked ? 'block' : 'none';
});
</script>
</body>
</html>