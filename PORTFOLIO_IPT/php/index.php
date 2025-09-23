<?php
// index.php
session_start();

// If previous form input/errors exist, retrieve them
$old = $_SESSION['old'] ?? [];
$errors = $_SESSION['errors'] ?? [];
$flash = $_SESSION['flash'] ?? null;

// clear flashes so they appear only once
unset($_SESSION['errors'], $_SESSION['old'], $_SESSION['flash']);
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <title>Contact - Quimba Portfolio</title>
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <link rel="stylesheet" href="css/style.css">
</head>
<body>
  <main class="container">
    <h1>Contact</h1>
    <?php if($flash): ?>
      <script>
        // display JS alert from flash (success or error)
        alert(<?= json_encode($flash) ?>);
      </script>
    <?php endif; ?>

    <form id="contactForm" action="EmailController.php" method="post" novalidate>
      <input type="hidden" name="action" value="submit">
      <div class="form-row">
        <label for="name">Name <span class="required">*</span></label>
        <input id="name" name="name" type="text" required value="<?= htmlspecialchars($old['name'] ?? '') ?>">
        <?php if(!empty($errors['name'])): ?><div class="error"><?= htmlspecialchars($errors['name']) ?></div><?php endif; ?>
      </div>

      <div class="form-row">
        <label for="subject">Subject <span class="required">*</span></label>
        <input id="subject" name="subject" type="text" required value="<?= htmlspecialchars($old['subject'] ?? '') ?>">
        <?php if(!empty($errors['subject'])): ?><div class="error"><?= htmlspecialchars($errors['subject']) ?></div><?php endif; ?>
      </div>

      <div class="form-row">
        <label for="email">Email <span class="required">*</span></label>
        <input id="email" name="email" type="email" required value="<?= htmlspecialchars($old['email'] ?? '') ?>">
        <?php if(!empty($errors['email'])): ?><div class="error"><?= htmlspecialchars($errors['email']) ?></div><?php endif; ?>
      </div>

      <div class="form-row">
        <label for="message">Message <span class="required">*</span></label>
        <textarea id="message" name="message" rows="5" maxlength="150" required><?= htmlspecialchars($old['message'] ?? '') ?></textarea>
        <small id="charCount">0 / 150</small>
        <?php if(!empty($errors['message'])): ?><div class="error"><?= htmlspecialchars($errors['message']) ?></div><?php endif; ?>
      </div>

      <div class="form-row">
        <button type="submit">Send Message</button>
      </div>
    </form>
  </main>

  <script src="javascript/script.js"></script>
  <script>
    // initialize char counter using existing textarea content
    document.addEventListener('DOMContentLoaded', function() {
      const ta = document.getElementById('message');
      const c = document.getElementById('charCount');
      c.textContent = ta.value.length + ' / 150';
    });
  </script>
</body>
</html>
