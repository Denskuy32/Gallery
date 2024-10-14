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
    <title>Halaman Foto</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    
    <style>
        @media print {
            /* Hide the action column in print */
            th:nth-child(8),
            td:nth-child(8) {
                display: none;
            }
            /* Additional print styling */
            body {
                -webkit-print-color-adjust: exact;
                color-adjust: exact;
            }
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
                <form class="form-inline my-2 my-lg-0" method="POST" action="foto2.php">
                    <input class="form-control mr-sm-2" type="search" name="keyword" placeholder="Search" aria-label="Search">
                    <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
                </form>
            </div>
        </div>
    </nav>

    <div class="container mt-5">
        <h1 class="mb-4">Halaman Foto</h1>
        <p>Selamat datang <b><?= $_SESSION['namalengkap'] ?></b></p>

        <!-- Tombol ke halaman tambah foto -->
        <a href="tambah2.php" class="btn btn-primary mb-4">Tambah Foto</a>

        <!-- Print Button -->
        <button class="btn btn-secondary mb-4" onclick="window.print()">Print Table</button>

        <!-- Tabel foto -->
        <table class="table table-striped mt-4">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Judul</th>
                    <th>Deskripsi</th>
                    <th>Tgl Unggah</th>
                    <th>Gambar</th>
                    <th>Album</th>
                    <th>Disukai</th>
                    <th>Aksi</th> <!-- This column will be hidden in print -->
                </tr>
            </thead>
            <tbody>
                <?php
                include "koneksi.php";

                // Cek apakah ada input pencarian
                $keyword = "";
                if (isset($_POST['keyword'])) {
                    $keyword = $_POST['keyword'];
                }

                // Query untuk menampilkan data foto dan album berdasarkan pencarian atau semua data
                if (!empty($keyword)) {
                    // Query jika ada keyword pencarian
                    $sql = mysqli_query($conn, "SELECT * FROM foto JOIN album ON foto.albumid = album.albumid 
                                                WHERE judulfoto LIKE '%$keyword%' OR deskripsifoto LIKE '%$keyword%' OR fotoid LIKE '%$keyword%'");
                } else {
                    // Query default tanpa pencarian
                    $sql = mysqli_query($conn, "SELECT * FROM foto JOIN album ON foto.albumid = album.albumid");
                }

                // Menampilkan hasil query
                while ($data = mysqli_fetch_array($sql)) {
                ?>
                    <tr>
                        <td><?= $data['fotoid'] ?></td>
                        <td><?= $data['judulfoto'] ?></td>
                        <td><?= $data['deskripsifoto'] ?></td>
                        <td><?= $data['tanggalunggah'] ?></td>
                        <td>
                            <img src="gambar/<?= $data['lokasifile'] ?>" width="200px" class="img-fluid">
                        </td>
                        <td><?= $data['namaalbum'] ?></td>
                        <td>
                            <?php
                            $fotoid = $data['fotoid'];
                            $sql2 = mysqli_query($conn, "SELECT * FROM likefoto WHERE fotoid='$fotoid'");
                            echo mysqli_num_rows($sql2);
                            ?>
                        </td>
                        <td>
                            <a href="hapus_foto2.php?fotoid=<?= $data['fotoid'] ?>" 
                            class="btn btn-danger btn-sm"
                            onclick="return confirm('Apakah Anda yakin ingin menghapus foto ini?')">Hapus</a>
                            <a href="edit_foto2.php?fotoid=<?= $data['fotoid'] ?>" class="btn btn-warning btn-sm">Edit</a>
                        </td>
                    </tr>
                <?php
                }
                ?>
            </tbody>
        </table>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script>
    function confirmLogout() {
        return confirm("Apakah Anda yakin ingin logout?");
    }
</script>
</body>

</html>
