<?php
session_start();
include('../config/db.php');

$error = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT * FROM admin_users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    $admin = $result->fetch_assoc();

    if ($admin && password_verify($password, $admin['password'])) {
        if ($admin['role'] === 'admin') {
            $_SESSION['admin_logged_in'] = true;
            $_SESSION['admin_username'] = $admin['username'];
            header("Location: dashboard.php");
            exit();
        } else {
            $error = "Access denied: You are not an admin.";
        }
    } else {
        $error = "Invalid username or password.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Login</title>
    <style>
        body {
            background-image: url('../images/Login-Background.jpg');
            background-size: cover;
            margin: 0;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: Arial, sans-serif;
        }
        .login-container {
            background-color: rgba(255, 255, 255, 0.55); /* 65% opacity white */
            padding: 40px;
            box-shadow: 0 0 10px rgba(0,0,0,0.15);
            border-radius: 10px;
            width: 300px;
        }

        h2 {
            text-align: center;
            margin-bottom: 25px;
            color: #333;
        }

        input[type="text"],
        input[type="password"] {
            width: 100%;
            padding: 12px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        button {
            width: 107%;
            padding: 12px;
            background-color: #18d731ff;
            border: none;
            color: black;
            font-size: 16px;
            border-radius: 5px;
            cursor: pointer;
        }

        button:hover {
            background-color: #18d731ff;
        }

        .error {
            color: red;
            text-align: center;
            margin-bottom: 15px;
        }

        .admin-link {
            display: block;
            margin-top: 10px;
            text-align: center;
            text-decoration: none;
            color: #020202ff;
        }

        .admin-link:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <h2>Admin Login</h2>
        <?php if ($error): ?>
            <div class="error"><?= $error ?></div>
        <?php endif; ?>
        <form method="post">
            <input type="text" name="username" placeholder="Username" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit">Login</button>
        </form>
        <a class="admin-link" href="admin_register.php">Register as Admin</a>
    </div>
</body>
</html>
