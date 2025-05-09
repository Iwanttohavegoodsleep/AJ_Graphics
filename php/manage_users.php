<?php
session_start();
if ($_SESSION['username'] !== 'admin') {
    header('Location: home.php');
    exit;
}

include_once "get_db.inc.php";

// Get all users
$query = "SELECT * FROM users";
$stmt = $pdo->prepare($query);
$stmt->execute();
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Users - AJ Graphics</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="styles.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/eedbcd0c96.js" crossorigin="anonymous"></script>
</head>
<body>
    <?php include_once "navbar.php"?>

    <div class="container mt-5">
        <h1 class="mb-4">Manage Users</h1>

        <?php if (isset($_SESSION['success'])): ?>
            <div class="alert alert-success">
                <?= $_SESSION['success'] ?>
                <?php unset($_SESSION['success']); ?>
            </div>
        <?php endif; ?>

        <?php if (isset($_SESSION['error'])): ?>
            <div class="alert alert-danger">
                <?= $_SESSION['error'] ?>
                <?php unset($_SESSION['error']); ?>
            </div>
        <?php endif; ?>

        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Username</th>
                        <th>Email</th>
                        <th>Phone Number</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($users as $user): ?>
                        <tr>
                            <td><?= htmlspecialchars($user['id']) ?></td>
                            <td><?= htmlspecialchars($user['username']) ?></td>
                            <td><?= htmlspecialchars($user['email']) ?></td>
                            <td><?= htmlspecialchars($user['phone_number']) ?></td>
                            <td>
                                <button class="btn btn-primary btn-sm" onclick="editUser(<?= htmlspecialchars(json_encode($user)) ?>)">
                                    <i class="fas fa-edit"></i> Edit
                                </button>
                                <button class="btn btn-danger btn-sm" onclick="deleteUser(<?= $user['id'] ?>)">
                                    <i class="fas fa-trash"></i> Delete
                                </button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Edit User Modal -->
    <div class="modal fade" id="editUserModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit User</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="editUserForm" action="update_user.php" method="POST">
                        <input type="hidden" name="user_id" id="edit_user_id">
                        <div class="mb-3">
                            <label class="form-label">Username</label>
                            <input type="text" class="form-control" name="username" id="edit_username" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" class="form-control" name="email" id="edit_email" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Phone Number</label>
                            <input type="text" class="form-control" name="phone_number" id="edit_phone_number" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">New Password (leave blank to keep current)</label>
                            <input type="password" class="form-control" name="password">
                        </div>
                        <button type="submit" class="btn btn-primary">Update User</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function editUser(user) {
            document.getElementById('edit_user_id').value = user.id;
            document.getElementById('edit_username').value = user.username;
            document.getElementById('edit_email').value = user.email;
            document.getElementById('edit_phone_number').value = user.phone_number;
            
            const modal = new bootstrap.Modal(document.getElementById('editUserModal'));
            modal.show();
        }

        function deleteUser(userId) {
            if (confirm('Are you sure you want to delete this user?')) {
                window.location.href = `delete_user.php?id=${userId}`;
            }
        }
    </script>
</body>
</html> 