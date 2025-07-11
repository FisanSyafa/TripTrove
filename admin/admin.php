<?php
session_start();
include '../includes/koneksi.php';
if(!isset($_SESSION['admin_name'])){
    header('Location: index.php');
    exit();
}

$admin_name = $_SESSION['admin_name'];

// Cek apakah user adalah admin (implementasi autentikasi sesuai kebutuhan)
// session_start();
// if (!isset($_SESSION['is_admin']) || !$_SESSION['is_admin']) {
//     header("Location: login.php");
//     exit();
// }

// Logika penghapusan pesan
if (isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];
    $delete_query = "DELETE FROM messages WHERE id = $delete_id";
    $delete_result = mysqli_query($link, $delete_query);

    if ($delete_result) {
        echo "<script>alert('Pesan berhasil dihapus');</script>";
    } else {
        echo "<script>alert('Gagal menghapus pesan');</script>";
    }
}

// Query untuk mengambil data dari tabel messages
$query = "SELECT * FROM messages ORDER BY timestamp DESC";
$result = mysqli_query($link, $query);

// Cek apakah query berhasil
if (!$result) {
    die("Query Error: " . mysqli_error($link));
}
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
    <link href="../css/styles.css" rel="stylesheet" />
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- DataTables CSS -->
    <link href="https://cdn.datatables.net/1.11.4/css/jquery.dataTables.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
</head>
<body class="sb-nav-fixed">
    <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
        <!-- Navbar Brand-->
        <a class="navbar-brand ps-3" href="index.html">TRIPTROVE</a>
        <!-- Sidebar Toggle-->
        <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!"><i
                class="fas fa-bars"></i></button>
        <!-- Navbar Search-->
        <form class="d-none d-md-inline-block form-inline ms-auto me-0 me-md-3 my-2 my-md-0">
            <div class="input-group">
                <input class="form-control" type="text" placeholder="Search for..." aria-label="Search for..."
                    aria-describedby="btnNavbarSearch" />
                <button class="btn btn-primary" id="btnNavbarSearch" type="button"><i
                        class="fas fa-search"></i></button>
            </div>
        </form>
        <!-- Navbar-->
        <ul class="navbar-nav ms-auto ms-md-0 me-3 me-lg-4">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown"
                    aria-expanded="false"><i class="fas fa-user fa-fw"></i></a>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                    <li><a class="dropdown-item" href="#!">Settings</a></li>
                    <li><a class="dropdown-item" href="#!">Activity Log</a></li>
                    <li>
                        <hr class="dropdown-divider" />
                    </li>
                    <li><a class="dropdown-item" href="#!">Logout</a></li>
                </ul>
            </li>
        </ul>
    </nav>
    <div id="layoutSidenav">
        <div id="layoutSidenav_nav">
            <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                <div class="sb-sidenav-menu">
                    <div class="nav">
                        <div class="sb-sidenav-menu-heading">Admin</div>
                        <a class="nav-link" href="index.html">
                            <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                            Dashboard
                        </a>
                        <div class="sb-sidenav-menu-heading">Addons</div>
                        <a class="nav-link" href="users_php/tampil_data_users.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-user"></i></div>
                            Users
                        </a>
                        <a class="nav-link" href="paket/tampil_paket.php">
                            <div class="sb-nav-link-icon"><i class="fa-solid fa-torii-gate"></i></div>
                            Paket Trip
                        </a>
                        <a class="nav-link" href="admin.php">
                            <div class="sb-nav-link-icon"><i class="fa-solid fa-user-tie"></i></div>
                            Admin
                        </a>
                        <a class="nav-link" href="jenis_kendaraan_php/tampil_data_jenis.php">
                            <div class="sb-nav-link-icon"><i class="fa-solid fa-car-on"></i></div>
                            Jenis Kendaraan
                        </a>
                        <a class="nav-link" href="bookings/tampil_data_booking.php">
                            <div class="sb-nav-link-icon"><i class="fa-solid fa-bookmark"></i></div>
                            Booking
                        </a>
                        <a class="nav-link" href="tipe_kendaraan_php/tampil_data_kendaraan.php">
                            <div class="sb-nav-link-icon"><i class="fa-solid fa-car"></i></div>
                            Kendaraan
                        </a>
                        <a class="nav-link" href="message/tampil_message.php">
                            <div class="sb-nav-link-icon"><i class="fa-solid fa-envelope"></i></div>
                            Pesan
                        </a>
                        <a class="nav-link" href="payment/tampil_payment.php">
                            <div class="sb-nav-link-icon"><i class="fa-solid fa-coins"></i></div>
                            Pembayaran
                        </a>
                    </div>
                </div>
                <div class="sb-sidenav-footer">
                    <div class="small">Logged in as:</div>
                    Admin
                </div>
            </nav>
        </div>
        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid px-4">
                    <h1 class="mt-4">Data Messages</h1>
                    <ol class="breadcrumb mb-4">
                        <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
                        <li class="breadcrumb-item active">Messages</li>
                    </ol>
                    <div class="card mb-4">
                        <div class="card-body">
                        <table class="table table-striped" id="datatablesSimple">
                                <thead>
                                    <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Subject</th>
                                    <th>Message</th>
                                    <th>Tanggal</th>
                                    <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                                        <tr>
                                        <td><?php echo $row['id']; ?></td>
                                        <td><?php echo $row['name']; ?></td>
                                        <td><?php echo $row['email']; ?></td>
                                        <td><?php echo $row['subject']; ?></td>
                                        <td><?php echo $row['message']; ?></td>
                                        <td><?php echo $row['timestamp']; ?></td>
                                        <td>
                                            <a href="admin.php?delete_id=<?php echo $row['id']; ?>" onclick="return confirm('Apakah Anda yakin ingin menghapus pesan ini?');" class="btn btn-danger">Hapus</a>
                                        </td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </main>
            <footer class="py-4 bg-light mt-auto">
                <div class="container-fluid px-4">
                    <div class="d-flex align-items-center justify-content-between small">
                        <div class="text-muted">Copyright &copy; TRIPTROVE</div>
                        <div>
                            <a href="#">Privacy Policy</a>
                            &middot;
                            <a href="#">Terms &amp; Conditions</a>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="../js/scripts.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js" crossorigin="anonymous"></script>
    <script src="../js/datatables-simple-demo.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>