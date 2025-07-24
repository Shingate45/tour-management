<?php
session_start();
include('config/db.php');

$tours = [];
$sql = "SELECT * FROM tours";
$result = $conn->query($sql);

if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $tours[] = $row;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Maharashtra Tours</title>
    <style>
        body {
            background-image: url('images/bg.jpg');
            background-size: cover;
            background-repeat: no-repeat;
            background-position: center;
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f8f9fa;
            overflow-x: hidden;
        }
        .sidebar {
            height: 100%;
            width: 250px;
            position: fixed;
            top: 0;
            left: -250px;
            background-color: #333;
            color: white;
            overflow-y: auto;
            transition: 0.3s;
            padding-top: 60px;
            z-index: 999;
        }
        .sidebar a {
            padding: 8px 8px 8px 32px;
            text-decoration: none;
            font-size: 25px;
            color: #818181;
            display: block;
            transition: 0.3s;
        }
        .sidebar a:hover {
            color: #f1f1f1;
        }
        .sidebar .closebtn {
            position: absolute;
            top: 0;
            right: 25px;
            font-size: 36px;
            color: #818181;
            cursor: pointer;
        }
        .dots-button {
            font-size: 30px;
            cursor: pointer;
            position: absolute;
            top: 20px;
            left: 20px;
        }
        .tours-list {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            padding: 20px;
            justify-content: center;
        }
        .tours-card {
            background-color: rgba(255, 255, 255, 0.65); /* 65% opacity white */
            border: 1px solid #ddd;
            border-radius: 6px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 300px;
            text-align: center;
            padding: 9px;
            transition: transform 0.3s ease-in-out;
            cursor: pointer;
            display: flex;
            flex-direction: column;
            overflow: hidden;
        }
        .tours-card:hover {
            transform: scale(1.05);
        }
        .tours-card img {
            width: 100%;
            height: 150px;
            border-radius: 8px 8px 0 0;
            object-fit: cover;
        }
        .tours-card h3 {
            font-size: 20px;
            margin: 5px 0;
            color: black;
        }
        .tours-card p {
            color: black;
            margin: 1px 0;
            font-size: 14px;
            line-height: 1.5;
            padding: 0 2px;
        }

        /* Scrollable description section */
        .tours-card .description {
            flex: 1;
            max-height: 60px;
            overflow-y: auto;
            margin-bottom: 10px;
            font-size: 14px;
            color: #666;
            padding: 0 5px;
            scrollbar-width: thin;
        }

        .tours-card .description p {
            margin: 0;
            padding-right: 10px;
            white-space: normal;
            overflow: visible;
            text-overflow: unset;
            max-height: none;
        }

        .tours-card .description::-webkit-scrollbar {
            width: 6px;
        }
        .tours-card .description::-webkit-scrollbar-track {
            background: rgba(255, 255, 255, 0.1); /* very light transparent white */
            border-radius: 8px;
        }
        .tours-card .description::-webkit-scrollbar-thumb {
            background-color: #888;
            border-radius: 8px;
        }
        .tours-card .description::-webkit-scrollbar-thumb:hover {
            background-color: #555;
        }

        .sidebar.open {
            left: 0;
        }
        .register-button {
            display: inline-block;
            padding: 8px 16px;
            background-color: #ff5722;
            color: white;
            border-radius: 20px;
            font-weight: bold;
            text-transform: uppercase;
            cursor: pointer;
            transition: background-color 0.3s ease, transform 0.3s ease;
            text-decoration: none;
        }
        .register-button:hover {
            background-color: #f44336;
            transform: scale(1.05);
        }
        .flash {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background-color: #4CAF50;
            color: white;
            padding: 20px;
            border-radius: 8px;
            font-size: 18px;
            z-index: 1000;
            text-align: center;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            opacity: 0;
            animation: fadeIn 2s forwards;
        }
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }
    </style>
</head>
<body>

    <!-- Flash message -->
    <?php if (isset($_SESSION['message'])): ?>
        <div class="flash">
            <?= htmlspecialchars($_SESSION['message']); ?>
        </div>
        <?php unset($_SESSION['message']); ?>
    <?php endif; ?>

    <!-- The 3 dots button -->
    <div class="dots-button" onclick="toggleSidebar()">&#x22EE;</div>

    <!-- The sidebar -->
    <div id="mySidebar" class="sidebar">
        <a href="javascript:void(0)" class="closebtn" onclick="closeSidebar()">&times;</a>
        <a href="admin/login.php">admin</a>
        <a href="user/user_feedback.php">Feedback</a>
        <a href="user/reciept.php">Receipt</a><br>
        <h2>Contact</h2>
        <h3>[+1-800-123-4567]</h3>
    </div>

    <!-- Main content -->
    <main>
        <div class="tours-list">
            <?php if (!empty($tours)): ?>
                <?php foreach ($tours as $tour): ?>
                    <div class="tours-card">
                        <img src="uploads/<?= htmlspecialchars($tour['image_path']) ?>" alt="<?= htmlspecialchars($tour['name']) ?>">
                        <h3><?= htmlspecialchars($tour['name']) ?></h3>
                        <div class="description">
                            <p><?= htmlspecialchars($tour['description']) ?></p>
                        </div>
                        <p><strong>Location:</strong> <?= htmlspecialchars($tour['location']) ?></p>
                        <p><strong>Per Person:</strong> ₹<?= htmlspecialchars($tour['price']) ?></p>
                        <p><strong>Days:</strong> <?= htmlspecialchars($tour['days']) ?></p>
                        <a href="user/register.php?tour_id=<?= urlencode($tour['id']) ?>" class="register-button">Register</a>

                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p style="color: white;">No tours found.</p>
            <?php endif; ?>
        </div>
    </main>

    <script>
        function toggleSidebar() {
            document.getElementById("mySidebar").classList.toggle("open");
        }
        function closeSidebar() {
            document.getElementById("mySidebar").classList.remove("open");
        }
    </script>
</body>
</html>
