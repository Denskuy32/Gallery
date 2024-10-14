<?php
include "koneksi.php";
session_start();

$fotoid = $_POST['fotoid'];  // Pastikan mengambil fotoid dari form
$judulfoto = $_POST['judulfoto'];
$deskripsifoto = $_POST['deskripsifoto'];
$albumid = $_POST['albumid'];

// Jika Upload gambar baru
if ($_FILES['lokasifile']['name'] != "") {
    $rand = rand();
    $ekstensi = array('png', 'jpg', 'jpeg', 'gif','jfif');
    $filename = $_FILES['lokasifile']['name'];
    $ukuran = $_FILES['lokasifile']['size'];
    $ext = pathinfo($filename, PATHINFO_EXTENSION);
    
    if (!in_array($ext, $ekstensi)) {
        header("location:foto2.php");
    } else {
        if ($ukuran < 1044070) {		
            $xx = $rand . '_' . $filename;
            move_uploaded_file($_FILES['lokasifile']['tmp_name'], 'gambar/' . $xx);
            
            // Update query dengan WHERE fotoid
            $query = "UPDATE foto SET judulfoto='$judulfoto', deskripsifoto='$deskripsifoto', lokasifile='$xx', albumid='$albumid' WHERE fotoid='$fotoid'";
            mysqli_query($conn, $query);
            
            header("location:foto2.php");
        } else {
            header("location:foto2.php?error=size");
        }
    }
} else {
    // Update query tanpa mengubah file gambar
    $query = "UPDATE foto SET judulfoto='$judulfoto', deskripsifoto='$deskripsifoto', albumid='$albumid' WHERE fotoid='$fotoid'";
    mysqli_query($conn, $query);
    
    header("location:foto2.php");
}
?>
