<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <div class="left-panel">
            <h1>Horizon Gallery</h1>
            <p>Join us by creating an account.</p>
        </div>
        <div class="right-panel">
            <form action="proses_register.php" method="post">
                <h2>Register</h2>

                <label for="username">Username</label>
                <input type="text" id="username" name="username" placeholder="Enter your username" required>

                <label for="password">Password</label>
                <input type="password" id="password" name="password" placeholder="Enter your password" required>

                <label for="email">Email</label>
                <input type="email" id="email" name="email" placeholder="name@mail.com" required>

                <label for="fullname">Full Name</label>
                <input type="text" id="fullname" name="namalengkap" placeholder="Enter your full name" required>

                <label for="address">Address</label>
                <input type="text" id="address" name="alamat" placeholder="Enter your address" required>

                <label for="level">User Level</label>
                <select id="role" name="role" required>
                    <option value="" disabled selected>Select your level</option>
                    <option value="admin">Admin</option>
                    <option value="user">User</option>
                </select>

                <div class="buttons">
                    <input type="submit" value="Register">
                    <a href="login.php" class="btn-signup">Login</a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
