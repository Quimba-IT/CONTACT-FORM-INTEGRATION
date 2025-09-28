<?php
require 'config.php';
session_start();


$errors = [];
$flash = null;


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
$name = trim($_POST['name'] ?? '');
$email = trim($_POST['email'] ?? '');
$subject = trim($_POST['subject'] ?? '');
$message = trim($_POST['message'] ?? '');


// Validation
if ($name === '') $errors[] = 'Name is required.';
if ($subject === '') $errors[] = 'Subject is required.';
if ($email === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = 'Valid email is required.';
if ($message === '') $errors[] = 'Message is required.';
if (strlen($message) > 150) $errors[] = 'Message cannot exceed 150 characters.';


if (empty($errors)) {
try {
$stmt = $pdo->prepare("INSERT INTO email (name, subject, recipient_email, messages) VALUES (?, ?, ?, ?)");
$stmt->execute([$name, $subject, $email, $message]);
$flash = ['type' => 'success', 'msg' => 'Your message has been successfully sent!'];
} catch (Exception $e) {
$flash = ['type' => 'error', 'msg' => 'Error! Please try again.'];
}
} else {
$flash = ['type' => 'error', 'msg' => implode("\\n", $errors)];
}
}


function e($val) { return htmlspecialchars($val ?? '', ENT_QUOTES); }
?>


<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Contact Form</title>
<link rel="stylesheet" href="style.css">
</head>
<body>
<main class="container">
<h1>Contact Us</h1>


<form method="post" action="">
<label>
Name
<input type="text" name="name" required value="<?= e($_POST['name'] ?? '') ?>">
</label>


<label>
Email
<input type="email" name="email" required value="<?= e($_POST['email'] ?? '') ?>">
</label>
</html>