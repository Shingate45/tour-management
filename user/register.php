<?php
include('../config/db.php');

$tour = null;
if (isset($_GET['tour_id'])) {
    $tour_id = intval($_GET['tour_id']);
    $query = "SELECT * FROM tours WHERE id = $tour_id";
    $result = $conn->query($query);
    if ($result && $result->num_rows > 0) {
        $tour = $result->fetch_assoc();
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Tour Registration</title>
    <style>
        body {
            background-image: url('../images/all-india-Tour.png');
            background-size: cover;
            background-repeat: no-repeat;
            background-position: center;
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f8f9fa;
            overflow-x: hidden;
        }
        .container {
            background-color: rgba(255, 255, 255, 0.65); /* 65% opacity white */
            padding: 20px;
            max-width: 600px;
            margin: auto;
            border-radius: 8px;
        }
        input, textarea {
            display: block;
            width: 100%;
            margin-bottom: 10px;
            padding: 8px;
        }
        button {
            background: #ff5722;
            color: white;
            border: none;
            padding: 10px 15px;
            cursor: pointer;
        }
    </style>
</head>
<body>

<div class="container">
    <?php if ($tour): ?>
        <h2>Register for <?= htmlspecialchars($tour['name']) ?></h2>
        <p><strong>Location:</strong> <?= htmlspecialchars($tour['location']) ?></p>
        <p><strong>Price:</strong> ₹<?= htmlspecialchars($tour['price']) ?></p>
        <form method="post" action="submit_registration.php">
            <input type="hidden" name="tour_id" value="<?= $tour['id'] ?>">
            <input type="hidden" name="tour_name" value="<?= htmlspecialchars($tour['name']) ?>">
            <input type="hidden" name="price" value="<?= $tour['price'] ?>"> <!-- Store price -->

            <label>Name:</label>
            <input type="text" name="name" required>

            <label>Email:</label>
            <input type="email" name="email" required>

            <label>Phone:</label>
            <input type="text" name="phone" required>

            <label>Total Persons:</label>
            <input type="number" name="total_persons" min="1" required>

            <button type="submit">Submit Registration</button>
        </form>

        
    <?php else: ?>
        <p>Invalid Tour Selected.</p>
    <?php endif; ?>
</div>

</body>
</html>
