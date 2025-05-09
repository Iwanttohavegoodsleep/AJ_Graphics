<?php
session_start();
if ($_SESSION['username'] !== 'admin') {
    header('Location: home.php');
    exit;
}

include_once "get_db.inc.php";

if (isset($_GET['id'])) {
    try {
        $user_id = $_GET['id'];
        
        // Don't allow deleting the admin user
        $query = "SELECT username FROM users WHERE id = ?";
        $stmt = $pdo->prepare($query);
        $stmt->execute([$user_id]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($user['username'] === 'admin') {
            throw new Exception('Cannot delete admin user');
        }
        
        // Delete the user
        $query = "DELETE FROM users WHERE id = ?";
        $stmt = $pdo->prepare($query);
        $stmt->execute([$user_id]);
        
        $_SESSION['success'] = 'User deleted successfully';
    } catch (Exception $e) {
        $_SESSION['error'] = $e->getMessage();
    }
}

header('Location: manage_users.php');
exit; 