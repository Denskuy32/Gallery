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
    <title>Tambah Foto</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
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
        <h1 class="mb-4">Tambah Foto</h1>

        <!-- Form tambah foto -->
        <form action="tambah_foto2.php" method="post" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="judulfoto" class="form-label">Judul</label>
                <input type="text" name="judulfoto" id="judulfoto" class="form-control">
            </div>
            <div class="mb-3">
                <label for="deskripsifoto" class="form-label">Deskripsi</label>
                <input type="text" name="deskripsifoto" id="deskripsifoto" class="form-control">
            </div>
            <div class="mb-3">
                <label for="lokasifile" class="form-label">Lokasi File</label>
                <input type="file" name="lokasifile" id="lokasifile" class="form-control">
            </div>
            <div class="mb-3">
                <label for="albumid" class="form-label">Album</label>
                <select name="albumid" id="albumid" class="form-select">
                    <?php
                    include "koneksi.php";
                    // Tampilkan semua album dari semua user
                    $sql = mysqli_query($conn, "SELECT * FROM album");
                    while ($data = mysqli_fetch_array($sql)) {
                    ?>
                        <option value="<?= $data['albumid'] ?>"><?= $data['namaalbum'] ?> - <?= $data['userid'] ?></option>
                    <?php
                    }
                    ?>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Tambah</button>
        </form>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
