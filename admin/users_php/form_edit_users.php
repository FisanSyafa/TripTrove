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

$username = $_GET['username'];
$sql = "SELECT * FROM users WHERE username='$username'";
$result = mysqli_query($link, $sql);
$data = mysqli_fetch_assoc($result);
?>
   <?php  include '../../includes/navbar.php'; ?>
        <div id="layoutSidenav">
            <?php include '../../includes/sidebar.php'; ?>
        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid px-4">
                    <h1 class="mt-4">Edit Paket Trip</h1>
                    <ol class="breadcrumb mb-4">
                    <li class="breadcrumb-item"><a href="../dashboard/dashboard.php">Dashboard</a></li>
                    <li class="breadcrumb-item active">Destinasi</li>
                    </ol>
                    <div class="card mb-4">
                        <div class="container">
                            <form method="POST" action="aksi_edit_users.php" id="userForm">
                                <div class="mb-3">
                                    <label for="username" class="form-label">Username</label>
                                    <input type="text" class="form-control" id="username" name="username" value="<?php echo $data['username']; ?>" disabled>
                                </div>
                                <div class="mb-3">
                                    <label for="password" class="form-label">Password</label>
                                    <input type="text" class="form-control" id="password" name="password" value="<?php echo $data['password']; ?>" required>
                                </div>
                                <div class="mb-3">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" class="form-control" id="email" name="email" required pattern="[a-zA-Z0-9._%+-]+@gmail\.com$" value="<?php echo $data['email']; ?>" required>
                                </div>
                                <div class="mb-3">
                                    <label for="no_telp" class="form-label">Nomor Telepon</label>
                                    <input type="text" class="form-control" id="no_telp" name="no_telp" value="<?php echo $data['no_telp']; ?>" required>
                                </div>
                                <div class="card-header">
                                    <button type="submit" class="btn btn-primary">Simpan</button>
                                    <a href="tampil_data_users.php" class="btn btn-secondary">Kembali</a>
                                </div>
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
    <script>
        // Additional email validation
        document.getElementById('userForm').addEventListener('submit', function(event) {
            const emailInput = document.getElementById('email');
            const emailPattern = /^[a-zA-Z0-9._%+-]+@gmail\.com$/;
            if (!emailPattern.test(emailInput.value)) {
                alert('Email harus berformat @gmail.com');
                event.preventDefault();
            }
        });
    </script>
</body>

</html>
