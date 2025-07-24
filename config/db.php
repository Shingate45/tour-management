<?php
$servername = "localhost";
$username = "root"; // Change if needed
$password = "sahil@27";     // Change if needed
$dbname = "travels"; // Your DB name

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
