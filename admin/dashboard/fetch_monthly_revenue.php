<?php
session_start();
include '../../includes/koneksi.php';
if(!isset($_SESSION['admin_name'])){
    header('Location: ../index.php');
    exit();
}

$admin_name = $_SESSION['admin_name'];

if (!isset($_GET['month'])) {
    http_response_code(400); // Bad request jika parameter bulan tidak ada
    exit();
}

$selectedMonth = $_GET['month'];

// Query untuk menghitung total pendapatan dari booking pada bulan yang dipilih dengan status 'DITERIMA'
$query_total_monthly_revenue = "SELECT SUM(p.total_price) AS total_revenue 
                                FROM bookings b
                                JOIN payment p ON b.booking_id = p.booking_id
                                WHERE p.status = 'DITERIMA' 
                                AND MONTHNAME(b.created_date) = '$selectedMonth'";
$result_total_monthly_revenue = mysqli_query($link, $query_total_monthly_revenue);

if ($result_total_monthly_revenue && mysqli_num_rows($result_total_monthly_revenue) > 0) {
    $row = mysqli_fetch_assoc($result_total_monthly_revenue);
    $totalRevenue = $row['total_revenue'];
    echo json_encode(['total_revenue' => $totalRevenue]);
} else {
    echo json_encode(['total_revenue' => 0]);
}
?>
