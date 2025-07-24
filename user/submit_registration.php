<?php
include('../config/db.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $tour_id = intval($_POST['tour_id']);
    $tour_name = $conn->real_escape_string($_POST['tour_name']);
    $name = $conn->real_escape_string($_POST['name']);
    $email = $conn->real_escape_string($_POST['email']);
    $phone = $conn->real_escape_string($_POST['phone']);
    $total_persons = intval($_POST['total_persons']);
    $price = floatval($_POST['price']); // per person price

    $stmt = $conn->prepare("INSERT INTO registrations (tour_id, tour_name, name, email, phone, total_persons, price) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("issssii", $tour_id, $tour_name, $name, $email, $phone, $total_persons, $price);

    if ($stmt->execute()) {
        echo "Registration successful!";
        // Redirect or show message
    } else {
        echo "Error: " . $stmt->error;
    }
}
?>
