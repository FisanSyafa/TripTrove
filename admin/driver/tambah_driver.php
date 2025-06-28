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
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Admin Panel-Manage Drivers</title>
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
    <link href="../../css/styles.css" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
</head>
<body>
<?php  include '../../includes/navbar.php'; ?>
        <div id="layoutSidenav">
            <?php include '../../includes/sidebar.php'; ?>
        
        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid px-4">
                    <h1 class="mt-4">Add Driver</h1>
                    <ol class="breadcrumb mb-4">
                    <li class="breadcrumb-item"><a href="../dashboard/dashboard.php">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="tampil_driver.php">Drivers</a></li>
                        <li class="breadcrumb-item active">Add Driver</li>
                    </ol>
                    <div class="card mb-4">
                        <div class="card-body">
                            <form action="simpan_driver.php" method="POST">
                                <div class="mb-3">
                                    <label for="driver_name" class="form-label">Driver Name</label>
                                    <input type="text" class="form-control" id="driver_name" name="driver_name" required>
                                </div>
                                <div class="mb-3">
                                    <label for="driver_address" class="form-label">Address</label>
                                    <input type="text" class="form-control" id="driver_address" name="driver_address" required>
                                </div>
                                <div class="mb-3">
                                    <label for="driver_no_telp" class="form-label">Phone Number</label>
                                    <input type="text" class="form-control" id="driver_no_telp" name="driver_no_telp" required>
                                </div>
                                <button type="submit" class="btn btn-primary">Submit</button>
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