<?php
session_start();
// Hapus semua session
session_unset();
// Hancurkan session
session_destroy();
// Redirect ke halaman login atau halaman lainnya
header("Location: login&register/login.php");
exit();
?>
