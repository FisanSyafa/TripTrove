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
$kode_jenis = $_GET['kode_jenis'];

// Query untuk mengambil data kendaraan berdasarkan nomor polisi
$sql = "SELECT * FROM jenis_kendaraan WHERE kode_jenis='$kode_jenis'";
$result = mysqli_query($link, $sql);
$data = mysqli_fetch_assoc($result);
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
                            <form method="POST" action="aksi_edit_jenis.php">
                                <div class="mb-3">
                                    <label for="kode_jenis" class="form-label">Kode Jenis</label>
                                    <input type="text" class="form-control" id="kode_jenis" name="kode_jenis" value="<?php echo $data['kode_jenis']; ?>" required>
                                </div>
                                <div class="mb-3">
                                    <label for="jenis" class="form-label">Jenis Kendaraan</label>
                                    <input type="text" class="form-control" id="jenis" name="jenis" value="<?php echo $data['jenis']; ?>" required>
                                </div>
                                <div class="mb-3">
                                    <label for="charge" class="form-label">Biaya Tambahan</label>
                                    <input type="text" class="form-control" id="charge" name="charge" value="<?php echo $data['charge']; ?>" required>
                                </div>
                                <div class="card-header">
                                    <button type="submit" class="btn btn-primary">Simpan</button>
                                    <a href="tampil_data_jenis.php" class="btn btn-secondary">Kembali</a>
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
