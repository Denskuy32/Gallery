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
                        <a class="nav-link" href="album2.php">Album</a>
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

        <form action="update_album2.php" method="post" enctype="multipart/form-data">
            <?php
                include "koneksi.php";
                $albumid=$_GET['albumid'];
                $sql=mysqli_query($conn,"select * from album where albumid='$albumid'");
                while($data=mysqli_fetch_array($sql)){
            ?>
            <input type="text" name="albumid" value="<?=$data['albumid']?>" hidden>
            <div class="mb-3">
                <label for="namaalbum" class="form-label">Judul</label>
                <input type="text" name="namaalbum" id="namaalbum" class="form-control" value="<?=$data['namaalbum']?>">
            </div>
            <div class="mb-3">
                <label for="deskripsi" class="form-label">Deskripsi</label>
                <input type="text" name="deskripsi" id="deskripsi" class="form-control" value="<?=$data['deskripsi']?>">
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
