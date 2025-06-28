<?php 
session_start();
include "../../includes/koneksi.php";

$booking_id = $_POST['booking_id'];
$status = $_POST['status'];

$cust_name = isset($_POST['cust_name']) ? $_POST['cust_name'] : null;
$nomor_polisi = isset($_POST['nomor_polisi']) ? $_POST['nomor_polisi'] : null;
$driver_id = isset($_POST['driver_id']) ? $_POST['driver_id'] : null;
$tour_guide_id = isset($_POST['tour_guide_id']) ? $_POST['tour_guide_id'] : null;
$kode_jenis = isset($_POST['kode_jenis']) ? $_POST['kode_jenis'] : null;

$updateFields = [];

if (!empty($cust_name)) {
    $updateFields[] = "cust_name='$cust_name'";
}
if (!empty($nomor_polisi)) {
    $updateFields[] = "nomor_polisi='$nomor_polisi'";
}
if (!empty($driver_id)) {
    $updateFields[] = "driver_id='$driver_id'";
}
if (!empty($tour_guide_id)) {
    $updateFields[] = "tour_guide_id='$tour_guide_id'";
}
if (!empty($kode_jenis)) {
    $updateFields[] = "kode_jenis='$kode_jenis'";
}

$updateFields[] = "status='$status'";

$updateQuery = "UPDATE bookings SET " . implode(", ", $updateFields) . " WHERE booking_id='$booking_id'";

if (mysqli_query($link, $updateQuery)) {
    header("Location: tampil_data_booking.php");
    exit();
} else {
    echo "Error: " . $updateQuery . "<br>" . mysqli_error($link);
}
?>
