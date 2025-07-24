<?php
// Include DB connection
include('../config/db.php');

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $conn->real_escape_string($_POST['name']);
    $description = $conn->real_escape_string($_POST['description']);
    $location = $conn->real_escape_string($_POST['location']);
    $price = floatval($_POST['price']);
    $days = intval($_POST['days']);

    // Handle image upload
    $image_name = basename($_FILES['image']['name']);
    $target_dir = "uploads/";
    $upload_path = '../uploads/' . $image_name;
    $image_type = strtolower(pathinfo($upload_path, PATHINFO_EXTENSION));

    $allowed_types = ['jpg', 'jpeg', 'png', 'gif'];

    if (in_array($image_type, $allowed_types)) {
        if (move_uploaded_file($_FILES['image']['tmp_name'], $upload_path)) {
            $sql = "INSERT INTO tours (name, description, location, price, days, image_path) 
                    VALUES (?, ?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("sssdis", $name, $description, $location, $price, $days, $image_name);

            if ($stmt->execute()) {
                // Redirect to index.php after successful insert
                header("Location: ../index.php");
                exit();
            } else {
                $message = "Error: " . $stmt->error;
            }
        } else {
            $message = "Failed to upload image.";
        }
    } else {
        $message = "Only JPG, JPEG, PNG & GIF files are allowed.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add New Tour</title>
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
        .form-container {
            width: 500px;
            margin: 10px auto;
            background-color: rgba(255, 255, 255, 0.65); /* 65% opacity white */
            padding: 30px;
            border-radius: 10px;
            box-shadow: 2px 2px 12px #aaa;
        }
        label {
            font-weight: bold;
        }
        input, textarea {
            width: 100%;
            margin-bottom: 15px;
            padding: 10px;
            border-radius: 6px;
            border: 1px solid #ccc;
        }
        .submit-btn {
            background-color: #2196F3;
            color: white;
            border: none;
            cursor: pointer;
        }
        .submit-btn:hover {
            background-color: #0b7dda;
        }
        .message {
            text-align: center;
            color: green;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="form-container">
        <h2>Register a New Tour</h2>
        <?php if (isset($message)): ?>
            <p class="message"><?= htmlspecialchars($message) ?></p>
        <?php endif; ?>
        <form method="POST" enctype="multipart/form-data">
            <label for="name">Tour Name</label>
            <input type="text" name="name" required>

            <label for="description">Description</label>
            <textarea name="description" rows="4" required></textarea>

            <label for="location">Location</label>
            <input type="text" name="location" required>

            <label for="price">Price (INR)</label>
            <input type="number" name="price" step="0.01" required>

            <label for="days">Number of Days</label>
            <input type="number" name="days" required>

            <label for="image">Tour Image</label>
            <input type="file" name="image" accept="image/*" required>

            <input type="submit" value="Add Tour" class="submit-btn">
        </form>
    </div>
</body>
</html>
