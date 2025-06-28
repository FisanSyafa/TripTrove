<?php 
session_start();
include '../../includes/koneksi.php';
if(!isset($_SESSION['admin_name'])){
    header('Location: ../index.php');
    exit();
}

$admin_name = $_SESSION['admin_name'];

    // Mendapatkan data dari form
    $nama_mobil = $_POST['nama_mobil'];
    $jenis_mobil = $_POST['jenis_mobil'];
    $warna_mobil = $_POST['warna_mobil'];
    $nomor_polisi = $_POST['nomor_polisi'];

    // Query update data product
    $sql = "UPDATE tipe_kendaraan SET nama_mobil='$nama_mobil', jenis_mobil='$jenis_mobil', warna_mobil='$warna_mobil', nomor_polisi='$nomor_polisi' WHERE nomor_polisi='$nomor_polisi'";
    if (mysqli_query($link, $sql)) {
        header("location:tampil_data_kendaraan.php");
    }
?>  