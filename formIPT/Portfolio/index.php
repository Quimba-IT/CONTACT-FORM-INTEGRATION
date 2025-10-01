<?php
session_start();
require 'config.php';

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
        $stmt = $conn->prepare("INSERT INTO email (name, subject, recipient_email, messages, sent_at) VALUES (?, ?, ?, ?, NOW())");
        if ($stmt) {
            $stmt->bind_param("ssss", $name, $subject, $email, $message);
            if ($stmt->execute()) {
                $flash = ['type' => 'success', 'msg' => 'Your message has been successfully sent!'];
                $_POST = [];
            } else {
                $flash = ['type' => 'error', 'msg' => 'Database error! Please try again.'];
            }
            $stmt->close();
        } else {
            $flash = ['type' => 'error', 'msg' => 'Database error: '.$conn->error];
        }
    }
}

function e($val) { return htmlspecialchars($val ?? '', ENT_QUOTES); }
?>

<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<title>My Portfolio Website</title>
<link rel="stylesheet" href="style.css">
<style>
* { box-sizing:border-box; margin:0; padding:0; }
body { font-family: Arial, sans-serif; background:#f5f7fa; line-height:1.6; }
header { background:#2563eb; color:#fff; padding:1rem 2rem; position:sticky; top:0; }
header nav { display:flex; justify-content:space-between; align-items:center; }
header nav a { color:#fff; margin-left:1.5rem; text-decoration:none; font-weight:bold; }
header nav a:hover { text-decoration:underline; }
.hero { padding:4rem 2rem; text-align:center; background:#1e3a8a; color:#fff; }
.hero h1 { font-size:2.5rem; margin-bottom:1rem; }
.hero p { font-size:1.2rem; max-width:600px; margin:0 auto; }
section { padding:4rem 2rem; max-width:1000px; margin:auto; }
section h2 { font-size:2rem; margin-bottom:1rem; text-align:center; }
.about, .projects, .contact { background:#fff; margin-bottom:2rem; border-radius:12px; padding:2rem; box-shadow:0 4px 12px rgba(0,0,0,0.05); }
form label { display:block; margin-bottom:.5rem; font-weight:bold; }
form input, form textarea { width:100%; padding:.75rem; margin-bottom:1rem; border:1px solid #ccc; border-radius:8px; font-size:1rem; }
form textarea { resize:none; height:120px; }
.error { color:#c00; font-size:.9rem; margin:-0.5rem 0 1rem 0; }
.flash.success { background:#e6ffed; border:1px solid #34d399; color:#065f46; padding:1rem; border-radius:8px; margin-bottom:1rem; }
.flash.error { background:#fee2e2; border:1px solid #f87171; color:#7f1d1d; padding:1rem; border-radius:8px; margin-bottom:1rem; }
button { width:100%; padding:.75rem; border:none; border-radius:8px; font-size:1rem; font-weight:bold; cursor:pointer; background:#2563eb; color:#fff; transition:background .3s ease; }
button:hover { background:#1d4ed8; }
footer { text-align:center; padding:1.5rem; background:#1e293b; color:#fff; margin-top:2rem; }

/* Projects styling */
.project-cards { display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 1.5rem; margin-top: 2rem; }
.project-card { background: #fff; border-radius: 12px; padding: 1rem; box-shadow: 0 4px 12px rgba(0,0,0,0.05); text-align: center; transition: transform 0.3s ease, box-shadow 0.3s ease; }
.project-card img { max-width: 100%; border-radius: 8px; margin-bottom: 1rem; }
.project-card h3 { margin-bottom: 0.5rem; color: #1e3a8a; }
.project-card p { font-size: 0.95rem; color: #333; margin-bottom: 1rem; }
.project-card a { display: inline-block; padding: 0.5rem 1rem; background: #2563eb; color: #fff; border-radius: 6px; text-decoration: none; transition: background 0.3s ease; }
.project-card a:hover { background: #1d4ed8; }
.project-card:hover { transform: translateY(-5px); box-shadow: 0 8px 20px rgba(0,0,0,0.1); }
</style>
</head>
<body>

<header>
  <nav>
    <div class="logo">MyPortfolio</div>
    <div>
      <a href="#about">About</a>
      <a href="#projects">Projects</a>
      <a href="#contact">Contact</a>
      <a href="login.php" class="login-btn">Login</a>
    </div>
  </nav>
</header>

<section class="hero">
  <h1>Welcome to My Portfolio</h1>
  <p>This is my portfolio website. Scroll down to see my work and contact me.</p>
</section>

<section id="about">
  <div class="about">
    <h2>About Me</h2>
    <p>Hi! I'm <strong>Noel Ivan Quimba</strong>, passionate about programming and web development. I love creating dynamic and user-friendly websites.</p>
  </div>
</section>

<section id="projects">
  <div class="projects">
    <h2>Projects</h2>
    <div class="project-cards">
      <div class="project-card">
        <img src="https://scontent.fdvo3-1.fna.fbcdn.net/v/t39.30808-6/557163800_778710075134898_4305253282335029623_n.jpg?_nc_cat=100&ccb=1-7&_nc_sid=127cfc&_nc_ohc=CRyskL3TK7kQ7kNvwHoXAyL&_nc_oc=AdknLRV1BzOPCEeQD3I82NE5ot-krNJY1_4VXqhwYJ3jap_kDzaMl6Ef1L3Y7yFnbWY&_nc_zt=23&_nc_ht=scontent.fdvo3-1.fna&_nc_gid=UHc4KG3t8xZhSljXQaUTjQ&oh=00_AfYuoPLRynnxTGp4D9vpTqhU3pMayR10kkCa2JPcOnQ4NA&oe=68E3012E" alt="Portfolio Website">
        <h3>Portfolio Website</h3>
        <p>A responsive personal portfolio website built with HTML, CSS, and PHP.</p>
        <a href="https://github.com/Quimba-IT/" target="_blank">View Project</a>
      </div>
      <div class="project-card">
        <img src="https://scontent.fdvo3-1.fna.fbcdn.net/v/t39.30808-6/557085685_778710071801565_7731627646650061473_n.jpg?_nc_cat=104&ccb=1-7&_nc_sid=127cfc&_nc_ohc=vpKN8Y4x2vMQ7kNvwFLELyW&_nc_oc=AdlcP6qjDa6rbqh1ZpCc3ZJxrab-cCqrDRNGIvMsMO_CKZWRfA4a51k-ftbxLC6Rc5c&_nc_zt=23&_nc_ht=scontent.fdvo3-1.fna&_nc_gid=GZ8gK6Tyt-7U-_lza6TcRg&oh=00_AfaDcHuG2xJlh6gP1MNF4BS0mm1mBPPKgddhCdL9PxnLEw&oe=68E2F100" alt="Task Manager App">
        <h3>Task Manager App</h3>
        <p>A PHP & MySQL-based task manager with login and CRUD functionality.</p>
        <a href="https://github.com/Quimba-IT/" target="_blank">View Project</a>
      </div>
      <div class="project-card">
        <img src="https://scontent.fdvo3-1.fna.fbcdn.net/v/t39.30808-6/556087123_778710078468231_2033407389187780071_n.jpg?_nc_cat=110&ccb=1-7&_nc_sid=127cfc&_nc_ohc=I2NOXheJycUQ7kNvwHoOitS&_nc_oc=AdmFynDO0SoQNAF43N41_RGS9RSUUXNMFuYWm4jFxJAmuzvOZAw8wz2erZx2xglIMAU&_nc_zt=23&_nc_ht=scontent.fdvo3-1.fna&_nc_gid=jQ1CLQXnvSlF2yc81fTm0g&oh=00_AfYaax7sMVHkhtu9rtFX5Pe7qznRM_m3XDeycQk0x-0wwg&oe=68E2F6BD" alt="Blog System">
        <h3>Blog System</h3>
        <p>A simple blog system with user registration, posting, and commenting features.</p>
        <a href="https://github.com/Quimba-IT/" target="_blank">View Project</a>
      </div>
    </div>
  </div>
</section>

<section id="contact">
  <div class="contact">
    <h2>Contact Me</h2>

    <?php if ($flash): ?>
      <div class="flash <?= e($flash['type']) ?>">
        <?= nl2br(e($flash['msg'])) ?>
      </div>
    <?php endif; ?>

    <form method="post" action="">
      <label for="name">Name</label>
      <input id="name" type="text" name="name" required value="<?= e($_POST['name'] ?? '') ?>">
      <?php if (!empty($errors['name'])): ?><div class="error"><?= e($errors['name']) ?></div><?php endif; ?>

      <label for="email">Email</label>
      <input id="email" type="email" name="email" required value="<?= e($_POST['email'] ?? '') ?>">
      <?php if (!empty($errors['email'])): ?><div class="error"><?= e($errors['email']) ?></div><?php endif; ?>

      <label for="subject">Subject</label>
      <input id="subject" type="text" name="subject" required value="<?= e($_POST['subject'] ?? '') ?>">
      <?php if (!empty($errors['subject'])): ?><div class="error"><?= e($errors['subject']) ?></div><?php endif; ?>

      <label for="message">Message</label>
      <textarea id="message" name="message" maxlength="150" required><?= e($_POST['message'] ?? '') ?></textarea>
      <?php if (!empty($errors['message'])): ?><div class="error"><?= e($errors['message']) ?></div><?php endif; ?>

      <button type="submit">Send Message</button>
    </form>
  </div>
</section>

<footer>
  <p>&copy; <?= date("Y") ?> MyPortfolio. All rights reserved.</p>
</footer>

</body>
</html>
