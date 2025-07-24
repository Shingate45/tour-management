<?php
include('../config/db.php');

// Handle Update
if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $description = $_POST['description'];
    $location = $_POST['location'];
    $price = $_POST['price'];

    $sql = "UPDATE tours SET name='$name', description='$description', location='$location', price='$price' WHERE id=$id";
    $conn->query($sql);
}

// Handle Delete
if (isset($_POST['delete'])) {
    $id = $_POST['id'];
    $sql = "DELETE FROM tours WHERE id=$id";
    $conn->query($sql);
}

// Fetch all tours
$tours = $conn->query("SELECT * FROM tours");
?>

<!DOCTYPE html>
<html>
<head>
    <title>All Tours</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            background-color: #919aa3ff;
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #333;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background-color: #fff;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
        }

        th {
            background-color: #007BFF;
            color: white;
            text-align: left;
            padding: 12px;
        }

        td {
            padding: 10px;
            border-bottom: 1px solid #ddd;
            vertical-align: top;
        }

        tr:hover {
            background-color: #f1f1f1;
        }

        input[type="text"],
        input[type="number"],
        textarea {
            width: 100%;
            padding: 6px;
            border: 1px solid #ccc;
            border-radius: 4px;
            resize: vertical;
            font-size: 14px;
            box-sizing: border-box;
        }

        textarea {
            height: 60px;
        }

        input[type="submit"] {
            padding: 6px 12px;
            margin-right: 5px;
            border: none;
            border-radius: 4px;
            font-weight: bold;
            cursor: pointer;
        }

        .update {
            background-color: #28a745;
            color: white;
        }

        .delete {
            background-color: #dc3545;
            color: white;
        }

        input[type="submit"]:hover {
            opacity: 0.85;
        }

    </style>
</head>
<body>

<h2>All Tours (Edit & Delete in One File)</h2>

<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Tour Name</th>
            <th>Description</th>
            <th>Location</th>
            <th>Price</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php while ($row = $tours->fetch_assoc()): ?>
            <tr>
                <form method="POST">
                    <td><?= $row['id'] ?><input type="hidden" name="id" value="<?= $row['id'] ?>"></td>
                    <td><input type="text" name="name" value="<?= htmlspecialchars($row['name']) ?>"></td>
                    <td><textarea name="description"><?= htmlspecialchars($row['description']) ?></textarea></td>
                    <td><input type="text" name="location" value="<?= htmlspecialchars($row['location']) ?>"></td>
                    <td><input type="number" name="price" value="<?= $row['price'] ?>"></td>
                    <td>
                        <input type="submit" name="update" value="Update" class="update">
                        <input type="submit" name="delete" value="Delete" class="delete" onclick="return confirm('Delete this tour?');">
                    </td>
                </form>
            </tr>
        <?php endwhile; ?>
    </tbody>
</table>

</body>
</html>
