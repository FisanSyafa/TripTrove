<!DOCTYPE html>
<html lang="en">

<?php
session_start();
include '../../includes/koneksi.php';
if(!isset($_SESSION['admin_name'])){
    header('Location: ../index.php');
    exit();
}

$admin_name = $_SESSION['admin_name'];
// Query untuk mengambil data pembayaran
$query_payments = "SELECT * FROM payment";
$result_payments = mysqli_query($link, $query_payments);

if (!$result_payments) {
    echo "Error: " . mysqli_error($link);
    exit();
}

// Query untuk menghitung total pendapatan dari semua booking dengan status 'DITERIMA'
$query_total_revenue = "SELECT SUM(b.total_price) AS total_revenue 
                        FROM bookings b
                        JOIN payment p ON b.booking_id = p.booking_id
                        WHERE p.status = 'DITERIMA'";
$result_total_revenue = mysqli_query($link, $query_total_revenue);
$total_revenue = 0;

if ($result_total_revenue && mysqli_num_rows($result_total_revenue) > 0) {
    $row = mysqli_fetch_assoc($result_total_revenue);
    $total_revenue = $row['total_revenue'];
} else {
    $total_revenue = 0; // Jika tidak ada data, set total pendapatan menjadi 0
}

// Query untuk menghitung pendapatan per bulan
$query_monthly_revenue = "SELECT MONTHNAME(b.created_date) AS month, SUM(b.total_price) AS total_revenue 
                          FROM bookings b
                          JOIN payment p ON b.booking_id = p.booking_id
                          WHERE p.status = 'DITERIMA'
                          GROUP BY MONTH(b.created_date)";
$result_monthly_revenue = mysqli_query($link, $query_monthly_revenue);
$monthly_revenues = [];

if ($result_monthly_revenue && mysqli_num_rows($result_monthly_revenue) > 0) {
    while ($row = mysqli_fetch_assoc($result_monthly_revenue)) {
        $monthly_revenues[$row['month']] = $row['total_revenue'];
    }
}

?>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
    <link href="../../css/styles.css" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
</head>
<body class="sb-nav-fixed">
<?php  include '../../includes/navbar.php'; ?>
        <div id="layoutSidenav">
            <?php include '../../includes/sidebar.php'; ?>
        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid px-4">
                    <h1 class="mt-4">Dashboard Admin</h1>
                    <ol class="breadcrumb mb-4">
                        <li class="breadcrumb-item active">Dashboard</li>
                    </ol>
                    <div class="row">
                        <div class="col-xl-3 col-md-6">
                            <div class="card bg-primary text-white mb-4">
                                <div class="card-body">Semua Order</div>
                                <div class="card-footer d-flex align-items-center justify-content-between">
                                    <a class="small text-white stretched-link" href="semua_order.php">View Details</a>
                                    <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-md-6">
                            <div class="card bg-warning text-white mb-4">
                                <div class="card-body">Order Pending</div>
                                <div class="card-footer d-flex align-items-center justify-content-between">
                                    <a class="small text-white stretched-link" href="order_pending.php">View Details</a>
                                    <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-md-6">
                            <div class="card bg-success text-white mb-4">
                                <div class="card-body">Order Diterima</div>
                                <div class="card-footer d-flex align-items-center justify-content-between">
                                    <a class="small text-white stretched-link" href="order_diterima.php">View Details</a>
                                    <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-md-6">
                            <div class="card bg-danger text-white mb-4">
                                <div class="card-body">Order Batal</div>
                                <div class="card-footer d-flex align-items-center justify-content-between">
                                    <a class="small text-white stretched-link" href="order_ditolak.php">View Details</a>
                                    <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                    <div class="col-xl-6 col-md-12">
                        <div class="card bg-info text-white mb-4">
                            <div class="card-body">Total Pendapatan Diterima</div>
                            <div class="card-footer d-flex align-items-center justify-content-between">
                                <div class="small text-white">$<?php echo number_format($total_revenue, 2); ?></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card mb-4">
                    <div class="card-body">
                        <form id="reportForm">
                            <div class="row">
                                <div class="col-md-5">
                                    <label for="startDate">Tanggal Mulai</label>
                                    <input type="date" id="startDate" class="form-control" required>
                                </div>
                                <div class="col-md-5">
                                    <label for="endDate">Tanggal Akhir</label>
                                    <input type="date" id="endDate" class="form-control" required>
                                </div>
                                <div class="col-md-2 d-flex align-items-end">
                                    <button type="button" class="btn btn-success" id="downloadReport" disabled>Download Laporan</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                    <div class="card mb-4">
                        <div class="card-body">
                            <table id="datatablesSimple">
                            <thead>
                                <tr>
                                    <th>ID Pembayaran</th>
                                    <th>Username</th>
                                    <th>Bukti Pembayaran</th>
                                    <th>Status</th>
                                    <th>Tanggal Dibuat</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php while ($row = mysqli_fetch_assoc($result_payments)): ?>
                                    <tr>
                                        <td><?php echo $row['id']; ?></td>
                                        <td><?php echo $row['username']; ?></td>
                                        <td><img src="../../booking_user/<?php echo $row['payment_proof']; ?>" class="img-thumbnail" style="max-width: 100px;"></td>
                                        <td><?php echo $row['status']; ?></td>
                                        <td><?php echo $row['created_date']; ?></td>
                                        <td><a href="edit_payment.php?id=<?php echo $row['id']; ?>" class="btn btn-primary btn-sm">Edit Status</a></td>
                                    </tr>
                                <?php endwhile; ?>
                            </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </main>
            <footer class="py-4 bg-light mt-auto">
                <div class="container-fluid px-4">
                    <div class="d-flex align-items-center justify-content-between small">
                        <div class="text-muted">Copyright &copy; Your Website 2023</div>
                        <div>
                            <a href="#">Privacy Policy</a>
                            &middot;
                            <a href="#">Terms &amp; Conditions</a>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
        crossorigin="anonymous"></script>
    <script src="../../js/scripts.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
    <script src="assets/demo/chart-area-demo.js"></script>
    <script src="assets/demo/chart-bar-demo.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js"
        crossorigin="anonymous"></script>
    <script src="../../js/datatables-simple-demo.js"></script>
</body>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const startDate = document.getElementById("startDate");
        const endDate = document.getElementById("endDate");
        const downloadButton = document.getElementById("downloadReport");

        function validateDates() {
            if (startDate.value && endDate.value && startDate.value <= endDate.value) {
                downloadButton.disabled = false;
            } else {
                downloadButton.disabled = true;
            }
        }

        startDate.addEventListener("change", validateDates);
        endDate.addEventListener("change", validateDates);

        downloadButton.addEventListener("click", function() {
            window.location.href = `download_report.php?start_date=${startDate.value}&end_date=${endDate.value}`;
        });
    });
</script>
</html>
