<?php
session_start();
include '../../includes/koneksi.php';
if(!isset($_SESSION['admin_name'])){
    header('Location: ../index.php');
    exit();
}

$admin_name = $_SESSION['admin_name'];
$booking_id = $_GET['booking_id'];
$sql = "SELECT * FROM bookings WHERE booking_id='$booking_id'";
$result = mysqli_query($link, $sql);
$data = mysqli_fetch_assoc($result);

// data untuk dropdown
$kode_jenis_sql = "SELECT DISTINCT kode_jenis FROM tipe_kendaraan";
$kode_jenis_result = mysqli_query($link, $kode_jenis_sql);

$tipe_kendaraan_sql = "SELECT * FROM tipe_kendaraan";
$tipe_kendaraan_result = mysqli_query($link, $tipe_kendaraan_sql);

$drivers_sql = "SELECT * FROM drivers";
$drivers_result = mysqli_query($link, $drivers_sql);

$tour_guides_sql = "SELECT * FROM tour_guides";
$tour_guides_result = mysqli_query($link, $tour_guides_sql);

$available_cars_sql = "
    SELECT DISTINCT tk.nomor_polisi, tk.nama_mobil, tk.kode_jenis 
    FROM tipe_kendaraan tk
    LEFT JOIN bookings b ON tk.nomor_polisi = b.nomor_polisi
    WHERE b.nomor_polisi IS NULL OR NOT (
        (b.start_time <= '{$data['end_time']}' AND b.end_time >= '{$data['start_time']}') AND b.booking_id != '$booking_id'
    )";
$available_cars_result = mysqli_query($link, $available_cars_sql);

// Fetch available drivers
$available_drivers_sql = "
    SELECT d.driver_id, d.driver_name
    FROM drivers d
    WHERE NOT EXISTS (
        SELECT 1 FROM bookings b
        WHERE b.driver_id = d.driver_id
        AND b.start_time <= '{$data['end_time']}' 
        AND b.end_time >= '{$data['start_time']}'
        AND b.booking_id != '$booking_id'
    )";
$available_drivers_result = mysqli_query($link, $available_drivers_sql);

// Fetch available tour guides
$available_tour_guides_sql = "
    SELECT tg.tour_guide_id, tg.tour_guide_name
    FROM tour_guides tg
    WHERE NOT EXISTS (
        SELECT 1 FROM bookings b
        WHERE b.tour_guide_id = tg.tour_guide_id
        AND b.start_time <= '{$data['end_time']}'
        AND b.end_time >= '{$data['start_time']}'
        AND b.booking_id != '$booking_id'
    )";
$available_tour_guides_result = mysqli_query($link, $available_tour_guides_sql);
?>
<!DOCTYPE html>
<html lang="en">
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
    <?php include '../../includes/navbar.php'; ?>
    <div id="layoutSidenav">
        <?php include '../../includes/sidebar.php'; ?>
        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid px-4">
                    <h1 class="mt-4">Edit Booking</h1>
                    <ol class="breadcrumb mb-4">
                    <li class="breadcrumb-item"><a href="../dashboard/dashboard.php">Dashboard</a></li>
                        <li class="breadcrumb-item active">Booking</li>
                    </ol>
                    <div class="card mb-4">
                        <div class="container">
                            <form method="POST" action="aksi_edit_booking.php">
                                <input type="hidden" name="booking_id" value="<?php echo $data['booking_id']; ?>">
                                <div class="mb-3">
                                    <label for="cust_name" class="form-label">Nama</label>
                                    <input type="text" class="form-control" id="cust_name" name="cust_name" value="<?php echo $data['cust_name']; ?>">
                                </div>
                                <div class="mb-3">
                                    <label for="nama_paket_trip" class="form-label">Paket trip</label>
                                    <input type="text" class="form-control" id="nama_paket_trip" name="nama_paket_trip" value="<?php echo $data['nama_paket_trip']; ?>" disabled>
                                </div>
                                <div class="mb-3">
                                    <label for="kode_jenis" class="form-label">Jenis Kendaraan</label>
                                    <select class="form-control" id="kode_jenis" name="kode_jenis" onchange="filterMobil()" disabled>
                                        <?php 
                                        while ($row = mysqli_fetch_assoc($kode_jenis_result)) { ?>
                                            <option value="<?php echo $row['kode_jenis']; ?>" <?php if($data['kode_jenis'] == $row['kode_jenis']) echo 'selected'; ?>>
                                                <?php echo $row['kode_jenis']; ?>
                                            </option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="nomor_polisi" class="form-label">Nama Mobil</label>
                                    <select class="form-control" id="nomor_polisi" name="nomor_polisi">
                                        <option value="">Pilih Nama Mobil</option>
                                        <?php 
                                        while ($row = mysqli_fetch_assoc($available_cars_result)) {
                                            // Hanya tampilkan mobil yang memiliki kode jenis sesuai dengan yang dipilih
                                            if ($row['kode_jenis'] == $data['kode_jenis']) {
                                        ?>
                                            <option value="<?php echo $row['nomor_polisi']; ?>" <?php if($data['nomor_polisi'] == $row['nomor_polisi']) echo 'selected'; ?>>
                                                <?php echo $row['nama_mobil']; ?>
                                            </option>
                                        <?php 
                                            }
                                        } 
                                        ?>
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label for="driver_id" class="form-label">Nama Driver</label>
                                    <select class="form-control" id="driver_id" name="driver_id" >
                                        <option value="">Pilih Nama Driver</option>
                                        <?php while ($row = mysqli_fetch_assoc($available_drivers_result)) { ?>
                                            <option value="<?php echo $row['driver_id']; ?>" <?php if($data['driver_id'] == $row['driver_id']) echo 'selected'; ?>>
                                                <?php echo $row['driver_name']; ?>
                                            </option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="tour_guide_id" class="form-label">Nama Tour Guide</label>
                                    <select class="form-control" id="tour_guide_id" name="tour_guide_id" >
                                        <option value="">Pilih Nama Tour Guide</option>
                                        <?php while ($row = mysqli_fetch_assoc($available_tour_guides_result)) { ?>
                                            <option value="<?php echo $row['tour_guide_id']; ?>" <?php if($data['tour_guide_id'] == $row['tour_guide_id']) echo 'selected'; ?>>
                                                <?php echo $row['tour_guide_name']; ?>
                                            </option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="person_amount" class="form-label">Jumlah orang</label>
                                    <input type="text" class="form-control" id="person_amount" name="person_amount" value="<?php echo $data['person_amount']; ?>" disabled>
                                </div>
                                <div class="mb-3">
                                    <label for="start_time" class="form-label">Waktu Mulai</label>
                                    <input type="text" class="form-control" id="start_time" name="start_time" value="<?php echo $data['start_time']; ?>" disabled>
                                </div>
                                <div class="mb-3">
                                    <label for="end_time" class="form-label">Waktu Berakhir</label>
                                    <input type="text" class="form-control" id="end_time" name="end_time" value="<?php echo $data['end_time']; ?>" disabled>
                                </div>
                                <div class="mb-3">
                                    <label for="total_price" class="form-label">Total Harga</label>
                                    <input type="text" class="form-control" id="total_price" name="total_price" value="<?php echo $data['total_price']; ?>" disabled>
                                </div>
                                <div class="mb-3">
                                    <label for="status" class="form-label">Status</label>
                                    <select class="form-control" id="status" name="status" required>
                                        <option value="PENDING" <?php if($data['status'] == 'PENDING') echo 'selected'; ?>>PENDING</option>
                                        <option value="CONFIRMED" <?php if($data['status'] == 'CONFIRMED') echo 'selected'; ?>>CONFIRMED</option>
                                        <option value="CANCELED" <?php if($data['status'] == 'CANCELED') echo 'selected'; ?>>CANCELED</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="created_date" class="form-label">Dibuat Pada</label>
                                    <input type="text" class="form-control" id="created_date" name="created_date" value="<?php echo $data['created_date']; ?>" disabled>
                                </div>
                                <div class="card-header">
                                    <button type="submit" class="btn btn-primary">Simpan</button>
                                    <a href="tampil_data_booking.php" class="btn btn-secondary">Kembali</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </main>
            <?php include '../../includes/footer.php'; ?>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="js/scripts.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js" crossorigin="anonymous"></script>
    <script src="js/datatables-simple-demo.js"></script>
</body>
</html>
