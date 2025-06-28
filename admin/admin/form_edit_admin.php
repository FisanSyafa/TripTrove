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
    include '../../includes/navbar.php'; ?>
        <div id="layoutSidenav">
            <?php include '../../includes/sidebar.php'; ?>
        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid px-4">
                    <h1 class="mt-4">Edit Admin</h1>
                    <ol class="breadcrumb mb-4">
                    <li class="breadcrumb-item"><a href="../dashboard/dashboard.php">Dashboard</a></li>
                        <li class="breadcrumb-item active">Admin</li>
                    </ol>
                    <div class="card mb-4">
                        <div class="card-body">
                            <?php
                           
                            if (isset($_GET['admin_id'])) {
                                $admin_id = $_GET['admin_id'];
                                $query = "SELECT * FROM admin WHERE admin_id = '$admin_id'";
                                $result = mysqli_query($link, $query);
                                if (mysqli_num_rows($result) > 0) {
                                    $row = mysqli_fetch_assoc($result);
                                    ?>
                                    <form action="aksi_edit_admin.php" method="POST">
                                        <input type="hidden" name="admin_id" value="<?php echo $row['admin_id']; ?>">
                                        <div class="form-group">
                                            <label for="admin_name">Admin Name</label>
                                            <input type="text" class="form-control" id="admin_name" name="admin_name" value="<?php echo $row['admin_name']; ?>" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="admin_email">Email</label>
                                            <input type="email" class="form-control" id="admin_email" name="admin_email" value="<?php echo $row['admin_email']; ?>" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="alamat">Alamat</label>
                                            <input type="text" class="form-control" id="alamat" name="alamat" value="<?php echo $row['alamat']; ?>" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="no_telp">Nomor Telepon</label>
                                            <input type="text" class="form-control" id="no_telp" name="no_telp" value="<?php echo $row['no_telp']; ?>" required>
                                        </div>
                                        <button type="submit" class="btn btn-primary">Update</button>
                                    </form>
                                    <?php
                                } else {
                                    echo "Admin tidak ditemukan.";
                                }
                            } else {
                                echo "Admin ID tidak disediakan.";
                            }
                            ?>
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
