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
<?php 
session_start();
include '../../includes/koneksi.php';
if(!isset($_SESSION['admin_name'])){
    header('Location: ../index.php');
    exit();
}

$admin_name = $_SESSION['admin_name'];
$sql = "SELECT * FROM bookings ORDER BY created_date DESC";
$result = mysqli_query($link, $sql);
?>
    <?php include '../../includes/navbar.php'; ?>
        <div id="layoutSidenav">
            <?php include '../../includes/sidebar.php'; ?>
        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid px-4">
                    <h1 class="mt-4">Data Booking</h1>
                    <ol class="breadcrumb mb-4">
                    <li class="breadcrumb-item"><a href="../dashboard/dashboard.php">Dashboard</a></li>
                        <li class="breadcrumb-item active">Booking</li>
                    </ol>
                    <div class="card mb-4">
                        <div class="card-body">
                        <table class="table table-striped" id="datatablesSimple">
                                <thead>
                                    <tr>
                                        <th>Id</th>
                                        <th>Nama</th>
                                        <th>Paket</th>
                                        <th>Jenis Kendaraan</th>
                                        <th>Jumlah</th>
                                        <th>Mulai</th>
                                        <th>Berakhir</th>
                                        <th>Total Harga</th>
                                        <th>Status</th>
                                        <th>Dibuat Pada</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                                        <tr>
                                            <td><?php echo $row['booking_id']; ?></td>
                                            <td><?php echo $row['username']; ?></td>
                                            <td><?php echo $row['nama_paket_trip']; ?></td>
                                            <td>
                                                <select class="form-control" name="kode_jenis" data-booking-id="<?php echo $row['booking_id']; ?>" onchange="updateJenisKendaraan(this)">
                                                    <option value="">None</option>
                                                    <?php
                                                    // Fetch unique vehicle types using DISTINCT
                                                    $tipe_kendaraan_sql = "SELECT DISTINCT kode_jenis FROM tipe_kendaraan";
                                                    $tipe_kendaraan_result = mysqli_query($link, $tipe_kendaraan_sql);
                                                    while ($type = mysqli_fetch_assoc($tipe_kendaraan_result)) { ?>
                                                        <option value="<?php echo $type['kode_jenis']; ?>" <?php if($row['kode_jenis'] == $type['kode_jenis']) echo 'selected'; ?>>
                                                            <?php echo $type['kode_jenis']; ?>
                                                        </option>
                                                    <?php } ?>
                                                </select>
                                            </td>
                                            <td><?php echo $row['person_amount']; ?> orang</td>
                                            <td><?php echo $row['start_time']; ?></td>
                                            <td><?php echo $row['end_time']; ?></td>
                                            <td>$<?php echo number_format($row['total_price'], 0, ',', '.'); ?></td>
                                            <td><?php echo $row['status']; ?></td>
                                            <td><?php echo $row['created_date']; ?></td>
                                            <td><a href="form_edit_booking.php?booking_id=<?php echo $row['booking_id']; ?>" class="btn btn-primary">Edit</a></td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </main>
            <?php include '../../includes/footer.php'; ?>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="../../js/scripts.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js" crossorigin="anonymous"></script>
    <script src="../../js/datatables-simple-demo.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <script>
    // Function to handle updating the selected vehicle type
    function updateJenisKendaraan(selectElement) {
        var bookingId = selectElement.getAttribute('data-booking-id');
        var kodeJenis = selectElement.value;

        // Send the selected data to the server using AJAX
        var xhr = new XMLHttpRequest();
        xhr.open('POST', 'update_jenis_kendaraan.php', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.onload = function() {
            if (xhr.status == 200) {
                alert('Jenis kendaraan berhasil diperbarui!');
            } else {
                alert('Gagal memperbarui jenis kendaraan!');
            }
        };
        xhr.send('booking_id=' + bookingId + '&kode_jenis=' + kodeJenis);
    }
    </script>
</body>
</html>
