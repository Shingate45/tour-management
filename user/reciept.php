<?php
session_start();
include('../config/db.php');

$error = "";
$show_receipt = false;
$user = null;
$tour = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $phone = trim($_POST['phone']);

    $query = "SELECT * FROM registrations WHERE phone = '$phone' LIMIT 1";
    $result = $conn->query($query);

    if ($result && $result->num_rows > 0) {
        $user = $result->fetch_assoc();

        $tour_id = $user['tour_id'];
        $tour_result = $conn->query("SELECT * FROM tours WHERE id = $tour_id");
        if ($tour_result && $tour_result->num_rows > 0) {
            $tour = $tour_result->fetch_assoc();
            $show_receipt = true;
        } else {
            $error = "Tour not found.";
        }
    } else {
        $error = "Mobile number not found. Please register first.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>User Login & Receipt</title>
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
        .container {
            max-width: 500px;
            margin: auto;
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0,0,0,0.1);
        }

        input[type="text"] {
            width: 100%;
            padding: 12px;
            margin: 15px 0;
            border: 1px solid #ccc;
            border-radius: 6px;
        }

        button {
            width: 100%;
            padding: 12px;
            background: #007bff;
            border: none;
            color: white;
            font-weight: bold;
            cursor: pointer;
        }

        .error {
            color: red;
            margin-bottom: 10px;
        }

        .receipt {
            margin-top: 30px;
            border-top: 1px solid #ddd;
            padding-top: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        td {
            padding: 8px;
        }

        .total {
            font-weight: bold;
        }

        h2 {
            color: #007bff;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>User Login</h2>
    <?php if ($error): ?>
        <p class="error"><?= $error ?></p>
    <?php endif; ?>

    <?php if (!$show_receipt): ?>
        <form method="POST">
            <label>Enter Your Mobile Number:</label>
            <input type="text" name="phone" pattern="[0-9]{10}" required placeholder="10-digit mobile number">
            <button type="submit">Login</button>
        </form>
    <?php endif; ?>

    <?php if ($show_receipt && $user && $tour): ?>
        <div class="receipt">
            <h2>Your Tour Receipt</h2>
            <table>
                <tr><td><strong>Tour Name:</strong></td><td><?= htmlspecialchars($tour['name']) ?></td></tr>
                <tr><td><strong>Location:</strong></td><td><?= htmlspecialchars($tour['location']) ?></td></tr>
                <tr><td><strong>Name:</strong></td><td><?= htmlspecialchars($user['name']) ?></td></tr>
                <tr><td><strong>Email:</strong></td><td><?= htmlspecialchars($user['email']) ?></td></tr>
                <tr><td><strong>Phone:</strong></td><td><?= htmlspecialchars($user['phone']) ?></td></tr>
                <tr><td><strong>Total Persons:</strong></td><td><?= $user['total_persons'] ?></td></tr>
                <tr><td><strong>Per Person Price:</strong></td><td>₹<?= number_format($tour['price']) ?></td></tr>
                <tr class="total"><td><strong>Total Amount:</strong></td><td>₹<?= number_format($tour['price'] * $user['total_persons']) ?></td></tr>
            </table>
        </div>
    <?php endif; ?>
</div>

</body>
</html>
