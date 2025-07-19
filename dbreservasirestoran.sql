-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 19, 2025 at 08:20 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `asdes`
--

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `meja`
--

CREATE TABLE `meja` (
  `no_meja` int(10) UNSIGNED NOT NULL,
  `tipe_meja` enum('Persegi','Bundar','Persegi Panjang','VIP') DEFAULT NULL,
  `kapasitas` int(11) DEFAULT NULL,
  `id_staf` int(10) UNSIGNED DEFAULT NULL,
  `status` enum('tersedia','dipesan') NOT NULL,
  `harga` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `meja`
--

INSERT INTO `meja` (`no_meja`, `tipe_meja`, `kapasitas`, `id_staf`, `status`, `harga`) VALUES
(1, 'Persegi', 4, 1, 'dipesan', 10000.00),
(2, 'Persegi', 4, 1, 'dipesan', 10000.00),
(3, 'Persegi', 4, 1, 'tersedia', 10000.00),
(4, 'Persegi', 4, 1, 'tersedia', 10000.00),
(5, 'Bundar', 4, 1, 'tersedia', 10000.00),
(6, 'Bundar', 4, 1, 'tersedia', 10000.00),
(7, 'Bundar', 4, 1, 'tersedia', 10000.00),
(8, 'Persegi Panjang', 6, 1, 'tersedia', 15000.00),
(9, 'Persegi Panjang', 6, 1, 'tersedia', 15000.00),
(10, 'VIP', 10, 1, 'tersedia', 25000.00);

-- --------------------------------------------------------

--
-- Table structure for table `menu`
--

CREATE TABLE `menu` (
  `id_menu` int(10) UNSIGNED NOT NULL,
  `id_staf` int(10) UNSIGNED DEFAULT NULL,
  `nama` varchar(100) NOT NULL,
  `gambar` varchar(255) DEFAULT NULL,
  `kategori` varchar(50) DEFAULT NULL,
  `tipe` enum('makanan','minuman') NOT NULL,
  `deskripsi` text DEFAULT NULL,
  `harga` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `menu`
--

INSERT INTO `menu` (`id_menu`, `id_staf`, `nama`, `gambar`, `kategori`, `tipe`, `deskripsi`, `harga`) VALUES
(19, 1, 'Steak Daging Sapi', 'steak.jpg', 'daging', 'makanan', 'Steak daging sapi premium', 90000.00),
(20, 1, 'Spaghetti Carbonara', 'carbonara.jpg', 'pasta', 'makanan', 'Spaghetti saus carbonara creamy', 55000.00),
(21, 1, 'Udang Saus Tiram', 'udang.jpg', 'seafood', 'makanan', 'Udang segar dengan saus tiram spesial', 65000.00),
(22, 1, 'Salad Caesar', 'salad.jpg', 'salad', 'makanan', 'Salad Caesar dengan topping keju dan ayam', 35000.00),
(23, 1, 'Mango Cocktail', 'cocktail.jpg', 'cocktail', 'minuman', 'Minuman cocktail rasa mangga segar', 45000.00);

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2025_05_24_154455_create_menus_table', 1),
(9, '0001_01_01_000000_create_users_table', 1),
(10, '0001_01_01_000001_create_cache_table', 1),
(11, '0001_01_01_000002_create_jobs_table', 1),
(12, '2025_05_24_154455_create_menus_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `otp`
--

CREATE TABLE `otp` (
  `id` int(20) UNSIGNED NOT NULL,
  `email` varchar(255) NOT NULL,
  `kode_otp` varchar(255) NOT NULL,
  `expires_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pelanggan`
--

CREATE TABLE `pelanggan` (
  `id_pelanggan` int(10) UNSIGNED NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(100) NOT NULL,
  `nomor_handphone` varchar(15) NOT NULL,
  `foto_profil` varchar(255) DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pelanggan`
--

INSERT INTO `pelanggan` (`id_pelanggan`, `username`, `password`, `email`, `nomor_handphone`, `foto_profil`, `remember_token`) VALUES
(15, 'Rafles', '$2y$12$FyNjVALIjOHb6wCaPgwE0uRbQ2Uv222YW1E8Wx.jH3DTM./.mdyTu', 'raflesyudaa@gmail.com', '123456789', 'uWGqVhcpfaKZB7FoPZVlCmOMeGasCHWR7JZ0M9e7.jpg', 'lXKXEHlyQujmECmFU2Xu8xsBCWUKlI4U5ix5rpehQgihtnRG47mBaHc6vt8O'),
(16, 'Carmite', '$2y$12$kpm5Ke.bTA1j.l8er5dr6ex6gtSuTdZSGzpSA.U4UNvq1m6SAxZaC', 'carmite@gmail.com', '1234567899', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `pembayaran`
--

CREATE TABLE `pembayaran` (
  `id_pembayaran` int(10) UNSIGNED NOT NULL,
  `id_pemesanan` int(10) UNSIGNED DEFAULT NULL,
  `total_harga` decimal(10,2) DEFAULT NULL,
  `metode_pembayaran` enum('bca','bni','bri','mandiri') DEFAULT NULL,
  `status` enum('dikonfirmasi','menunggu','dibatalkan','selesai') DEFAULT NULL,
  `id_staf` int(10) UNSIGNED DEFAULT NULL,
  `bukti_pembayaran` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pembayaran`
--

INSERT INTO `pembayaran` (`id_pembayaran`, `id_pemesanan`, `total_harga`, `metode_pembayaran`, `status`, `id_staf`, `bukti_pembayaran`) VALUES
(48, 126, 23000.00, 'bca', 'selesai', NULL, 'ZbyvJ4p9H9gCLQiuJxkZOnd2gPidyIkJq4TfA3bT.png'),
(49, 128, 23000.00, 'mandiri', 'selesai', NULL, 'LZU3D5gkm2xmBkedRklcLSjqQbn8rfCo4aFailrw.png'),
(50, 130, 23000.00, 'bni', 'selesai', NULL, 'fawO1hPJr6lEOd2tDonUI4TT4KZ6i87uBRDSCg29.png'),
(51, 132, 23000.00, 'mandiri', 'selesai', NULL, '7ZysobztjdPtSCubvushbMBEfDWtpq01k5HVzEqi.png'),
(52, 135, 23000.00, 'bni', 'selesai', NULL, 'e1ZhXoa3wuKIawrs374lk44wv2C4qbNGS8BvaCL5.png'),
(53, 137, 33000.00, 'bca', 'dikonfirmasi', NULL, 'EtQfKQEpwoS4243MiiXcDn8ydMWBu6BzA4eUA91C.png'),
(54, 137, 33000.00, 'bca', 'menunggu', NULL, '7zCsefsncI6xcF9dwMsBoj0Zn00DKfhRxBpvPI76.png'),
(55, 140, 80000.00, 'bca', 'dikonfirmasi', NULL, '1751824114_TRX2025070700474524O.png'),
(56, 141, 80000.00, 'bca', 'dikonfirmasi', NULL, '1751824114_TRX2025070700474524O.png'),
(57, 142, 40000.00, 'bca', 'menunggu', NULL, '1752044837_TRX20250709131221ONZ.png'),
(58, 148, 23000.00, 'bca', 'dikonfirmasi', NULL, 'jLl01VF4Mb43HxNLraGhWhAIyr9kTNjFqqK676Xe.jpg'),
(59, 150, 33000.00, 'bca', 'dikonfirmasi', NULL, '0ve1vyxXP9kG4Pya1C2M88sFiFUmmZSy773BFDLZ.jpg'),
(60, 153, 23000.00, 'bca', 'menunggu', NULL, 'VSL8oixPyI4aOBNHaqA1yry56bHeHw66upq2dcUO.jpg'),
(61, 155, 23000.00, 'bni', 'dikonfirmasi', NULL, 'anfPrK8hNeZOtA8VarAwj1tj8YCnhzlJSZJF3L75.jpg'),
(62, 157, 23000.00, 'bca', 'dikonfirmasi', NULL, 'C715ENQsOVz5A16lWkchiReHl9iplYKBl6ACltza.jpg'),
(63, 159, 23000.00, 'bni', 'dikonfirmasi', NULL, 'E7GradW8Xoc9NEkE8DbIYDhPuhMB5PZLPoHMuWYn.jpg'),
(64, 161, 23000.00, 'bni', 'dikonfirmasi', NULL, 'R3xJxcCzujtHzUJFVNo7EyIzyQyvNUoJIkw5dGbQ.jpg'),
(65, 163, 28000.00, 'bni', 'dikonfirmasi', NULL, 'sivZZWF9xtjgU6dxUwHKkEF4R76QmsHQg4mHPR30.jpg'),
(66, 164, 23000.00, 'bni', 'menunggu', NULL, 'oWPVu1rJA3Asv3ziIJRmRV4V0tB5rZbkY2V48U6C.jpg'),
(67, 166, 23000.00, 'bca', 'dikonfirmasi', NULL, 'oQ8HIdRaLFPZhedOfI8J0w3xL41aiMBCSLwD1bua.jpg'),
(68, 168, 23000.00, 'bca', 'dikonfirmasi', NULL, 'Z3uepXsfN2rmnhVhi8pNHXuDEp45bFcRnlmOoVJP.jpg'),
(69, 172, 43000.00, 'bca', 'dikonfirmasi', NULL, 'q6PVZxEQvES4CURFi8dqRT5aI0WseuJ3rRK2R6yr.jpg'),
(70, 174, 23000.00, 'bca', 'dikonfirmasi', NULL, 'yz9AW82hByUxdgx0hZUOGgUPTN07kdS4i4s3YLS0.jpg'),
(71, 176, 23000.00, 'bca', 'dikonfirmasi', NULL, 'NroVHGHz2t6pb8uT8voVkseLxd8tjUPkeSUfZbim.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `pemesanan`
--

CREATE TABLE `pemesanan` (
  `id_pemesanan` int(10) UNSIGNED NOT NULL,
  `id_pelanggan` int(10) UNSIGNED DEFAULT NULL,
  `kode_transaksi` varchar(255) DEFAULT NULL,
  `no_meja` int(11) UNSIGNED DEFAULT NULL,
  `nama_pemesan` varchar(255) DEFAULT NULL,
  `jumlah_tamu` int(11) DEFAULT NULL,
  `no_handphone` varchar(255) DEFAULT NULL,
  `catatan` text DEFAULT NULL,
  `jadwal` datetime DEFAULT NULL,
  `status` enum('dikonfirmasi','menunggu','dibatalkan','selesai') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pemesanan`
--

INSERT INTO `pemesanan` (`id_pemesanan`, `id_pelanggan`, `kode_transaksi`, `no_meja`, `nama_pemesan`, `jumlah_tamu`, `no_handphone`, `catatan`, `jadwal`, `status`) VALUES
(126, 15, 'TRX20250630105740ASO', 1, 'asd', 2, '1234', 'sdfe', '2025-06-30 11:00:00', 'selesai'),
(127, 15, 'TRX20250630105740ASO', 2, 'asd', 2, '1234', 'sdfe', '2025-06-30 11:00:00', 'selesai'),
(128, 15, 'TRX20250630110405GNJ', 5, 'Rafles', 2, '1234', 'asd2', '2025-06-30 11:00:00', 'selesai'),
(129, 15, 'TRX20250630110405GNJ', 4, 'Rafles', 2, '1234', 'asd2', '2025-06-30 11:00:00', 'selesai'),
(130, 15, 'TRX20250630110917XVP', 5, 'Rafles', 2, '1234', 'asdw', '2025-06-30 12:00:00', 'selesai'),
(131, 15, 'TRX20250630110917XVP', 2, 'Rafles', 2, '1234', 'asdw', '2025-06-30 12:00:00', 'selesai'),
(132, 15, 'TRX20250630144149FQ5', 1, 'Rafles', 2, '1234', 'asd', '2025-06-30 15:00:00', 'selesai'),
(133, 15, 'TRX20250630144149FQ5', 2, 'Rafles', 2, '1234', 'asd', '2025-06-30 15:00:00', 'selesai'),
(134, 15, 'TRX20250630150950RVH', 3, 'Rafles', 2, '1234', NULL, '2025-06-30 15:00:00', 'dibatalkan'),
(135, 15, 'TRX202506301520461E3', 4, 'asd', 2, '1234', NULL, '2025-06-30 16:00:00', 'selesai'),
(136, 15, 'TRX202506301520461E3', 5, 'asd', 2, '1234', NULL, '2025-06-30 16:00:00', 'selesai'),
(137, 15, 'TRX20250630165309DGN', 5, 'Rafles', 2, '1234', NULL, '2025-06-30 18:00:00', 'dikonfirmasi'),
(138, 15, 'TRX20250630165309DGN', 4, 'Rafles', 2, '1234', NULL, '2025-06-30 18:00:00', 'dikonfirmasi'),
(139, 15, 'TRX20250630165309DGN', 3, 'Rafles', 2, '1234', NULL, '2025-06-30 18:00:00', 'dikonfirmasi'),
(140, 15, 'TRX2025070700474524O', 1, 'rafles', 2, '09864', NULL, '2025-07-07 11:00:00', 'dikonfirmasi'),
(141, 15, 'TRX2025070700474524O', 2, 'rafles', 2, '09864', NULL, '2025-07-07 11:00:00', 'dikonfirmasi'),
(142, 15, 'TRX20250709131221ONZ', 1, 'rafles', 3, '123', NULL, '2025-07-09 15:00:00', 'menunggu'),
(143, 15, 'TRX20250709141059TKA', 2, 'rafles', 2, 'asdw', NULL, '2025-07-09 15:00:00', 'menunggu'),
(144, 15, 'TRX20250709142333J77', 8, 'rafles', 2, '09864', NULL, '2025-07-09 15:00:00', 'menunggu'),
(145, 15, 'TRX20250709142939ZER', 9, 'Rafleswqe', 2, '123', NULL, '2025-07-09 15:00:00', 'dibatalkan'),
(146, 15, 'TRX20250709185457BAW', 10, 'Rafles', 12, '12345', NULL, '2025-07-09 21:00:00', 'dibatalkan'),
(147, 15, 'TRX20250709185457BAW', 9, 'Rafles', 12, '12345', NULL, '2025-07-09 21:00:00', 'dibatalkan'),
(148, 15, 'TRX202507181216265NK', 1, 'Rafles', 4, '1234567896', NULL, '2025-07-18 13:00:00', 'dikonfirmasi'),
(149, 15, 'TRX202507181216265NK', 2, 'Rafles', 4, '1234567896', NULL, '2025-07-18 13:00:00', 'dikonfirmasi'),
(150, 15, 'TRX20250718122351XAF', 3, 'Rafles', 10, '1234567890', NULL, '2025-07-18 13:00:00', 'dikonfirmasi'),
(151, 15, 'TRX20250718122351XAF', 4, 'Rafles', 10, '1234567890', NULL, '2025-07-18 13:00:00', 'dikonfirmasi'),
(152, 15, 'TRX20250718122351XAF', 7, 'Rafles', 10, '1234567890', NULL, '2025-07-18 13:00:00', 'dikonfirmasi'),
(153, 15, 'TRX20250718123756ZQD', 1, 'Rafles', 7, '1234567890', NULL, '2025-07-18 17:00:00', 'dibatalkan'),
(154, 15, 'TRX20250718123756ZQD', 2, 'Rafles', 7, '1234567890', NULL, '2025-07-18 17:00:00', 'dibatalkan'),
(155, 15, 'TRX20250718124035KEL', 1, 'Rafles', 7, '12345678909', NULL, '2025-07-18 19:00:00', 'dikonfirmasi'),
(156, 15, 'TRX20250718124035KEL', 2, 'Rafles', 7, '12345678909', NULL, '2025-07-18 19:00:00', 'dikonfirmasi'),
(157, 15, 'TRX20250718125232XMM', 1, 'Rafles', 6, '12345678990', NULL, '2025-07-18 21:00:00', 'dikonfirmasi'),
(158, 15, 'TRX20250718125232XMM', 2, 'Rafles', 6, '12345678990', NULL, '2025-07-18 21:00:00', 'dikonfirmasi'),
(159, 15, 'TRX20250718125653HDP', 5, 'Rafles', 6, '12345678990', NULL, '2025-07-18 17:00:00', 'dikonfirmasi'),
(160, 15, 'TRX20250718125653HDP', 6, 'Rafles', 6, '12345678990', NULL, '2025-07-18 17:00:00', 'dikonfirmasi'),
(161, 15, 'TRX20250718130037BAX', 3, 'Rafles', 7, '12345678990', NULL, '2025-07-18 19:00:00', 'dikonfirmasi'),
(162, 15, 'TRX20250718130037BAX', 4, 'Rafles', 7, '12345678990', NULL, '2025-07-18 19:00:00', 'dikonfirmasi'),
(163, 15, 'TRX202507181311510SE', 10, 'Rafles', 10, '1231231231231', NULL, '2025-07-18 19:00:00', 'dikonfirmasi'),
(164, 15, 'TRX202507181553058QA', 6, 'Rafles', 6, '12345678909', NULL, '2025-07-18 19:00:00', 'menunggu'),
(165, 15, 'TRX202507181553058QA', 7, 'Rafles', 6, '12345678909', NULL, '2025-07-18 19:00:00', 'menunggu'),
(166, 15, 'TRX20250718155711171', 3, 'Rafles', 6, '12345678990', NULL, '2025-07-18 21:00:00', 'dikonfirmasi'),
(167, 15, 'TRX20250718155711171', 4, 'Rafles', 6, '12345678990', NULL, '2025-07-18 21:00:00', 'dikonfirmasi'),
(168, 15, 'TRX2025071816083880N', 5, 'Rafles', 8, '12345678990', NULL, '2025-07-18 21:00:00', 'dikonfirmasi'),
(169, 15, 'TRX2025071816083880N', 6, 'Rafles', 8, '12345678990', NULL, '2025-07-18 21:00:00', 'dikonfirmasi'),
(170, 15, 'TRX202507181627546LB', 7, 'Rafles', 8, '12345678990', NULL, '2025-07-18 21:00:00', 'dibatalkan'),
(171, 15, 'TRX202507181627546LB', 9, 'Rafles', 8, '12345678990', NULL, '2025-07-18 21:00:00', 'dibatalkan'),
(172, 15, 'TRX20250718163027UHE', 8, 'Rafles', 8, '12345678990', NULL, '2025-07-18 21:00:00', 'dikonfirmasi'),
(173, 15, 'TRX20250718163027UHE', 10, 'Rafles', 8, '12345678990', NULL, '2025-07-18 21:00:00', 'dikonfirmasi'),
(174, 15, 'TRX20250718163344BTD', 1, 'Rafles', 7, '12345678990', NULL, '2025-07-19 11:00:00', 'dikonfirmasi'),
(175, 15, 'TRX20250718163344BTD', 2, 'Rafles', 7, '12345678990', NULL, '2025-07-19 11:00:00', 'dikonfirmasi'),
(176, 15, 'TRX20250719233636UNE', 1, 'Rafles', 7, '12345678990', NULL, '2025-07-20 13:00:00', 'dikonfirmasi'),
(177, 15, 'TRX20250719233636UNE', 2, 'Rafles', 7, '12345678990', NULL, '2025-07-20 13:00:00', 'dikonfirmasi');

-- --------------------------------------------------------

--
-- Table structure for table `resi`
--

CREATE TABLE `resi` (
  `id_resi` varchar(255) NOT NULL,
  `id_pembayaran` int(10) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `resi`
--

INSERT INTO `resi` (`id_resi`, `id_pembayaran`) VALUES
('RCP00001', 48),
('RCP00002', 49),
('RCP00003', 50),
('RCP00004', 51),
('RCP00005', 52),
('RCP00006', 53),
('RCP00007', 55),
('RCP00008', 56),
('RCP00010', 58),
('RCP00009', 59),
('RCP00011', 61),
('RCP00012', 62),
('RCP00014', 63),
('RCP00013', 64),
('RCP00015', 65),
('RCP00016', 67),
('RCP00017', 68),
('RCP00018', 69),
('RCP00019', 70),
('RCP00020', 71);

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('UjLIL1n3BDWrcAdx5cCYtYwisqjx3pqI4fa5buRP', 15, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36 Edg/138.0.0.0', 'YTo2OntzOjY6Il90b2tlbiI7czo0MDoiMUhJUEQ2QXJpcURwd2NmWURGbTl6WVVDaWEwZDlaZmNxdTM4dU9WRSI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NDE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9yZXNlcnZhdGlvbi1oaXN0b3J5Ijt9czo1NjoibG9naW5fcGVsYW5nZ2FuXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MTU7czozOiJ1cmwiO2E6MDp7fXM6NTE6ImxvZ2luX3N0YWZfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aToxO30=', 1751225721);

-- --------------------------------------------------------

--
-- Table structure for table `staf_restoran`
--

CREATE TABLE `staf_restoran` (
  `id_staf` int(10) UNSIGNED NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `staf_restoran`
--

INSERT INTO `staf_restoran` (`id_staf`, `username`, `password`) VALUES
(1, 'staf1', '$2y$12$IyBCQajsrI3/DNk73EzuLeQpiM7IOWtt5IyFCSyXv61yZtR0IbHRK'),
(2, 'staf2', '$2y$12$.aU2/dxu/TV1fy7.X6NWC.KK57cjlLXqwBj1v.WfLeLG6IaTM0oxG'),
(3, 'staf3', '$2y$12$Fcd6D/TIVEKaO8qlFdgMxuSbeO2jRjWdb4nLP5glzW2VG/9unfE3u'),
(4, 'staf4', '$2y$12$8p6GTVNXLoTUuta9fUotr.BXsnh6oLZzIGrkMf7rD0gnm60NT6DmW'),
(5, 'staf5', '$2y$12$hLOhzbNJCFTTFO.F6JGM..D0uYEL4YG1OtXT4mGfRxMHt7gyq7O72');

-- --------------------------------------------------------

--
-- Table structure for table `ulasan`
--

CREATE TABLE `ulasan` (
  `id` int(10) UNSIGNED NOT NULL,
  `id_pemesanan` int(10) UNSIGNED NOT NULL,
  `id_pelanggan` int(10) UNSIGNED NOT NULL,
  `comments` longtext DEFAULT NULL,
  `star_rating` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ulasan`
--

INSERT INTO `ulasan` (`id`, `id_pemesanan`, `id_pelanggan`, `comments`, `star_rating`) VALUES
(61, 174, 15, 'Restorannya bersih dan nyaman', 5);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `meja`
--
ALTER TABLE `meja`
  ADD PRIMARY KEY (`no_meja`),
  ADD KEY `fk_meja_staf` (`id_staf`);

--
-- Indexes for table `menu`
--
ALTER TABLE `menu`
  ADD PRIMARY KEY (`id_menu`),
  ADD KEY `id_staf` (`id_staf`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `otp`
--
ALTER TABLE `otp`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pelanggan`
--
ALTER TABLE `pelanggan`
  ADD PRIMARY KEY (`id_pelanggan`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `nomor_handphone` (`nomor_handphone`);

--
-- Indexes for table `pembayaran`
--
ALTER TABLE `pembayaran`
  ADD PRIMARY KEY (`id_pembayaran`),
  ADD KEY `id_pemesanan` (`id_pemesanan`),
  ADD KEY `fk_pembayaran_staf` (`id_staf`);

--
-- Indexes for table `pemesanan`
--
ALTER TABLE `pemesanan`
  ADD PRIMARY KEY (`id_pemesanan`) USING BTREE,
  ADD KEY `id_pelanggan` (`id_pelanggan`),
  ADD KEY `no_meja` (`no_meja`);

--
-- Indexes for table `resi`
--
ALTER TABLE `resi`
  ADD PRIMARY KEY (`id_resi`),
  ADD KEY `id_pembayaran` (`id_pembayaran`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `staf_restoran`
--
ALTER TABLE `staf_restoran`
  ADD PRIMARY KEY (`id_staf`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `ulasan`
--
ALTER TABLE `ulasan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_pelanggan` (`id_pelanggan`) USING BTREE,
  ADD KEY `id_pemesanan` (`id_pemesanan`) USING BTREE;

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `menu`
--
ALTER TABLE `menu`
  MODIFY `id_menu` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `otp`
--
ALTER TABLE `otp`
  MODIFY `id` int(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `pelanggan`
--
ALTER TABLE `pelanggan`
  MODIFY `id_pelanggan` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `pembayaran`
--
ALTER TABLE `pembayaran`
  MODIFY `id_pembayaran` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=72;

--
-- AUTO_INCREMENT for table `pemesanan`
--
ALTER TABLE `pemesanan`
  MODIFY `id_pemesanan` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=178;

--
-- AUTO_INCREMENT for table `ulasan`
--
ALTER TABLE `ulasan`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=63;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `meja`
--
ALTER TABLE `meja`
  ADD CONSTRAINT `fk_meja_staf` FOREIGN KEY (`id_staf`) REFERENCES `staf_restoran` (`id_staf`) ON DELETE SET NULL;

--
-- Constraints for table `menu`
--
ALTER TABLE `menu`
  ADD CONSTRAINT `fk_menu_staf` FOREIGN KEY (`id_staf`) REFERENCES `staf_restoran` (`id_staf`) ON DELETE SET NULL,
  ADD CONSTRAINT `menu_ibfk_1` FOREIGN KEY (`id_staf`) REFERENCES `staf_restoran` (`id_staf`) ON DELETE SET NULL;

--
-- Constraints for table `pembayaran`
--
ALTER TABLE `pembayaran`
  ADD CONSTRAINT `fk_pembayaran_pemesanan` FOREIGN KEY (`id_pemesanan`) REFERENCES `pemesanan` (`id_pemesanan`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_pembayaran_staf` FOREIGN KEY (`id_staf`) REFERENCES `staf_restoran` (`id_staf`) ON DELETE SET NULL;

--
-- Constraints for table `pemesanan`
--
ALTER TABLE `pemesanan`
  ADD CONSTRAINT `fk_pemesanan_pelanggan` FOREIGN KEY (`id_pelanggan`) REFERENCES `pelanggan` (`id_pelanggan`) ON DELETE CASCADE;

--
-- Constraints for table `resi`
--
ALTER TABLE `resi`
  ADD CONSTRAINT `fk_resi_pembayaran` FOREIGN KEY (`id_pembayaran`) REFERENCES `pembayaran` (`id_pembayaran`) ON DELETE CASCADE,
  ADD CONSTRAINT `resi_ibfk_1` FOREIGN KEY (`id_pembayaran`) REFERENCES `pembayaran` (`id_pembayaran`);

--
-- Constraints for table `ulasan`
--
ALTER TABLE `ulasan`
  ADD CONSTRAINT `fk_ulasan_pelanggan` FOREIGN KEY (`id_pelanggan`) REFERENCES `pelanggan` (`id_pelanggan`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_ulasan_pemesanan` FOREIGN KEY (`id_pemesanan`) REFERENCES `pemesanan` (`id_pemesanan`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
