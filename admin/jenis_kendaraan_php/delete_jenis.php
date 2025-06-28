<?php
session_start();
include '../../includes/koneksi.php';
if(!isset($_SESSION['admin_name'])){
    header('Location: ../index.php');
    exit();
}

$admin_name = $_SESSION['admin_name'];

    $kode_jenis = $_GET['kode_jenis'];

    // Query hapus data product
    $sql = "DELETE FROM jenis_kendaraan WHERE kode_jenis= '$kode_jenis'";
    if (mysqli_query($link, $sql)) {
        header("location:tampil_data_jenis.php");
    }
?>