<?php
session_start();
include '../../includes/koneksi.php';
if(!isset($_SESSION['admin_name'])){
    header('Location: ../index.php');
    exit();
}

$admin_name = $_SESSION['admin_name'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $tour_guide_name = $_POST['tour_guide_name'];
    $tour_guide_address = $_POST['tour_guide_address'];
    $tour_guide_no_telp = $_POST['tour_guide_no_telp'];

    $sql = "INSERT INTO tour_guides (tour_guide_name, tour_guide_address, tour_guide_no_telp) VALUES ('$tour_guide_name', '$tour_guide_address', '$tour_guide_no_telp')";

    if (mysqli_query($link, $sql)) {
        header("Location: tampil_tour_guide.php");
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($link);
    }

    mysqli_close($link);
}
?>