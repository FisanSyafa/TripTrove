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

    // Query tambah data product
    $sql = "INSERT INTO jenis_kendaraan (kode_jenis, jenis, charge ) VALUES ('$kode_jenis', '$jenis','$charge')";
    if (mysqli_query($link, $sql)) {
        header("location:tampil_data_jenis.php");
    } else {
        header("location:form_tambah_jenis.php");
    }
?>