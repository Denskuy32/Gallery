<?php
include "koneksi.php";
session_start();

$username = $_POST['username'];
$password = $_POST['password'];

// Cek apakah username dan password sesuai di database
$sql = mysqli_query($conn, "SELECT * FROM user WHERE username='$username' AND password='$password'");

$cek = mysqli_num_rows($sql);

if ($cek == 1) {
    // Ambil data user termasuk role-nya
    while ($data = mysqli_fetch_array($sql)) {
        $_SESSION['loggedin'] = true;
        $_SESSION['userid'] = $data['userid'];
        $_SESSION['namalengkap'] = $data['namalengkap'];
        $_SESSION['role'] = $data['role']; // Simpan role (misalnya: admin atau user)
    }

    // Redirect ke halaman utama
    header("location:home.php");
} else {
    // Set pesan error di session jika login gagal
    $_SESSION['error'] = "Username atau password salah!";
    header("location:login.php");
}
?>
