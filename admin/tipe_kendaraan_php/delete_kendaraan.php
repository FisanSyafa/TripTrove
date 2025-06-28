<?php
session_start();
include '../../includes/koneksi.php';
if(!isset($_SESSION['admin_name'])){
    header('Location: ../index.php');
    exit();
}

$admin_name = $_SESSION['admin_name'];

    $nomor_polisi = $_GET['nomor_polisi'];

    // Query hapus data product
    $sql = "DELETE FROM tipe_kendaraan WHERE nomor_polisi= '$nomor_polisi'";
    if (mysqli_query($link, $sql)) {
        header("location:tampil_data_kendaraan.php");
    }
?>