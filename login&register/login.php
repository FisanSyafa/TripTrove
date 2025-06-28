<?php
session_start();
include "../includes/koneksi_login.php";

$error = ""; // Inisialisasi variabel error
$username_cookie = isset($_COOKIE['username']) ? $_COOKIE['username'] : "";
$password_cookie = isset($_COOKIE['password']) ? $_COOKIE['password'] : "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $remember = isset($_POST['remember']); // Cek apakah remember me dicentang

    if (!empty($username) && !empty($password)) {
        // Query untuk mengambil data pengguna dari database
        $sql = "SELECT * FROM users WHERE username = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $hashed_password = hash('sha256', $password);
            if ($hashed_password === $row['password']) {
                $_SESSION['username'] = $username; // Set session username
                
                // Jika "Remember me" dicentang, simpan username dan password dalam cookie selama 30 hari
                if ($remember) {
                    setcookie("username", $username, time() + (30 * 24 * 60 * 60), "/"); 
                    setcookie("password", $password, time() + (30 * 24 * 60 * 60), "/"); 
                } else {
                    // Hapus cookie jika user tidak mencentang "Remember me"
                    setcookie("username", "", time() - 3600, "/");
                    setcookie("password", "", time() - 3600, "/");
                }

                header("Location: ../user_login.php"); // Redirect ke dashboard user
                exit();
            } else {
                $error = "Invalid password."; // Jika password salah
            }
        } else {
            $error = "No user found with that username."; // Jika username tidak ditemukan
        }
        $stmt->close();
    } else {
        $error = "Please fill in both username and password.";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/login.css">
    <link rel="stylesheet" href="fontawesome-free-6.5.2-web/css/all.min.css"/>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Merienda:wght@300..900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900&display=swap" rel="stylesheet">
    <title>Login</title>
</head>
<body style="background: url('../images/borobudur2.jpg') center center fixed no-repeat; background-size: cover;">
    <form action="login.php" method="POST">
        <div class="imgcontainer">
            <i class="fa-regular fa-user fa-4x"></i>
        </div>
      
        <div class="container">
          <label for="username"><b>Username</b></label>
          <input style="color: white" class="usrnm" type="text" placeholder="Enter Username" id="username" name="username" value="<?= htmlspecialchars($username_cookie) ?>" required>
      
          <label for="password"><b>Password</b></label>
          <input style="color: white" class="pwd" type="password" placeholder="Enter Password" id="password" name="password" value="<?= htmlspecialchars($password_cookie) ?>" required>

          <button class="login" type="submit">Login</button>
          
          <label>
            <input type="checkbox" name="remember" <?= !empty($username_cookie) ? "checked" : "" ?>> Remember me
          </label>
        </div>
      
        <div class="container">
          <a href="../index.php"><button type="button" class="cancelbtn">Cancel</button></a>  
          <span class="psw">Don't have an account yet? <a class="link-psw" href="register.php">Register now!</a></span>
        </div>

        <?php
        if (!empty($error)) {
            echo "<div style='color:red;' class='error'>$error</div>";
        }
        ?>
    </form>
</body>
</html>
