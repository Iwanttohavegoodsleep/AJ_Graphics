<?php
session_start();
if ($_SESSION['username'] !== 'admin') {
    header('Location: home.php');
    exit;
}

include_once "get_db.inc.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $user_id = $_POST['user_id'];
        $username = trim($_POST['username']);
        $email = trim($_POST['email']);
        $phone_number = trim($_POST['phone_number']);
        $password = trim($_POST['password']);

        // Validate input
        if (empty($username) || empty($email) || empty($phone_number)) {
            throw new Exception('All fields are required');
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new Exception('Invalid email format');
        }

        // Check if username or email already exists for other users
        $query = "SELECT id FROM users WHERE (username = ? OR email = ?) AND id != ?";
        $stmt = $pdo->prepare($query);
        $stmt->execute([$username, $email, $user_id]);
        if ($stmt->rowCount() > 0) {
            throw new Exception('Username or email already exists');
        }

        // Update user
        if (!empty($password)) {
            // Update with new password
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $query = "UPDATE users SET username = ?, email = ?, phone_number = ?, password = ? WHERE id = ?";
            $stmt = $pdo->prepare($query);
            $stmt->execute([$username, $email, $phone_number, $hashed_password, $user_id]);
        } else {
            // Update without changing password
            $query = "UPDATE users SET username = ?, email = ?, phone_number = ? WHERE id = ?";
            $stmt = $pdo->prepare($query);
            $stmt->execute([$username, $email, $phone_number, $user_id]);
        }

        $_SESSION['success'] = 'User updated successfully';
    } catch (Exception $e) {
        $_SESSION['error'] = $e->getMessage();
    }
}

header('Location: manage_users.php');
exit; 