<?php
session_start();
include '../../includes/koneksi.php';
if(!isset($_SESSION['admin_name'])){
    header('Location: ../index.php');
    exit();
}

$admin_name = $_SESSION['admin_name'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $original_nama_paket_trip = isset($_GET['nama_paket_trip']) ? $_GET['nama_paket_trip'] : '';
    $nama_paket_trip = $_POST['nama_paket_trip'];
    $destinasi = $_POST['destinasi'];
    $lokasi = $_POST['lokasi'];
    $deskripsi = $_POST['deskripsi'];
    $features = isset($_POST['features']) ? $_POST['features'] : [];
    
    $hotel = in_array('include', $features) ? 1 : 0;
    $include_hotel = in_array('hotel', $features) ? 1 : 0;
    $include_request = in_array('request', $features) ? 1 : 0;
    $include_entrance = in_array('entrance', $features) ? 1 : 0;
    $include_tip = in_array('tip', $features) ? 1 : 0;
    
    $durasi = $_POST['durasi'];
    $harga = $_POST['harga'];
    $diskon = $_POST['diskon'];

    // Ambil kategori dari form
    $kategori = isset($_POST['kategori']) ? mysqli_real_escape_string($link, $_POST['kategori']) : '';

    if (!empty($_FILES["image"]["name"])) {
        $target_dir = "../../assets/images/";
        $target_file = $target_dir . basename($_FILES["image"]["name"]);
        
        if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
            $image = "assets/images/" . basename($_FILES["image"]["name"]);
        } else {
            $image = isset($_POST['existing_image']) ? $_POST['existing_image'] : '';
        }
    } else {
        $image = isset($_POST['existing_image']) ? $_POST['existing_image'] : '';
    }

    if ($original_nama_paket_trip) {
        // Update existing record
        $sql = "UPDATE paket_trip SET 
                    nama_paket_trip='$nama_paket_trip', 
                    destinasi='$destinasi', 
                    lokasi='$lokasi', 
                    deskripsi='$deskripsi', 
                    hotel='$hotel',
                    include_hotel='$include_hotel',
                    include_request='$include_request',
                    include_entrance='$include_entrance',
                    include_tip='$include_tip',
                    image='$image', 
                    durasi='$durasi', 
                    harga='$harga',
                    diskon='$diskon',
                    kategori='$kategori'
                WHERE nama_paket_trip='$original_nama_paket_trip'";
    } else {
        // Insert new record
        $sql = "INSERT INTO paket_trip 
                (nama_paket_trip, destinasi, lokasi, deskripsi, hotel, include_hotel, include_request, include_entrance, include_tip, image, durasi, harga, diskon, kategori) 
                VALUES 
                ('$nama_paket_trip', '$destinasi', '$lokasi', '$deskripsi', '$hotel', '$include_hotel', '$include_request', '$include_entrance', '$include_tip', '$image', '$durasi', '$harga', '$diskon', '$kategori')";
    }

    if (mysqli_query($link, $sql)) {
        header("Location: tampil_paket.php");
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($link);
    }

    mysqli_close($link);
}
?>
