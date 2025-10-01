<?php
session_start();
include('config.php');

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}

if (isset($_GET['delete_id'])) {
    $delete_id = intval($_GET['delete_id']);
    $stmt = $conn->prepare("DELETE FROM email WHERE id = ?");
    $stmt->bind_param("i", $delete_id);
    $stmt->execute();
    $stmt->close();
    header("Location: dashboard.php");
    exit;
}

$stmt = $conn->prepare("
    SELECT id, name, subject, recipient_email, messages, created_at 
    FROM email 
    ORDER BY created_at DESC
");
$stmt->execute();
$result = $stmt->get_result();
?>

<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>Dashboard</title>
<link rel="stylesheet" href="style.css">
<style>
body { margin:0; font-family: Arial, sans-serif; background:#ecf0f1; }
.dashboard-wrapper { display: flex; min-height: 100vh; }
.sidebar { width: 220px; background: #2c3e50; color: #fff; padding: 20px; }
.sidebar h2 { font-size: 18px; margin-bottom: 20px; }
.sidebar ul { list-style: none; padding: 0; }
.sidebar ul li { margin: 10px 0; }
.sidebar ul li a { color: #fff; text-decoration: none; }
.sidebar ul li a.active { font-weight: bold; }
.main-content { flex: 1; padding: 20px; }
h1, h2 { color: #2c3e50; }
table { width: 100%; border-collapse: collapse; margin-top: 20px; background:#fff; }
table, th, td { border: 1px solid #bdc3c7; }
th, td { padding: 10px; text-align: left; }
th { background: #34495e; color: #fff; }
.success-message { color: green; font-weight: bold; margin-bottom: 15px; }
.delete-btn { background: #f87171; color: #fff; padding: 4px 8px; border: none; border-radius: 4px; cursor: pointer; text-decoration: none; }
.delete-btn:hover { background: #dc2626; }
</style>
</head>
<body>
<div class="dashboard-wrapper">
    <div class="sidebar">
        <h2>Welcome, <?= htmlspecialchars($_SESSION['username']) ?></h2>
        <ul>
            <li><a href="dashboard.php" class="active">Home</a></li>
            <li><a href="logout.php">Logout</a></li>
        </ul>
    </div>
    <div class="main-content">
        <h1>Dashboard</h1>
        <p class="success-message">You have successfully logged in, <?= htmlspecialchars($_SESSION['username']) ?>!</p>

        <h2>Contact Form Submissions</h2>
        <?php if ($result->num_rows > 0): ?>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Subject</th>
                    <th>Email</th>
                    <th>Message</th>
                    <th>Submitted At</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?= $row['id'] ?></td>
                    <td><?= htmlspecialchars($row['name']) ?></td>
                    <td><?= htmlspecialchars($row['subject']) ?></td>
                    <td><?= htmlspecialchars($row['recipient_email']) ?></td>
                    <td><?= htmlspecialchars($row['messages']) ?></td>
                    <td><?= $row['created_at'] ?></td>
                    <td>
                        <a href="dashboard.php?delete_id=<?= $row['id'] ?>" class="delete-btn" onclick="return confirm('Are you sure you want to delete this message?');">Delete</a>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
        <?php else: ?>
            <p>No contact form submissions yet.</p>
        <?php endif; ?>
    </div>
</div>
</body>
</html>
