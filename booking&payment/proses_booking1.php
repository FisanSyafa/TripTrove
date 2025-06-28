<?php
include '../includes/koneksi_login.php';

// Ambil mata uang dari URL (default: USD)
$currency = isset($_POST['currency']) ? $_POST['currency'] : 'USD';

// Ambil kurs mata uang real-time dari API
$api_url = "https://api.exchangerate-api.com/v4/latest/USD";
$exchange_rates = json_decode(@file_get_contents($api_url), true);

// Default kurs jika API gagal diakses
$rates = [
    'USD' => 1,
    'MYR' => $exchange_rates['rates']['MYR'] ?? 4.2,
    'IDR' => $exchange_rates['rates']['IDR'] ?? 15000,
    'EUR' => $exchange_rates['rates']['EUR'] ?? 0.92,
    'SGD' => $exchange_rates['rates']['SGD'] ?? 1.35
];

// Pastikan kurs tersedia, jika tidak gunakan USD
$rate = $rates[$currency] ?? 1;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama_paket_trip = $_POST['nama_paket_trip'];
    $start_time = $_POST['start_time'];
    $person_amount = $_POST['person'];

    // Ambil data harga, diskon, dan durasi dari database
    $query = "SELECT destinasi, harga, COALESCE(diskon, 0) AS diskon, durasi FROM paket_trip WHERE nama_paket_trip = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "s", $nama_paket_trip);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($result && mysqli_num_rows($result) > 0) {
        $data = mysqli_fetch_assoc($result);
        $destinasi = $data['destinasi'];
        $harga_asli = (float) $data['harga'];
        $diskon = (int) $data['diskon'];
        $durasi_str = $data['durasi'];

        // Hitung harga setelah diskon
        $harga_setelah_diskon = ($diskon > 0) ? $harga_asli - ($harga_asli * ($diskon / 100)) : $harga_asli;

         // Parsing durasi
         $durasi_jumlah = 0;
         $durasi_satuan = "";
         if (preg_match('/(\d+)\s*(Days|Hours)/i', $durasi_str, $matches)) {
             $durasi_jumlah = (int) $matches[1];
             $durasi_satuan = strtolower($matches[2]); // Menjadi "days" atau "hours"
         }
 
         // Hitung end_time berdasarkan durasi trip
         $start_date = new DateTime($start_time);
         $end_date = clone $start_date;
 
         if ($durasi_satuan === "days") {
             $end_date->modify("+".($durasi_jumlah - 1)." days"); // Dikurangi 1 agar hari pertama dihitung
             $end_time = $end_date->format('Y-m-d'); // Format tanggal saja
         } elseif ($durasi_satuan === "hours") {
             $end_date->modify("+$durasi_jumlah hours");
             $end_time = $end_date->format('Y-m-d'); // Format dengan jam
         } else {
             $end_time = $start_date->format('Y-m-d'); // Default jika durasi tidak dikenali
         }

        // Konversi harga sesuai mata uang yang dipilih
        $harga_asli_converted = $harga_asli * $rate;
        $harga_setelah_diskon_converted = $harga_setelah_diskon * $rate;

        function roundToNearestFiveCents($amount) {
            return round($amount * 20) / 20; // Membulatkan ke kelipatan 0.05 MYR
        }
        
        if ($currency == 'IDR') {
            $harga_asli_converted = floor($harga_asli_converted / 1000) * 1000;
            $harga_setelah_diskon_converted = floor($harga_setelah_diskon_converted / 1000) * 1000;
        } elseif ($currency == 'MYR') {
            $harga_asli_converted = roundToNearestFiveCents($harga_asli_converted);
            $harga_setelah_diskon_converted = roundToNearestFiveCents($harga_setelah_diskon_converted);
            $total_price_converted = roundToNearestFiveCents($total_price_converted);
        } else {
            $harga_asli_converted = floor($harga_asli_converted * 100) / 100;
            $harga_setelah_diskon_converted = floor($harga_setelah_diskon_converted * 100) / 100;
            $total_price_converted = floor($total_price_converted * 100) / 100;
        }
        

        // Hitung total harga dalam mata uang pilihan
        $total_price_converted = $harga_setelah_diskon_converted * $person_amount;

        // Simbol mata uang
        $currency_symbols = [
            'USD' => 'US$',
            'MYR' => 'RM',
            'IDR' => 'Rp',
            'EUR' => '€',
            'SGD' => 'S$'
        ];
        $currency_symbol = $currency_symbols[$currency] ?? 'US$';

        // Simpan ke database
        $query_insert = "INSERT INTO bookings (nama_paket_trip, person_amount, start_time, total_price, created_date, status) 
                         VALUES (?, ?, ?, ?, NOW(), 'PENDING')";
        $stmt_insert = mysqli_prepare($conn, $query_insert);
        mysqli_stmt_bind_param($stmt_insert, "sisd", $nama_paket_trip, $person_amount, $start_time, $total_price_converted);
        $success = mysqli_stmt_execute($stmt_insert);

        if ($success) {
            $booking_id = mysqli_insert_id($conn);

            // Update total_order pada tabel paket_trip
            $query_update_order = "UPDATE paket_trip SET total_order = COALESCE(total_order, 0) + 1 WHERE nama_paket_trip = ?";
            $stmt_update_order = mysqli_prepare($conn, $query_update_order);
            mysqli_stmt_bind_param($stmt_update_order, "s", $nama_paket_trip);
            mysqli_stmt_execute($stmt_update_order);

            // Format pesan WhatsApp
            $message = "Hello, I would like to book the following trip package:\n\n" .
                "Booking ID: $booking_id\n" .
                "Package Name: $nama_paket_trip\n" .
                "Destination: $destinasi\n" .
                "Start Date: $start_time\n" .
                "End Date: $end_time\n" .
                "Number of Person: $person_amount\n" .
                "Original Price: $currency_symbol " . number_format($harga_asli_converted, 2) . "\n" .
                "Discount: $diskon%\n" .
                "Final Price Per Person: $currency_symbol " . number_format($harga_setelah_diskon_converted, 2) . "\n" .
                "Total Price: $currency_symbol " . number_format($total_price_converted, 2) . "\n\n" .
                "Please confirm availability. Thank you!";

            // Kirim ke WhatsApp
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
