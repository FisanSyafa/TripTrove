<?php
// include '../includes/koneksi_login.php'; // Gunakan koneksi tanpa login
session_start();
include '../includes/koneksi_login.php';

if (!isset($_SESSION['username'])) {
    header("Location: ../login.php");
    exit();
}

if (isset($_GET['nama_paket_trip'])) {
    $nama_paket_trip = $_GET['nama_paket_trip'];

    $_SESSION['nama_paket_trip'] = $nama_paket_trip;

    // Query untuk mendapatkan data dari database berdasarkan nama_paket_trip
    $query = "SELECT * FROM paket_trip WHERE nama_paket_trip = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "s", $nama_paket_trip);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($result && mysqli_num_rows($result) > 0) {
        $data = mysqli_fetch_assoc($result);
    } else {
        echo "Data tidak ditemukan.";
        exit();
    }

    $query_comments = "SELECT c.*, r.region_name 
                   FROM comments c 
                   INNER JOIN regions r ON c.region_id = r.region_id 
                   WHERE c.nama_paket_trip = ? 
                   ORDER BY c.comment_date DESC";
    $stmt_comments = mysqli_prepare($conn, $query_comments);
    mysqli_stmt_bind_param($stmt_comments, "s", $nama_paket_trip);
    mysqli_stmt_execute($stmt_comments);
    $result_comments = mysqli_stmt_get_result($stmt_comments);
} else {
    echo "ID tidak diberikan.";
    exit();
}

// Ambil mata uang dari URL (default ke USD jika tidak ada)
$currency = isset($_GET['currency']) ? $_GET['currency'] : 'USD';

// Ambil kurs mata uang real-time
$api_url = "https://api.exchangerate-api.com/v4/latest/USD";
$exchange_rates = json_decode(file_get_contents($api_url), true);

$rates = [
    'USD' => 1,
    'MYR' => $exchange_rates['rates']['MYR'] ?? 4.2,
    'IDR' => $exchange_rates['rates']['IDR'] ?? 15000,
    'EUR' => $exchange_rates['rates']['EUR'] ?? 0.92,
    'SGD' => $exchange_rates['rates']['SGD'] ?? 1.35
];

// Pastikan mata uang yang dipilih valid
$rate = $rates[$currency] ?? 1;

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://fonts.googleapis.com/css?family=Poppins' rel='stylesheet'>
    <title><?php echo $data['nama_paket_trip']; ?> - TRIPTROVE</title>
    <link rel="stylesheet" href="../css/deskripsiTrip1.css?v=123">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"/>
</head>
<body>
<div class="scroll-up-btn">
        <i class="fas fa-angle-up"></i>
    </div>
    <nav class="navbar">
        <div class="max-width">
            <div class="logo"><img src="../images/Trip Trove PNG.png" style="max-width: 25%;" alt=""></div>
            <ul class="menu">
                <li><a href="../user_login.php" class="menu-btn">Home</a></li>
                <li><a href="#deskripsi" class="menu-btn">Description</a></li>
                <li><a href="#testimonial" class="menu-btn">Testimonial</a></li>
            </ul>
            <div class="menu-btn">
                <i class="fas fa-bars"></i>
            </div>
        </div>
    </nav>
    
    <div class="slideshow-container">
        <div class="slide">
            <div class="numbertext"></div>
                <img class="gambar" src="../<?php echo $data['image']; ?>" alt="<?php echo $data['nama_paket_trip']; ?>">
            <div class="text"><?php echo $data['nama_paket_trip']; ?></div>
        </div>
    </div>
    <br>

    <div class="container">
        <div class="harga">  
            <small>From</small>
            <h1 class="dollar">
            <?php
            // Fungsi untuk membulatkan RM ke kelipatan 0.05
            if (!function_exists('roundToNearestFiveCents')) {
                function roundToNearestFiveCents($amount) {
                    return round($amount * 20) / 20; // Membulatkan ke 0.05
                }
            }

            $harga = $data['harga'] * $rate;
            $diskon = isset($data['diskon']) ? (int) $data['diskon'] : 0;

            if ($diskon > 0) {
                $harga_diskon = $harga - ($harga * ($diskon / 100));

                // Pembulatan sesuai mata uang
                if ($currency == 'IDR') {
                    $harga = floor($harga / 1000) * 1000;
                    $harga_diskon = floor($harga_diskon / 1000) * 1000;
                } elseif ($currency == 'MYR') {
                    $harga = roundToNearestFiveCents($harga);
                    $harga_diskon = roundToNearestFiveCents($harga_diskon);
                } else {
                    $harga = floor($harga * 100) / 100;
                    $harga_diskon = floor($harga_diskon * 100) / 100;
                }

                echo "<span style='text-decoration: line-through; color: red;'><small>{$currency} " . number_format($harga, 2) . "</small></span> ";
                echo "<span style='color: green; font-weight: bold;'>{$currency} " . number_format($harga_diskon, 2) . "</span>";
            } else {
                if ($currency == 'IDR') {
                    $harga = floor($harga / 1000) * 1000;
                } elseif ($currency == 'MYR') {
                    $harga = roundToNearestFiveCents($harga);
                } else {
                    $harga = floor($harga * 100) / 100;
                }

                echo "{$currency} " . number_format($harga, 2);
            }
            ?>
            </h1>
            <small>Per Person</small>
        </div>
        <div class="judul">  
            <h1><?php echo $data['destinasi']; ?></h1>
            <small>Duration: <?php echo $data['durasi']; ?></small>
        </div>
        <p><img src="../images/icons/map-pin-line.png" alt=""> <?php echo $data['lokasi']; ?></p>

        <hr>
        <h2>Include</h2>
        <?php if ($data['include_hotel']) : ?>
            <p><i class="fas fa-check-circle"></i> Hotel pickup and dropoff</p>
        <?php else : ?>
            <p><i class="fas fa-times-circle"></i> Hotel pickup and dropoff</p>
        <?php endif; ?>

        <?php if ($data['include_request']) : ?>
            <p><i class="fas fa-check-circle"></i> Optional pickup and dropoff at the Yogyakarta Airport</p>
        <?php else : ?>
            <p><i class="fas fa-times-circle"></i> Optional pickup and dropoff at the Yogyakarta Airport</p>
        <?php endif; ?>

        <?php if ($data['include_entrance']) : ?>
            <p><i class="fas fa-check-circle"></i> Entrance fee</p>
        <?php else : ?>
            <p><i class="fas fa-times-circle"></i> Entrance fee</p>
        <?php endif; ?>

        <?php if ($data['include_tip']) : ?>
            <p><i class="fas fa-check-circle"></i> Tip for driver</p>
        <?php else : ?>
            <p><i class="fas fa-times-circle"></i> Tip for driver</p>
        <?php endif; ?>


        <hr>
        <h2 id="deskripsi">Full Description</h2>
        <div class="deskripsi">
            <?php echo nl2br($data['deskripsi']); ?>
        </div>
        <hr>
        <div class="order-container">
        <h2 id="booking">Booking</h2>
            <form id="order-form" class="order-form" action="../booking&payment/proses_booking.php?nama_paket_trip=<?php echo urlencode($data['nama_paket_trip']); ?>" method="post">
                <input type="hidden" name="nama_paket_trip" value="<?php echo htmlspecialchars($data['nama_paket_trip']); ?>">
                <input type="hidden" name="currency" value="<?php echo htmlspecialchars($currency); ?>">
                
                <div class="form-group">
                    <label for="start_time">Choose Date:</label>
                    <input type="date" id="start_time" name="start_time" required>
                </div>

                <div class="form-group">
                    <label for="person">Number of Person:</label>
                    <input type="number" id="person" name="person" required>
                </div>

                <button type="submit" class="order-button"><b>Order Now</b></button>
            </form>
        </div>
        <hr>
        <div class="komentar" id="testimonial">
            <a href="<?php echo isset($_SESSION['username']) ? "../rating&comment/comment_rating.php" : "../login&register/login.php"; ?>" class="order-button">Add Your Rating & Comment</a>
            <h2>Customer reviews</h2>
            <p>(Only customers who made the trip with us can review)</p>
            <?php while ($comment = mysqli_fetch_assoc($result_comments)) : ?>
                <div class="komentar-header">
                    <?php
                    // Menghitung jumlah bintang berdasarkan rating
                    $rating = intval($comment['comment_star']);
                    $stars = str_repeat('&#9733;', $rating) . str_repeat('&#9734;', 5 - $rating);
                    ?>
                    <div class="bintang"><?php echo $stars; ?></div>
                    <div class="tanggal"><?php echo date('d F Y', strtotime($comment['comment_date'])); ?></div>
                </div>
                <div class="komentar-isi">
                    <div><b><?php echo htmlspecialchars($comment['username']) . " - " . htmlspecialchars($comment['region_name']) ?></b></div>
                    <div class="teks"><?php echo nl2br(htmlspecialchars($comment['comment'])); ?></div>
                    <?php if (!empty($comment['image'])) : ?>
                        <div class="gambar-komentar">
                            <img src="../<?php echo htmlspecialchars($comment['image']); ?>" alt="Foto Ulasan">
                        </div>
                    <?php endif; ?>
                </div>
                <hr>
            <?php endwhile; ?>
        </div>

    <footer class="footer">
        <ul class="social-icon">
          <li class="social-icon__item"><a class="social-icon__link" href="#">
              <ion-icon name="logo-facebook"></ion-icon>
            </a></li>
          <li class="social-icon__item"><a class="social-icon__link" href="#">
              <ion-icon name="logo-twitter"></ion-icon>
            </a></li>
          <li class="social-icon__item"><a class="social-icon__link" href="#">
              <ion-icon name="logo-Whatsapp"></ion-icon>
            </a></li>
          <li class="social-icon__item"><a class="social-icon__link" href="#">
              <ion-icon name="logo-linkedin"></ion-icon>
            </a></li>
        </ul>
        <ul class="menu">
          <li class="menu__item"><a class="menu__link" href="../index.php">Home</a></li>
          <li class="menu__item"><a class="menu__link" href="../index.php">About</a></li>
          <li class="menu__item"><a class="menu__link" href="../index.php">Services</a></li>
          <li class="menu__item"><a class="menu__link" href="../index.php">Team</a></li>
          <li class="menu__item"><a class="menu__link" href="../index.php">Contact</a></li>
        </ul>
        <p>&copy;2024 TRIPTROVE | All Rights Reserved</p>
      </footer>
      <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
      <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
                        
    <script src="deskripsiTrip1.js"></script>
    <script>
    document.getElementById("order-form").addEventListener("submit", function(event) {
    let startDate = document.getElementById("start_time").value;
    let person = document.getElementById("person").value;
    
    if (!startDate || !person) {
        alert("Harap lengkapi semua data sebelum memesan.");
        event.preventDefault();
        }
        });
        
    const today = new Date().toISOString().split('T')[0];
    document.getElementById("start_time").setAttribute("min", today);
    </script>

</body>
</html>
