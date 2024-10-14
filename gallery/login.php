<?php
session_start();
$error_message = "";
if (isset($_SESSION['error'])) {
    $error_message = $_SESSION['error'];
    unset($_SESSION['error']);  // Hapus error setelah ditampilkan
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <div class="left-panel">
            <h1>Horizon Gallery</h1>
        </div>
        <div class="right-panel">
            <form action="proses_login.php" method="post">
                <h2>Login</h2>
                
                <!-- Pesan Error -->
                <?php if ($error_message): ?>
                    <div class="error-message"><?= $error_message ?></div>
                <?php endif; ?>

                <label for="username">Username</label>
                <input type="text" id="username" name="username" placeholder="Username" required>

                <label for="password">Password</label>
                <input type="password" id="password" name="password" placeholder="Password" required>

                <div class="buttons">
                    <input type="submit" value="Login">
                    <a href="register.php" class="btn-signup">Sign up</a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
