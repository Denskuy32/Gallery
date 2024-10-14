<?php
session_start();
include "koneksi.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $fotoid = $_POST['fotoid'];
    $judulfoto = $_POST['judulfoto'];
    $deskripsifoto = $_POST['deskripsifoto'];
    $albumid = $_POST['albumid'];
    $lokasifile = $_FILES['lokasifile']['name'];

    // Prepare the update query
    $query = "UPDATE foto SET judulfoto=?, deskripsifoto=?, albumid=?";

    // Check if a new file was uploaded
    if (!empty($lokasifile)) {
        // Move the uploaded file to the desired directory
        move_uploaded_file($_FILES['lokasifile']['tmp_name'], "gambar/" . $lokasifile);
        $query .= ", lokasifile=?";
    }

    $query .= " WHERE fotoid=?";
    $stmt = $conn->prepare($query);

    // Bind parameters
    if (!empty($lokasifile)) {
        $stmt->bind_param("ssisi", $judulfoto, $deskripsifoto, $albumid, $lokasifile, $fotoid);
    } else {
        // If no new file, bind parameters without it
        $stmt->bind_param("ssii", $judulfoto, $deskripsifoto, $albumid, $fotoid);
    }

    // Execute the query
    if ($stmt->execute()) {
        header("Location: foto.php");
        exit();
    } else {
        echo "Error updating record: " . $stmt->error;
    }
}
?>
