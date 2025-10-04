<?php
require_once "config/db.php"; 

$username = "admin";
$password_plain = "1234";


$hashed_password = password_hash($password_plain, PASSWORD_DEFAULT);

$conn->query("DELETE FROM admins");


$stmt = $conn->prepare("INSERT INTO admins (username, password) VALUES (?, ?)");
$stmt->bind_param("ss", $username, $hashed_password);

if ($stmt->execute()) {
    echo "Admin created successfully.<br>";
    echo "Username: $username<br>";
    echo "Password: $password_plain<br>";
    echo "Hashed password: $hashed_password";
} else {
    echo " Error: " . $stmt->error;
}
?>
