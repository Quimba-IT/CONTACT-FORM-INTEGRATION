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

    if ($name === '') $errors['name'] = 'Name is required.';
    if ($subject === '') $errors['subject'] = 'Subject is required.';
    if ($email === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) $errors['email'] = 'Valid email is required.';
    if ($message === '') $errors['message'] = 'Message is required.';
    if (strlen($message) > 150) $errors['message'] = 'Message cannot exceed 150 characters.';

    if (empty($errors)) {
        try {
            $stmt = $pdo->prepare("INSERT INTO email (name, subject, recipient_email, messages, sent_at) VALUES (?, ?, ?, ?, NOW())");
            $stmt->execute([$name, $subject, $email, $message]);
            $flash = ['type' => 'success', 'msg' => 'Your message has been successfully sent!'];
            $_POST = [];
        } catch (Exception $e) {
            $flash = ['type' => 'error', 'msg' => 'Error! Please try again.'];
        }
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
  <style>
    body {
      font-family: Arial, sans-serif;
      background: #f5f7fa;
      margin: 0;
      padding: 0;
      display: flex;
      justify-content: center;
      align-items: center;
      min-height: 100vh;
    }
    .container {
      background: #fff;
      padding: 2rem;
      border-radius: 12px;
      box-shadow: 0 4px 12px rgba(0,0,0,0.1);
      width: 100%;
      max-width: 500px;
    }
    h1 {
      text-align: center;
      margin-bottom: 1.5rem;
    }
    form label {
      display: block;
      margin-bottom: .5rem;
      font-weight: bold;
    }
    form input, form textarea {
      width: 100%;
      padding: .75rem;
      margin-bottom: 1rem;
      border: 1px solid #ccc;
      border-radius: 8px;
      font-size: 1rem;
    }
    form textarea {
      resize: none;
      height: 120px;
    }
    .error {
      color: #c00;
      font-size: .9rem;
      margin-top: -0.75rem;
      margin-bottom: 1rem;
    }
    .flash.success {
      background: #e6ffed;
      border: 1px solid #34d399;
      color: #065f46;
      padding: 1rem;
      border-radius: 8px;
      margin-bottom: 1rem;
    }
    .flash.error {
      background: #fee2e2;
      border: 1px solid #f87171;
      color: #7f1d1d;
      padding: 1rem;
      border-radius: 8px;
      margin-bottom: 1rem;
    }
    button {
      width: 100%;
      padding: .75rem;
      border: none;
      border-radius: 8px;
      font-size: 1rem;
      font-weight: bold;
      cursor: pointer;
      background: #2563eb;
      color: #fff;
      transition: background .3s ease;
    }
    button:hover {
      background: #1d4ed8;
    }
  </style>
</head>
<body>
<main class="container">
  <h1>Contact Us</h1>

  <?php if ($flash): ?>
    <div class="flash <?= e($flash['type']) ?>">
      <?= nl2br(e($flash['msg'])) ?>
    </div>
  <?php endif; ?>

  <form method="post" action="">
    <label for="name">Name</label>
    <input id="name" type="text" name="name" required value="<?= e($_POST['name'] ?? '') ?>">
    <?php if (!empty($errors['name'])): ?>
      <div class="error"><?= e($errors['name']) ?></div>
    <?php endif; ?>

    <label for="email">Email</label>
    <input id="email" type="email" name="email" required value="<?= e($_POST['email'] ?? '') ?>">
    <?php if (!empty($errors['email'])): ?>
      <div class="error"><?= e($errors['email']) ?></div>
    <?php endif; ?>

    <label for="subject">Subject</label>
    <input id="subject" type="text" name="subject" required value="<?= e($_POST['subject'] ?? '') ?>">
    <?php if (!empty($errors['subject'])): ?>
      <div class="error"><?= e($errors['subject']) ?></div>
    <?php endif; ?>

    <label for="message">Message</label>
    <textarea id="message" name="message" maxlength="150" required><?= e($_POST['message'] ?? '') ?></textarea>
    <?php if (!empty($errors['message'])): ?>
      <div class="error"><?= e($errors['message']) ?></div>
    <?php endif; ?>

    <button type="submit">Send Message</button>
  </form>
</main>
</body>
</html>
