<div id="layoutSidenav_nav">
            <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                <div class="sb-sidenav-menu">
                    <div class="nav">
                        <div class="sb-sidenav-menu-heading">Admin</div>
                            <a class="nav-link <?php echo (basename($_SERVER['REQUEST_URI']) == 'dashboard.php') ? 'active' : ''; ?>" 
                            href="../dashboard/dashboard.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                                Dashboard
                            </a>
                            
                            <div class="sb-sidenav-menu-heading">Addons</div>

                            <a class="nav-link <?php echo (basename($_SERVER['REQUEST_URI']) == 'tampil_data_users.php') ? 'active' : ''; ?>" 
                            href="../users_php/tampil_data_users.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-user"></i></div>
                                Users
                            </a>

                            <a class="nav-link <?php echo (basename($_SERVER['REQUEST_URI']) == 'tampil_paket.php') ? 'active' : ''; ?>" 
                            href="../paket/tampil_paket.php">
                                <div class="sb-nav-link-icon"><i class="fa-solid fa-torii-gate"></i></div>
                                Paket Trip
                            </a>

                            <a class="nav-link <?php echo (basename($_SERVER['REQUEST_URI']) == 'tampil_data_admin.php') ? 'active' : ''; ?>" 
                            href="../admin/tampil_data_admin.php">
                                <div class="sb-nav-link-icon"><i class="fa-solid fa-user-tie"></i></div>
                                Admin
                            </a>

                            <a class="nav-link <?php echo (basename($_SERVER['REQUEST_URI']) == 'tampil_data_jenis.php') ? 'active' : ''; ?>" 
                            href="../jenis_kendaraan_php/tampil_data_jenis.php">
                                <div class="sb-nav-link-icon"><i class="fa-solid fa-car-on"></i></div>
                                Jenis Kendaraan
                            </a>

                            <a class="nav-link <?php echo (basename($_SERVER['REQUEST_URI']) == 'tampil_data_booking.php') ? 'active' : ''; ?>" 
                            href="../bookings/tampil_data_booking.php">
                                <div class="sb-nav-link-icon"><i class="fa-solid fa-bookmark"></i></div>
                                Booking
                            </a>

                            <a class="nav-link <?php echo (basename($_SERVER['REQUEST_URI']) == 'tampil_data_kendaraan.php') ? 'active' : ''; ?>" 
                            href="../tipe_kendaraan_php/tampil_data_kendaraan.php">
                                <div class="sb-nav-link-icon"><i class="fa-solid fa-car"></i></div>
                                Kendaraan
                            </a>

                            <a class="nav-link <?php echo (basename($_SERVER['REQUEST_URI']) == 'tampil_message.php') ? 'active' : ''; ?>" 
                            href="../message/tampil_message.php">
                                <div class="sb-nav-link-icon"><i class="fa-solid fa-envelope"></i></div>
                                Pesan
                            </a>

                            <a class="nav-link <?php echo (basename($_SERVER['REQUEST_URI']) == 'tampil_payment.php') ? 'active' : ''; ?>" 
                            href="../payment/tampil_payment.php">
                                <div class="sb-nav-link-icon"><i class="fa-solid fa-coins"></i></div>
                                Pembayaran
                            </a>

                            <a class="nav-link <?php echo (basename($_SERVER['REQUEST_URI']) == 'tampil_payment_method.php') ? 'active' : ''; ?>" 
                            href="../payment_method/tampil_payment_method.php">
                                <div class="sb-nav-link-icon"><i class="fa-solid fa-coins"></i></div>
                                Metode Pembayaran
                            </a>

                            <a class="nav-link <?php echo (basename($_SERVER['REQUEST_URI']) == 'tampil_driver.php') ? 'active' : ''; ?>" 
                            href="../driver/tampil_driver.php">
                                <div class="sb-nav-link-icon"><i class="fa-regular fa-id-card"></i></div>
                                Driver
                            </a>

                            <a class="nav-link <?php echo (basename($_SERVER['REQUEST_URI']) == 'tampil_tour_guide.php') ? 'active' : ''; ?>" 
                            href="../tour_guide/tampil_tour_guide.php">
                                <div class="sb-nav-link-icon"><i class="fa-solid fa-user-ninja"></i></div>
                                Tour Guide
                            </a>
                        </div>
                    </div>
                <div class="sb-sidenav-footer">
                    <div class="small">Logged in as:</div>
                    Admin
                </div>
            </nav>
        </div>