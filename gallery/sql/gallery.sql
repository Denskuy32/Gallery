-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 14, 2024 at 08:42 AM
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
-- Database: `gallery`
--

-- --------------------------------------------------------

--
-- Table structure for table `album`
--

CREATE TABLE `album` (
  `albumid` int(11) NOT NULL,
  `namaalbum` varchar(255) NOT NULL,
  `deskripsi` text NOT NULL,
  `tanggaldibuat` date NOT NULL,
  `userid` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `album`
--

INSERT INTO `album` (`albumid`, `namaalbum`, `deskripsi`, `tanggaldibuat`, `userid`) VALUES
(21, 'Gunung', 'gunung yang menjulang tinggi ', '2024-10-13', 8),
(22, 'pantai', 'pemandang di pantai', '2024-10-13', 8),
(23, 'gurun', 'gurun yang isinya pasir', '2024-10-13', 8),
(24, 'laut', 'laut yang indah', '2024-10-13', 8),
(25, 'hutan ', 'hutan hujan tropis ', '2024-10-13', 6),
(26, 'kota', 'kota kota besar di dunia', '2024-10-13', 6),
(27, 'ladang bunga', 'hamparan bunga yang indah', '2024-10-13', 6),
(29, 'Air Terjun', 'pemandangn di air terjun', '2024-10-14', 9),
(30, 'padang rumput', 'luasnya hamparan rumput hijau', '2024-10-14', 9);

-- --------------------------------------------------------

--
-- Table structure for table `foto`
--

CREATE TABLE `foto` (
  `fotoid` int(11) NOT NULL,
  `judulfoto` varchar(255) NOT NULL,
  `deskripsifoto` text NOT NULL,
  `tanggalunggah` date NOT NULL,
  `lokasifile` varchar(255) NOT NULL,
  `albumid` int(11) NOT NULL,
  `userid` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `foto`
--

INSERT INTO `foto` (`fotoid`, `judulfoto`, `deskripsifoto`, `tanggalunggah`, `lokasifile`, `albumid`, `userid`) VALUES
(53, 'gunung bromo ', 'indahnya panorama gunung ', '2024-10-13', 'Finding the Perfect Panorama at Bromo-Tengger-Semeru National Park.jfif', 21, 8),
(56, 'pantai blue coral', 'pantai biru yang indah', '2024-10-13', '2106613969_8k Wallpaper Nature Beach 2.jfif', 22, 8),
(57, 'gunung fuji', 'gunung yang indah dari jepang', '2024-10-13', '1446134128_Download premium image of Fuji mountain in wintertime landscape outdoors nature_ by Ling about sunrise mountain, wallpaper wintertime, snow tree, wallpaper fuji mountain, and fuji montain in wintertime 14105556.jfif', 21, 8),
(58, 'gurun pasir', 'sejauh memndang hanyalah pasir', '2024-10-13', '1738798846_download (7).jfif', 23, 8),
(59, 'ocean ', 'laut yang luas', '2024-10-13', '1964719436_خلفيه🫀_ _ Ocean pictures, Ocean wallpaper, Sky aesthetic.jfif', 24, 8),
(60, 'beach vacation', 'liburan kepantai di hari weekand', '2024-10-13', '649991380_X.jfif', 22, 8),
(61, 'rain forest', 'beautiful rain forest', '2024-10-13', '1217795368_Beautiful rain forest.jfif', 25, 6),
(63, 'gunung everest', 'gunung tertinggi di dunia', '2024-10-14', '348051252_Everest Mountain Snow Stars Smartphone Wallpaper….jfif', 21, 8),
(64, 'Waterfal telunjuk raung ', 'air terjun yang ada di banyuwangi,jawa timur', '2024-10-14', '1220132143_Waterfal Telunjuk Raung.jfif', 29, 9),
(65, 'niagara waterfall', 'Air Terjun Niagara merupakan tujuan wisata yang sangat populer', '2024-10-14', '218353863_Niagara Falls Attractions.jfif', 29, 9),
(67, 'New york', 'kota yang ada di amerika serikat', '2024-10-14', '1958310368_bdf3e5ad-cfe9-4f98-b39a-d226cf4a8ca7.jfif', 26, 6),
(68, 'bunga matahari', 'bunga matahari disaat matahari terbit', '2024-10-14', '499036304_Ladang bunga matahari.jfif', 27, 6);

-- --------------------------------------------------------

--
-- Table structure for table `komentarfoto`
--

CREATE TABLE `komentarfoto` (
  `komentarid` int(11) NOT NULL,
  `fotoid` int(11) NOT NULL,
  `userid` int(11) NOT NULL,
  `isikomentar` text NOT NULL,
  `tanggalkomentar` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `komentarfoto`
--

INSERT INTO `komentarfoto` (`komentarid`, `fotoid`, `userid`, `isikomentar`, `tanggalkomentar`) VALUES
(26, 53, 6, 'waw!! aku ingin sekali liburan ke gunung bromo', '2024-10-13'),
(27, 53, 9, 'test', '2024-10-14');

-- --------------------------------------------------------

--
-- Table structure for table `likefoto`
--

CREATE TABLE `likefoto` (
  `likeid` int(11) NOT NULL,
  `fotoid` int(11) NOT NULL,
  `userid` int(11) NOT NULL,
  `tanggallike` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `likefoto`
--

INSERT INTO `likefoto` (`likeid`, `fotoid`, `userid`, `tanggallike`) VALUES
(121, 53, 6, '2024-10-13'),
(126, 57, 6, '2024-10-14');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `userid` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `namalengkap` varchar(255) NOT NULL,
  `alamat` text NOT NULL,
  `role` enum('admin','user') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`userid`, `username`, `password`, `email`, `namalengkap`, `alamat`, `role`) VALUES
(6, 'royals23', '12345', 'royals@gmail.com', 'royals32', 'taman yasmin kebun', 'user'),
(7, 'admin', '1234#admin', 'admin@gmail.com', 'boonboom', '10011010010001', 'admin'),
(8, 'boonboom', '12345', 'boom@gmail.com', 'boonboom', 'taman yasmin kebun', 'user'),
(9, 'randomlock', '12345', 'random@gmail.com', 'randomlock', 'hotel transylvania', 'user');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `album`
--
ALTER TABLE `album`
  ADD PRIMARY KEY (`albumid`),
  ADD KEY `userid` (`userid`);

--
-- Indexes for table `foto`
--
ALTER TABLE `foto`
  ADD PRIMARY KEY (`fotoid`),
  ADD KEY `albumid` (`albumid`),
  ADD KEY `userid` (`userid`);

--
-- Indexes for table `komentarfoto`
--
ALTER TABLE `komentarfoto`
  ADD PRIMARY KEY (`komentarid`),
  ADD KEY `fotoid` (`fotoid`),
  ADD KEY `userid` (`userid`);

--
-- Indexes for table `likefoto`
--
ALTER TABLE `likefoto`
  ADD PRIMARY KEY (`likeid`),
  ADD KEY `fotoid` (`fotoid`),
  ADD KEY `userid` (`userid`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`userid`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `album`
--
ALTER TABLE `album`
  MODIFY `albumid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `foto`
--
ALTER TABLE `foto`
  MODIFY `fotoid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=69;

--
-- AUTO_INCREMENT for table `komentarfoto`
--
ALTER TABLE `komentarfoto`
  MODIFY `komentarid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `likefoto`
--
ALTER TABLE `likefoto`
  MODIFY `likeid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=127;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `userid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `album`
--
ALTER TABLE `album`
  ADD CONSTRAINT `album_ibfk_1` FOREIGN KEY (`userid`) REFERENCES `user` (`userid`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `foto`
--
ALTER TABLE `foto`
  ADD CONSTRAINT `foto_ibfk_1` FOREIGN KEY (`albumid`) REFERENCES `album` (`albumid`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `foto_ibfk_2` FOREIGN KEY (`userid`) REFERENCES `user` (`userid`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `komentarfoto`
--
ALTER TABLE `komentarfoto`
  ADD CONSTRAINT `komentarfoto_ibfk_1` FOREIGN KEY (`userid`) REFERENCES `user` (`userid`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `komentarfoto_ibfk_2` FOREIGN KEY (`fotoid`) REFERENCES `foto` (`fotoid`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `likefoto`
--
ALTER TABLE `likefoto`
  ADD CONSTRAINT `likefoto_ibfk_1` FOREIGN KEY (`userid`) REFERENCES `user` (`userid`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `likefoto_ibfk_2` FOREIGN KEY (`fotoid`) REFERENCES `foto` (`fotoid`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
