<?php
    session_start();
    if (!isset($_SESSION['userid'])) {
        header("location:login.php");
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Halaman Edit Foto</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
       <!-- Navbar -->
       <nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm">
        <div class="container">
            <a class="navbar-brand" href="home.php">Horizon Gallery</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="home.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="album.php">Album</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="foto2.php">Upload</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="logout.php">Logout</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    
    <div class="container mt-5">
        <h1 class="mb-4">Halaman Edit Foto</h1>
        <p>Selamat datang <b><?=$_SESSION['namalengkap']?></b></p>

        <form action="update_foto2.php" method="post" enctype="multipart/form-data">
            <?php
                include "koneksi.php";
                $fotoid = $_GET['fotoid'];
                $sql = mysqli_query($conn, "SELECT * FROM foto WHERE fotoid='$fotoid'");
                while ($data = mysqli_fetch_array($sql)) {
            ?>
            <input type="text" name="fotoid" value="<?=$data['fotoid']?>" hidden>
            <div class="mb-3">
                <label for="judulfoto" class="form-label">Judul</label>
                <input type="text" name="judulfoto" id="judulfoto" class="form-control" value="<?=$data['judulfoto']?>">
            </div>
            <div class="mb-3">
                <label for="deskripsifoto" class="form-label">Deskripsi</label>
                <input type="text" name="deskripsifoto" id="deskripsifoto" class="form-control" value="<?=$data['deskripsifoto']?>">
            </div>
            <div class="mb-3">
                <label for="lokasifile" class="form-label">Lokasi File</label>
                <input type="file" name="lokasifile" id="lokasifile" class="form-control">
            </div>
            <div class="mb-3">
                <label for="albumid" class="form-label">Album</label>
                <select name="albumid" id="albumid" class="form-select">
                <?php
                    // Ambil semua album dari semua pengguna
                    $sql2 = mysqli_query($conn, "SELECT * FROM album");
                    while ($data2 = mysqli_fetch_array($sql2)) {
                ?>
                    <option value="<?=$data2['albumid']?>" <?php if ($data2['albumid'] == $data['albumid']) { echo 'selected'; }?>><?=$data2['namaalbum']?></option>
                <?php
                    }
                ?>
                </select>
            </div>
            <button type="submit" class="btn btn-warning">Ubah</button>
            <?php
                }
            ?>
        </form>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
