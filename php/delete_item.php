<?php
session_start();
if ($_SESSION['username'] !== 'admin') {
    header('Content-Type: application/json');
    echo json_encode(['success' => false, 'message' => 'Unauthorized access']);
    exit;
}

include_once "get_db.inc.php";

$item_id = $_POST['id'] ?? 0;

try {
    // Get item image filename before deletion
    $query = "SELECT image FROM item WHERE id = ?";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$item_id]);
    $item = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if (!$item) {
        throw new Exception('Item not found');
    }
    
    // Delete the item
    $query = "DELETE FROM item WHERE id = ?";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$item_id]);
    
    if ($stmt->rowCount() > 0) {
        // Delete the image file
        $imagePath = 'uploads/' . $item['image'];
        if (file_exists($imagePath)) {
            unlink($imagePath);
        }
        
        echo json_encode(['success' => true]);
    } else {
        throw new Exception('Failed to delete item');
    }
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
} 