<?php
session_start();
if (!isset($_SESSION['userid'])) {
    header("location:login.php");
}

include "koneksi.php"; // Koneksi ke database
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Horizon Gallery</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
        }

        .album-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            gap: 10px;
        }

        .album-card {
            background: #fff;
            border: 1px solid #ddd;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            transition: transform 0.2s ease;
        }

        .album-card:hover {
            transform: scale(1.05);
        }

        .album-details {
            padding: 10px;
        }

        .album-details h3 {
            margin: 0 0 5px;
            font-size: 1.2em;
        }

        .album-details p {
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
                        <a class="nav-link" href="logout.php" onclick="return confirmLogout()">Logout</a>
                    </li>
                </ul>
                <!-- Search form -->
                <form class="form-inline my-2 my-lg-0" method="POST" action="album.php">
                    <input class="form-control mr-sm-2" type="search" name="keyword" placeholder="Search" aria-label="Search">
                    <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
                </form>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="container my-4">
        <p>Selamat datang <b><?= $_SESSION['namalengkap'] ?></b></p>

        <button type="button" class="btn btn-primary mb-3" data-toggle="modal" data-target="#addAlbumModal">
            Tambah Album
        </button>

        <!-- Modal for Adding Album -->
        <div class="modal fade" id="addAlbumModal" tabindex="-1" role="dialog" aria-labelledby="addAlbumModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addAlbumModalLabel">Tambah Album</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="tambah_album.php" method="post">
                            <div class="form-group">
                                <label>Nama Album</label>
                                <input type="text" class="form-control" name="namaalbum" required>
                            </div>
                            <div class="form-group">
                                <label>Deskripsi</label>
                                <input type="text" class="form-control" name="deskripsi" required>
                            </div>
                            <button type="submit" class="btn btn-primary">Tambah</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Album Grid -->
        <div class="album-grid">
        <?php
        $userid = $_SESSION['userid'];

        // Cek apakah ada keyword yang dikirimkan via POST
        if (isset($_POST['keyword'])) {
            $keyword = mysqli_real_escape_string($conn, $_POST['keyword']); // Amankan data input
            // Query pencarian album berdasarkan nama album atau deskripsi yang sesuai dengan akun login
            $sql = "SELECT * FROM album WHERE (namaalbum LIKE '%$keyword%' OR deskripsi LIKE '%$keyword%' OR albumid LIKE '%$keyword%') AND userid = '$userid'";
        } else {
            // Jika tidak ada pencarian, tampilkan semua album milik pengguna yang login
            $sql = "SELECT * FROM album WHERE userid = '$userid'";
        }

        $result = mysqli_query($conn, $sql);

        // Tampilkan hasil album
        while ($data = mysqli_fetch_array($result)) {
            // Cek apakah album milik pengguna yang sedang login
            $isOwner = $data['userid'] == $userid;
        ?>
            <div class="album-card">
                <div class="album-details">
                    <h3><a href="gambar_album.php?albumid=<?= $data['albumid'] ?>"><?= $data['namaalbum'] ?></a></h3>
                    <p><?= $data['deskripsi'] ?></p>
                    <p>album id      :<?= $data['albumid'] ?></p>
                    <p>Tanggal dibuat: <?= $data['tanggaldibuat'] ?></p>
                    <?php if ($isOwner) { ?>
                    <p>
                        <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#editAlbumModal<?= $data['albumid'] ?>">Edit</button>
                        <?php if ($_SESSION['role'] === 'admin') { // Hanya admin yang dapat menghapus ?>
                        <a href="hapus_album.php?albumid=<?= $data['albumid'] ?>" class="btn btn-danger">Hapus</a>
                        <?php } ?>
                    </p>
                    <?php } ?>
                </div>
            </div>

            <!-- Modal for Editing Album -->
            <?php if ($isOwner) { ?>
            <div class="modal fade" id="editAlbumModal<?= $data['albumid'] ?>" tabindex="-1" role="dialog" aria-labelledby="editAlbumModalLabel<?= $data['albumid'] ?>" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="editAlbumModalLabel<?= $data['albumid'] ?>">Edit Album</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form action="update_album.php" method="post">
                                <input type="hidden" name="albumid" value="<?= $data['albumid'] ?>">
                                <div class="form-group">
                                    <label>Nama Album</label>
                                    <input type="text" class="form-control" name="namaalbum" value="<?= $data['namaalbum'] ?>" required>
                                </div>
                                <div class="form-group">
                                    <label>Deskripsi</label>
                                    <input type="text" class="form-control" name="deskripsi" value="<?= $data['deskripsi'] ?>" required>
                                </div>
                                <button type="submit" class="btn btn-warning">Ubah</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <?php } ?>
        <?php
        }
        ?>
        </div>
    </div>

    <!-- Footer -->
    <footer class="text-center">
        <div class="container">
            <p>&copy; 2024 Horizon Gallery. All rights reserved.</p>
        </div>
    </footer>
    <script>
    function confirmLogout() {
        return confirm("Apakah Anda yakin ingin logout?");
    }
</script>

</body>

</html>
