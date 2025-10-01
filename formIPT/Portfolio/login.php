<?php
session_start();
include('config.php');

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = trim($_POST['password'] ?? '');

    if ($username === '') $errors['username'] = 'Username is required.';
    if ($password === '') $errors['password'] = 'Password is required.';

    if (empty($errors)) {
        $stmt = $conn->prepare("SELECT username FROM login WHERE username = ? AND password = ?");
        if ($stmt) {
            $stmt->bind_param("ss", $username, $password);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result && $result->num_rows === 1) {
                $row = $result->fetch_assoc();
                $_SESSION['username'] = $row['username'];

                echo '<script>
                        alert("Login successful! Welcome '.$row['username'].'");
                        window.location.href = "dashboard.php";
                      </script>';
                exit;
            } else {
                echo '<script>
                        alert("Login failed! Invalid username or password.");
                        window.location.href = "login.php";
                      </script>';
                exit;
            }
            $stmt->close();
        } else {
            echo '<script>
                    alert("Database error: '.$conn->error.'");
                    window.location.href = "login.php";
                  </script>';
            exit;
        }
    }
}
?>

<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<title>Login</title>
<style>
body { font-family: Arial; background:#f4f4f4; display:flex; justify-content:center; padding-top:50px; }
.container { background:#fff; padding:20px; border-radius:5px; box-shadow:0 0 10px rgba(0,0,0,0.1); width:300px; }
.form-group { margin-bottom:15px; }
input { width:100%; padding:8px; box-sizing:border-box; }
button { width:100%; padding:10px; background:#007BFF; color:#fff; border:none; cursor:pointer; }
button:hover { background:#0056b3; }
</style>
</head>
<body>
<div class="container">
    <h2>Login</h2>
    <form method="post" action="">
        <div class="form-group">
            <label>Username</label>
            <input type="text" name="username" required value="<?= htmlspecialchars($_POST['username'] ?? '') ?>">
        </div>
        <div class="form-group">
            <label>Password</label>
            <input type="password" name="password" required>
        </div>
        <button type="submit">Login</button>
    </form>
</div>
</body>
</html>
