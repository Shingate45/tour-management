<?php
include('../config/db.php');

// Fetch all submitted users with tour price
$sql = "
    SELECT r.id, r.name, r.email, r.phone, r.total_persons, 
           t.name AS tour_name, t.price AS tour_price
    FROM registrations r
    JOIN tours t ON r.tour_id = t.id
    ORDER BY r.id DESC
";

$submitted_users = $conn->query($sql);
?>

<h2>All Tour Registrations</h2>
<style>
    body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f5f8fa;
            margin: 0;
            padding: 20px;
        }

        h2 {
            color: #2c3e50;
            text-align: center;
            margin-top: 20px;
        }

        table {
            width: 100%;
            max-width: 1100px;
            margin: 30px auto;
            border-collapse: collapse;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
            background-color: #ffffff;
            border-radius: 10px;
            overflow: hidden;
        }

        th, td {
            padding: 14px 16px;
            text-align: left;
            border-bottom: 1px solid #e0e0e0;
        }

        th {
            background-color: #007bff;
            color: white;
            font-size: 16px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        tr:hover {
            background-color: #eef6ff;
        }

        td {
            color: #333;
            font-size: 15px;
        }

</style>

<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Tour Name</th>
            <th>Name</th>
            <th>Email</th>
            <th>Phone</th>
            <th>Total Persons</th>
            <th>Per Person Price</th>
            <th>Total Expense</th>
        </tr>
    </thead>
    <tbody>
        <?php if ($submitted_users && $submitted_users->num_rows > 0): ?>
            <?php while ($row = $submitted_users->fetch_assoc()): ?>
                <?php
                    $per_person = $row['tour_price'];
                    $total_expense = $row['total_persons'] * $per_person;
                ?>
                <tr>
                    <td><?= $row['id'] ?></td>
                    <td><?= htmlspecialchars($row['tour_name']) ?></td>
                    <td><?= htmlspecialchars($row['name']) ?></td>
                    <td><?= htmlspecialchars($row['email']) ?></td>
                    <td><?= htmlspecialchars($row['phone']) ?></td>
                    <td><?= $row['total_persons'] ?></td>
                    <td>₹<?= number_format($per_person) ?></td>
                    <td>₹<?= number_format($total_expense) ?></td>
                </tr>
            <?php endwhile; ?>
        <?php else: ?>
            <tr><td colspan="8">No registrations found.</td></tr>
        <?php endif; ?>
    </tbody>
</table>
