<?php
session_start(); // Mulai session
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        h2 {
            text-align: center;
            margin-top: 20px;
        }

        /* Scrollable albums section */
        .albums-wrapper {
            display: flex;
            overflow-x: auto;
            padding: 10px 20px;
            white-space: nowrap;
            scroll-behavior: smooth;
            -ms-overflow-style: none;
            scrollbar-width: none;
        }

        .albums-wrapper::-webkit-scrollbar {
            display: none;
        }

        .albums {
            display: flex;
            align-items: center;
        }

        .album-item {
            margin: 5px;
            padding: 10px 20px;
            border-radius: 30px;
            text-align: center;
            background-color: #f9f9f9;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            flex-shrink: 0;
            font-size: 16px;
            font-weight: bold;
        }

        .album-item a {
            text-decoration: none;
            color: #333;
        }

        .album-item:hover {
            transform: translateY(-3px);
            background-color: #eee;
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.2);
        }

        .album-item:nth-child(1) { background-color: #D5F5E3; } /* Light Green */
        .album-item:nth-child(2) { background-color: #BB8FCE; } /* Light Purple */
        .album-item:nth-child(3) { background-color: #AED6F1; } /* Light Blue */
        .album-item:nth-child(4) { background-color: #F5B7B1; } /* Light Pink */
        .album-item:nth-child(5) { background-color: #F7DC6F; } /* Light Yellow */
        .album-item:nth-child(6) { background-color: #82E0AA; } /* Pastel Green */
        .album-item:nth-child(7) { background-color: #F1948A; } /* Pastel Red */
        .album-item:nth-child(8) { background-color: #A9CCE3; } /* Light Sky Blue */
        .album-item:nth-child(9) { background-color: #F9E79F; } /* Soft Yellow */
        .album-item:nth-child(10) { background-color: #A3E4D7; } /* Soft Cyan */


        .gallery {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            gap: 15px;
            padding: 20px;
            max-width: 1200px;
            margin: auto;
        }

        .gallery .image-container {
            position: relative;
            overflow: hidden;
            border-radius: 12px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease;
        }

        .gallery img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 12px;
            transition: all 0.3s ease;
        }

        .gallery .image-container:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 15px rgba(0, 0, 0, 0.2);
        }

        .gallery .image-container:hover img {
            transform: scale(1.05);
            filter: brightness(0.9);
        }

        .image-actions {
            position: absolute;
            bottom: 10px;
            left: 10px;
            display: flex;
            gap: 15px;
            color: white;
            font-size: 16px;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.5);
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .gallery .image-container:hover .image-actions {
            opacity: 1;
        }

        .image-actions span {
            display: flex;
            align-items: center;
        }

        .image-actions i {
            margin-right: 5px;
        }

        .image-title {
            position: absolute;
            top: 10px;
            left: 10px;
            color: white;
            font-size: 18px;
            font-weight: bold;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.5);
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .gallery .image-container:hover .image-title {
            opacity: 1;
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
                    <?php if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) : ?>
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo ($_SESSION['role'] === 'admin') ? 'album2.php' : 'album.php'; ?>">Album</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo ($_SESSION['role'] === 'admin') ? 'foto2.php' : 'foto.php'; ?>">Upload</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="logout.php" onclick="return confirmLogout()">Logout</a>
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
                <!-- Search form -->
                <form class="form-inline my-2 my-lg-0" action="home.php" method="POST">
                    <input class="form-control mr-sm-2" type="search" name="keyword" placeholder="Search" aria-label="Search">
                    <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
                </form>
            </div>
        </div>
    </nav>

    <!-- Scrollable Album Section -->
    <div class="albums-wrapper">
        <div class="albums">
            <?php
            // Query to fetch albums from the database
            $album_result = mysqli_query($conn, "SELECT * FROM album");

            if (mysqli_num_rows($album_result) > 0) {
                while ($album = mysqli_fetch_array($album_result)) {
                    // Display only the album name linked to its details, with album id in URL
                    echo '
                    <div class="album-item">
                        <a href="home.php?albumid=' . $album['albumid'] . '">' . $album['namaalbum'] . '</a>
                    </div>';
                }
            } else {
                echo "<p>No albums found.</p>";
            }
            ?>
        </div>
    </div>


 <!-- Existing Gallery Section -->
    <div class="gallery">
        <?php
        // Search functionality
        $keyword = '';
        if (isset($_POST['keyword'])) {
            $keyword = mysqli_real_escape_string($conn, $_POST['keyword']);
        }

        // Check if an album is selected based on albumid in URL
        if (isset($_GET['albumid'])) {
            $albumid = mysqli_real_escape_string($conn, $_GET['albumid']);
            // Query to display images that match the selected album and search keyword
            $result = mysqli_query($conn, "SELECT * FROM foto WHERE albumid = '$albumid' AND judulfoto LIKE '%$keyword%'");
        } else {
            // If no album is selected, display all images matching the search keyword
            $result = mysqli_query($conn, "SELECT * FROM foto WHERE judulfoto LIKE '%$keyword%'");
        }

        // Display search results or default images
        if (mysqli_num_rows($result) > 0) {
            while ($data = mysqli_fetch_array($result)) {
                $fotoid = $data['fotoid'];

                // Query to count likes and comments for each image
                $like_query = mysqli_query($conn, "SELECT COUNT(*) AS like_count FROM likefoto WHERE fotoid = '$fotoid'");
                $like_data = mysqli_fetch_array($like_query);
                $like_count = $like_data['like_count'];

                $comment_query = mysqli_query($conn, "SELECT COUNT(*) AS comment_count FROM komentarfoto WHERE fotoid = '$fotoid'");
                $comment_data = mysqli_fetch_array($comment_query);
                $comment_count = $comment_data['comment_count'];

                // Display the image, title, likes, and comments
                echo '
                <div class="image-container">
                    <a href="details.php?id=' . $data['fotoid'] . '">
                        <img src="gambar/' . $data['lokasifile'] . '" alt="' . $data['judulfoto'] . '">
                    </a>
                    <div class="image-title">' . $data['judulfoto'] . '</div>
                    <div class="image-actions">
                        <span><i class="fas fa-heart"></i> ' . $like_count . '</span>
                        <span><i class="fas fa-comment"></i> ' . $comment_count . '</span>
                    </div>
                </div>';
            }
        } else {
            echo "<p>No images found .</p>";
        }
        ?>
    </div>


    <!-- Footer -->
    <footer>
        <div class="container text-center">
            <p>&copy; 2024 Horizon Gallery. All Rights Reserved.</p>
            <p>Follow us on:
                <a href="#"><i class="fab fa-facebook"></i></a>
                <a href="#"><i class="fab fa-twitter"></i></a>
                <a href="#"><i class="fab fa-instagram"></i></a>
            </p>
        </div>
    </footer>

<script>
function confirmLogout() {
        return confirm("Apakah Anda yakin ingin logout?");
    }

    const albumsWrapper = document.querySelector('.albums-wrapper');
let isDown = false;
let startX;
let scrollLeft;

albumsWrapper.addEventListener('mousedown', (e) => {
    isDown = true;
    startX = e.pageX - albumsWrapper.offsetLeft;
    scrollLeft = albumsWrapper.scrollLeft;
});

albumsWrapper.addEventListener('mouseleave', () => {
    isDown = false;
});

albumsWrapper.addEventListener('mouseup', () => {
    isDown = false;
});

albumsWrapper.addEventListener('mousemove', (e) => {
    if (!isDown) return;
    e.preventDefault();
    const x = e.pageX - albumsWrapper.offsetLeft;
    const walk = (x - startX) * 2; // scroll-fast multiplier
    albumsWrapper.scrollLeft = scrollLeft - walk;
});
</script>

</body>
</html>
