<?php
session_start();
include('../../includes/koneksi.php');
include('delete_message.php');

if(!isset($_SESSION['admin_name'])){
         header('Location: ../index.php');
         exit();
}
 
$admin_name = $_SESSION['admin_name'];

// Ambil semua pesan untuk ditampilkan di admin page
$query = "SELECT * FROM messages";
$result = mysqli_query($link, $query);

if (!$result) {
    die("Query Error: " . mysqli_error($link));
}

if (isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];
    if (deleteMessage($delete_id)) {
    }
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
    <title>Admin Panel-Manage Trips</title>
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
                    <h1 class="mt-4">Pesan-ContactUS</h1>
                    <ol class="breadcrumb mb-4">
                    <li class="breadcrumb-item"><a href="../dashboard/dashboard.php">Dashboard</a></li>
                        <li class="breadcrumb-item active">Pesan-ContactUS</li>
                    </ol>
                    <div class="card mb-4">
                        <div class="card-body">
                            <table id="datatablesSimple">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Nama</th>
                                        <th>Email</th>
                                        <th>Subjek</th>
                                        <th>Pesan</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php
                                    $sql = "SELECT * FROM messages";
                                    $result = mysqli_query($link, $sql);

                                    if (mysqli_num_rows($result) > 0) {
                                        while($row = mysqli_fetch_assoc($result)) {
                                            echo "<tr>";
                                            echo "<td>".$row['id']."</td>";
                                            echo "<td>".$row['name']."</td>";
                                            echo "<td>".$row['email']."</td>";
                                            echo "<td>".$row['subject']."</td>";
                                            echo "<td>".$row['message']."</td>";
                                            echo "<td>";
                                            echo '<a href="tampil_message.php?delete_id=' . $row['id'] . '" class="btn btn-danger" onclick="return confirm(\'Apakah Anda yakin ingin menghapus pesan ini?\')">Delete</a>';
                                            echo "</td>";
                                            echo "</tr>";
                                        }
                                    } else {
                                        echo "0 results";
                                    }

                                    mysqli_close($link);
                                ?>
                                </tbody>

                                <tbody>
                                    <?php while ($row = mysqli_fetch_assoc($result)) : ?>
                                        <tr>
                                            <td><?php echo $row['id']; ?></td>
                                            <td><?php echo $row['name']; ?></td>
                                            <td><?php echo $row['email']; ?></td>
                                            <td><?php echo $row['subject']; ?></td>
                                            <td><?php echo $row['message']; ?></td>
                                            <td>
                                                <a href="tampil_message.php?delete_id=<?php echo $row['id']; ?>" class="btn btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus pesan ini?')">Delete</a>
                                            </td>

                                        </tr>
                                    <?php endwhile; ?>
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
</body>
</html>



