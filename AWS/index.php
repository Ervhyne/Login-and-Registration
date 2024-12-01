<?php
session_start();

// Check if the user is logged in
if (isset($_SESSION["user_id"])) {
    $mysqli = require __DIR__ . "/database.php";

    // Fetch the current logged-in user's details
    $sql = "SELECT * FROM users WHERE id = {$_SESSION['user_id']}";
    $result = $mysqli->query($sql);
    $user = $result->fetch_assoc();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/water.css@2/out/water.css">
</head>
<body>
    <h1>Welcome</h1>

    <?php if (isset($user)): ?>
        <!-- User part: Show Fullname and Logout Button -->
        <h2>Hello, <b><?= htmlspecialchars($user["fullname"]) ?></b></h2>
        <p><a href="logout.php">Log out</a></p>

        <!-- Admin Section -->
        <?php if ($user['role'] === 'admin'): ?>
            <h2>Admin Dashboard</h2>
            <h3>User Management</h3>
            
            <?php
            // Fetch all users (admin and regular users)
            $sql = "SELECT id, fullname, email, role FROM users"; 
            $result = $mysqli->query($sql);
            ?>

            <table border="1">
                <thead>
                    <tr>
                        <th>Full Name</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($user = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?= htmlspecialchars($user['fullname']) ?></td>
                            <td><?= htmlspecialchars($user['email']) ?></td>
                            <td><?= htmlspecialchars($user['role']) ?></td>
                            <td>
                                <?php if ($user['role'] !== 'admin'): ?>
                                    <button onclick="editUser(<?= $user['id'] ?>, '<?= addslashes($user['fullname']) ?>', '<?= addslashes($user['email']) ?>')">Edit</button> | 
                                    <a href="index.php?delete=<?= $user['id'] ?>" onclick="return confirm('Are you sure you want to delete this user?')">Delete</a>
                                <?php else: ?>
                                    <span>Admin</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>

            <h2>Edit User</h2>
            <div id="edit-form" style="display: none;">
                <form method="POST" action="index.php">
                    <input type="hidden" name="edit_user" id="edit_user_id">
                    <div>
                        <label for="fullname">Full Name:</label>
                        <input type="text" name="fullname" id="edit_fullname" required>
                    </div>
                    <div>
                        <label for="email">Email:</label>
                        <input type="email" name="email" id="edit_email" required>
                    </div>
                    <button type="submit">Update User</button>
                </form>
            </div>
        <?php endif; ?>

    <?php else: ?>
        <!-- If the user is not logged in, show login/signup options -->
        <p><a href="login.php">Log in</a> or <a href="signup.html">sign up</a></p>
    <?php endif; ?>

    <script>
        function editUser(userId, fullname, email) {
            // Fill the form with the user data
            document.getElementById('edit_user_id').value = userId;
            document.getElementById('edit_fullname').value = fullname;
            document.getElementById('edit_email').value = email;

            // Show the form
            document.getElementById('edit-form').style.display = 'block';
        }
    </script>
</body>
</html>
