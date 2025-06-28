<?php
session_start();
include '../includes/koneksi.php';

// Aktifkan error reporting untuk debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Pastikan user sudah login sebelum mengakses halaman ini
if (!isset($_SESSION['username'])) {
    header("Location: ../login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Proses upload bukti pembayaran
    $upload_dir = 'uploads/';
    
    // Buat direktori upload jika belum ada
    if (!file_exists($upload_dir)) {
        mkdir($upload_dir, 0777, true);
    }

    // Pastikan file yang diupload adalah gambar
    $allowed_extensions = array('jpg', 'jpeg', 'png', 'gif');
    $file_name = $_FILES['payment_proof']['name'];
    $file_tmp = $_FILES['payment_proof']['tmp_name'];
    $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));

    if (!in_array($file_ext, $allowed_extensions)) {
        die("Error: Format file tidak didukung. Silakan upload file gambar (jpg, jpeg, png, gif).");
    }

    // Generate nama file unik untuk menghindari overwrite
    $new_file_name = uniqid().'.'.$file_ext;
    $payment_proof_path = $upload_dir . $new_file_name;

    // Move file ke folder uploads
    if (move_uploaded_file($file_tmp, $payment_proof_path)) {
        // Simpan data pembayaran ke database
        $username = $_SESSION['username'];
        $status = 'PENDING';
        $created_date = date('Y-m-d H:i:s');
        $booking_id = $_POST['booking_id'];

        // Validasi booking_id
        if (empty($booking_id) || !is_numeric($booking_id)) {
            die("Error: Booking ID tidak valid.");
        }

        $query_payment = "INSERT INTO payment (booking_id, username, payment_proof, status, created_date) 
                         VALUES (?, ?, ?, ?, ?)";
        $stmt_payment = mysqli_prepare($link, $query_payment);
        mysqli_stmt_bind_param($stmt_payment, "issss", $booking_id, $username, $payment_proof_path, $status, $created_date);

        if (mysqli_stmt_execute($stmt_payment)) {
            // Update status booking ke 'PAID'
            $update_booking = "UPDATE bookings SET status = 'PAID' WHERE booking_id = ?";
            $stmt_update = mysqli_prepare($link, $update_booking);
            mysqli_stmt_bind_param($stmt_update, "i", $booking_id);
            mysqli_stmt_execute($stmt_update);
            
            $_SESSION['payment_success'] = "Pembayaran berhasil disimpan. Menunggu konfirmasi dari admin.";
            header("Location: tampil_booking.php");
            exit();
        } else {
            die("Error: " . mysqli_error($link));
        }
    } else {
        die("Error: Gagal mengupload file.");
    }
}

// Validasi booking_id dari GET parameter
$booking_id = isset($_GET['booking_id']) ? (int)$_GET['booking_id'] : 0;
if ($booking_id <= 0) {
    die("Error: Booking ID tidak valid.");
}

// Query untuk mengambil metode pembayaran
$query_payment_methods = "SELECT * FROM payment_methods";
$result_payment_methods = mysqli_query($link, $query_payment_methods);

if (!$result_payment_methods) {
    die("Error: " . mysqli_error($link));
}

// Ambil data booking dengan verifikasi username
$username = $_SESSION['username'];
$query_last_booking = "SELECT bookings.*, 
                      bookings.total_price AS harga_paket,
                      paket_trip.image AS gambar_paket
                      FROM bookings
                      LEFT JOIN paket_trip ON bookings.nama_paket_trip = paket_trip.nama_paket_trip
                      WHERE bookings.booking_id = ? AND bookings.username = ?
                      LIMIT 1";

$stmt_last_booking = mysqli_prepare($link, $query_last_booking);
mysqli_stmt_bind_param($stmt_last_booking, "is", $booking_id, $username);
mysqli_stmt_execute($stmt_last_booking);
$result_last_booking = mysqli_stmt_get_result($stmt_last_booking);

if (!$result_last_booking || mysqli_num_rows($result_last_booking) == 0) {
    die("Error: Data booking tidak ditemukan atau Anda tidak memiliki akses ke booking ini.");
}

$data_last_booking = mysqli_fetch_assoc($result_last_booking);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload Bukti Pembayaran</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <style>
        .card {
            margin-top: 20px;
        }
        .card-title {
            margin-bottom: 10px;
        }
        .card-body {
            font-size: 14px;
        }
        .payment-instructions {
            margin-top: 20px;
        }
        .alert {
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <?php if (isset($_SESSION['payment_error'])): ?>
            <div class="alert alert-danger">
                <?php echo $_SESSION['payment_error']; unset($_SESSION['payment_error']); ?>
            </div>
        <?php endif; ?>
        
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        Upload Proof of Payment
                    </div>
                    <div class="card-body">
                        <h6 class="card-title">Booking Details</h6>
                        <?php if (!empty($data_last_booking['gambar_paket'])): ?>
                            <img src="../<?php echo htmlspecialchars($data_last_booking['gambar_paket']); ?>" class="img-fluid mb-3" alt="Gambar Paket Trip" style="max-width: 50%;">
                        <?php endif; ?>
                        <p><strong>Trip Name:</strong> <?php echo htmlspecialchars($data_last_booking['nama_paket_trip']); ?></p>
                        <p><strong>Person Amount:</strong> <?php echo htmlspecialchars($data_last_booking['person_amount']); ?></p>
                        <p><strong>Date Start:</strong> <?php echo htmlspecialchars($data_last_booking['start_time']); ?></p>
                        <p><strong>Date End:</strong> <?php echo htmlspecialchars($data_last_booking['end_time']); ?></p>
                        <p><strong>Trip Price:</strong> $<?php echo number_format($data_last_booking['harga_paket'], 2, ',', '.'); ?></p>
                        <p><strong>Additional Cost:</strong> <?php echo isset($data_last_booking['biaya_tambahan']) ? '$'.number_format((float)$data_last_booking['biaya_tambahan'], 0, ',', '.') : 'N/A'; ?></p>
                        <p><strong>Total Price:</strong> $<?php echo number_format($data_last_booking['total_price'], 2, ',', '.'); ?></p>
                    </div>
                </div>

                <div class="card payment-instructions">
                    <div class="card-header">
                        Payment Instructions
                    </div>
                    <div class="card-body">
                        <p>Please transfer to one of the following accounts:</p>
                        <ul>
                            <?php while ($row = mysqli_fetch_assoc($result_payment_methods)): ?>
                                <li><strong><?php echo htmlspecialchars($row['payment_method_name']); ?>:</strong> 
                                    <?php echo htmlspecialchars($row['payment_method_code']); ?>
                                </li>
                            <?php endwhile; ?>
                        </ul>
                    </div>
                </div>

                <div class="card">
                    <div class="card-body">
                        <h6 class="card-title">Upload Proof of Payment</h6>
                        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>?booking_id=<?php echo $booking_id; ?>" method="POST" enctype="multipart/form-data">
                            <input type="hidden" name="booking_id" value="<?php echo $booking_id; ?>">
                            <div class="form-group">
                                <label for="payment_proof">Proof of Payment (Max 2MB):</label>
                                <input type="file" class="form-control-file" id="payment_proof" name="payment_proof" accept="image/*" required>
                                <small class="form-text text-muted">Format: JPG, JPEG, PNG, GIF</small>
                            </div>
                            <button type="submit" class="btn btn-primary">Submit Payment</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>