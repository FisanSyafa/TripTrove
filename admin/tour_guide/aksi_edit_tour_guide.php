<?php
session_start();
include '../../includes/koneksi.php';
if(!isset($_SESSION['admin_name'])){
    header('Location: ../index.php');
    exit();
}

$admin_name = $_SESSION['admin_name'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $tour_guide_id = $_POST['tour_guide_id'];
    $tour_guide_name = $_POST['tour_guide_name'];
    $tour_guide_address = $_POST['tour_guide_address'];
    $tour_guide_no_telp = $_POST['tour_guide_no_telp'];

    $sql = "UPDATE tour_guides SET tour_guide_name='$tour_guide_name', tour_guide_address='$tour_guide_address', tour_guide_no_telp='$tour_guide_no_telp' WHERE tour_guide_id=$tour_guide_id";

    if (mysqli_query($link, $sql)) {
        header("Location: tampil_tour_guide.php");
    } else {
        echo "Error updating record: " . mysqli_error($link);
    }

    mysqli_close($link);
}
?>