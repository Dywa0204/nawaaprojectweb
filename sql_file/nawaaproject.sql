-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 23, 2021 at 03:11 AM
-- Server version: 10.4.14-MariaDB
-- PHP Version: 7.4.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `nawaaproject`
--

-- --------------------------------------------------------

--
-- Table structure for table `order_detail`
--

CREATE TABLE `order_detail` (
  `id` varchar(12) NOT NULL,
  `status` enum('Persetujuan','Pembayaran','Diproses','Selesai','Dibatalkan') NOT NULL,
  `file_path` varchar(42) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `person` int(11) NOT NULL,
  `price` int(11) NOT NULL,
  `message` text DEFAULT NULL,
  `date_start` datetime DEFAULT NULL,
  `date_finish` datetime DEFAULT NULL,
  `file_result` varchar(50) NOT NULL DEFAULT 'Belum ada',
  `is_review` tinyint(1) NOT NULL,
  `id_user` varchar(12) NOT NULL,
  `id_product` varchar(4) NOT NULL,
  `id_rating` varchar(12) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `id` varchar(4) NOT NULL,
  `name` varchar(50) NOT NULL,
  `price` int(11) NOT NULL,
  `description` text NOT NULL,
  `time` varchar(3) NOT NULL,
  `image` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`id`, `name`, `price`, `description`, `time`, `image`) VALUES
('P001', 'Edit Background Foto', 1000, 'Background diedit menggunakan aplikasi Adobe PhotoShop sehingga hasil rapi dan realistic. Background foto dapat berupa background polos atau objek sesuai request', '1-2', 'sample-bg.png'),
('P002', 'Edit Foto Semi Realistic ', 20000, 'Efek edit foto dengan meniru keadaan yang sebenarnya baik proporsi maupun anatomi dibuat sama menyerupai dengan objek yg digambar', '3-4', 'sample-semireal.png'),
('P003', 'Edit Foto Vektor atau Kartun', 30000, 'Efek edit foto ini memanipulasi gambar dari gambar biasa menjadi seperti kartun pada foto yang diedit, efek ini bisa menjadikan anda sebagai seorang tokoh kartun.', '3-4', 'sample-vector.png'),
('P004', 'Edit Foto Manipulation', 10000, 'Efek foto ini menjadikan foto Anda menjadi lebih berimajinasi dan terkesan kreatif, Anda bisa ganti foto background Anda atau rubah bentuk tubuh Anda.', '2-3', 'sample-manipulation.png'),
('P005', 'Edit Foto Smude Painting', 25000, 'Efek edit foto ini memanipulasi gambar dari gambar biasa menjadi seperti efek kanvas pada foto yang diedit, efek ini bisa menjadikan wajah terlihat lebih mulus.', '3-4', 'sample-smudge.png'),
('P006', 'Edit Foto Low Poly', 25000, 'dawdawawva', '2-3', 'sample-lowpoly.png');

-- --------------------------------------------------------

--
-- Table structure for table `review`
--

CREATE TABLE `review` (
  `id` varchar(12) NOT NULL,
  `rating` int(2) NOT NULL,
  `comment` text NOT NULL,
  `date` datetime NOT NULL,
  `id_user` varchar(12) NOT NULL,
  `id_product` varchar(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `suggest`
--

CREATE TABLE `suggest` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `message` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` varchar(12) NOT NULL,
  `firstname` varchar(50) NOT NULL,
  `lastname` varchar(50) NOT NULL,
  `username` varchar(32) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(80) NOT NULL,
  `status` enum('admin','user') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `firstname`, `lastname`, `username`, `email`, `password`, `status`) VALUES
('MOERMCoRTXAq', 'Admin', 'Nawaa', 'adminnawa', 'nawaa.projectofficial@gmail.com', '$2y$10$xGNzwV1K.6TNLqNXt3UPpO.dszC5RhaipZCf57L10SLd1Buq/rmYO', 'admin'),
('SbYLb5NSzRgU', 'Akun', 'Baru', 'akunbaru', 'akun@akun.com', '$2y$10$CQGcxKC7q0MqLfqO0j11VOGqwdQqfcWJtnh4jIeA2Ol4Ca8F6qRqi', 'user');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `order_detail`
--
ALTER TABLE `order_detail`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `review`
--
ALTER TABLE `review`
  ADD PRIMARY KEY (`id`),
  ADD KEY `comment_user` (`id_user`),
  ADD KEY `comment_product` (`id_product`);

--
-- Indexes for table `suggest`
--
ALTER TABLE `suggest`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `suggest`
--
ALTER TABLE `suggest`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `review`
--
ALTER TABLE `review`
  ADD CONSTRAINT `comment_product` FOREIGN KEY (`id_product`) REFERENCES `product` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `comment_user` FOREIGN KEY (`id_user`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
