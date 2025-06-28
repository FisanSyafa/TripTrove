<?php
include '../includes/koneksi_login.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama_paket_trip = $_POST['nama_paket_trip'];
    $start_time = $_POST['start_time'];
    $person_amount = $_POST['person'];

    // Ambil data harga, diskon, dan durasi dari tabel paket_trip
    $query = "SELECT harga, COALESCE(diskon, 0) AS diskon, durasi FROM paket_trip WHERE nama_paket_trip = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "s", $nama_paket_trip);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($result && mysqli_num_rows($result) > 0) {
        $data = mysqli_fetch_assoc($result);
        $harga_asli = (float) $data['harga']; // Pastikan harga berupa angka
        $diskon = (int) $data['diskon']; // Pastikan diskon berupa integer
        $durasi = (int) $data['durasi']; // Pastikan durasi berupa angka

        // Hitung harga setelah diskon jika ada
        $harga_setelah_diskon = ($diskon > 0) ? $harga_asli - ($harga_asli * ($diskon / 100)) : $harga_asli;

        // Hitung end_time berdasarkan durasi trip
        $start_date = new DateTime($start_time);
        $end_date = clone $start_date;
        $end_date->modify("+$durasi days");
        $end_time = $end_date->format('Y-m-d');

        // Hitung total harga
        $total_price = $harga_setelah_diskon * $person_amount;

        // Simpan ke database
        $query_insert = "INSERT INTO bookings (nama_paket_trip, person_amount, start_time, end_time, total_price) 
                         VALUES (?, ?, ?, ?, ?)";
        $stmt_insert = mysqli_prepare($conn, $query_insert);
        mysqli_stmt_bind_param($stmt_insert, "sissd", $nama_paket_trip, $person_amount, $start_time, $end_time, $total_price);
        $success = mysqli_stmt_execute($stmt_insert);

        if ($success) {
            // Redirect ke halaman WhatsApp
            $message = "Hello, I would like to book the following trip package:\n\n" .
                "Package Name: $nama_paket_trip\n" .
                "Start Date: $start_time\n" .
                "End Date: $end_time\n" .
                "Number of Person: $person_amount\n" .
                "Original Price: US$ " . number_format($harga_asli, 2) . "\n" .
                "Discount: $diskon%\n" .
                "Final Price Per Person: US$ " . number_format($harga_setelah_diskon, 2) . "\n" .
                "Total Price: US$ " . number_format($total_price, 2) . "\n\n" .
                "Please confirm availability. Thank you!";

            $whatsappURL = "https://api.whatsapp.com/send?phone=6281212399615&text=" . urlencode($message);
            header("Location: $whatsappURL");
            exit();
        } else {
            echo "Booking gagal. Silakan coba lagi.";
        }
    } else {
        echo "Paket trip tidak ditemukan.";
    }
} else {
    echo "Invalid request.";
}
?>
