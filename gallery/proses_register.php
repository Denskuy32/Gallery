<?php
    include "koneksi.php";

    // Ambil data dari form
    $username = $_POST['username'];
    $password = $_POST['password'];
    $email = $_POST['email'];
    $namalengkap = $_POST['namalengkap'];
    $alamat = $_POST['alamat'];
    $level = $_POST['role'];

    // Cek apakah username sudah terdaftar
    $check_user = mysqli_query($conn, "SELECT * FROM user WHERE username = '$username'");
    
    // Cek apakah email sudah terdaftar
    $check_email = mysqli_query($conn, "SELECT * FROM user WHERE email = '$email'");

    if (mysqli_num_rows($check_user) > 0) {
        // Jika username sudah ada, tampilkan pesan error dan kembali ke halaman register
        echo "<script>
            alert('Username sudah digunakan, silakan gunakan yang lain.');
            window.location.href = 'register.php';
        </script>";
    } elseif (mysqli_num_rows($check_email) > 0) {
        // Jika email sudah ada, tampilkan pesan error dan kembali ke halaman register
        echo "<script>
            alert('Email sudah digunakan, silakan gunakan email lain.');
            window.location.href = 'register.php';
        </script>";
    } else {
        // Coba simpan data jika username dan email belum ada
        $sql = mysqli_query($conn, "INSERT INTO user (userid, username, password, email, namalengkap, alamat, role) 
                                    VALUES ('', '$username', '$password', '$email', '$namalengkap', '$alamat', '$level')");

        if ($sql) {
            // Jika berhasil, arahkan ke halaman login
            header("Location: login.php");
        } else {
            // Jika gagal, tampilkan pesan error umum
            echo "<script>
                alert('Gagal mendaftarkan akun, silakan coba lagi.');
                window.location.href = 'register.php';
            </script>";
        }
    }
?>
