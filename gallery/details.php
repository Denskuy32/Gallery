<?php
include "koneksi.php";
session_start();
$userid = $_SESSION['userid'] ?? null; // Cek apakah user sudah login

// Handle Like/Dislike
if (isset($_POST['toggle_like']) && $userid) {
    $fotoid = $_POST['fotoid'];
    $user_liked = mysqli_query($conn, "SELECT * FROM likefoto WHERE fotoid = '$fotoid' AND userid = '$userid'");

    if (mysqli_num_rows($user_liked) > 0) {
        // Remove like
        mysqli_query($conn, "DELETE FROM likefoto WHERE fotoid = '$fotoid' AND userid = '$userid'");
    } else {
        // Add like
        mysqli_query($conn, "INSERT INTO likefoto (fotoid, userid, tanggallike) VALUES ('$fotoid', '$userid', NOW())");
    }

    header("Location: details.php?id=" . $fotoid);
    exit();
}

// Handle Comment submission
if (isset($_POST['submit_comment']) && $userid) {
    $fotoid = $_POST['fotoid'];
    $isikomentar = mysqli_real_escape_string($conn, $_POST['isikomentar']);
    mysqli_query($conn, "INSERT INTO komentarfoto (fotoid, userid, isikomentar, tanggalkomentar) VALUES ('$fotoid', '$userid', '$isikomentar', NOW())");

    header("Location: details.php?id=" . $fotoid);
    exit();
}

// Ambil ID dari URL
$id = $_GET['id'];
$sql = mysqli_query($conn, "SELECT foto.*, user.namalengkap FROM foto JOIN user ON foto.userid = user.userid WHERE foto.fotoid = '$id'");

// Query untuk jumlah komentar
$sql_comment_count = mysqli_query($conn, "SELECT COUNT(*) as comment_count FROM komentarfoto WHERE fotoid = '$id'");
$comment_data = mysqli_fetch_assoc($sql_comment_count);
$comment_count = $comment_data['comment_count'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Image Details</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
    body {
        background-color: #f0f0f0;
    }
    .container {
        margin-top: 30px;
        border-radius: 10px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
    }
    .image-section img {
        max-width: 100%;
        border-radius: 10px;
    }
    .like-button {
        border: none; /* Menghilangkan border */
        background: none; /* Menghilangkan background */
        padding: 0; /* Mengatur padding menjadi 0 */
    }

    .like-button:focus {
        outline: none; /* Menghilangkan outline saat button di klik */
    }

    .like-button i {
        font-size: 24px;
        cursor: pointer;
        color: red; /* Warna jika sudah disukai */
    }

    .comment-icon {
        font-size: 24px; /* Ukuran ikon komentar sama dengan ukuran ikon like */
        color: grey; /* Warna default untuk ikon komentar */
        cursor: pointer; /* Menunjukkan bahwa ini dapat diklik */
        margin-left: 10px; /* Jarak antara ikon like dan ikon komentar */
    }

    .comment {
        border-bottom: 1px solid #ccc;
        padding: 10px 0;
    }

    .like-button i.liked {
        color: red; /* Warna merah jika disukai */
    }

    .dropdown {
        position: absolute; /* Menjadikan dropdown bisa diposisikan di pojok */
        top: 10px;          /* Atur jarak dari atas */
        right: 10px;        /* Atur jarak dari kanan */
    }

    .dropdown-content {
        display: none;
        position: absolute;
        right: 0;
        background-color: #f9f9f9;
        min-width: 150px;
        box-shadow: 0px 8px 16px rgba(0, 0, 0, 0.2);
        z-index: 1;
    }

    .dropdown-content a {
        color: black;
        padding: 10px 16px;
        text-decoration: none;
        display: block;
    }

    .dropdown-content a:hover {
        background-color: #f1f1f1;
    }

    .dropdown:hover .dropdown-content {
        display: block;
    }

    .dropdown-toggle {
        cursor: pointer;
        font-size: 24px;
    }

    .text-section {
        position: relative; /* Tambahkan ini untuk membuat text-section sebagai referensi posisi */
        padding: 20px;
    }
</style>

</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm">
        <div class="container-fluid">
            <a class="navbar-brand" href="home.php">Horizon Gallery</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav mr-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="home.php">Home</a>
                    </li>
                    <?php if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) : ?>
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo ($_SESSION['role'] === 'admin') ? 'album2.php' : 'album.php'; ?>">Album</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo ($_SESSION['role'] === 'admin') ? 'foto2.php' : 'foto.php'; ?>">Upload</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="logout.php">Logout</a>
                        </li>
                    <?php else : ?>
                        <li class="nav-item">
                            <a class="nav-link" href="login.php">Login</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="register.php">Register</a>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Content -->
    <div class="container">
        <div class="row">
            <?php while ($data = mysqli_fetch_array($sql)) {
                $fotoid = $data['fotoid'];
                $sql2 = mysqli_query($conn, "SELECT * FROM likefoto WHERE fotoid = '$fotoid'");
                $like_count = mysqli_num_rows($sql2);
                $user_has_liked = false;

                if ($userid) {
                    $user_liked = mysqli_query($conn, "SELECT * FROM likefoto WHERE fotoid = '$fotoid' AND userid = '$userid'");
                    $user_has_liked = mysqli_num_rows($user_liked) > 0;
                }
            ?>
            <div class="col-md-6">
                <div class="image-section text-center">
                    <img src="gambar/<?= $data['lokasifile'] ?>" alt="Foto">
                </div>
            </div>
            <div class="col-md-6">
                <div class="text-section p-4">
                    <div class="profile-info d-flex align-items-center mb-3">
                        <img src="https://i.pinimg.com/236x/f5/c2/33/f5c233abe166b186b989293ad18ba07a.jpg" alt="Profile" class="rounded-circle" style="width: 40px; height: 40px;">
                        <span class="ml-2"><?= $data['namalengkap'] ?></span>
                    </div>

                    <!-- Titik Tiga Dropdown -->
                    <div class="dropdown" id="dropdown">
                        <i class="fas fa-ellipsis-v" onclick="toggleDropdown(event)"></i>
                        <div class="dropdown-content" style="display: none;">
                            <?php if ($userid): // Cek jika user sudah login ?>
                                <a href="gambar/<?= $data['lokasifile'] ?>" download>
                                    <i class="fas fa-download"></i> Unduh
                                </a>
                            <?php else: ?>
                                <span style="color: grey; cursor: not-allowed;">
                                    <i class="fas fa-download"></i>Login untuk mengunduh
                                </span>
                            <?php endif; ?>
                        </div>
                    </div>

                    <h2><?= $data['judulfoto'] ?></h2>
                    <p><?= $data['deskripsifoto'] ?></p>
                    <div class="actions mb-4">
                        <form method="POST" action="">
                            <input type="hidden" name="fotoid" value="<?= $fotoid ?>">
                            <?php if ($userid): ?>
                                <!-- Like Button -->
                                <button type="submit" class="like-button <?= $user_has_liked ? 'active' : '' ?>" name="toggle_like">
                                    <i class="<?= $user_has_liked ? 'fas fa-heart liked' : 'far fa-heart' ?>"></i>
                                    <span class="like-count"><?= $like_count ?></span>
                                </button>

                                <!-- Comment Icon and Count -->
                                <i class="fas fa-comment comment-icon"></i> <!-- Menggunakan kelas comment-icon -->
                                <span class="comment-count"><?= $comment_count ?></span>
                            <?php else: ?>
                                <p><a href="login.php">Login to like or comment on this photo</a></p>
                            <?php endif; ?>
                        </form>
                    </div>


                    <!-- Comments Section -->
                    <div class="comments">
                        <h3>Comments</h3>
                        <?php
                        $sql_comments = mysqli_query($conn, "SELECT komentarfoto.*, user.namalengkap FROM komentarfoto JOIN user ON komentarfoto.userid = user.userid WHERE komentarfoto.fotoid = '$fotoid' ORDER BY tanggalkomentar DESC");
                        while ($comment = mysqli_fetch_array($sql_comments)) {
                            $formatted_date = date('F j, Y', strtotime($comment['tanggalkomentar']));
                        ?>
                        <div class="comment">
                            <strong><?= $comment['namalengkap'] ?></strong> <br>
                            <?= $comment['isikomentar'] ?> <br>
                            <small><?= $formatted_date ?></small>
                        </div>
                        <?php } ?>

                        <!-- Comment Form -->
                        <?php if ($userid): ?>
                        <div class="comment-form mt-3">
                            <form method="POST" action="">
                                <input type="hidden" name="fotoid" value="<?= $fotoid ?>">
                                <textarea name="isikomentar" class="form-control" placeholder="Add a comment" required></textarea>
                                <button type="submit" name="submit_comment" class="btn btn-danger mt-2"><i class="fas fa-paper-plane"></i> Send</button>
                            </form>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <?php } ?>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
    function toggleDropdown(event) {
        // Mengambil dropdown content
        const dropdownContent = event.currentTarget.nextElementSibling;
        // Toggle display antara 'none' dan 'block'
        if (dropdownContent.style.display === "none" || dropdownContent.style.display === "") {
            dropdownContent.style.display = "block";
        } else {
            dropdownContent.style.display = "none";
        }
    }

    // Menutup dropdown jika diklik di luar
    window.onclick = function(event) {
        if (!event.target.matches('.dropdown-toggle')) {
            const dropdowns = document.querySelectorAll('.dropdown-content');
            dropdowns.forEach(dropdown => {
                dropdown.style.display = "none";
            });
        }
    }
</script>

</body>
</html>
