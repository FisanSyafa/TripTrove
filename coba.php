<?php
// Include koneksi.php untuk menghubungkan ke database
include('includes/koneksi.php');

// Memulai session
session_start();

// Query untuk memilih semua data dari tabel trips
$query = "SELECT * FROM trips";
$result = mysqli_query($link, $query);

// Menangani error jika query tidak berhasil
if (!$result) {
    die("Query Error: " . mysqli_error($link));
}

// Variabel untuk menyimpan pesan sukses dan error
$success = null;
$error = null;

// Pengecekan jika request method adalah POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ambil nilai dari form
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
        $recaptchaSecretKey = "6LfoBvspAAAAAKsAwow2TMgazUmEvhl_Ro6LCqnz"; // Ganti dengan secret key reCAPTCHA Anda
        $recaptchaResponse = $_POST['g-recaptcha-response'];

        // Membuat request untuk memverifikasi reCAPTCHA
        $recaptchaUrl = "https://www.google.com/recaptcha/api/siteverify?secret={$recaptchaSecretKey}&response={$recaptchaResponse}";
        $recaptchaResponseData = json_decode(file_get_contents($recaptchaUrl));

        // Pengecekan hasil verifikasi reCAPTCHA
        if (!$recaptchaResponseData->success) {
            $error = "Silakan verifikasi reCAPTCHA.";
        } else {
            // Jika tidak ada error, proses pengiriman pesan
            $ip = $_SERVER['REMOTE_ADDR'];
            $currentTime = time();      

            if (isset($_SESSION['last_submission_time'][$ip])) {
                $lastSubmissionTime = $_SESSION['last_submission_time'][$ip];
                $timeDiff = $currentTime - $lastSubmissionTime;

                if ($timeDiff < 10) {
                    $error = "Maaf, Anda hanya dapat mengirim formulir setiap 10 detik.";
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
                    // Siapkan query untuk menyimpan pesan ke database
                    $stmt = $link->prepare("INSERT INTO messages (name, email, subject, message) VALUES (?, ?, ?, ?)");
                    $stmt->bind_param("ssss", $name, $email, $subject, $message);

                    // Eksekusi query
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
?>


<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TRIPTROVE</title>
    <link rel="icon" href="images/Trip Trove.png" type="image/icon type">
    <link rel="stylesheet" href="style.css">
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
                <li><a href="login.html"><button type="submit">Login</button></a></li>
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
                <div class="text-1">EXPLORE NOW</div>
                <div class="text-2">Mr.Tri Travel And Tour</div>
                <div class="text-3">EXPLORE: <span class="typing"></span></div>
                <a href="#paket"> Explore Now</a>
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

   <!-- Paket-Perjalanan section-->
   <section class="paket" id="paket">
        <div class="max-width">
            <h2 class="title">Our Trip</h2>
            <div class="carousel owl-carousel">
                <?php
                    // Loop through hasil query dan tampilkan data trips
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo '
                        <a href="deskripsiTrip.php?id=' . $row['id'] . '" class="card-link">
                            <div class="card">
                                <div class="box">
                                    <img src="' . $row['image'] . '" alt="">
                                    <div class="text">' . $row['title'] . '</div>
                                    <p>' . $row['description'] . '<br><small>Duration: ' . $row['duration'] . '</small></p>
                                    <p class="price"><b>US$ ' . $row['price'] . '/Person</b></p>
                                </div>
                            </div>
                        </a>';
                    }
                ?>
            </div>
        </div>
    </section>
    
    <!-- Hotels And Restaurants Section -->
    <section class="hotel-restaurants" id="hotel">
        <div class="container">
          <div class="title-container">
            <h1 class="section-title">Hotels & Restaurants Include</h1>
          </div>
          <div class="pencarian">
            <form action="" class="search-bar">
                <input type="search" name="search" pattern=".*\S.*" required>
                <button class="search-btn" type="submit">
                    <span>Search</span>
                </button>
            </form>
          </div>
          
          <!-- cards -->
          <div class="hotel-card">
            
            <!-- card 1 -->
            <div class="hotel-cards">
              <img src="images/paket1.jpg" alt="" width="320" height="380">
              <h2 class="judul-trip">TRIP1</h2>
              <p>Borobudur & Prambanan temple + Tour Guide + Entry Fee<br><small>Duration: 2 Day</small></p>
              <h6><img src="/images/icons/map-pin-line.png" alt=""> Borobudur, Magelang, Central Java, Indonesia</h6>
              <div class="ratings"> <img src="/images/icons/rating=5.png" alt=""></div>
              <a href="deskripsiTrip1.html"><button class="btn-price">US$ 109/Person</button></a>
            </div>
            <!-- card 2 -->
            <div class="hotel-cards">
              <img src="images/paket2.jpeg" alt="" width="320" height="380">
              <h2 class="judul-trip">TRIP2</h2>
              <p>Mount Merbabu Sunrise & Sunset + Entry Fee<br><small>Duration: 2 Day</small></p>
              <h6><img src="/images/icons/map-pin-line.png" alt=""> Mt. Merbabu, Suroteleng, Kec. Selo, Kabupaten Boyolali, Central Java, Indonesia</h6>
              <div class="ratings"> <img src="/images/icons/rating=4.png" alt=""></div>
              <a href="deskripsiTrip2.html"><button class="btn-price">US$ 159/Person</button></a>
            </div>
            <!-- card 3 -->
            <div class="hotel-cards">
              <img src="images/paket3.jpeg" alt="" width="320" height="380">
              <h2 class="judul-trip">TRIP3</h2>
              <p>Mount Bromo + Ijen Crater + Tour Guide + Entry Fee<br><small>Duration: 3 Day</small></p>
              <h6><img src="/images/icons/map-pin-line.png" alt=""> Mt. Bromo, Podokoyo, Kec. Tosari, Pasuruan, East Java</h6>
              <div class="ratings"> <img src="/images/icons/rating=4.png" alt=""></div>
              <a href="deskripsiTrip3.html"><button class="btn-price">US$ 389.9/Person</button></a>
            </div>
            <!-- card 4 -->
            <div class="hotel-cards">
              <img src="images/paket4.jpg" alt="" width="320" height="380">
              <h2 class="judul-trip">TRIP4</h2>
              <p>Goes to East Java + Tour Guide + Entry Fee<br><small>Duration: 2 Day</small></p>
              <h6><img src="/images/icons/map-pin-line.png" alt=""> Dewi Sartika Atas Street, Sisir, Kec. Batu, Batu City, East Java.</h6>
              <div class="ratings"> <img src="/images/icons/rating=5.png" alt=""></div>
              <a href="deskripsiTrip4.html"><button class="btn-price">US$ 180/Person</button></a>
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
                        <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Rem quia sunt, quasi quo illo enim.</p>
                    </div>
                </div>
                <div class="card">
                    <div class="box">
                        <i class="fa-solid fa-road"></i>
                        <div class="text">Experienced</div>
                        <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Rem quia sunt, quasi quo illo enim.</p>
                    </div>
                </div>
                <div class="card">
                    <div class="box">
                        <i class="fa-solid fa-user-tie"></i>
                        <div class="text">Neat Appearance</div>
                        <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Rem quia sunt, quasi quo illo enim.</p>
                    </div>
                </div>
               </div>
            </div>
        </div>
    </section>


    <section class="Testimonial" id="testimonial">
    <div class="max-width">
        <h2 class="title">Testimonial</h2> <!-- Judul ditempatkan di luar dari div .Testimonial-content -->
        <div class="Testimonial-content">
            <figure class="snip1390">
                <img src="https://s3-us-west-2.amazonaws.com/s.cdpn.io/331810/profile-sample3.jpg" alt="profile-sample3" class="profile" />
                <figcaption>
                  <h2>Raju Kencang</h2>
                  <h4>Malaysia</h4>
                  <blockquote>Seronok sangat! Awak suka kereta TRIPTROVE ni, driver pun macam friend.</blockquote>
                </figcaption>
              </figure>
              <figure class="snip1390 hover"><img src="https://s3-us-west-2.amazonaws.com/s.cdpn.io/331810/profile-sample6.jpg" alt="profile-sample5" class="profile" />
                <figcaption>
                  <h2>Sue Shei</h2>
                  <h4>Singapore</h4>
                  <blockquote>That's amazing trip with TRIPTROVE, I can't move on. You must try trip with TRIPTROVE! </blockquote>
                </figcaption>
              </figure>
              <figure class="snip1390"><img src="https://s3-us-west-2.amazonaws.com/s.cdpn.io/331810/profile-sample5.jpg" alt="profile-sample6" class="profile" />
                <figcaption>
                  <h2>Charlie Puth</h2>
                  <h4>United State</h4>
                  <blockquote>I think you must try trip with TRIPTROVE at least once. That's cool experience!!</blockquote>
                </figcaption>
              </figure>
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
        <p>&copy;2024 TRIPTROVE | All Rights Reserved</p>
      </footer>
      <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
      <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>

    <script src="script.js"></script>
</body>
</html>
