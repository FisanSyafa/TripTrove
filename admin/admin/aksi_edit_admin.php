<?php 
session_start();
    include "../../includes/koneksi.php";

    // Mendapatkan data dari form
    $admin_id = $_POST['admin_id'];
    $admin_name = $_POST['admin_name'];
    $admin_password = $_POST['admin_password'];
    $admin_email = $_POST['admin_email'];
    $alamat = $_POST['alamat'];
    $no_telp = $_POST['no_telp'];

    // Query update data admin
    $sql = "UPDATE admin SET admin_name='$admin_name', admin_password=SHA2('$admin_password', 256), admin_email='$admin_email', alamat='$alamat', no_telp='$no_telp' WHERE admin_id='$admin_id'";
    if (mysqli_query($link, $sql)) {
        header("location:tampil_data_admin.php");
    }
?>