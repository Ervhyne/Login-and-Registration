<?php
$is_invalid = false;
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $mysqli = require __DIR__ . "/database.php";
    
    // Admin login credentials
    $admin_email = "admin@gmail.com"; // Admin email
    $admin_password = "12345678"; // Admin password (fixed password for admin login)

    // If the entered email matches the admin's email and the password is correct
    if ($_POST["email"] === $admin_email && $_POST["password"] === $admin_password) {
        session_start();
        session_regenerate_id();
        $_SESSION["user_id"] = "admin";  // Set a special session for admin
        $_SESSION["is_admin"] = true;   // Add an admin flag to the session
        header("Location: index.php");
        exit;
    }

    // If it's not the admin login, proceed with normal user login
    $sql = sprintf("SELECT * FROM users WHERE email = '%s'", 
                   $mysqli->real_escape_string($_POST["email"]));

    $result = $mysqli->query($sql);
    $user = $result->fetch_assoc();

    if ($user) {
        // For regular users, check hashed password
        if (password_verify($_POST["password"], $user["password_hash"])) {
            session_start();
            session_regenerate_id();
            $_SESSION["user_id"] = $user["id"];
            $_SESSION["is_admin"] = false;  // Regular user, not an admin
            header("Location: index.php");
            exit;
        }
    }

    $is_invalid = true;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/water.css@2/out/water.css">
</head>
<body>
    <h1>Log in</h1>
    <?php if ($is_invalid): ?>
        <em>Invalid login</em>
    <?php endif; ?>
    <form method="post">
        <div>
            <input type="email" id="email" name="email" placeholder="Email Address" value="<?= htmlspecialchars($_POST["email"] ?? "") ?>">
        </div>
        <div>
            <input type="password" id="password" name="password" placeholder="Password">
        </div>
        <button>Log in</button>
    </form>
</body>
</html>
