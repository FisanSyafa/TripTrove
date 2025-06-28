<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Edit Payment Method - TRIPTROVE</title>
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
                    <h1 class="mt-4">Edit Payment Method</h1>
                    <ol class="breadcrumb mb-4">
                    <li class="breadcrumb-item"><a href="../dashboard/dashboard.php">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="tampil_payment_method.php">Payment Methods</a></li>
                        <li class="breadcrumb-item active">Edit Payment Method</li>
                    </ol>
                    <div class="card mb-4">
                        <div class="card-header">
                            <i class="fas fa-table me-1"></i>
                            Edit Payment Method
                        </div>
                        <div class="card-body">
                            <?php
                            $id = $_GET['id'];
                            $sql = "SELECT * FROM payment_methods WHERE payment_method_id = ?";
                            $stmt = mysqli_prepare($link, $sql);
                            mysqli_stmt_bind_param($stmt, "i", $id);
                            mysqli_stmt_execute($stmt);
                            $result = mysqli_stmt_get_result($stmt);
                            $row = mysqli_fetch_assoc($result);
                            ?>
                            <form action="aksi_edit_payment_method.php" method="post">
                                <input type="hidden" name="payment_method_id" value="<?php echo $row['payment_method_id']; ?>">
                                <div class="mb-3">
                                    <label for="payment_method_name" class="form-label">Payment Method Name</label>
                                    <input type="text" class="form-control" id="payment_method_name" name="payment_method_name" value="<?php echo $row['payment_method_name']; ?>" required>
                                </div>
                                <div class="mb-3">
                                    <label for="payment_method_code" class="form-label">Payment Method Code</label>
                                    <input type="text" class="form-control" id="payment_method_code" name="payment_method_code" value="<?php echo $row['payment_method_code']; ?>" required>
                                </div>
                                <div class="mb-3">
                                    <label for="super_admin_password" class="form-label">Super Admin Password</label>
                                    <input type="password" class="form-control" id="super_admin_password" name="super_admin_password" required>
                                </div>
                                <button type="submit" class="btn btn-primary">Update Payment Method</button>
                            </form>
                        </div>
                    </div>
                </div>
            </main>
            <?php include '../../includes/footer.php'; ?>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="../../js/scripts.js"></script>
</body>
</html>