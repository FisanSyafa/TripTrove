<?php
session_start();
include '../../includes/koneksi.php';
if(!isset($_SESSION['admin_name'])){
    header('Location: ../index.php');
    exit();
}

$admin_name = $_SESSION['admin_name'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Paket Trip</title>
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
    <link href="../../css/styles.css" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
</head>
<body>
<?php include '../../includes/navbar.php'; ?>
<div id="layoutSidenav">
    <?php include '../../includes/sidebar.php'; ?>
    <div id="layoutSidenav_content">
        <main>
            <div class="container-fluid px-4">
                <h1 class="mt-4">Tambah Paket Trip</h1>
                <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item"><a href="../dashboard/dashboard.php">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="tampil_paket.php">Paket Trip</a></li>
                    <li class="breadcrumb-item active">Tambah Paket Trip</li>
                </ol>
                <div class="card mb-4">
                    <div class="card-body">
                        <form action="simpan_paket.php" method="POST" enctype="multipart/form-data">
                            <div class="mb-3">
                                <label for="nama_paket_trip" class="form-label">Nama Paket Trip:</label>
                                <input type="text" class="form-control" name="nama_paket_trip" required>
                            </div>
                            <div class="mb-3">
                                <label for="destinasi" class="form-label">Destinasi:</label>
                                <input type="text" class="form-control" name="destinasi" required>
                            </div>
                            <div class="mb-3">
                                <label for="lokasi" class="form-label">Lokasi mulai</label>
                                <textarea class="form-control" name="lokasi" rows="5" required></textarea>
                            </div>
                            <div class="mb-3">
                                <label for="deskripsi" class="form-label">Deskripsi</label>
                                <textarea class="form-control" name="deskripsi" rows="5" required></textarea>
                            </div>
                            <div class="mb-3">
                                <label for="features" class="form-label">Include</label>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="features[]" value="include" id="include">
                                    <label class="form-check-label" for="include">Hotel Include</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="features[]" value="hotel" id="hotel" >
                                    <label class="form-check-label" for="hotel">Hotel pickup dan dropoff</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="features[]" value="request" id="request" >
                                    <label class="form-check-label" for="request">Pilihan pickup dan dropoff di Bandara Yogyakarta</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="features[]" value="entrance" id="entrance">
                                    <label class="form-check-label" for="entrance">Tiket masuk</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="features[]" value="tip" id="tip">
                                    <label class="form-check-label" for="tip">Tip untuk driver</label>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="image" class="form-label">Gambar:</label>
                                <input type="file" class="form-control" name="image" required>
                            </div>
                            <div class="mb-3">
                                <label for="durasi" class="form-label">Durasi:</label>
                                <input type="text" class="form-control" name="durasi" required>
                            </div>
                            <div class="mb-3">
                                <label for="harga" class="form-label">Harga:</label>
                                <input type="text" class="form-control" name="harga" required>
                            </div>
                            <div class="mb-3">
                                <label for="diskon" class="form-label">Diskon:</label>
                                <input type="text" class="form-control" name="diskon" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Kategori</label>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="kategori" value="Long Trip" id="long_trip" required>
                                    <label class="form-check-label" for="long_trip">Long Trip</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="kategori" value="Short Trip" id="short_trip" required>
                                    <label class="form-check-label" for="short_trip">Short Trip</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="kategori" value="Half Day" id="half_day" required>
                                    <label class="form-check-label" for="half_day">Half Day</label>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </form>
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
</body>
</html>
