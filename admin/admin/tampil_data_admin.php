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
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- DataTables CSS -->
    <link href="https://cdn.datatables.net/1.11.4/css/jquery.dataTables.min.css" rel="stylesheet">
    <!-- Font Awesome -->
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
    $sql = "SELECT * FROM admin";
    $result = mysqli_query($link, $sql);
    ?>
    <?php  include '../../includes/navbar.php'; ?>
        <div id="layoutSidenav">
            <?php include '../../includes/sidebar.php'; ?>
        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid px-4">
                    <h1 class="mt-4">Data Admin</h1>
                    <ol class="breadcrumb mb-4">
                    <li class="breadcrumb-item"><a href="../dashboard/dashboard.php">Dashboard</a></li>
                        <li class="breadcrumb-item active">Admin</li>
                    </ol>
                    <div class="card mb-4">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped" id="datatablesSimple">
                                    <thead>
                                        <tr>
                                            <th>Admin ID</th>
                                            <th>Admin Name</th>
                                            <th>Email</th>
                                            <th>Alamat</th>
                                            <th>Nomor Telepon</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                                        <tr>
                                            <td><?php echo $row['admin_id']; ?></td>
                                            <td><?php echo $row['admin_name']; ?></td>
                                            <td><?php echo $row['admin_email']; ?></td>
                                            <td><?php echo $row['alamat']; ?></td>
                                            <td><?php echo $row['no_telp']; ?></td>
                                            <td>
                                                <!-- Button trigger modal -->
                                                <button type="button" class="btn btn-primary"
                                                    data-toggle="modal"
                                                    data-target="#verificationModal-<?php echo $row['admin_id']; ?>">
                                                    Edit
                                                </button>

                                                <!-- Modal -->
                                                <div class="modal fade"
                                                    id="verificationModal-<?php echo $row['admin_id']; ?>"
                                                    tabindex="-1" role="dialog"
                                                    aria-labelledby="verificationModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title"
                                                                    id="verificationModalLabel">Verifikasi Super Admin</h5>
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <label for="superadminPassword">Masukkan Password Super Admin:</label>
                                                                <input type="password" class="form-control" id="superadminPassword-<?php echo $row['admin_id']; ?>" required>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                                <button type="button" class="btn btn-primary" onclick="verifySuperAdmin('<?php echo $row['admin_id']; ?>')">Verify</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
            <?php include '../../includes/footer.php'; ?>
        </div>
    </div>
    <!-- Bootstrap JS and DataTables JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="../../js/scripts.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js" crossorigin="anonymous"></script>
    <script src="../../js/datatables-simple-demo.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        $(document).ready(function () {
            $('#datatablesSimple').DataTable();
        });

        function verifySuperAdmin(admin_id) {
            // Get input value
            var passwordInput = $('#superadminPassword-' + admin_id).val();

            // Check if password is correct
            if (passwordInput === 'superadmin') {
                // Redirect to edit page (replace with your edit page URL)
                window.location.href = 'form_edit_admin.php?admin_id=' + admin_id;
            } else {
                // Show error message or alert
                alert('Password Super Admin Salah!');
            }

            // Close modal
            $('#verificationModal-' + admin_id).modal('hide');
        }
    </script>
</body>

</html>
