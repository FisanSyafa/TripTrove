<?php
include '../../includes/koneksi.php';

// Get data from the POST request
$booking_id = $_POST['booking_id'];
$kode_jenis = $_POST['kode_jenis'];

// Update the vehicle type in the bookings table
$sql = "UPDATE bookings SET kode_jenis='$kode_jenis' WHERE booking_id='$booking_id'";
if (mysqli_query($link, $sql)) {
    echo "Jenis kendaraan berhasil diperbarui.";
} else {
    echo "Error: " . mysqli_error($link);
}

mysqli_close($link);
?>
