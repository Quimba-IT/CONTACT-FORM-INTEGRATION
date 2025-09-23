<?php
// dashboard.php
session_start();
require_once 'config.php';

$flash = $_SESSION['flash'] ?? null;
unset($_SESSION['flash']);

// fetch messages ordered newest first
$stmt = $pdo->query("SELECT Id, name, subject, messages, recipient_email, created_at FROM `email1` ORDER BY created_at DESC");
$messages = $stmt->fetchAll();
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <title>Dashboard - Quimba Portfolio</title>
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <link rel="stylesheet" href="css/style.css">
</head>
<body>
  <div class="dashboard">
    <aside class="sidebar">
      <h2>Menu</h2>
      <ul>
        <li><a href="dashboard.php">Email</a></li>
        <li><a href="index.php" target="_blank">Go to Site</a></li>
      </ul>
    </aside>

    <main class="main-content">
      <h1>Messages</h1>

      <?php if($flash): ?>
        <script> alert(<?= json_encode($flash) ?>); </script>
      <?php endif; ?>

      <?php if(empty($messages)): ?>
        <p>No messages found.</p>
      <?php else: ?>
        <table class="msg-table">
          <thead>
            <tr>
              <th>Name</th>
              <th>Subject</th>
              <th>Message</th>
              <th>Date Submitted</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach($messages as $m): ?>
            <tr>
              <td><?= htmlspecialchars($m['name']) ?></td>
              <td><?= htmlspecialchars($m['subject']) ?></td>
              <td><?= htmlspecialchars(mb_strimwidth($m['messages'], 0, 60, '...')) ?></td>
              <td><?= htmlspecialchars($m['created_at']) ?></td>
              <td>
                <a href="dashboard.php?view=<?= $m['Id'] ?>">View</a>
                <form method="post" action="EmailController.php" style="display:inline" onsubmit="return confirmDelete();">
                  <input type="hidden" name="action" value="delete">
                  <input type="hidden" name="id" value="<?= $m['Id'] ?>">
                  <button type="submit">Delete</button>
                </form>
              </td>
            </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      <?php endif; ?>

      <?php
      // View single message if ?view=ID
      if (isset($_GET['view'])):
        $id = (int)$_GET['view'];
       $st = $pdo->prepare("SELECT * FROM `email1` WHERE Id = :id LIMIT 1");
        $st->execute([':id'=>$id]);
        $msg = $st->fetch();
        if ($msg):
      ?>
        <section class="view-panel">
          <h2>View Message</h2>
          <p><strong>Name:</strong> <?= htmlspecialchars($msg['name']) ?></p>
          <p><strong>Subject:</strong> <?= htmlspecialchars($msg['subject']) ?></p>
          <p><strong>Email:</strong> <?= htmlspecialchars($msg['recipient_email']) ?></p>
          <p><strong>Message:</strong><br><?= nl2br(htmlspecialchars($msg['messages'])) ?></p>
          <p><strong>Submitted at:</strong> <?= htmlspecialchars($msg['created_at']) ?></p>
          <p><a href="dashboard.php">Back to list</a></p>
        </section>
      <?php
        else:
          echo "<p>Message not found.</p>";
        endif;
      endif;
      ?>
    </main>
  </div>

  <script>
    function confirmDelete() {
      return confirm("Are you sure you want to delete this message?");
    }
  </script>
</body>
</html>
