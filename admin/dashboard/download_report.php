<?php
session_start();
include '../../includes/koneksi.php';
if(!isset($_SESSION['admin_name'])){
    header('Location: ../index.php');
    exit();
}

$admin_name = $_SESSION['admin_name'];

// Menggunakan PhpSpreadsheet
require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

// Ambil parameter tanggal dari URL
$start_date = isset($_GET['start_date']) ? $_GET['start_date'] : '';
$end_date = isset($_GET['end_date']) ? $_GET['end_date'] : '';

// Validasi input tanggal
if (!$start_date || !$end_date) {
    die("Tanggal mulai dan akhir harus diisi.");
}

// Query dengan filter tanggal
$query = "SELECT
            booking_id, 
            cust_name, 
            status, 
            created_date, 
            nama_paket_trip, 
            kode_jenis, 
            person_amount, 
            total_price 
          FROM bookings
          WHERE status = 'CONFIRMED' 
          AND created_date BETWEEN '$start_date' AND '$end_date'";
$result = mysqli_query($link, $query);

if (!$result) {
    die("Query gagal dijalankan: " . mysqli_error($link));
}

// Inisialisasi Spreadsheet PhpSpreadsheet
$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

// Menambahkan informasi tanggal awal dan akhir di bagian atas
$sheet->setCellValue('A1', 'Laporan Pendapatan');
$sheet->setCellValue('A2', 'Periode: ' . $start_date . ' s/d ' . $end_date);

// Judul kolom
$sheet->setCellValue('A4', 'Booking ID');
$sheet->setCellValue('B4', 'Customer');
$sheet->setCellValue('C4', 'Status');
$sheet->setCellValue('D4', 'Tanggal Dibuat');
$sheet->setCellValue('E4', 'Nama Paket Trip');
$sheet->setCellValue('F4', 'Kode Jenis');
$sheet->setCellValue('G4', 'Jumlah Orang');
$sheet->setCellValue('H4', 'Total Harga($)');

// Menulis data dari database ke file Excel
$row = 5;
while ($row_data = mysqli_fetch_assoc($result)) {
    $sheet->setCellValue('A' . $row, $row_data['booking_id']);
    $sheet->setCellValue('B' . $row, $row_data['cust_name']);
    $sheet->setCellValue('C' . $row, $row_data['status']);
    $sheet->setCellValue('D' . $row, $row_data['created_date']);
    $sheet->setCellValue('E' . $row, $row_data['nama_paket_trip']);
    $sheet->setCellValue('F' . $row, $row_data['kode_jenis']);
    $sheet->setCellValue('G' . $row, $row_data['person_amount']);
    $sheet->setCellValue('H' . $row, $row_data['total_price']);
    $row++;
}

// Query untuk menghitung total pendapatan dalam rentang tanggal yang dipilih
$query_total_revenue = "SELECT SUM(total_price) AS total_revenue 
                        FROM bookings
                        WHERE status = 'CONFIRMED' 
                        AND created_date BETWEEN '$start_date' AND '$end_date'";
$result_total_revenue = mysqli_query($link, $query_total_revenue);

if ($result_total_revenue && mysqli_num_rows($result_total_revenue) > 0) {
    $row_data = mysqli_fetch_assoc($result_total_revenue);
    $total_revenue = $row_data['total_revenue'];
} else {
    $total_revenue = 0; // Jika tidak ada data, set total pendapatan menjadi 0
}

// Menambahkan informasi total pendapatan ke dalam file Excel
$sheet->setCellValue('A' . $row, 'Total Pendapatan');
$sheet->setCellValue('H' . $row, '$' . $total_revenue);

// Mengatur header untuk file Excel yang akan diunduh
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="laporan_pendapatan_' . $start_date . '_to_' . $end_date . '.xlsx"');
header('Cache-Control: max-age=0');

// Menyimpan file Excel
$writer = new Xlsx($spreadsheet);
$writer->save('php://output');
exit();
