<?php
session_start();
include '../../includes/koneksi.php';
if(!isset($_SESSION['admin_name'])){
    header('Location: ../index.php');
    exit();
}

$admin_name = $_SESSION['admin_name'];
$payment_data = null; // Inisialisasi variabel $payment_data
$payment_id = null; // Inisialisasi variabel $payment_id

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['id'])) {
    $payment_id = $_GET['id'];

    // Query untuk mengambil data pembayaran berdasarkan ID
    $query_payment = "SELECT * FROM payment WHERE id = ?";
    $stmt_payment = mysqli_prepare($link, $query_payment);
    mysqli_stmt_bind_param($stmt_payment, "i", $payment_id);
    mysqli_stmt_execute($stmt_payment);
    $result_payment = mysqli_stmt_get_result($stmt_payment);

    if ($result_payment && mysqli_num_rows($result_payment) > 0) {
        $payment_data = mysqli_fetch_assoc($result_payment);
    } else {
        echo "Pembayaran tidak ditemukan.";
        exit();
    }
} else if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['payment_id'])) {
    $payment_id = $_POST['payment_id'];
    $new_status = $_POST['status'];

    // Query untuk mengupdate status pembayaran
    $query_update = "UPDATE payment SET status = ? WHERE id = ?";
    $stmt_update = mysqli_prepare($link, $query_update);
    mysqli_stmt_bind_param($stmt_update, "si", $new_status, $payment_id);

    if (mysqli_stmt_execute($stmt_update)) {
        header("Location: tampil_payment.php"); // Mengarahkan ke halaman tampil_payment.php
        exit();
    } else {
        echo "Error: " . mysqli_error($link);
    }
} else {
    echo "Akses tidak sah.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Status Pembayaran</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <h2>Edit Status Pembayaran</h2>
                <?php if ($payment_data): // Pastikan $payment_data tidak null ?>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
                        <input type="hidden" name="payment_id" value="<?php echo htmlspecialchars($payment_id); ?>">
                        <div class="form-group">
                            <label for="status">Status Pembayaran:</label>
                            <select class="form-control" id="status" name="status">
                                <option value="PENDING" <?php if ($payment_data['status'] == 'PENDING') echo 'selected'; ?>>PENDING</option>
                                <option value="DITERIMA" <?php if ($payment_data['status'] == 'DITERIMA') echo 'selected'; ?>>DITERIMA</option>
                                <option value="DITOLAK" <?php if ($payment_data['status'] == 'DITOLAK') echo 'selected'; ?>>DITOLAK</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </form>
                <?php else: ?>
                    <p>Pembayaran tidak ditemukan atau terjadi kesalahan.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</body>
</html>
