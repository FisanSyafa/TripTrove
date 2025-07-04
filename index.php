<?php
include('includes/koneksi_login.php');


$query = "SELECT * FROM paket_trip";
$result = mysqli_query($conn, $query);


if (!$result) {
    die("Query Error: " . mysqli_error($conn));
}

$success = null;
$error = null;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $subject = $_POST['subject'];
    $message = $_POST['message'];

    // Validasi sisi server
    if (empty($name) || empty($email) || empty($subject) || empty($message)) {
        $error = "Mohon lengkapi semua kolom dalam formulir.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Alamat email tidak valid.";
    } else {
        // Validasi reCAPTCHA di sisi server
        $recaptchaSecretKey = "6LebrHcrAAAAAAqppaxOphuGX7YkkV_3gu_ZfG1r"; 
        $recaptchaResponse = $_POST['g-recaptcha-response'];

        // Membuat request untuk memverifikasi reCAPTCHA
        $recaptchaUrl = "https://www.google.com/recaptcha/api/siteverify?secret={$recaptchaSecretKey}&response={$recaptchaResponse}";
        $recaptchaResponseData = json_decode(file_get_contents($recaptchaUrl));

        // Pengecekan hasil verifikasi reCAPTCHA
        if (!$recaptchaResponseData->success) {
            $error = "Silakan verifikasi reCAPTCHA.";
        } else {
            
            $ip = $_SERVER['REMOTE_ADDR'];
            $currentTime = time();      

            if (isset($_SESSION['last_submission_time'][$ip])) {
                $lastSubmissionTime = $_SESSION['last_submission_time'][$ip];
                $timeDiff = $currentTime - $lastSubmissionTime;

                if ($timeDiff < 10) {
                    $error = "Maaf, Anda hanya dapat mengirim formulir setiap 1 jam.";
                }
            }

            if (!isset($error)) {
                $_SESSION['last_submission_time'][$ip] = $currentTime;

                $spamKeywords = ["viagra", "cialis", "jual", "obat"];
                foreach ($spamKeywords as $keyword) {
                    if (stripos($message, $keyword) !== false) {
                        $error = "Maaf, pesan Anda terdeteksi sebagai spam.";
                        break;
                    }
                }

                if (!isset($error)) {
                    $stmt = $conn->prepare("INSERT INTO messages (name, email, subject, message) VALUES (?, ?, ?, ?)");
                    $stmt->bind_param("ssss", $name, $email, $subject, $message);

                    if ($stmt->execute()) {
                        $success = "Your message has been sent, we will reply to your message via email, within 24 working hours";
                    } else {
                        $error = "Terjadi kesalahan saat mengirim pesan. Silakan coba lagi.";
                    }
                    $stmt->close();
                }
            }
        }
    }
}
// Query untuk mengambil data testimonial dengan rating 4 ke atas, diurutkan berdasarkan rating tertinggi, dan dibatasi 3 hasil
$query = "
    SELECT c.username, c.comment, c.comment_star, c.image, r.region_name
    FROM comments c
    JOIN regions r ON c.region_id = r.region_id
    WHERE c.comment_star >= 4
    ORDER BY c.comment_star DESC
    LIMIT 3
";
$result = mysqli_query($conn, $query);

if (!$result) {
    die("Query gagal dijalankan: " . mysqli_error($conn));
}

$testimonials = mysqli_fetch_all($result, MYSQLI_ASSOC);

// Query untuk mengambil rata-rata comment_star untuk setiap nama_paket_trip
$rating_query = "SELECT nama_paket_trip, AVG(comment_star) AS average_rating 
                FROM comments 
                GROUP BY nama_paket_trip";

$rating_result = mysqli_query($conn, $rating_query);

// Menyimpan hasil query ke dalam array untuk mempermudah akses
$ratings = [];
while ($rating_row = mysqli_fetch_assoc($rating_result)) {
    $ratings[$rating_row['nama_paket_trip']] = $rating_row['average_rating'];
}

// KONVERSI MATA UANG
// Ambil kurs mata uang real-time dari API (gunakan API key Anda)
$api_url = "https://api.exchangerate-api.com/v4/latest/USD";
$exchange_rates = json_decode(@file_get_contents($api_url), true);

// Default kurs jika API gagal diakses
$rates = [
    'USD' => 1,
    'MYR' => $exchange_rates['rates']['MYR'] ?? 4.2,
    'IDR' => $exchange_rates['rates']['IDR'] ?? 15000,
    'EUR' => $exchange_rates['rates']['EUR'] ?? 0.92,
    'SGD' => $exchange_rates['rates']['SGD'] ?? 1.35
];

// Mata uang yang dipilih (default USD)
$currency = isset($_GET['currency']) ? $_GET['currency'] : 'USD';
$rate = $rates[$currency] ?? 1;
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TRIPTROVE</title>
    <link rel="icon" href="images/Trip Trove.png" type="image/icon type">
    <link rel="stylesheet" href="style.css?v=123">
    <link rel="stylesheet" href="fontawesome-free-6.5.2-web/css/all.min.css"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"/>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/typed.js/2.0.11/typed.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/waypoints/4.0.1/jquery.waypoints.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css"/>
</head>
<body>
    <div class="scroll-up-btn">
        <i class="fas fa-angle-up"></i>
    </div>
    <nav class="navbar">
        <div class="max-width">
            <div class="logo"><img src="images/Trip Trove PNG.png" style="max-width: 25%;" alt=""></div>
            <ul class="menu">
                <li><a href="#home" class="menu-btn">Home</a></li>
                <li><a href="#about" class="menu-btn">About</a></li>
                <li><a href="#paket" class="menu-btn">Trip</a></li>
                <li><a href="#hotel" class="menu-btn">Include</a></li>
                <li><a href="#testimonial" class="menu-btn">Testimonial</a></li>
                <li><a href="#contact" class="menu-btn">Contact</a></li>
                <li><a href="login&register/login.php"><button type="submit">Login</button></a></li>
            </ul>
            <div class="menu-btn">
                <i class="fas fa-bars"></i>
            </div>
        </div>
    </nav>

  <!-- home section start -->
  <section class="home" id="home">
        <div class="max-width">
            <div class="home-content">
                <div class="text-1">FSN Tour And Travel</div>
                <div class="text-2">Get more discount in 2025 sale</div>
                <div class="text-3">EXPLORE: <span class="typing"></span></div>
                <a href="#paket"> Explore Now</a>
            </div>
        </div>
    </section>

   <!-- Paket-Perjalanan section-->
   <section class="paket" id="paket">
        <div class="max-width">
            <h2 class="title">Our Trip</h2>
            <?php
            // Ambil semua kategori unik dari database
            $query_kategori = "SELECT DISTINCT kategori FROM paket_trip WHERE kategori IS NOT NULL AND kategori != ''";
            $result_kategori = mysqli_query($conn, $query_kategori);
            $kategori_list = [];

            while ($row = mysqli_fetch_assoc($result_kategori)) {
                $kategori_list[] = $row['kategori'];
            }
            ?>

            <!-- Pilihan kategori sebagai button -->
            <div class="kategori-filter text-center">
                <form id="kategoriForm" action="<?php echo $_SERVER['PHP_SELF']; ?>#paket" method="GET" class="filter-form">
                    <input type="hidden" name="search" value="<?php echo isset($_GET['search']) ? $_GET['search'] : ''; ?>">
                    <button type="submit" name="kategori" value="" class="btn-kategori <?php echo !isset($_GET['kategori']) || $_GET['kategori'] == '' ? 'active' : ''; ?>">All</button>
                    
                    <?php foreach ($kategori_list as $kategori) : ?>
                        <button type="submit" name="kategori" value="<?php echo htmlspecialchars($kategori); ?>" class="btn-kategori <?php echo (isset($_GET['kategori']) && $_GET['kategori'] == $kategori) ? 'active' : ''; ?>">
                            <?php echo htmlspecialchars($kategori); ?>
                        </button>
                    <?php endforeach; ?>
                </form>
            </div>

            <!-- Form pencarian -->
            <div class="pencarian">
                <form id="searchForm" action="<?php echo $_SERVER['PHP_SELF']; ?>#paket" method="GET" class="search-bar">
                    <input type="search" name="search" placeholder="Search..." pattern=".*\S.*" required value="<?php echo isset($_GET['search']) ? $_GET['search'] : ''; ?>">
                    <button class="search-btn" type="submit">
                        <span>Search</span>
                    </button>
                    
                    <!-- Pilihan mata uang -->
                    <select name="currency" onchange="this.form.submit()">
                        <option value="USD" <?php echo $currency == 'USD' ? 'selected' : ''; ?>>USD ($)</option>
                        <option value="MYR" <?php echo $currency == 'MYR' ? 'selected' : ''; ?>>MYR (RM)</option>
                        <option value="IDR" <?php echo $currency == 'IDR' ? 'selected' : ''; ?>>IDR (Rp)</option>
                        <option value="EUR" <?php echo $currency == 'EUR' ? 'selected' : ''; ?>>EUR (€)</option>
                        <option value="SGD" <?php echo $currency == 'SGD' ? 'selected' : ''; ?>>SGD (S$)</option>
                    </select>
                </form>
            </div>

            <div class="card-best-container">
                <?php
                $sql = "SELECT * FROM paket_trip WHERE 1";

                if (isset($_GET['search']) && !empty($_GET['search'])) {
                    $search = mysqli_real_escape_string($conn, $_GET['search']);
                    $sql .= " AND (destinasi LIKE '%$search%' OR nama_paket_trip LIKE '%$search%')";
                }
                $result = mysqli_query($conn, $sql);
                ?>

                <?php while ($row = mysqli_fetch_assoc($result)) : ?>
                    <a href="login&register/login.php" class="card-best-link">
                        <div class="card-best">
                            <img class="img-best" src="<?php echo $row['image']; ?>" alt="Trip Image" style="width: 100%;">
                            <div class="text-trip"><?php echo $row['nama_paket_trip']; ?></div>
                            <hr>
                            <div class="destinasi">
                                <p><?php echo $row['destinasi']; ?></p>
                            </div>
                            <br>
                            <small>Duration: <?php echo $row['durasi']; ?></small>

                            <!-- Harga dengan konversi mata uang -->
                            <?php
                            if (!function_exists('roundToNearestFiveCents')) {
                                function roundToNearestFiveCents($amount) {
                                    return round($amount * 20) / 20; // Membulatkan ke 0.05
                                }
                            }
                            ?>
                            <button class="btn-price">
                                <?php
                                $harga = $row['harga'] * $rate;
                                $diskon = isset($row['diskon']) ? (int) $row['diskon'] : 0;

                                if ($diskon > 0) {
                                    $harga_diskon = $harga - ($harga * ($diskon / 100));

                                    // Pembulatan berdasarkan mata uang
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

                                    echo "<span style='text-decoration: line-through; color: white;'>{$currency} " . number_format($harga, 2) . "</span> ";
                                    echo "<span style='color: #F39422; font-weight: bold;'>{$currency} " . number_format($harga_diskon, 2) . "</span>";
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
                                ?>/<small>Person</small>
                            </button>
                        </div>
                    </a>
                <?php endwhile; ?>
            </div>

        </div>
    </section>

    <!-- Hotels And Restaurants Section -->
    <section class="hotel-restaurants" id="hotel">
        <div class="container">
            <div class="title-container">
                <h1 class="section-title">Hotels Include</h1>
            </div>
            <div class="hotel-card">
                <?php 
                // Query untuk mengambil data paket_trip
                $sql = "SELECT * FROM paket_trip WHERE hotel = 1";
                
                $result = mysqli_query($conn, $sql);
                
                mysqli_data_seek($result, 0); // reset the result pointer to the start
                while ($row = mysqli_fetch_assoc($result)) { ?>
                    <div class="hotel-cards">
                        <div class="card">
                            <img class="img-paket" src="<?php echo $row['image']; ?>" alt="">
                            <h2 class="judul-trip"><?php echo $row['nama_paket_trip']; ?></h2>
                            <p><?php echo $row['destinasi']; ?><br><small>Duration: <?php echo $row['durasi']; ?></small></p>
                            <h6><img src="images/icons/map-pin-line.png" alt=""><?php echo $row['lokasi']; ?></h6>
                            <div class="rating">
                                <?php
                                $rating = isset($ratings[$row['nama_paket_trip']]) ? round($ratings[$row['nama_paket_trip']]) : 0;
                                for ($i = 1; $i <= 5; $i++) {
                                    echo $i <= $rating ? '&#9733;' : '&#9734;';
                                }
                                ?>
                            </div>  
                            <a href="login&register/login.php" class="card-best-link">
                                <button class="btn-price">US$ <?php echo $row['harga']; ?>/Person</button></a>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
    </section>

    <!-- about section  -->
    <section class="about" id="about">
        <div class="max-width">
            <h2 class="title">About Us</h2>
            <div class="about-content">
                <div class="column left">
                    <img src="images/Trip Trove.png" alt="">
                </div>
                <div class="column right">
                    <div class="text">What We Offer <span class="typing-2"></span></div>
                    <p>Welcome to TRIPTROVE, your gateway to the enchanting archipelago of Indonesia. From lush rainforests to ancient temples and vibrant cities, Indonesia is a treasure trove of unforgettable experiences, and we're here to help you explore every corner of this magnificent country. With our deep-rooted knowledge of Indonesia, TRIPTROVE provides authentic experiences that let you connect with the local culture, cuisine, and communities. Our guides are passionate locals who are eager to share their homeland's hidden gems.</p>
                    <a href="#">Destination</a>
                </div>
            </div>
        </div>
    </section>

      <!-- Advantage section start -->
      <section class="advantage" id="advantage">
        <div class="max-width">
            <h2 class="title">Our Advantages</h2>
            <div class="adv-content">
                <div class="card">
                    <div class="box">
                        <i class="fa-solid fa-car"></i>
                        <div class="text">Professional Driver</div>
                        <p>We guarantee your trip is safe, comfortable, and fun by means of knowledgeable, friendly, and professional drivers.</p>
                    </div>
                </div>
                <div class="card">
                    <div class="box">
                        <i class="fa-solid fa-road"></i>
                        <div class="text">Experienced</div>
                        <p>With competent, informed, and professional service, we guarantee your trip is seamless and fun.</p>
                    </div>
                </div>
                <div class="card">
                    <div class="box">
                        <i class="fa-solid fa-user-tie"></i>
                        <div class="text">Neat Appearance</div>
                        <p>Our drivers have a neat and professional appearance, so guaranteeing a nice and respectful journey.</p>
                    </div>
                </div>
               </div>
            </div>
        </div>
    </section>

    <!-- Testimonial section start -->
    <section class="Testimonial" id="testimonial">
    <div class="max-width">
        <h2 class="title">Testimonial</h2>
        <div class="Testimonial-content">
            <?php foreach ($testimonials as $testimonial): ?>
                <figure class="snip1390">
                    <img src="<?php echo htmlspecialchars($testimonial['image']); ?>" alt="profile-sample" class="profile" />
                    <figcaption>
                        <h2><?php echo htmlspecialchars($testimonial['username']); ?></h2>
                        <h4><?php echo htmlspecialchars($testimonial['region_name']); ?></h4>
                        <blockquote><?php echo htmlspecialchars($testimonial['comment']); ?></blockquote>
                    </figcaption>
                </figure>
            <?php endforeach; ?>
        </div>
    </div>
</section>

    <!-- contact section start -->
    <section class="contact" id="contact">
        <div class="max-width">
            <h2 class="title">Contact Us</h2>
            <div class="contact-content">
                <div class="column left">
                    <div class="text">Get in Touch</div>
                    <p>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Dignissimos harum corporis fuga corrupti. Doloribus quis soluta nesciunt veritatis vitae nobis?</p>
                    <div class="icons">
                        <div class="row">
                            <i class="fa-solid fa-people-group"></i>
                            <div class="info">
                                <div class="head">Company</div>
                                <div class="sub-title">TripTrove</div>
                            </div>
                        </div>
                        <div class="row">
                            <i class="fas fa-map-marker-alt"></i>
                            <div class="info">
                                <div class="head">Address</div>
                                <div class="sub-title">Bantul, Yogyakarta</div>
                            </div>
                        </div>
                        <div class="row">
                            <i class="fas fa-envelope"></i>
                            <div class="info">
                                <div class="head">Email</div>
                                <div class="sub-title">TripTrove@gmail.com</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="column right">
                    <div class="text">Message Us</div>
                    <?php if ($success): ?>
                        <div class="success"><?php echo $success; ?></div>
                    <?php endif; ?>
                    <?php if ($error): ?>
                        <div class="error"><?php echo $error; ?></div>
                    <?php endif; ?>
                    <form action="" method="post">
                        <div class="fields">
                            <div class="field name">
                                <input type="text" name="name" placeholder="Name" required>
                            </div>
                            <div class="field email">
                                <input type="email" name="email" placeholder="Email" required>
                            </div>
                        </div>
                        <div class="field">
                            <input type="text" name="subject" placeholder="Subject" required>
                        </div>
                        <div class="field textarea">
                            <textarea name="message" cols="30" rows="10" placeholder="Message.." required></textarea>
                        </div>
                        <!-- Elemen reCAPTCHA -->
                        <div class="g-recaptcha" data-sitekey="6LfoBvspAAAAAOYcL1E-yeOQ3_gCjOk3u0W2tJzt"></div>
                        <div class="button-area">
                            <button type="submit">Send Message</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <!-- footer section start -->
    <footer class="footer">
        <div class="waves">
            <div class="wave" id="wave1"></div>
            <div class="wave" id="wave2"></div>
            <div class="wave" id="wave3"></div>
            <div class="wave" id="wave4"></div>
          </div>
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
              <ion-icon name="logo-instagram"></ion-icon>
            </a></li>
        </ul>
        <ul class="menu">
          <li class="menu__item"><a class="menu__link" href="#">Home</a></li>
          <li class="menu__item"><a class="menu__link" href="#about">About</a></li>
          <li class="menu__item"><a class="menu__link" href="#paket">Paket</a></li>
          <li class="menu__item"><a class="menu__link" href="#testimonial">Testimonial</a></li>
          <li class="menu__item"><a class="menu__link" href="#contact">Contact</a></li>
        </ul>
        <p>&copy;2025 TRIPTROVE | All Rights Reserved</p>
      </footer>
      <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
      <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
                        
    <script src="script.js"></script>
</body>
</html>
