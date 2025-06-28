<?php 
session_start();
include '../../includes/koneksi.php';
if(!isset($_SESSION['admin_name'])){
    header('Location: ../index.php');
    exit();
}

$admin_name = $_SESSION['admin_name'];

    // Mendapatkan data dari form
    $username = $_POST['username'];
    $password = $_POST['password'];
    $email = $_POST['email'];
    $no_telp = $_POST['no_telp'];

    // Query update data product
    $sql = "UPDATE users SET username='$username', password=SHA2('$password', 256), email='$email', no_telp='$no_telp' WHERE username='$username'";
    if (mysqli_query($link, $sql)) {
        header("location:tampil_data_users.php");
    }
?>  