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

    // Query tambah data product
    $sql = "INSERT INTO tipe_kendaraan (nomor_polisi, nama_mobil, kode_jenis, warna_mobil) VALUES ('$nomor_polisi', '$nama_mobil', '$kode_jenis', '$warna_mobil')";
    if (mysqli_query($link, $sql)) {
        header("location:tampil_data_kendaraan.php");
    } else {
        header("location:form_tambah_kendaraan.php");
    }
?>