<?php
// EmailController.php
session_start();
require_once 'config.php';

// convenience: sanitize input
function val($key) {
    return trim($_POST[$key] ?? '');
}

// route by action
$action = $_POST['action'] ?? $_GET['action'] ?? '';

if ($action === 'submit' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = val('name');
    $subject = val('subject');
    $email = val('email');
    $message = val('message');

    $errors = [];
    // Validation rules
    if ($name === '') $errors['name'] = 'Name is required.';
    if ($subject === '') $errors['subject'] = 'Subject is required.';
    if ($email === '') {
        $errors['email'] = 'Email is required.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = 'Enter a valid email address.';
    }

    if ($message === '') {
        $errors['message'] = 'Message is required.';
    } elseif (mb_strlen($message) > 150) {
        $errors['message'] = 'Message cannot exceed 150 characters.';
    }

    // Persist old values so user doesn't retype
    $_SESSION['old'] = ['name'=>$name,'subject'=>$subject,'email'=>$email,'message'=>$message];

    if (!empty($errors)) {
        $_SESSION['errors'] = $errors;
        header('Location: index.php');
        exit;
    }

    // Insert into database `email`
    try {
        $stmt = $pdo->prepare("INSERT INTO `email1` (name, subject, recipient_email, messages, sent_at, created_at) 
                       VALUES (:name, :subject, :recipient_email, :messages, NULL, NOW())");

        // recipient_email: we will store the sender email in recipient_email column as requested by table header.
        $stmt->execute([
            ':name' => $name,
            ':subject' => $subject,
            ':recipient_email' => $email,
            ':messages' => $message
        ]);
        // success
        unset($_SESSION['old'], $_SESSION['errors']);
        $_SESSION['flash'] = "Your message has been successfully sent!";
        header('Location: index.php');
        exit;
    } catch (Exception $e) {
        // log $e in real app
        $_SESSION['flash'] = "Error! Please try again.";
        header('Location: index.php');
        exit;
    }

} elseif ($action === 'delete' && isset($_POST['id'])) {
    // Admin deletes message
    $id = (int)$_POST['id'];
    try {
       $stmt = $pdo->prepare("DELETE FROM `email1` WHERE Id = :id");
        $stmt->execute([':id' => $id]);
        $_SESSION['flash'] = "Message deleted.";
    } catch (Exception $e) {
        $_SESSION['flash'] = "Error deleting message.";
    }
    header('Location: dashboard.php');
    exit;
} else {
    // Unknown action
    http_response_code(400);
    echo "Bad request.";
    exit;
}
