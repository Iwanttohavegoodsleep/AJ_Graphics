<?php
session_start();
if ($_SESSION['username'] !== 'admin') {
    header('Location: home.php');
    exit;
}

include_once "get_db.inc.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        // Validate input
        $id = intval($_POST['id']);
        $name = trim($_POST['name']);
        $category = trim($_POST['category']);
        $price = floatval($_POST['price']);
        $description = trim($_POST['description']);
        
        if (empty($name) || empty($category) || $price <= 0 || empty($description)) {
            throw new Exception('All fields are required and price must be greater than 0');
        }
        
        // Get current item data
        $query = "SELECT image FROM item WHERE id = ?";
        $stmt = $pdo->prepare($query);
        $stmt->execute([$id]);
        $currentItem = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if (!$currentItem) {
            throw new Exception('Item not found');
        }
        
        $filename = $currentItem['image'];
        
        // Handle new image upload if provided
        if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            $file = $_FILES['image'];
            $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
            
            if (!in_array($file['type'], $allowedTypes)) {
                throw new Exception('Invalid file type. Only JPG, PNG and GIF are allowed');
            }
            
            $maxSize = 5 * 1024 * 1024; // 5MB
            if ($file['size'] > $maxSize) {
                throw new Exception('File size too large. Maximum size is 5MB');
            }
            
            // Generate unique filename
            $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
            $filename = uniqid() . '.' . $extension;
            $uploadPath = 'uploads/' . $filename;
            
            if (!move_uploaded_file($file['tmp_name'], $uploadPath)) {
                throw new Exception('Failed to save image');
            }
            
            // Delete old image
            $oldImagePath = 'uploads/' . $currentItem['image'];
            if (file_exists($oldImagePath)) {
                unlink($oldImagePath);
            }
        }
        
        // Update database
        $query = "UPDATE item SET name = ?, category = ?, price = ?, description = ?, image = ? WHERE id = ?";
        $stmt = $pdo->prepare($query);
        $stmt->execute([$name, $category, $price, $description, $filename, $id]);
        
        header('Location: manage_items.php?success=1');
        exit;
        
    } catch (Exception $e) {
        // If there was an error and we uploaded a new image, delete it
        if (isset($uploadPath) && file_exists($uploadPath)) {
            unlink($uploadPath);
        }
        
        header('Location: manage_items.php?error=' . urlencode($e->getMessage()));
        exit;
    }
} else {
    header('Location: manage_items.php');
    exit;
} 