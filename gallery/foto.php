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
                        <a class="nav-link" href="logout.php" onclick="return confirmLogout()">Logout</a>
                    </li>
                </ul>
                <!-- Search form -->
                <form class="form-inline my-2 my-lg-0" method="POST" action="foto.php">
                    <input class="form-control mr-sm-2" type="search" name="keyword" placeholder="Search" aria-label="Search">
                    <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
                </form>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="container my-4">
        <p>Selamat datang <b><?= $_SESSION['namalengkap'] ?></b></p>

        <button type="button" class="btn btn-primary mb-3" data-toggle="modal" data-target="#addPhotoModal">
            Tambah Foto
        </button>

        <!-- Modal for Adding Photo -->
        <div class="modal fade" id="addPhotoModal" tabindex="-1" role="dialog" aria-labelledby="addPhotoModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addPhotoModalLabel">Tambah Foto</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="tambah_foto.php" method="post" enctype="multipart/form-data">
                            <div class="form-group">
                                <label>Judul</label>
                                <input type="text" class="form-control" name="judulfoto" required>
                            </div>
                            <div class="form-group">
                                <label>Deskripsi</label>
                                <input type="text" class="form-control" name="deskripsifoto" required>
                            </div>
                            <div class="form-group">
                                <label>Lokasi File</label>
                                <input type="file" class="form-control-file" name="lokasifile" required>
                            </div>
                            <div class="form-group">
                                <label>Album</label>
                                <select class="form-control" name="albumid" required>
                                    <?php
                                    $userid = $_SESSION['userid'];
                                    $sql = mysqli_query($conn, "select * from album where userid='$userid'");
                                    while ($data = mysqli_fetch_array($sql)) {
                                    ?>
                                        <option value="<?= $data['albumid'] ?>"><?= $data['namaalbum'] ?></option>
                                    <?php
                                    }
                                    ?>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-primary">Tambah</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Photo Grid -->
        <div class="photo-grid">
        <?php
        $userid = $_SESSION['userid'];

        // Proses pencarian jika ada keyword yang dikirim
        if (isset($_POST['keyword'])) {
            $keyword = mysqli_real_escape_string($conn, $_POST['keyword']);
            // Query pencarian berdasarkan judul, deskripsi, atau nama album
            $sql = mysqli_query($conn, "SELECT * FROM foto, album WHERE foto.userid='$userid' AND foto.albumid=album.albumid AND (judulfoto LIKE '%$keyword%' OR deskripsifoto LIKE '%$keyword%' OR namaalbum LIKE '%$keyword%')");
        } else {
            // Jika tidak ada keyword, tampilkan semua foto
            $sql = mysqli_query($conn, "SELECT * FROM foto, album WHERE foto.userid='$userid' AND foto.albumid=album.albumid");
        }

        while ($data = mysqli_fetch_array($sql)) {
        ?>
            <div class="photo-card">
                <img src="gambar/<?= $data['lokasifile'] ?>" alt="<?= $data['judulfoto'] ?>">
                <div class="photo-details">
                    <h2><?= $data['judulfoto'] ?></h2>
                    <p><?= $data['deskripsifoto'] ?></p>
                    <p>foto id:<?= $data['fotoid'] ?></p>
                    <p>Tanggal Unggah: <?= $data['tanggalunggah'] ?></p>
                    <p>Album: <?= $data['namaalbum'] ?></p>
                    <p>Disukai: 
                        <?php
                        $fotoid = $data['fotoid'];
                        $sql2 = mysqli_query($conn, "SELECT * FROM likefoto WHERE fotoid='$fotoid'");
                        echo mysqli_num_rows($sql2);
                        ?>
                    </p>
                    <p>Komentar:
                        <?php
                        $sql2 = mysqli_query($conn, "SELECT * FROM komentarfoto WHERE fotoid='$fotoid'");
                        echo mysqli_num_rows($sql2);
                        ?>
                    </p>
                    <p>
                        <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#editPhotoModal<?= $data['fotoid'] ?>">Edit</button>
                        <?php if ($_SESSION['role'] == 'admin') { ?>
                            <a href="hapus_foto.php?fotoid=<?= $data['fotoid'] ?>" class="btn btn-danger">Hapus</a>
                        <?php } ?>
                    </p>
                </div>
            </div>
                       <!-- Modal for Editing Album -->
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

                <!-- Modal Edit Foto -->
            <div class="modal fade" id="editPhotoModal<?= $data['fotoid'] ?>" tabindex="-1" role="dialog" aria-labelledby="editPhotoModalLabel<?= $data['fotoid'] ?>" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="editPhotoModalLabel<?= $data['fotoid'] ?>">Edit Foto</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form action="update_foto.php" method="post" enctype="multipart/form-data">
                                <input type="hidden" name="fotoid" value="<?= $data['fotoid'] ?>">
                                <div class="form-group">
                                    <label>Judul</label>
                                    <input type="text" class="form-control" name="judulfoto" value="<?= $data['judulfoto'] ?>" required>
                                </div>
                                <div class="form-group">
                                    <label>Deskripsi</label>
                                    <input type="text" class="form-control" name="deskripsifoto" value="<?= $data['deskripsifoto'] ?>" required>
                                </div>
                                <div class="form-group">
                                    <label>Lokasi File</label>
                                    <input type="file" class="form-control-file" name="lokasifile">
                                    <small class="form-text text-muted">Kosongkan jika tidak ingin mengubah foto.</small>
                                </div>
                                <div class="form-group">
                                    <label>Album</label>
                                    <select class="form-control" name="albumid" required>
                                        <?php
                                        $sqlAlbum = mysqli_query($conn, "SELECT * FROM album WHERE userid='$userid'");
                                        while ($album = mysqli_fetch_array($sqlAlbum)) {
                                            $selected = ($album['albumid'] == $data['albumid']) ? 'selected' : '';
                                            echo "<option value='{$album['albumid']}' {$selected}>{$album['namaalbum']}</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                            </form>
                        </div>
                    </div>
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
    <script>
    function confirmLogout() {
        return confirm("Apakah Anda yakin ingin logout?");
    }
</script>

</body>

</html>
