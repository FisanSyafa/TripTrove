<?php
session_start();
include '../includes/koneksi.php';

// Pastikan user sudah login sebelum mengakses halaman ini
if (!isset($_SESSION['username'])) {
    echo "Anda harus login untuk melakukan booking.";
    exit();
}

// Ambil data dari form
$start_time = $_POST['start_time'];
$person_amount = $_POST['person'];

// Ambil nama_paket_trip dari parameter GET
if (isset($_GET['nama_paket_trip'])) {
    $nama_paket_trip = $_GET['nama_paket_trip'];
} else {
    echo "Nama Paket Trip tidak diberikan.";
    exit();
}

// Query untuk mendapatkan data paket_trip berdasarkan nama_paket_trip
$query_trip = "SELECT * FROM paket_trip WHERE nama_paket_trip = ?";
$stmt_trip = mysqli_prepare($link, $query_trip);
mysqli_stmt_bind_param($stmt_trip, "s", $nama_paket_trip);
mysqli_stmt_execute($stmt_trip);
$result_trip = mysqli_stmt_get_result($stmt_trip);

if ($result_trip && mysqli_num_rows($result_trip) > 0) {
    $data_trip = mysqli_fetch_assoc($result_trip);
    $durasi = $data_trip['durasi'];
    
    // Hitung harga dengan mempertimbangkan diskon
    $harga_normal = $data_trip['harga'];
    $diskon = isset($data_trip['diskon']) ? (int)$data_trip['diskon'] : 0;
    
    if ($diskon > 0) {
        $harga_per_orang = $harga_normal - ($harga_normal * ($diskon / 100));
    } else {
        $harga_per_orang = $harga_normal;
    }
    
    // Bulatkan harga jika perlu (sesuai dengan logika di deskripsi_trip.php)
    if ($currency == 'IDR') {
        $harga_per_orang = floor($harga_per_orang / 1000) * 1000;
    } elseif ($currency == 'MYR') {
        $harga_per_orang = round($harga_per_orang * 20) / 20; // Membulatkan ke 0.05
    } else {
        $harga_per_orang = floor($harga_per_orang * 100) / 100;
    }
    
} else {
    echo "Error: Data paket_trip tidak ditemukan.";
    exit();
}

// Hitung end_time berdasarkan durasi paket_trip
$end_time = date('Y-m-d', strtotime($start_time . ' + ' . ($durasi -1) . ' days'));

// Hitung total harga booking
$total_price = $harga_per_orang * $person_amount;

// Ambil username dari session
$username = $_SESSION['username'];

// Tentukan status dan tanggal pembuatan
$status = 'PENDING';

// Simpan data booking ke dalam tabel bookings
$query_booking = "INSERT INTO bookings (username, nama_paket_trip, kode_jenis, person_amount, start_time, end_time, total_price, status, created_date) 
                 VALUES (?, ?, ?, ?, ?, ?, ?, ?, NOW())";
$stmt_booking = mysqli_prepare($link, $query_booking);
mysqli_stmt_bind_param($stmt_booking, "sssissss", $username, $nama_paket_trip, $kode_jenis, $person_amount, $start_time, $end_time, $total_price, $status);

if (mysqli_stmt_execute($stmt_booking)) {
    $booking_id = mysqli_insert_id($link);
    // header("Location: ../booking_user/payment.php?booking_id=".$booking_id);
    $_SESSION['success'] = "Booking berhasil dibuat!";
    header("Location: ../booking_user/tampil_booking.php");
    exit();
} else {
    echo "Error: " . mysqli_error($link);
}
?>