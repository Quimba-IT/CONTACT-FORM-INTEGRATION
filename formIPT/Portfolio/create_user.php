<?php
require 'config.php';

$username = '123';
$password = '123';
$hashed_password = password_hash($password, PASSWORD_DEFAULT);

$stmt = $pdo->prepare("INSERT INTO user (username, password) VALUES (?, ?)");
$stmt->execute([$username]);
$user = $stmt->fetch();

if ($user) {
    echo "User already exists!";
} else {
    $stmt = $pdo->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
    if ($stmt->execute([$username, $hashed_password])) {
        echo "User created successfully!";
    } else {
        echo "Failed to create user!";
    }
}
