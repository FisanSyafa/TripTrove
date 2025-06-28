<?php
include "koneksi_login.php"; // Sertakan file koneksi database Anda

$error_message = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $admin_name = $_POST['admin_name'];
    $admin_password = $_POST['admin_password'];
    $confirm_password = $_POST['confirm_password'];
    $admin_email = $_POST['admin_email'];
    $alamat = $_POST['alamat'];
    $no_telp = $_POST['no_telp'];

    if ($admin_password !== $confirm_password) {
        $error_message = "Password dan konfirmasi password tidak cocok.";
    } elseif (!preg_match('/^[a-zA-Z0-9._%+-]+@gmail\.com$/', $admin_email)) {
        $error_message = "Email harus menggunakan '@gmail.com'.";
    } else {
        // Hash password menggunakan SHA2
        $hashed_password = hash('sha256', $admin_password);

        // Insert user data into the database menggunakan prepared statement
        $sql = "INSERT INTO admin (admin_name, admin_password, admin_email, alamat, no_telp) VALUES (?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);

        // Bind parameter ke prepared statement
        $stmt->bind_param("sssss", $admin_name, $hashed_password, $admin_email, $alamat, $no_telp);

        if ($stmt->execute()) {
            header("Location: index.php"); // Redirect ke halaman login setelah registrasi berhasil
            exit();
        } else {
            $error_message = "Error: " . $stmt->error;
        }

        $stmt->close();
        $conn->close();
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/register.css">
    <link rel="stylesheet" href="../fontawesome-free-6.5.2-web/css/all.min.css"/>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Merienda:wght@300..900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900&display=swap" rel="stylesheet">
    <title>Register</title>
    <script>
        function validateForm() {
            var password = document.getElementById("admin_password").value;
            var confirmPassword = document.getElementById("confirm_password").value;
            var errorMessage = document.getElementById("error_message");

            if (password !== confirmPassword) {
                errorMessage.textContent = "Password dan konfirmasi password tidak cocok.";
                return false;
            }

            var email = document.getElementById("admin_email").value;
            var emailPattern = /^[a-zA-Z0-9._%+-]+@gmail\.com$/;

            if (!emailPattern.test(email)) {
                errorMessage.textContent = "Email harus menggunakan '@gmail.com'.";
                return false;
            }

            return true;
        }
    </script>
</head>
<body style="background: url('../images/Borobudur2.jpg') center center fixed no-repeat; background-size: cover;">
    <form action="register.php" method="POST" onsubmit="return validateForm()">
        <div class="imgcontainer">
            <i class="fa-regular fa-user fa-4x"></i>
        </div>
      
        <div class="container">
          <label for="admin_name"><b>Nama</b></label>
          <input style="color: white" class="usrnm" type="text" placeholder="Masukkan Nama" id="admin_name" name="admin_name" required>
      
          <label for="admin_password"><b>Password</b></label>
          <input style="color: white" class="pwd" type="password" placeholder="Masukkan Password" id="admin_password" name="admin_password" required>

          <label for="confirm_password"><b>Konfirmasi Password</b></label>
          <input style="color: white" class="pwd" type="password" placeholder="Masukkan Konfirmasi Password" id="confirm_password" name="confirm_password" required>

          <label for="admin_email"><b>Email</b></label>
          <input style="color: white" class="email" type="email" placeholder="Masukkan Email" id="admin_email" name="admin_email" required>

          <label for="alamat"><b>Alamat</b></label>
          <input style="color: white" class="alamat" type="text" placeholder="Masukkan Alamat" id="alamat" name="alamat" required>

          <label for="no_telp"><b>No. Telepon</b></label>
          <input style="color: white" class="no_telp" type="text" placeholder="Masukkan No. Telepon" id="no_telp" name="no_telp" required>

          <button class="register" type="submit">Register</button>
          <p id="error_message" style="color: red; text-align: center;"><?php echo $error_message; ?></p>
        </div>
      </form>
</body>
</html>
