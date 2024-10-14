<?php
session_start();
if (!isset($_SESSION['userid'])) {
    header("location:login.php");
}

include "koneksi.php";

if (isset($_GET['albumid'])) {
    $albumid = $_GET['albumid'];
    $userid = $_SESSION['userid'];

    // Fetch album details
    $album_query = mysqli_query($conn, "SELECT * FROM album WHERE albumid='$albumid'");
    $album = mysqli_fetch_array($album_query);

    // Periksa apakah album ditemukan
    if (!$album) {
        echo "<p>Album tidak ditemukan atau Anda tidak memiliki akses ke album ini.</p>";
        exit;
    }

    // Proses pencarian jika ada keyword yang dikirim
    if (isset($_POST['keyword'])) {
        $keyword = mysqli_real_escape_string($conn, $_POST['keyword']);
        // Query pencarian berdasarkan judul atau deskripsi foto dalam album
        $images_query = mysqli_query($conn, "SELECT * FROM foto WHERE albumid='$albumid' AND (judulfoto LIKE '%$keyword%' OR deskripsifoto LIKE '%$keyword%')");
    } else {
        // Jika tidak ada keyword, tampilkan semua foto dalam album
        $images_query = mysqli_query($conn, "SELECT * FROM foto WHERE albumid='$albumid'");
    }
} else {
    echo "Album not found!";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Album: <?= $album['namaalbum'] ?></title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
        }

        .photo-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            gap: 10px;
        }

        .photo-card {
            background: #fff;
            border: 1px solid #ddd;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            transition: transform 0.2s ease;
        }

        .photo-card img {
            width: 100%;
            height: auto;
            border-top-left-radius: 5px;
            border-top-right-radius: 5px;
        }

        .photo-card:hover {
            transform: scale(1.05);
        }

        .photo-details {
            padding: 10px;
        }

        .photo-details h2 {
            margin: 0 0 5px;
            font-size: 1.2em;
        }

        .photo-details p {
            margin: 0;
            font-size: 0.9em;
            color: #555;
        }

        footer {
            background-color: #333;
            color: white;
            padding: 20px 0;
        }

        footer a {
            color: white;
            margin: 0 15px;
        }
    </style>
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
                        <a class="nav-link" href="<?php echo ($_SESSION['role'] === 'admin') ? 'album2.php' : 'album.php'; ?>">Album</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo ($_SESSION['role'] === 'admin') ? 'foto2.php' : 'foto.php'; ?>">Upload</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="logout.php">Logout</a>
                    </li>
                </ul>
                <!-- Search form -->
                <form class="form-inline my-2 my-lg-0" method="POST" action="">
                    <input class="form-control mr-sm-2" type="search" name="keyword" placeholder="Search in album" aria-label="Search">
                    <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
                </form>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="container my-4">
        <h1>Album: <?= $album['namaalbum'] ?></h1>

        <!-- Photo Grid -->
        <div class="photo-grid">
            <?php
            while ($image = mysqli_fetch_array($images_query)) {
            ?>
                <div class="photo-card">
                    <img src="gambar/<?= $image['lokasifile'] ?>" alt="<?= $image['judulfoto'] ?>">
                    <div class="photo-details">
                        <h2><?= $image['judulfoto'] ?></h2>
                        <p><?= $image['deskripsifoto'] ?></p>
                        <p>Tanggal Unggah: <?= $image['tanggalunggah'] ?></p>
                        <p>Disukai:
                            <?php
                            $fotoid = $image['fotoid'];
                            $sql2 = mysqli_query($conn, "SELECT * FROM likefoto WHERE fotoid='$fotoid'");
                            echo mysqli_num_rows($sql2);
                            ?>
                        </p>
                        <p>Komentar:
                            <?php
                            $fotoid = $image['fotoid'];
                            $sql2 = mysqli_query($conn, "SELECT * FROM komentarfoto WHERE fotoid='$fotoid'");
                            echo mysqli_num_rows($sql2);
                            ?>
                        </p>
                    </div>
                </div>
            <?php
            }
            ?>
        </div>
    </div>

    <!-- Footer -->
    <footer class="mt-4">
        <div class="container text-center">
            <p>&copy; 2024 Foto Gallery. All rights reserved.</p>
        </div>
    </footer>

</body>
</html>
