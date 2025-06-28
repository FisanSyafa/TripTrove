<?php 
include "../../includes/koneksi.php";

$booking_id = $_POST['booking_id'];
$status = $_POST['status'];

$nomor_polisi = isset($_POST['nomor_polisi']) ? $_POST['nomor_polisi'] : null;
$driver_id = isset($_POST['driver_id']) ? $_POST['driver_id'] : null;
$tour_guide_id = isset($_POST['tour_guide_id']) ? $_POST['tour_guide_id'] : null;

$updateFields = [];

if (!empty($nomor_polisi)) {
    $updateFields[] = "nomor_polisi='$nomor_polisi'";
}
if (!empty($driver_id)) {
    $updateFields[] = "driver_id='$driver_id'";
}
if (!empty($tour_guide_id)) {
    $updateFields[] = "tour_guide_id='$tour_guide_id'";
}

$updateFields[] = "status='$status'";

$updateQuery = "UPDATE bookings SET " . implode(", ", $updateFields) . " WHERE booking_id='$booking_id'";

if (mysqli_query($link, $updateQuery)) {
    header("Location: dashboard.php");
    exit();
} else {
    echo "Error: " . $updateQuery . "<br>" . mysqli_error($link);
}
?>
