<?php
session_start();
if ($_SESSION['username'] !== 'admin') {
    header('Location: home.php');
    exit;
}

include_once "get_db.inc.php";

$item_id = $_GET['id'] ?? 0;

$query = "SELECT * FROM item WHERE id = ?";
$stmt = $pdo->prepare($query);
$stmt->execute([$item_id]);
$item = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$item) {
    echo '<div class="alert alert-danger">Item not found</div>';
    exit;
}
?>

<form action="update_item.php" method="POST" enctype="multipart/form-data">
    <input type="hidden" name="id" value="<?= $item['id'] ?>">
    
    <div class="mb-3">
        <label class="form-label">Name</label>
        <input type="text" class="form-control" name="name" value="<?= htmlspecialchars($item['name']) ?>" required>
    </div>
    
    <div class="mb-3">
        <label class="form-label">Category</label>
        <input type="text" class="form-control" name="category" value="<?= htmlspecialchars($item['category']) ?>" required>
    </div>
    
    <div class="mb-3">
        <label class="form-label">Price</label>
        <input type="number" class="form-control" name="price" step="0.01" value="<?= $item['price'] ?>" required>
    </div>
    
    <div class="mb-3">
        <label class="form-label">Description</label>
        <textarea class="form-control" name="description" rows="3" required><?= htmlspecialchars($item['description']) ?></textarea>
    </div>
    
    <div class="mb-3">
        <label class="form-label">Current Image</label>
        <img src="uploads/<?= htmlspecialchars($item['image']) ?>" alt="Current image" class="img-thumbnail" style="max-width: 200px;">
    </div>
    
    <div class="mb-3">
        <label class="form-label">New Image (optional)</label>
        <input type="file" class="form-control" name="image" accept="image/*">
        <small class="text-muted">Leave empty to keep current image</small>
    </div>
    
    <button type="submit" class="btn btn-primary">Update Item</button>
</form> 