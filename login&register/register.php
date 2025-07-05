<?php
include "../includes/koneksi_login.php"; // Sertakan file koneksi database Anda

$message = ""; // Variabel untuk menampung pesan

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $email = $_POST['email'];
    $no_telp = $_POST['no_telp'];

    if ($password !== $confirm_password) {
        $message = "❌ Password and password confirmation don't match.";
    } else {
        // Hash password menggunakan SHA-256
        $hashed_password = hash('sha256', $password);

        // Query untuk memasukkan user baru
        $sql = "INSERT INTO users (username, password, email, no_telp) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssss", $username, $hashed_password, $email, $no_telp);

        try {
            if ($stmt->execute()) {
                header("Location: login.php"); // Redirect ke halaman login setelah registrasi berhasil
                exit();
            }
        } catch (mysqli_sql_exception $e) {
            if ($e->getCode() == 1062) { // Error Code 1062 = Duplicate entry (karena username adalah primary key)
                $message = "❌ Username is already taken. Please choose another one.";
            } else {
                $message = "❌ Error: " . $e->getMessage();
            }
        }

        $stmt->close();
    }

    $conn->close();
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/register.css">
    <link rel="stylesheet" href="fontawesome-free-6.5.2-web/css/all.min.css"/>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Merienda:wght@300..900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900&display=swap" rel="stylesheet">
    <title>Register</title>
    <script>
        function validateForm() {
            var email = document.getElementById("email").value;
            if (!email.endsWith("@gmail.com")) {
                alert("Email must be @gmail.com.");
                return false;
            }
            return true;
        }

        const password = document.getElementById("password");

        password.addEventListener("input", function () {
            if (password.value.length < 8) {
                password.setCustomValidity("Password must be at least 8 characters long.");
            } else {
                password.setCustomValidity("");
            }
        });
    </script>
</head>
<body style="background: url('../images/borobudur2.jpg') center center fixed no-repeat; background-size: cover;">
    <form action="register.php" method="POST" onsubmit="return validateForm()">
        <div class="imgcontainer">
            <i class="fa-regular fa-user fa-4x"></i>
        </div>

        <div class="container">
            <label for="username"><b>Username</b></label>
            <input style="color: white" class="usrnm" type="text" placeholder="Enter Username" id="username" name="username" required>

            <label for="password"><b>Password</b></label>
            <input style="color: white" class="pwd" type="password" placeholder="Enter Password" id="password" name="password" minlength="8" required>

            <label for="confirm_password"><b>Password Confirmation</b></label>
            <input style="color: white" class="pwd" type="password" placeholder="Enter Password Confirmation" id="confirm_password" name="confirm_password" required>

            <label for="email"><b>Email</b></label>
            <input style="color: white" class="email" type="email" placeholder="Enter Email" id="email" name="email" required>

            <label for="no_telp"><b>Phone Number</b></label>
            <input style="color: white" class="no_telp" type="text" placeholder="Enter Phone Number" id="no_telp" name="no_telp" required>

            <!-- Pesan Kesalahan atau Sukses -->
            <?php if (!empty($message)) : ?>
                <div style="color: orange; text-align: center; margin-bottom: 10px; font-weight: bold;">
                    <?= $message; ?>
                </div>
            <?php endif; ?>

            <!-- Tombol Register -->
            <button class="register" type="submit">Register</button>
        </div>
        
        <div class="container">
            <a href="login.php"><button type="button" class="cancelbtn">Cancel</button></a>  
        </div>
    </form>
</body>
</html>
