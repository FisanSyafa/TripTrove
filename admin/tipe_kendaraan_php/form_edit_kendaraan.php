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

// Ambil nomor polisi dari parameter GET
$nomor_polisi = $_GET['nomor_polisi'];

// Query untuk mengambil data kendaraan berdasarkan nomor polisi
$sql = "SELECT * FROM tipe_kendaraan WHERE nomor_polisi='$nomor_polisi'";
$result = mysqli_query($link, $sql);
$data = mysqli_fetch_assoc($result);

// Query untuk menampilkan semua jenis kendaraan yang tersedia
$sql_jenis = "SELECT * FROM jenis_kendaraan";
$result_jenis = mysqli_query($link, $sql_jenis);
?>
   <?php  include '../../includes/navbar.php'; ?>
        <div id="layoutSidenav">
            <?php include '../../includes/sidebar.php'; ?>
        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid px-4">
                    <h1 class="mt-4">Edit Tipe Kendaraan</h1>
                    <ol class="breadcrumb mb-4">
                    <li class="breadcrumb-item"><a href="../dashboard/dashboard.php">Dashboard</a></li>
                        <li class="breadcrumb-item active">Kendaraan</li>
                    </ol>
                    <div class="card mb-4">
                        <div class="container">
                            <form method="POST" action="aksi_edit_kendaraan.php">
                                <div class="mb-3">
                                    <label for="nama_mobil" class="form-label">Nama Mobil</label>
                                    <input type="text" class="form-control" id="nama_mobil" name="nama_mobil" value="<?php echo $data['nama_mobil']; ?>" required>
                                </div>
                                <div class="mb-3">
                                    <label for="kode_jenis" class="form-label">Jenis Mobil</label>
                                    <select class="form-select" id="kode_jenis" name="kode_jenis" required>
                                        <option value="" disabled>Pilih Jenis Mobil</option>
                                        <?php
                                        // Loop untuk menampilkan semua opsi jenis mobil dari tabel jenis_kendaraan
                                        while ($row_jenis = mysqli_fetch_assoc($result_jenis)) {
                                            $selected = ($row_jenis['kode_jenis'] == $data['kode_jenis']) ? 'selected' : '';
                                            echo "<option value='" . $row_jenis['kode_jenis'] . "' $selected>" . $row_jenis['kode_jenis'] . "</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="warna_mobil" class="form-label">Warna Mobil</label>
                                    <input type="text" class="form-control" id="warna_mobil" name="warna_mobil" value="<?php echo $data['warna_mobil']; ?>" required>
                                </div>
                                <div class="mb-3">
                                    <label for="nomor_polisi" class="form-label">Nomor Polisi</label>
                                    <input type="text" class="form-control" id="nomor_polisi" name="nomor_polisi" value="<?php echo $data['nomor_polisi']; ?>" required>
                                </div>
                                <div class="card-header">
                                    <button type="submit" class="btn btn-primary">Simpan</button>
                                    <a href="tampil_data_kendaraan.php" class="btn btn-secondary">Kembali</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </main>
            <?php include '../../includes/footer.php'; ?>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
        crossorigin="anonymous"></script>
    <script src="js/scripts.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js"
        crossorigin="anonymous"></script>
    <script src="js/datatables-simple-demo.js"></script>
</body>
</html>
