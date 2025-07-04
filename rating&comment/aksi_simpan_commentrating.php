<?php
session_start();
include "../includes/koneksi.php";

// Pastikan user sudah login sebelum mengakses halaman ini
if (!isset($_SESSION['username'])) {
    header("Location: ../login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Mendapatkan data dari form
    $username = $_SESSION['username']; // Mengambil username dari session
    $nama_paket_trip = $_POST['nama_paket_trip']; // Mengambil nama_paket_trip dari form
    $region_id = $_POST['region_id'];
    $comment = $_POST['comment'];
    $comment_star = $_POST['comment_star'];
    $comment_date = $_POST['comment_date'];
    $image = $_FILES['image']['name'];

    // Validasi data input
    if (!empty($username) && !empty($nama_paket_trip) && !empty($region_id) && !empty($comment) && !empty($comment_star) && !empty($comment_date)) {
        if (!empty($_FILES["image"]["name"])) {
            $target_dir = "../assets/images/";
            $target_file = $target_dir . basename($_FILES["image"]["name"]);
            
            if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
                $image = "assets/images/" . basename($_FILES["image"]["name"]);
            } else {
                echo "Sorry, there was an error uploading your file.";
                exit;
            }
        } else {
            $image = isset($_POST['existing_image']) ? $_POST['existing_image'] : '';
        }

        // Query tambah data comment
        $sql = "INSERT INTO comments (username, nama_paket_trip, region_id, image, comment_star, comment, comment_date)
        VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = mysqli_prepare($link, $sql);
        
        if ($stmt) {
            // Bind parameter (s = string, i = integer)
            mysqli_stmt_bind_param($stmt, "sssisis", $username, $nama_paket_trip, $region_id, $image, $comment_star, $comment, $comment_date);
            
            // Jalankan statement
            if (mysqli_stmt_execute($stmt)) {
                // Sukses, redirect kembali
                header("Location: ../deskripsi/deskripsi_trip.php?nama_paket_trip=" . urlencode($nama_paket_trip));
                exit();
            } else {
                echo "Gagal mengeksekusi query: " . mysqli_stmt_error($stmt);
            }
        
            mysqli_stmt_close($stmt);
        } else {
            echo "Gagal mempersiapkan query: " . mysqli_error($link);
        }
    } else {
        echo "All fields are required.";
    }
}
?>
