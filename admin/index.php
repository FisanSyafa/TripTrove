<?php
session_start();
include "koneksi_login.php";

$error = ""; // Inisialisasi variabel error

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $admin_name = $_POST['admin_name'];
    $admin_password = $_POST['admin_password'];

    // Query untuk mengambil data pengguna dari database
    $sql = "SELECT * FROM admin WHERE admin_name = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $admin_name);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $hashed_password = hash('sha256', $admin_password);
        // Memverifikasi hash password
        if ($hashed_password === $row['admin_password']) {
            $_SESSION['admin_name'] = $admin_name;
            header("Location: dashboard/dashboard.php");
            exit();
        } else {
            $error = "Password salah."; // Pesan kesalahan jika password salah
        }
    } else {
        $error = "Tidak ada admin dengan nama tersebut."; // Pesan kesalahan jika username tidak ditemukan
    }
    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/login.css">
    <link rel="stylesheet" href="../fontawesome-free-6.5.2-web/css/all.min.css"/>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Merienda:wght@300..900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900&display=swap" rel="stylesheet">
    <title>Login</title>
</head>
<body style="background: url('../images/Borobudur2.jpg') center center fixed no-repeat; background-size: cover;">
    <form action="index.php" method="POST">
        <div class="imgcontainer">
            <i class="fa-regular fa-user fa-4x"></i>
        </div>
      
        <div class="container">
          <label for="admin_name"><b>Nama</b></label>
          <input style="color: white" class="usrnm" type="text" placeholder="Masukkan anama" id="admin_name" name="admin_name" required>
      
          <label for="admin_password"><b>Password</b></label>
          <input style="color: white" class="pwd" type="password" placeholder="Masukkan Password" id="admin_password" name="admin_password" required>

          <button class="login" type="submit">Login</button>
          
          <label>
            <input type="checkbox" checked="checked" name="remember"> Remember me
          </label>
        </div>
        <div class="container">
        </div>

        <?php
        if (!empty($error)) {
            echo "<div style='color:red;' class='error'>$error</div>";
        }
        ?>
      </form>
</body>
</html>
