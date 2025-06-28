<?php
session_start();
include '../includes/koneksi.php';

// Pastikan user sudah login sebelum mengakses halaman ini
if (!isset($_SESSION['username'])) {
    echo "Anda harus login untuk melihat booking Anda.";
    exit();
}

// Ambil data booking pengguna beserta status pembayaran
$username = $_SESSION['username'];
$query_bookings = "
    SELECT 
        b.booking_id,
        b.nama_paket_trip,
        b.person_amount,
        b.start_time,
        b.end_time,
        pt.harga AS harga_paket,
        jk.charge AS biaya_tambahan,
        b.status AS booking_status,
        COALESCE(p.status, 'BELUM DIBAYAR') AS payment_status
    FROM 
        bookings b
        JOIN paket_trip pt ON b.nama_paket_trip = pt.nama_paket_trip
        LEFT JOIN jenis_kendaraan jk ON b.kode_jenis = jk.kode_jenis
        LEFT JOIN payment p ON b.booking_id = p.booking_id
    WHERE 
        b.username = ?
    ORDER BY 
        b.created_date DESC
";
$stmt_bookings = mysqli_prepare($link, $query_bookings);
mysqli_stmt_bind_param($stmt_bookings, "s", $username);
mysqli_stmt_execute($stmt_bookings);
$result_bookings = mysqli_stmt_get_result($stmt_bookings);

// Handle delete request
if (isset($_GET['delete_booking_id'])) {
    $delete_booking_id = $_GET['delete_booking_id'];

    // Pastikan booking milik pengguna saat ini
    $query_check = "SELECT start_time FROM bookings WHERE booking_id = ? AND username = ?";
    $stmt_check = mysqli_prepare($link, $query_check);
    mysqli_stmt_bind_param($stmt_check, "is", $delete_booking_id, $username);
    mysqli_stmt_execute($stmt_check);
    $result_check = mysqli_stmt_get_result($stmt_check);
    $data_booking = mysqli_fetch_assoc($result_check);

    if ($data_booking) {
        $start_time = $data_booking['start_time'];
        $current_date = date('Y-m-d');
        $days_diff = floor((strtotime($start_time) - strtotime($current_date)) / (60 * 60 * 24));

        if ($days_diff < 3) {
            echo "Anda hanya dapat menghapus booking hingga 3 hari sebelum tanggal mulai.";
            exit();
        }

        // Hapus booking
        $query_delete = "DELETE FROM bookings WHERE booking_id = ?";
        $stmt_delete = mysqli_prepare($link, $query_delete);
        mysqli_stmt_bind_param($stmt_delete, "i", $delete_booking_id);

        if (mysqli_stmt_execute($stmt_delete)) {
            echo "Booking berhasil dihapus.";
            header("Location: tampil_booking.php");
            exit();
        } else {
            echo "Error: " . mysqli_error($link);
        }
    } else {
        echo "Error: Booking tidak ditemukan atau tidak dapat dihapus.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booked Trips</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .table th, .table td {
            vertical-align: middle;
        }
        .confirmed {
            color: green;
        }
        .canceled {
            color: red;
        }
        .btn-pay {
            background-color: #28a745;
            color: white;
        }
        .btn-pay:hover {
            background-color: #218838;
        }
        .table thead {
            background-color: #343a40;
            color: #ffffff;
        }
        .table tbody tr:hover {
            background-color: #e9ecef;
        }
        .container {
            background-color: #ffffff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.2);
        }
        h1 {
            margin-bottom: 20px;
            color: #343a40;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <h1 class="mb-4">Booked Trips</h1>
        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th>Trip Name</th>
                        <th>Person Amount</th>
                        <th>Start</th>
                        <th>Finish</th>
                        <th>Trip Price</th>
                        <th>Additional Cost</th>
                        <th>Total Price</th>
                        <th>Booking Status</th>
                        <th>Action/Payment Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = mysqli_fetch_assoc($result_bookings)) {
                        // Hitung total harga
                        $total_price = $row['harga_paket'] * $row['person_amount'] + $row['biaya_tambahan'];

                        // Hitung selisih hari
                        $start_time = $row['start_time'];
                        $current_date = date('Y-m-d');
                        $days_diff = floor((strtotime($start_time) - strtotime($current_date)) / (60 * 60 * 24));

                        // Status pembayaran
                        $payment_status_html = '';

                        if ($row['payment_status'] == 'DITERIMA') {
                            $payment_status_html = '<i class="fas fa-check-circle confirmed"></i> Confirmed';
                        } elseif ($row['payment_status'] == 'DITOLAK') {
                            $payment_status_html = '<i class="fas fa-times-circle canceled"></i> Canceled';
                        } else {
                            if ($days_diff < 3) {
                                // Jika dalam 3 hari sebelum trip, hanya boleh bayar
                                if ($row['booking_status'] == 'CONFIRMED') {
                                    $payment_status_html .= '<br><a href="payment.php?booking_id=' . htmlspecialchars($row['booking_id']) . '" class="btn btn-pay btn-sm">Pay Now</a>';
                                } else {
                                    $payment_status_html = 'Cannot edit or delete after 3 days before the trip.';
                                }
                            } else {
                                // Sebelum 3 hari, bisa edit, hapus, atau bayar
                                $payment_status_html = '<a href="edit_booking.php?booking_id=' . htmlspecialchars($row['booking_id']) . '" class="btn btn-primary btn-sm">Edit</a>';
                                $payment_status_html .= '<a href="tampil_booking.php?delete_booking_id=' . htmlspecialchars($row['booking_id']) . '" class="btn btn-danger btn-sm" onclick="return confirm(\'Are you sure you want to cancel this booking?\');">Cancel</a>';
                                if ($row['booking_status'] == 'CONFIRMED') {
                                    $payment_status_html .= '<a href="payment.php?booking_id=' . htmlspecialchars($row['booking_id']) . '" class="btn btn-pay btn-sm">Pay Now</a>';
                                }
                            }
                        }
                    ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['nama_paket_trip']); ?></td>
                            <td><?php echo htmlspecialchars($row['person_amount']); ?></td>
                            <td><?php echo date('d F Y', strtotime($row['start_time'])); ?></td>
                            <td><?php echo date('d F Y', strtotime($row['end_time'])); ?></td>
                            <td><?php echo 'US$ ' . number_format($row['harga_paket'], 2); ?></td>
                            <td><?php echo 'US$ ' . number_format($row['biaya_tambahan'], 2); ?></td>
                            <td><?php echo 'US$ ' . number_format($total_price, 2); ?></td>
                            <td><?php echo htmlspecialchars($row['booking_status']); ?></td>
                            <td><?php echo $payment_status_html; ?></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
        <a href="../user_login.php" class="btn btn-secondary btn-sm mt-3">Back</a>
    </div>
</body>
</html>
