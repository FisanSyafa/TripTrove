<?php
session_start();
include '../includes/koneksi.php';

// Pastikan user sudah login sebelum mengakses halaman ini
if (!isset($_SESSION['username'])) {
    echo "Anda harus login untuk mengedit booking Anda.";
    exit();
}

// Ambil data booking yang akan diedit
if (isset($_GET['booking_id'])) {
    $booking_id = $_GET['booking_id'];
    $query_booking = "SELECT * FROM bookings WHERE booking_id = ?";
    $stmt_booking = mysqli_prepare($link, $query_booking);
    mysqli_stmt_bind_param($stmt_booking, "i", $booking_id);
    mysqli_stmt_execute($stmt_booking);
    $result_booking = mysqli_stmt_get_result($stmt_booking);

    if ($result_booking && mysqli_num_rows($result_booking) > 0) {
        $data_booking = mysqli_fetch_assoc($result_booking);
    } else {
        echo "Error: Booking tidak ditemukan.";
        exit();
    }
} else {
    echo "Error: Booking ID tidak diberikan.";
    exit();
}

// Proses form edit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $person_amount = $_POST['person_amount'];
    $start_time = $_POST['start_time'];

    // Ambil durasi dari paket_trip terkait
    $query_durasi = "SELECT durasi, harga FROM paket_trip WHERE nama_paket_trip = ?";
    $stmt_durasi = mysqli_prepare($link, $query_durasi);
    mysqli_stmt_bind_param($stmt_durasi, "s", $data_booking['nama_paket_trip']);
    mysqli_stmt_execute($stmt_durasi);
    $result_durasi = mysqli_stmt_get_result($stmt_durasi);
    $durasi_row = mysqli_fetch_assoc($result_durasi);
    $durasi = $durasi_row['durasi'];
    $harga_paket = $durasi_row['harga'];

    // Hitung end_time berdasarkan start_time dan durasi
    $end_time = date('Y-m-d', strtotime($start_time . ' + ' . ($durasi - 1) . ' days'));

    // Hitung total_price baru tanpa biaya tambahan kendaraan
    $total_price = $harga_paket * $person_amount;

    // Update booking dengan total_price baru dan set status menjadi PENDING
    $query_update = "UPDATE bookings SET person_amount = ?, start_time = ?, end_time = ?, total_price = ?, status = 'PENDING' WHERE booking_id = ?";
    $stmt_update = mysqli_prepare($link, $query_update);
    mysqli_stmt_bind_param($stmt_update, "issdi", $person_amount, $start_time, $end_time, $total_price, $booking_id);

    if (mysqli_stmt_execute($stmt_update)) {
        echo "Booking berhasil diperbarui.";
        header("Location: tampil_booking.php");
        exit();
    } else {
        echo "Error: " . mysqli_error($link);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Booking</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h1>Edit Booking</h1>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) . "?booking_id=" . $booking_id; ?>" method="POST">
            <div class="form-group">
                <label for="person_amount">Jumlah Orang</label>
                <input type="number" class="form-control" id="person_amount" name="person_amount" value="<?php echo $data_booking['person_amount']; ?>" required>
            </div>
            <div class="form-group">
                <label for="start_time">Tanggal Mulai</label>
                <input type="date" class="form-control" id="start_time" name="start_time" value="<?php echo $data_booking['start_time']; ?>" required>
            </div>
            <button type="submit" class="btn btn-primary">Update</button>
        </form>
    </div>
</body>
</html>
