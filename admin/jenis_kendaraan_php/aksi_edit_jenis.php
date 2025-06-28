<?php 
session_start();
include '../../includes/koneksi.php';
if(!isset($_SESSION['admin_name'])){
    header('Location: ../index.php');
    exit();
}

$admin_name = $_SESSION['admin_name'];

    // Mendapatkan data dari form
    $kode_jenis = $_POST['kode_jenis'];
    $jenis = $_POST['jenis'];
    $charge = $_POST['charge'];

    // Query update data product
    $sql = "UPDATE jenis_kendaraan SET kode_jenis='$kode_jenis', jenis='$jenis', charge='$charge' WHERE kode_jenis='$kode_jenis'";
    if (mysqli_query($link, $sql)) {
        header("location:tampil_data_jenis.php");
    }
?>  