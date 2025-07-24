<?php
include('../config/db.php'); // Change path as needed

$message = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $feedback = trim($_POST['message']);
    $rating = (int)$_POST['rating'];

    $stmt = $conn->prepare("INSERT INTO feedback (name, email, message, rating) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("sssi", $name, $email, $feedback, $rating);

    if ($stmt->execute()) {
        $message = "Thank you for your feedback!";
    } else {
        $message = "Error: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>User Feedback</title>
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

        .feedback-container {
            background-color: rgba(255, 255, 255, 0.55); /* 65% opacity white */
            padding: 40px;
            box-shadow: 0 0 10px rgba(0,0,0,0.15);
            border-radius: 10px;
            width: 400px;
        }

        h2 {
            text-align: center;
            color: #333;
            margin-bottom: 20px;
        }

        input[type="text"],
        input[type="email"],
        textarea,
        select {
            width: 100%;
            padding: 12px;
            margin-bottom: 15px;
            border-radius: 5px;
            border: 1px solid #ccc;
            resize: none;
        }

        button {
            width: 100%;
            padding: 12px;
            background-color: #007bff;
            border: none;
            color: white;
            font-size: 16px;
            border-radius: 5px;
            cursor: pointer;
        }

        button:hover {
            background-color: #0056b3;
        }

        .message {
            text-align: center;
            margin-bottom: 15px;
            color: green;
        }
    </style>
</head>
<body>
    <div class="feedback-container">
        <h2>User Feedback Form</h2>

        <?php if ($message): ?>
            <div class="message"><?= htmlspecialchars($message) ?></div>
        <?php endif; ?>

        <form method="post">
            <input type="text" name="name" placeholder="Your Name" required>
            <input type="email" name="email" placeholder="Your Email" required>
            <textarea name="message" placeholder="Your Feedback" rows="5" required></textarea>
            <select name="rating" required>
                <option value="">Rate us</option>
                <option value="5">5 - Excellent</option>
                <option value="4">4 - Very Good</option>
                <option value="3">3 - Good</option>
                <option value="2">2 - Fair</option>
                <option value="1">1 - Poor</option>
            </select>
            <button type="submit">Submit Feedback</button>
        </form>
    </div>
</body>
</html>
