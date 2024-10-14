<?php
session_start();
include "koneksi.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $albumid = $_POST['albumid'];
    $namaalbum = $_POST['namaalbum'];
    $deskripsi = $_POST['deskripsi'];

    // Prepare the update query
    $query = "UPDATE album SET namaalbum=?, deskripsi=? WHERE albumid=?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ssi", $namaalbum, $deskripsi, $albumid);

    if ($stmt->execute()) {
        // Redirect to album page with success message
        $_SESSION['message'] = "Album updated successfully.";
        header("Location: album2.php");
        exit();
    } else {
        // Redirect to album page with error message
        $_SESSION['message'] = "Failed to update album.";
        header("Location: album2.php");
        exit();
    }
}
?>
