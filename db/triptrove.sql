-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 02 Jul 2025 pada 15.17
-- Versi server: 10.4.32-MariaDB
-- Versi PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `triptrove`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `admin`
--

CREATE TABLE `admin` (
  `admin_id` int(5) NOT NULL,
  `admin_name` varchar(30) NOT NULL,
  `admin_password` varchar(255) NOT NULL,
  `admin_email` varchar(30) NOT NULL,
  `alamat` varchar(255) NOT NULL,
  `no_telp` varchar(14) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `admin`
--

INSERT INTO `admin` (`admin_id`, `admin_name`, `admin_password`, `admin_email`, `alamat`, `no_telp`) VALUES
(1, 'addd', 'e3b0c44298fc1c149afbf4c8996fb92427ae41e4649b934ca495991b7852b855', 'admin@gmail.com', 'seturan, yogyakarta', '00998678'),
(3, 'admin2', 'fb118ff846721feae4ecc60a43e8b7a27511e67eacab2818117d74e6c3fbbbba', 'admin2@gmail.com', 'seturan, yogyakarta', '342455452'),
(4, 'admin', '240be518fabd2724ddb6f04eeb1da5967448d7e831c08c8fa822809f74c720a9', 'adminn@gmail.com', 'jogja', '779867');

-- --------------------------------------------------------

--
-- Struktur dari tabel `bookings`
--

CREATE TABLE `bookings` (
  `booking_id` int(5) NOT NULL,
  `cust_name` varchar(100) DEFAULT NULL,
  `username` varchar(30) DEFAULT NULL,
  `nama_paket_trip` varchar(10) NOT NULL,
  `nomor_polisi` varchar(15) DEFAULT NULL,
  `driver_id` int(5) DEFAULT NULL,
  `tour_guide_id` int(5) DEFAULT NULL,
  `kode_jenis` char(10) DEFAULT NULL,
  `person_amount` int(3) NOT NULL,
  `start_time` date NOT NULL,
  `end_time` date NOT NULL,
  `total_price` varchar(13) NOT NULL,
  `status` varchar(10) DEFAULT NULL,
  `created_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `bookings`
--

INSERT INTO `bookings` (`booking_id`, `cust_name`, `username`, `nama_paket_trip`, `nomor_polisi`, `driver_id`, `tour_guide_id`, `kode_jenis`, `person_amount`, `start_time`, `end_time`, `total_price`, `status`, `created_date`) VALUES
(59, '', 'fisan', 'TRIP2', 'AA 3323 AA', 3, 2, 'SUV-VIP', 4, '2024-07-03', '2024-07-08', '240', 'CONFIRMED', '2024-07-08 21:17:12'),
(62, '', 'fisan', 'TRIP2', 'AB 2248 AB', 5, 1, 'SUV-VIP', 3, '2024-07-18', '2024-07-23', '230', 'CONFIRMED', '2024-07-09 00:08:05'),
(63, '', 'fisan', 'TRIP4', 'AB 2248 AB', 1, 1, 'SUV-VIP', 6, '2024-07-04', '2024-07-07', '584', 'CONFIRMED', '2024-07-09 00:40:25'),
(64, '', 'fisan', 'TRIP3', NULL, NULL, NULL, 'SEDAN', 5, '2024-07-11', '2024-07-13', '1540', 'CANCELED', '2024-07-09 09:26:41'),
(66, '', 'fisan', 'TRIP2', 'AA 3323 AA', 3, 2, 'SUV-VIP', 5, '2024-08-01', '2024-08-06', '350', 'CONFIRMED', '2024-07-09 09:42:41'),
(67, '', 'fisan', 'TRIP1', 'AB 1234 AB', 2, 1, 'MVP-VIP', 4, '2024-07-13', '2024-07-14', '486', 'CONFIRMED', '2024-07-11 15:34:58'),
(71, '', 'abc', 'TRIP1', 'AB 1264 UJ', 3, 2, 'MVP', 5, '2025-02-19', '2025-02-20', '545', 'PENDING', '2025-02-18 20:34:23'),
(72, '', 'abc', 'TRIP1', NULL, NULL, NULL, NULL, 2, '2025-02-19', '2025-02-20', '218', 'PENDING', '2025-02-18 21:40:36'),
(73, 'zilong skin legend', 'abc', 'TRIP3', 'AB 1264 UJ', 4, 2, 'SEDAN', 4, '2025-02-22', '2025-02-24', '1232', 'CONFIRMED', '2025-02-18 21:48:48'),
(75, 'mas amba', 'abc', 'TRIP1', 'AB 1 RI', NULL, NULL, 'MVP', 2, '2025-03-01', '2025-03-02', '218', 'CANCELED', '2025-02-20 22:01:46'),
(84, 'ambalabu', NULL, 'TRIP1', 'AB 2323 AC', 2, 2, 'SUV', 8, '2025-02-28', '2025-03-01', '872', 'CONFIRMED', '2025-02-26 11:33:04'),
(85, 'Cikgu Jasmine', NULL, 'TRIP2', NULL, NULL, NULL, 'SUV', 3, '2025-03-01', '2025-03-06', '180', 'PENDING', '2025-02-26 19:53:24'),
(90, NULL, NULL, 'TRIP1', NULL, NULL, NULL, NULL, 2, '2025-03-02', '2025-03-03', '218', 'PENDING', '2025-02-26 21:12:11'),
(91, NULL, NULL, 'TRIP1', NULL, NULL, NULL, NULL, 2, '2025-03-02', '2025-03-03', '218', 'PENDING', '2025-02-26 21:15:57'),
(92, NULL, NULL, 'TRIP1', NULL, NULL, NULL, NULL, 2, '2025-03-02', '2025-03-03', '218', 'PENDING', '2025-02-26 21:20:45'),
(93, NULL, NULL, 'TRIP1', NULL, NULL, NULL, NULL, 2, '2025-03-07', '2025-03-08', '218', 'PENDING', '2025-02-26 21:25:13'),
(94, NULL, NULL, 'TRIP1', NULL, NULL, NULL, NULL, 2, '2025-03-06', '2025-03-08', '174.4', 'PENDING', '2025-02-26 21:26:23'),
(95, NULL, NULL, 'TRIP1', NULL, NULL, NULL, NULL, 2, '2025-03-31', '2025-04-02', '196.2', 'PENDING', '2025-03-02 10:13:50'),
(96, NULL, NULL, 'TRIP1', NULL, NULL, NULL, NULL, 2, '2025-03-31', '2025-04-01', '196.2', 'PENDING', '2025-03-02 10:16:45'),
(97, NULL, NULL, 'TRIP5', NULL, NULL, NULL, NULL, 2, '2025-03-31', '2025-03-31', '480', 'PENDING', '2025-03-02 10:18:08'),
(98, NULL, NULL, 'TRIP1', NULL, NULL, NULL, NULL, 3, '2025-03-19', '2025-03-20', '294.3', 'PENDING', '2025-03-03 22:10:04'),
(99, NULL, NULL, 'TRIP2', NULL, NULL, NULL, NULL, 4, '2025-03-05', '2025-03-10', '240', 'PENDING', '2025-03-03 22:13:53'),
(100, NULL, NULL, 'TRIP2', NULL, NULL, NULL, NULL, 3, '2025-03-04', '0000-00-00', '180', 'PENDING', '2025-03-03 22:17:49'),
(101, NULL, NULL, 'TRIP1', NULL, NULL, NULL, NULL, 1, '2025-03-04', '0000-00-00', '98.1', 'PENDING', '2025-03-03 22:19:07'),
(102, NULL, NULL, 'TRIP1', NULL, NULL, NULL, NULL, 1, '2025-03-04', '0000-00-00', '437.53', 'PENDING', '2025-03-03 22:32:43'),
(103, NULL, NULL, 'TRIP1', NULL, NULL, NULL, NULL, 1, '2025-03-03', '0000-00-00', '1625000', 'PENDING', '2025-03-03 22:33:51'),
(104, NULL, NULL, 'TRIP1', NULL, NULL, NULL, NULL, 2, '2025-03-13', '0000-00-00', '875.04', 'PENDING', '2025-03-03 22:37:51'),
(105, NULL, NULL, 'TRIP1', NULL, NULL, NULL, NULL, 1, '2025-03-13', '0000-00-00', '437.52', 'PENDING', '2025-03-03 22:38:25'),
(106, NULL, NULL, 'TRIP1', NULL, NULL, NULL, NULL, 1, '2025-03-05', '0000-00-00', '437.55', 'PENDING', '2025-03-03 23:01:31'),
(107, NULL, NULL, 'TRIP1', NULL, NULL, NULL, NULL, 1, '2025-03-05', '0000-00-00', '437.55', 'PENDING', '2025-03-03 23:04:50'),
(108, NULL, NULL, 'TRIP1', NULL, NULL, NULL, NULL, 2, '2025-06-25', '0000-00-00', '196.2', 'PENDING', '2025-06-23 20:31:27'),
(109, NULL, NULL, 'TRIP1', NULL, NULL, NULL, NULL, 2, '2025-06-11', '0000-00-00', '196.2', 'PENDING', '2025-06-23 20:33:02'),
(110, NULL, 'ikan', 'TRIP1', NULL, NULL, NULL, NULL, 3, '2025-06-18', '2025-06-19', '327', 'PENDING', '2025-06-23 20:42:28'),
(111, NULL, 'ikan', 'TRIP1', NULL, NULL, NULL, NULL, 3, '2025-06-18', '2025-06-19', '327', 'PENDING', '2025-06-23 20:46:16'),
(115, NULL, 'ikan', 'TRIP1', NULL, NULL, NULL, NULL, 1, '2025-07-01', '2025-07-02', '109', 'PENDING', '2025-06-23 20:59:16'),
(116, NULL, 'ikan', 'TRIP1', NULL, NULL, NULL, NULL, 3, '2025-06-24', '2025-06-25', '327', 'PENDING', '2025-06-23 21:00:05'),
(117, NULL, 'ikan', 'TRIP1', NULL, NULL, NULL, NULL, 3, '2025-06-24', '2025-06-25', '327', 'PENDING', '2025-06-23 21:01:40'),
(118, NULL, 'ikan', 'TRIP1', NULL, NULL, NULL, NULL, 3, '2025-06-24', '2025-06-25', '327', 'PENDING', '2025-06-23 21:02:17'),
(119, NULL, 'ikan', 'TRIP1', NULL, NULL, NULL, NULL, 4, '2025-06-27', '2025-06-28', '436', 'PENDING', '2025-06-23 21:02:28'),
(120, NULL, 'ikan', 'TRIP1', NULL, NULL, NULL, NULL, 3, '2025-06-28', '2025-06-29', '327', 'PENDING', '2025-06-23 21:12:27'),
(121, NULL, 'ikan', 'TRIP1', NULL, NULL, NULL, NULL, 3, '2025-07-04', '2025-07-05', '327', 'PENDING', '2025-06-23 21:14:26'),
(122, NULL, 'ikan', 'TRIP1', NULL, NULL, NULL, NULL, 3, '2025-07-04', '2025-07-05', '327', 'PENDING', '2025-06-23 21:18:54'),
(123, NULL, 'ikan', 'TRIP1', NULL, NULL, NULL, NULL, 2, '2025-06-25', '2025-06-26', '218', 'PENDING', '2025-06-23 21:19:02'),
(124, NULL, 'ikan', 'TRIP1', NULL, NULL, NULL, NULL, 2, '2025-06-25', '2025-06-26', '218', 'PENDING', '2025-06-23 21:26:46'),
(125, NULL, 'ikan', 'TRIP1', NULL, NULL, NULL, NULL, 2, '2025-07-12', '2025-07-13', '218', 'PENDING', '2025-06-23 21:30:59'),
(126, NULL, 'ikan', 'TRIP1', NULL, NULL, NULL, NULL, 2, '2025-07-09', '2025-07-10', '218', 'PAID', '2025-06-23 21:38:45'),
(127, NULL, 'ikan', 'TRIP1', NULL, NULL, NULL, NULL, 5, '2025-07-10', '2025-07-11', '490.5', 'PENDING', '2025-06-23 22:00:23'),
(128, NULL, 'ikan', 'TRIP1', NULL, NULL, NULL, NULL, 6, '2025-07-10', '2025-07-11', '588.6', 'PENDING', '2025-06-23 22:01:53'),
(129, NULL, 'ikan', 'TRIP1', NULL, NULL, NULL, NULL, 1, '2025-07-10', '2025-07-11', '98.1', 'PENDING', '2025-06-23 22:02:02'),
(130, 'ikan', 'ikan', 'TRIP1', 'AB 4321 UJ', 1, 1, 'MVP', 1, '2025-07-10', '2025-07-11', '98.1', 'CONFIRMED', '2025-06-23 22:05:15'),
(131, NULL, 'ikan', 'TRIP1', NULL, NULL, NULL, NULL, 2, '2025-07-09', '2025-07-10', '196.2', 'PENDING', '2025-06-25 21:16:09'),
(132, NULL, 'ikan', 'TRIP1', NULL, NULL, NULL, NULL, 2, '2025-07-10', '2025-07-11', '218', 'PENDING', '2025-06-25 21:20:27'),
(133, 'fisan', 'ikan', 'TRIP1', 'AB 1212 JJ', 4, 2, 'MVP', 5, '2025-07-03', '2025-07-04', '490.5', 'PAID', '2025-06-25 21:24:55');

-- --------------------------------------------------------

--
-- Struktur dari tabel `comments`
--

CREATE TABLE `comments` (
  `comment_id` int(5) NOT NULL,
  `username` varchar(30) NOT NULL,
  `nama_paket_trip` varchar(10) NOT NULL,
  `region_id` int(5) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `comment_star` int(1) NOT NULL,
  `comment` varchar(255) DEFAULT NULL,
  `comment_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `comments`
--

INSERT INTO `comments` (`comment_id`, `username`, `nama_paket_trip`, `region_id`, `image`, `comment_star`, `comment`, `comment_date`) VALUES
(5, 'fisan', 'TRIP2', 11, 'assets/images/2023-06-05 (27).png', 4, 'aaasss', '2024-07-04 19:22:12'),
(6, 'fisan', 'TRIP2', 11, 'assets/images/2023-06-05 (27).png', 4, 'aaasss', '2024-07-04 19:25:45'),
(10, 'fisan', 'TRIP2', 235, 'assets/images/Screenshot 2024-07-02 174029.png', 5, 'Amazing trip with TRIPTROVE!!', '2024-07-04 21:22:09'),
(11, 'fisan', 'TRIP1', 227, 'assets/images/nizar.png', 4, 'asasasasadsad', '2024-07-05 08:48:44'),
(13, 'fisan', 'TRIP1', 103, 'assets/images/PAKET C.jpg', 5, 'Amazing trip!!!', '2024-07-09 09:45:43'),
(14, 'abc', 'TRIP1', 2, '', 5, 'WOWWWW', '2025-02-20 12:18:40'),
(15, 'abc', 'TRIP2', 11, '', 1, 'BAD', '2025-02-20 12:19:21'),
(16, 'abc', 'TRIP2', 4, '', 1, 'ewww', '2025-02-20 12:19:48');

-- --------------------------------------------------------

--
-- Struktur dari tabel `drivers`
--

CREATE TABLE `drivers` (
  `driver_id` int(5) NOT NULL,
  `driver_name` varchar(50) NOT NULL,
  `driver_address` varchar(200) NOT NULL,
  `driver_no_telp` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `drivers`
--

INSERT INTO `drivers` (`driver_id`, `driver_name`, `driver_address`, `driver_no_telp`) VALUES
(1, 'Bambang', 'Jl. Magelang', '89877687'),
(2, 'Samuel', 'Condongcatur, D.I.Yogyakarta', '098767656456'),
(3, 'samm', 'Sleman', '0897756656'),
(4, 'mamang', 'Magelang', '0897655445'),
(5, 'Udin', 'Bantul', '0876898776');

-- --------------------------------------------------------

--
-- Struktur dari tabel `jenis_kendaraan`
--

CREATE TABLE `jenis_kendaraan` (
  `kode_jenis` char(10) NOT NULL,
  `jenis` varchar(30) NOT NULL,
  `charge` int(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `jenis_kendaraan`
--

INSERT INTO `jenis_kendaraan` (`kode_jenis`, `jenis`, `charge`) VALUES
('HATCHBACK', 'Hatchback', 0),
('MVP', 'Multi Purpose Vehicle', 0),
('MVP-VIP', 'Multi Purpose Vehicle - VIP', 50),
('SEDAN', 'Sedan', 0),
('SUV', 'SUV', 0),
('SUV-VIP', 'SUV-VIP', 50);

-- --------------------------------------------------------

--
-- Struktur dari tabel `messages`
--

CREATE TABLE `messages` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `subject` varchar(100) NOT NULL,
  `message` text NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `messages`
--

INSERT INTO `messages` (`id`, `name`, `email`, `subject`, `message`, `timestamp`) VALUES
(17, 'haitsam', 'ahmadhaitsam763@gmail.com', 'dsd', 'hhgh', '2024-06-17 16:24:00'),
(24, 'kukuh', 'jadeemperor7@gmail.com', 'mantap', 'jossssssssssssssssssssss', '2024-06-17 17:12:44'),
(27, 'Fisan', 'fisansyafa812@gmail.com', 'Tanya', 'bagaimana', '2024-07-09 02:41:19'),
(28, 'Fisan', 'fisan@gmail.com', 'Best', 'Your Tour & Travel are the best ever!!!', '2025-03-02 03:30:00');

-- --------------------------------------------------------

--
-- Struktur dari tabel `paket_trip`
--

CREATE TABLE `paket_trip` (
  `nama_paket_trip` varchar(10) NOT NULL,
  `destinasi` varchar(100) NOT NULL,
  `lokasi` varchar(255) NOT NULL,
  `deskripsi` varchar(255) NOT NULL,
  `hotel` int(1) NOT NULL,
  `include_hotel` int(1) NOT NULL,
  `include_request` int(1) NOT NULL,
  `include_entrance` int(1) NOT NULL,
  `include_tip` int(1) NOT NULL,
  `image` varchar(255) NOT NULL,
  `durasi` varchar(10) NOT NULL,
  `harga` float NOT NULL,
  `diskon` int(3) DEFAULT NULL,
  `kategori` varchar(255) DEFAULT NULL,
  `total_order` int(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `paket_trip`
--

INSERT INTO `paket_trip` (`nama_paket_trip`, `destinasi`, `lokasi`, `deskripsi`, `hotel`, `include_hotel`, `include_request`, `include_entrance`, `include_tip`, `image`, `durasi`, `harga`, `diskon`, `kategori`, `total_order`) VALUES
('TRIP1', 'Borobudur & Prambanan Temple + Tour Guide + Entrance Fee', 'jl. Borobudur, Magelang', 'First day we go from hotel to Borobudur temple and then the second day we go to Prambanan temple', 1, 1, 1, 1, 0, 'assets/images/borobudur1.jpg', '2 Days', 109, 10, 'Short Trip', 17),
('TRIP2', 'Ijen Cater', 'East Java', 'In the morning, go to the ijen cater hiking to see the cater', 0, 1, 1, 0, 0, 'assets/images/ijen1.jpg', '6 Days', 60, 0, 'Long Trip', 4),
('TRIP3', 'Bromo Mount + Tour Guide + Entry Fee', 'Bromo, East Java', 'Bromo is the best mount ever in East Java\r\n\r\nBromo Always be the best journey\r\n\r\ncool Mount', 1, 1, 1, 1, 0, 'assets/images/bromo1.jpg', '3 Days', 308, 0, 'Long Trip', NULL),
('TRIP4', 'AMIKOM', 'condongcatur', 'sasdas', 0, 1, 0, 1, 0, 'assets/images/main-photo.jpg', '4 Hours', 89, 0, 'Half Day', NULL),
('TRIP5', 'JAUHHH', 'Jogja', 'ashjalbfdld\r\nendksalbd ddddddddd idddddddddd djdkd hdjjjjjkkljdfkslafjafd;fd fdjsfld;fhjdfh fgdhjk fdhja;fhe\r\nfdhjalhbfjd dhfdj fhdkl fhdshfdsafh hfejhfaje;frgb f;aei;if  hejsfe\r\nfefef\r\negrq;jfe\r\n\r\nfewfjke;fjnkoejfieofew', 1, 1, 1, 0, 0, 'assets/images/bunga.jpg', '4 Hours', 300, 20, 'Half Day', 1),
('TRIP6', 'DEKAT', 'jogja', 'saadsddsad\r\nsafdasfdfdf\r\n\r\nfdfdafd\r\n\r\ndsfadsffafda\r\ndfdfdafddddddddddddddddddddd\r\ndf\r\n\r\ndfsafd', 0, 1, 1, 1, 0, 'assets/images/stick.jpg', '1 Hours', 60, 5, 'Half Day', NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `payment`
--

CREATE TABLE `payment` (
  `id` int(11) NOT NULL,
  `booking_id` int(5) NOT NULL,
  `payment_method_id` int(2) NOT NULL,
  `username` varchar(255) NOT NULL,
  `payment_proof` varchar(255) NOT NULL,
  `status` varchar(50) NOT NULL,
  `created_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `payment_methods`
--

CREATE TABLE `payment_methods` (
  `payment_method_id` int(2) NOT NULL,
  `payment_method_name` varchar(20) NOT NULL,
  `payment_method_code` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `payment_methods`
--

INSERT INTO `payment_methods` (`payment_method_id`, `payment_method_name`, `payment_method_code`) VALUES
(0, 'Paypal', 'mamad@gmail.com'),
(1, 'BRI', '811273286');

-- --------------------------------------------------------

--
-- Struktur dari tabel `regions`
--

CREATE TABLE `regions` (
  `region_id` int(5) NOT NULL,
  `region_name` varchar(20) NOT NULL,
  `first_code` varchar(3) NOT NULL,
  `sec_code` varchar(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `regions`
--

INSERT INTO `regions` (`region_id`, `region_name`, `first_code`, `sec_code`) VALUES
(1, 'Aruba', 'ABW', 'AW'),
(2, 'Afghanistan', 'AFG', 'AF'),
(3, 'Angola', 'AGO', 'AO'),
(4, 'Anguilla', 'AIA', 'AI'),
(5, 'Åland', 'ALA', 'AX'),
(6, 'Albania', 'ALB', 'AL'),
(7, 'Andorra', 'AND', 'AD'),
(8, 'United Arab Emirates', 'ARE', 'AE'),
(9, 'Argentina', 'ARG', 'AR'),
(10, 'Armenia', 'ARM', 'AM'),
(11, 'American Samoa', 'ASM', 'AS'),
(12, 'Antarctica', 'ATA', 'AQ'),
(13, 'French Southern Terr', 'ATF', 'TF'),
(14, 'Antigua and Barbuda', 'ATG', 'AG'),
(15, 'Australia', 'AUS', 'AU'),
(16, 'Austria', 'AUT', 'AT'),
(17, 'Azerbaijan', 'AZE', 'AZ'),
(18, 'Burundi', 'BDI', 'BI'),
(19, 'Belgium', 'BEL', 'BE'),
(20, 'Benin', 'BEN', 'BJ'),
(21, 'Bonaire', 'BES', 'BQ'),
(22, 'Burkina Faso', 'BFA', 'BF'),
(23, 'Bangladesh', 'BGD', 'BD'),
(24, 'Bulgaria', 'BGR', 'BG'),
(25, 'Bahrain', 'BHR', 'BH'),
(26, 'Bahamas', 'BHS', 'BS'),
(27, 'Bosnia and Herzegovi', 'BIH', 'BA'),
(28, 'Saint Barthélemy', 'BLM', 'BL'),
(29, 'Belarus', 'BLR', 'BY'),
(30, 'Belize', 'BLZ', 'BZ'),
(31, 'Bermuda', 'BMU', 'BM'),
(32, 'Bolivia', 'BOL', 'BO'),
(33, 'Brazil', 'BRA', 'BR'),
(34, 'Barbados', 'BRB', 'BB'),
(35, 'Brunei', 'BRN', 'BN'),
(36, 'Bhutan', 'BTN', 'BT'),
(37, 'Bouvet Island', 'BVT', 'BV'),
(38, 'Botswana', 'BWA', 'BW'),
(39, 'Central African Repu', 'CAF', 'CF'),
(40, 'Canada', 'CAN', 'CA'),
(41, 'Cocos [Keeling] Isla', 'CCK', 'CC'),
(42, 'Switzerland', 'CHE', 'CH'),
(43, 'Chile', 'CHL', 'CL'),
(44, 'China', 'CHN', 'CN'),
(45, 'Ivory Coast', 'CIV', 'CI'),
(46, 'Cameroon', 'CMR', 'CM'),
(47, 'Democratic Republic ', 'COD', 'CD'),
(48, 'Republic of the Cong', 'COG', 'CG'),
(49, 'Cook Islands', 'COK', 'CK'),
(50, 'Colombia', 'COL', 'CO'),
(51, 'Comoros', 'COM', 'KM'),
(52, 'Cape Verde', 'CPV', 'CV'),
(53, 'Costa Rica', 'CRI', 'CR'),
(54, 'Cuba', 'CUB', 'CU'),
(55, 'Curacao', 'CUW', 'CW'),
(56, 'Christmas Island', 'CXR', 'CX'),
(57, 'Cayman Islands', 'CYM', 'KY'),
(58, 'Cyprus', 'CYP', 'CY'),
(59, 'Czech Republic', 'CZE', 'CZ'),
(60, 'Germany', 'DEU', 'DE'),
(61, 'Djibouti', 'DJI', 'DJ'),
(62, 'Dominica', 'DMA', 'DM'),
(63, 'Denmark', 'DNK', 'DK'),
(64, 'Dominican Republic', 'DOM', 'DO'),
(65, 'Algeria', 'DZA', 'DZ'),
(66, 'Ecuador', 'ECU', 'EC'),
(67, 'Egypt', 'EGY', 'EG'),
(68, 'Eritrea', 'ERI', 'ER'),
(69, 'Western Sahara', 'ESH', 'EH'),
(70, 'Spain', 'ESP', 'ES'),
(71, 'Estonia', 'EST', 'EE'),
(72, 'Ethiopia', 'ETH', 'ET'),
(73, 'Finland', 'FIN', 'FI'),
(74, 'Fiji', 'FJI', 'FJ'),
(75, 'Falkland Islands', 'FLK', 'FK'),
(76, 'France', 'FRA', 'FR'),
(77, 'Faroe Islands', 'FRO', 'FO'),
(78, 'Micronesia', 'FSM', 'FM'),
(79, 'Gabon', 'GAB', 'GA'),
(80, 'United Kingdom', 'GBR', 'GB'),
(81, 'Georgia', 'GEO', 'GE'),
(82, 'Guernsey', 'GGY', 'GG'),
(83, 'Ghana', 'GHA', 'GH'),
(84, 'Gibraltar', 'GIB', 'GI'),
(85, 'Guinea', 'GIN', 'GN'),
(86, 'Guadeloupe', 'GLP', 'GP'),
(87, 'Gambia', 'GMB', 'GM'),
(88, 'Guinea-Bissau', 'GNB', 'GW'),
(89, 'Equatorial Guinea', 'GNQ', 'GQ'),
(90, 'Greece', 'GRC', 'GR'),
(91, 'Grenada', 'GRD', 'GD'),
(92, 'Greenland', 'GRL', 'GL'),
(93, 'Guatemala', 'GTM', 'GT'),
(94, 'French Guiana', 'GUF', 'GF'),
(95, 'Guam', 'GUM', 'GU'),
(96, 'Guyana', 'GUY', 'GY'),
(97, 'Hong Kong', 'HKG', 'HK'),
(98, 'Heard Island and McD', 'HMD', 'HM'),
(99, 'Honduras', 'HND', 'HN'),
(100, 'Croatia', 'HRV', 'HR'),
(101, 'Haiti', 'HTI', 'HT'),
(102, 'Hungary', 'HUN', 'HU'),
(103, 'Indonesia', 'IDN', 'ID'),
(104, 'Isle of Man', 'IMN', 'IM'),
(105, 'India', 'IND', 'IN'),
(106, 'British Indian Ocean', 'IOT', 'IO'),
(107, 'Ireland', 'IRL', 'IE'),
(108, 'Iran', 'IRN', 'IR'),
(109, 'Iraq', 'IRQ', 'IQ'),
(110, 'Iceland', 'ISL', 'IS'),
(111, 'Israel', 'ISR', 'IL'),
(112, 'Italy', 'ITA', 'IT'),
(113, 'Jamaica', 'JAM', 'JM'),
(114, 'Jersey', 'JEY', 'JE'),
(115, 'Jordan', 'JOR', 'JO'),
(116, 'Japan', 'JPN', 'JP'),
(117, 'Kazakhstan', 'KAZ', 'KZ'),
(118, 'Kenya', 'KEN', 'KE'),
(119, 'Kyrgyzstan', 'KGZ', 'KG'),
(120, 'Cambodia', 'KHM', 'KH'),
(121, 'Kiribati', 'KIR', 'KI'),
(122, 'Saint Kitts and Nevi', 'KNA', 'KN'),
(123, 'South Korea', 'KOR', 'KR'),
(124, 'Kuwait', 'KWT', 'KW'),
(125, 'Laos', 'LAO', 'LA'),
(126, 'Lebanon', 'LBN', 'LB'),
(127, 'Liberia', 'LBR', 'LR'),
(128, 'Libya', 'LBY', 'LY'),
(129, 'Saint Lucia', 'LCA', 'LC'),
(130, 'Liechtenstein', 'LIE', 'LI'),
(131, 'Sri Lanka', 'LKA', 'LK'),
(132, 'Lesotho', 'LSO', 'LS'),
(133, 'Lithuania', 'LTU', 'LT'),
(134, 'Luxembourg', 'LUX', 'LU'),
(135, 'Latvia', 'LVA', 'LV'),
(136, 'Macao', 'MAC', 'MO'),
(137, 'Saint Martin', 'MAF', 'MF'),
(138, 'Morocco', 'MAR', 'MA'),
(139, 'Monaco', 'MCO', 'MC'),
(140, 'Moldova', 'MDA', 'MD'),
(141, 'Madagascar', 'MDG', 'MG'),
(142, 'Maldives', 'MDV', 'MV'),
(143, 'Mexico', 'MEX', 'MX'),
(144, 'Marshall Islands', 'MHL', 'MH'),
(145, 'Macedonia', 'MKD', 'MK'),
(146, 'Mali', 'MLI', 'ML'),
(147, 'Malta', 'MLT', 'MT'),
(148, 'Myanmar [Burma]', 'MMR', 'MM'),
(149, 'Montenegro', 'MNE', 'ME'),
(150, 'Mongolia', 'MNG', 'MN'),
(151, 'Northern Mariana Isl', 'MNP', 'MP'),
(152, 'Mozambique', 'MOZ', 'MZ'),
(153, 'Mauritania', 'MRT', 'MR'),
(154, 'Montserrat', 'MSR', 'MS'),
(155, 'Martinique', 'MTQ', 'MQ'),
(156, 'Mauritius', 'MUS', 'MU'),
(157, 'Malawi', 'MWI', 'MW'),
(158, 'Malaysia', 'MYS', 'MY'),
(159, 'Mayotte', 'MYT', 'YT'),
(160, 'Namibia', 'NAM', 'NA'),
(161, 'New Caledonia', 'NCL', 'NC'),
(162, 'Niger', 'NER', 'NE'),
(163, 'Norfolk Island', 'NFK', 'NF'),
(164, 'Nigeria', 'NGA', 'NG'),
(165, 'Nicaragua', 'NIC', 'NI'),
(166, 'Niue', 'NIU', 'NU'),
(167, 'Netherlands', 'NLD', 'NL'),
(168, 'Norway', 'NOR', 'NO'),
(169, 'Nepal', 'NPL', 'NP'),
(170, 'Nauru', 'NRU', 'NR'),
(171, 'New Zealand', 'NZL', 'NZ'),
(172, 'Oman', 'OMN', 'OM'),
(173, 'Pakistan', 'PAK', 'PK'),
(174, 'Panama', 'PAN', 'PA'),
(175, 'Pitcairn Islands', 'PCN', 'PN'),
(176, 'Peru', 'PER', 'PE'),
(177, 'Philippines', 'PHL', 'PH'),
(178, 'Palau', 'PLW', 'PW'),
(179, 'Papua New Guinea', 'PNG', 'PG'),
(180, 'Poland', 'POL', 'PL'),
(181, 'Puerto Rico', 'PRI', 'PR'),
(182, 'North Korea', 'PRK', 'KP'),
(183, 'Portugal', 'PRT', 'PT'),
(184, 'Paraguay', 'PRY', 'PY'),
(185, 'Palestine', 'PSE', 'PS'),
(186, 'French Polynesia', 'PYF', 'PF'),
(187, 'Qatar', 'QAT', 'QA'),
(188, 'Réunion', 'REU', 'RE'),
(189, 'Romania', 'ROU', 'RO'),
(190, 'Russia', 'RUS', 'RU'),
(191, 'Rwanda', 'RWA', 'RW'),
(192, 'Saudi Arabia', 'SAU', 'SA'),
(193, 'Sudan', 'SDN', 'SD'),
(194, 'Senegal', 'SEN', 'SN'),
(195, 'Singapore', 'SGP', 'SG'),
(196, 'South Georgia and th', 'SGS', 'GS'),
(197, 'Saint Helena', 'SHN', 'SH'),
(198, 'Svalbard and Jan May', 'SJM', 'SJ'),
(199, 'Solomon Islands', 'SLB', 'SB'),
(200, 'Sierra Leone', 'SLE', 'SL'),
(201, 'El Salvador', 'SLV', 'SV'),
(202, 'San Marino', 'SMR', 'SM'),
(203, 'Somalia', 'SOM', 'SO'),
(204, 'Saint Pierre and Miq', 'SPM', 'PM'),
(205, 'Serbia', 'SRB', 'RS'),
(206, 'South Sudan', 'SSD', 'SS'),
(207, 'São Tomé and Príncip', 'STP', 'ST'),
(208, 'Suriname', 'SUR', 'SR'),
(209, 'Slovakia', 'SVK', 'SK'),
(210, 'Slovenia', 'SVN', 'SI'),
(211, 'Sweden', 'SWE', 'SE'),
(212, 'Swaziland', 'SWZ', 'SZ'),
(213, 'Sint Maarten', 'SXM', 'SX'),
(214, 'Seychelles', 'SYC', 'SC'),
(215, 'Syria', 'SYR', 'SY'),
(216, 'Turks and Caicos Isl', 'TCA', 'TC'),
(217, 'Chad', 'TCD', 'TD'),
(218, 'Togo', 'TGO', 'TG'),
(219, 'Thailand', 'THA', 'TH'),
(220, 'Tajikistan', 'TJK', 'TJ'),
(221, 'Tokelau', 'TKL', 'TK'),
(222, 'Turkmenistan', 'TKM', 'TM'),
(223, 'East Timor', 'TLS', 'TL'),
(224, 'Tonga', 'TON', 'TO'),
(225, 'Trinidad and Tobago', 'TTO', 'TT'),
(226, 'Tunisia', 'TUN', 'TN'),
(227, 'Turkey', 'TUR', 'TR'),
(228, 'Tuvalu', 'TUV', 'TV'),
(229, 'Taiwan', 'TWN', 'TW'),
(230, 'Tanzania', 'TZA', 'TZ'),
(231, 'Uganda', 'UGA', 'UG'),
(232, 'Ukraine', 'UKR', 'UA'),
(233, 'U.S. Minor Outlying ', 'UMI', 'UM'),
(234, 'Uruguay', 'URY', 'UY'),
(235, 'United States', 'USA', 'US'),
(236, 'Uzbekistan', 'UZB', 'UZ'),
(237, 'Vatican City', 'VAT', 'VA'),
(238, 'Saint Vincent and th', 'VCT', 'VC'),
(239, 'Venezuela', 'VEN', 'VE'),
(240, 'British Virgin Islan', 'VGB', 'VG'),
(241, 'U.S. Virgin Islands', 'VIR', 'VI'),
(242, 'Vietnam', 'VNM', 'VN'),
(243, 'Vanuatu', 'VUT', 'VU'),
(244, 'Wallis and Futuna', 'WLF', 'WF'),
(245, 'Samoa', 'WSM', 'WS'),
(246, 'Kosovo', 'XKX', 'XK'),
(247, 'Yemen', 'YEM', 'YE'),
(248, 'South Africa', 'ZAF', 'ZA'),
(249, 'Zambia', 'ZMB', 'ZM'),
(250, 'Zimbabwe', 'ZWE', 'ZW');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tipe_kendaraan`
--

CREATE TABLE `tipe_kendaraan` (
  `nomor_polisi` varchar(15) NOT NULL,
  `nama_mobil` varchar(30) NOT NULL,
  `kode_jenis` varchar(15) NOT NULL,
  `warna_mobil` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `tipe_kendaraan`
--

INSERT INTO `tipe_kendaraan` (`nomor_polisi`, `nama_mobil`, `kode_jenis`, `warna_mobil`) VALUES
('AA 3323 AA', 'Mitsubishi Pajero', 'SUV-VIP', 'Putih'),
('AB 1 RI', 'Toyota Camry', 'SEDAN', 'Hitam'),
('AB 1212 JJ', 'Daihatsu Xenia', 'MVP', 'Silver'),
('AB 1234 AB', 'Toyota Innova Reborn', 'MVP-VIP', 'hitam'),
('AB 1264 UJ', 'Toyota Vios', 'SEDAN', 'Abu-abu'),
('AB 2248 AB', 'Toyota Fortuner', 'SUV-VIP', 'Putih'),
('AB 2323 AC', 'Toyota Rush', 'SUV', 'Hitam'),
('AB 4321 UJ', 'Toyota Avanza Veloz', 'MVP', 'Merah Maroon'),
('AJ 6645 JJ', 'Honda HR-V', 'SUV', 'Abu-abu');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tour_guides`
--

CREATE TABLE `tour_guides` (
  `tour_guide_id` int(5) NOT NULL,
  `tour_guide_name` varchar(30) NOT NULL,
  `tour_guide_address` varchar(200) NOT NULL,
  `tour_guide_no_telp` int(14) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `tour_guides`
--

INSERT INTO `tour_guides` (`tour_guide_id`, `tour_guide_name`, `tour_guide_address`, `tour_guide_no_telp`) VALUES
(1, 'Ahmad', 'Jl. Kaliurang', 88875565),
(2, 'Budi', 'Seturan, D.I. Yogyakarta', 2147483647);

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `username` varchar(30) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(20) NOT NULL,
  `no_telp` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`username`, `password`, `email`, `no_telp`) VALUES
('abc', 'af46384fe03b14b0121dd62703afd73b03574cb5701bb8592edafe5d53f3f720', 'fisan1234@gmail.com', '0812345678901'),
('ahmad', '716498e9b899e2f90b3f204775bfdf2c2af51e62db5c375d8bc23e1d317ea4fe', 'aaad@gmail.com', '080808080'),
('fisan', '05696987ee042d9502787f7b7dceb7a510f4fe269cc1ce7ff37be4d8a15dcd5d', 'fisan@gmail.com', '08934112231'),
('gugugaga', '9c1c682a77f0ad181fb39d5c1efdad740e74804e3c66dc54b0a200d703a291ea', 'gugugaga@gmail.com', '01274656576'),
('Haitsam', '07ba38d7a9affba269a613da6d99a7ffa4d128ce38f5e24ee5a7383b796b58b2', 'haitsam@sjkds.com', '086656888'),
('haitsama', 'ef797c8118f02dfb649607dd5d3f8c7623048c9c063d532cc95c5ed7a898a64f', 'jadeemperor55@gmail.', '082145756668'),
('ikan', '781fe54fb77cc386f9e2ae6a306ea45356fc05b4d10b99529465fb0bd106904b', 'ikan@gmail.com', '081234567890'),
('jenderal', 'e3f161b18a1a549eafbeeca4223ca4757c2c6745c074645c6fb9399d02146b79', 'jend@gmail.com', '000008888'),
('test1', 'ef797c8118f02dfb649607dd5d3f8c7623048c9c063d532cc95c5ed7a898a64f', 'mafiagedhang4@gmail.', '082145756668'),
('user2', 'b999205cdacd2c4516598d99b420d29786443e9908556a65f583a6fd4765ee4a', 'user2@gmail.com', '0976727234'),
('user4', 'bd35283fe8fcfd77d7c05a8bf2adb85c773281927e12c9829c72a9462092f7c4', 'user4@gmail.com', '0812345678901'),
('userr', 'a0d941bf53aa98ac9c0ad3a5b80dab529f4de9f7a1b98564025a0c6e6f6c823d', 'userr@gmail.com', '098686878');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`admin_id`);

--
-- Indeks untuk tabel `bookings`
--
ALTER TABLE `bookings`
  ADD PRIMARY KEY (`booking_id`),
  ADD KEY `username` (`username`),
  ADD KEY `kode_jenis` (`kode_jenis`),
  ADD KEY `nama_paket_trip` (`nama_paket_trip`),
  ADD KEY `nomor_polisi` (`nomor_polisi`),
  ADD KEY `driver_id` (`driver_id`),
  ADD KEY `tour_guide_id` (`tour_guide_id`);

--
-- Indeks untuk tabel `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`comment_id`),
  ADD KEY `username` (`username`),
  ADD KEY `region_id` (`region_id`),
  ADD KEY `nama_paket_trip` (`nama_paket_trip`);

--
-- Indeks untuk tabel `drivers`
--
ALTER TABLE `drivers`
  ADD PRIMARY KEY (`driver_id`);

--
-- Indeks untuk tabel `jenis_kendaraan`
--
ALTER TABLE `jenis_kendaraan`
  ADD PRIMARY KEY (`kode_jenis`);

--
-- Indeks untuk tabel `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `paket_trip`
--
ALTER TABLE `paket_trip`
  ADD PRIMARY KEY (`nama_paket_trip`);

--
-- Indeks untuk tabel `payment`
--
ALTER TABLE `payment`
  ADD PRIMARY KEY (`id`),
  ADD KEY `booking_id` (`booking_id`),
  ADD KEY `payment_method_id` (`payment_method_id`);

--
-- Indeks untuk tabel `payment_methods`
--
ALTER TABLE `payment_methods`
  ADD PRIMARY KEY (`payment_method_id`);

--
-- Indeks untuk tabel `regions`
--
ALTER TABLE `regions`
  ADD PRIMARY KEY (`region_id`);

--
-- Indeks untuk tabel `tipe_kendaraan`
--
ALTER TABLE `tipe_kendaraan`
  ADD PRIMARY KEY (`nomor_polisi`),
  ADD KEY `kode_jenis` (`kode_jenis`);

--
-- Indeks untuk tabel `tour_guides`
--
ALTER TABLE `tour_guides`
  ADD PRIMARY KEY (`tour_guide_id`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`username`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `admin`
--
ALTER TABLE `admin`
  MODIFY `admin_id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT untuk tabel `bookings`
--
ALTER TABLE `bookings`
  MODIFY `booking_id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=134;

--
-- AUTO_INCREMENT untuk tabel `comments`
--
ALTER TABLE `comments`
  MODIFY `comment_id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT untuk tabel `drivers`
--
ALTER TABLE `drivers`
  MODIFY `driver_id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT untuk tabel `payment`
--
ALTER TABLE `payment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT untuk tabel `tour_guides`
--
ALTER TABLE `tour_guides`
  MODIFY `tour_guide_id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `bookings`
--
ALTER TABLE `bookings`
  ADD CONSTRAINT `bookings_ibfk_1` FOREIGN KEY (`username`) REFERENCES `users` (`username`),
  ADD CONSTRAINT `bookings_ibfk_3` FOREIGN KEY (`kode_jenis`) REFERENCES `jenis_kendaraan` (`kode_jenis`),
  ADD CONSTRAINT `bookings_ibfk_4` FOREIGN KEY (`nama_paket_trip`) REFERENCES `paket_trip` (`nama_paket_trip`),
  ADD CONSTRAINT `bookings_ibfk_5` FOREIGN KEY (`nomor_polisi`) REFERENCES `tipe_kendaraan` (`nomor_polisi`),
  ADD CONSTRAINT `bookings_ibfk_6` FOREIGN KEY (`driver_id`) REFERENCES `drivers` (`driver_id`),
  ADD CONSTRAINT `bookings_ibfk_7` FOREIGN KEY (`tour_guide_id`) REFERENCES `tour_guides` (`tour_guide_id`);

--
-- Ketidakleluasaan untuk tabel `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_ibfk_1` FOREIGN KEY (`username`) REFERENCES `users` (`username`),
  ADD CONSTRAINT `comments_ibfk_3` FOREIGN KEY (`region_id`) REFERENCES `regions` (`region_id`),
  ADD CONSTRAINT `comments_ibfk_4` FOREIGN KEY (`nama_paket_trip`) REFERENCES `paket_trip` (`nama_paket_trip`);

--
-- Ketidakleluasaan untuk tabel `payment`
--
ALTER TABLE `payment`
  ADD CONSTRAINT `payment_ibfk_1` FOREIGN KEY (`booking_id`) REFERENCES `bookings` (`booking_id`),
  ADD CONSTRAINT `payment_ibfk_2` FOREIGN KEY (`payment_method_id`) REFERENCES `payment_methods` (`payment_method_id`);

--
-- Ketidakleluasaan untuk tabel `tipe_kendaraan`
--
ALTER TABLE `tipe_kendaraan`
  ADD CONSTRAINT `tipe_kendaraan_ibfk_1` FOREIGN KEY (`kode_jenis`) REFERENCES `jenis_kendaraan` (`kode_jenis`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
