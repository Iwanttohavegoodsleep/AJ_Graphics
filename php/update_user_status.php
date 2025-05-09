<?php
session_start();
if ($_SESSION['username'] !== 'admin') {
    header('Content-Type: application/json');
    echo json_encode(['success' => false, 'message' => 'Unauthorized access']);
    exit;
}

include_once "get_db.inc.php";

$user_id = $_POST['id'] ?? 0;
$new_status = $_POST['status'] === 'true' ? 1 : 0;

try {
    $query = "UPDATE users SET is_active = ? WHERE id = ? AND username != 'admin'";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$new_status, $user_id]);
    
    if ($stmt->rowCount() > 0) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'User not found or no changes made']);
    }
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'message' => 'Database error']);
} 