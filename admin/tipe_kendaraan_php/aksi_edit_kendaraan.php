<?php 
session_start();
include '../../includes/koneksi.php';
if(!isset($_SESSION['admin_name'])){
    header('Location: ../index.php');
    exit();
}

$admin_name = $_SESSION['admin_name'];

    // Mendapatkan data dari form
    $nomor_polisi = $_POST['nomor_polisi'];
    $nama_mobil = $_POST['nama_mobil'];
    $kode_jenis = $_POST['kode_jenis'];
    $warna_mobil = $_POST['warna_mobil'];

    // Query update data product
    $sql = "UPDATE tipe_kendaraan SET nomor_polisi='$nomor_polisi', nama_mobil='$nama_mobil', kode_jenis='$kode_jenis', warna_mobil='$warna_mobil' WHERE nomor_polisi='$nomor_polisi'";
    if (mysqli_query($link, $sql)) {
        header("location:tampil_data_kendaraan.php");
    }
?>  