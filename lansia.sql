-- phpMyAdmin SQL Dump
-- version 4.8.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 21, 2021 at 06:30 PM
-- Server version: 10.1.32-MariaDB
-- PHP Version: 7.2.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `lansia`
--

-- --------------------------------------------------------

--
-- Table structure for table `hasil`
--

CREATE TABLE `hasil` (
  `id_hasil` int(11) NOT NULL,
  `id_penyakit` int(11) NOT NULL,
  `id_pasien` int(11) NOT NULL,
  `nilai` float DEFAULT NULL,
  `bulan` char(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `hasil`
--

INSERT INTO `hasil` (`id_hasil`, `id_penyakit`, `id_pasien`, `nilai`, `bulan`) VALUES
(1, 1, 1, 0.54, 'Maret'),
(2, 2, 2, 0.4575, 'Maret'),
(3, 3, 3, 0.7525, 'Maret'),
(4, 4, 4, 1, 'Maret'),
(23, 2, 1, 1, 'Maret'),
(24, 4, 3, 0.708333, 'Maret'),
(25, 2, 3, 1, 'Maret'),
(26, 1, 3, 1, 'Maret'),
(27, 1, 4, 1, 'Maret'),
(28, 1, 2, 0.75, 'Maret'),
(29, 3, 4, 0.875, 'Maret'),
(30, 3, 1, 0.708333, 'Maret'),
(31, 4, 1, 0.708333, 'Maret'),
(32, 4, 2, 1, 'Maret'),
(33, 2, 4, 1, 'Maret'),
(34, 3, 2, 0.75, 'Maret');

-- --------------------------------------------------------

--
-- Table structure for table `kriteria`
--

CREATE TABLE `kriteria` (
  `id_kriteria` int(11) NOT NULL,
  `id_penyakit` int(11) NOT NULL,
  `nama` varchar(50) DEFAULT NULL,
  `sifat` enum('min','max') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `kriteria`
--

INSERT INTO `kriteria` (`id_kriteria`, `id_penyakit`, `nama`, `sifat`) VALUES
(1, 1, 'Riwayat Penyakit', 'min'),
(2, 1, 'Keluhan Penyakit', 'min'),
(3, 1, 'Olahraga', 'max'),
(4, 2, 'Riwayat Penyakit', 'min'),
(5, 2, 'Keluhan Penyakit', 'min'),
(6, 2, 'Olahraga', 'max'),
(7, 3, 'Riwayat Penyakit', 'min'),
(8, 3, 'Keluhan Penyakit', 'min'),
(9, 3, 'Olahraga', 'max'),
(10, 4, 'Riwayat Penyakit', 'min'),
(11, 4, 'Keluhan Penyakit', 'min'),
(12, 4, 'Olahraga', 'max');

-- --------------------------------------------------------

--
-- Table structure for table `makanan`
--

CREATE TABLE `makanan` (
  `id_makanan` int(11) NOT NULL,
  `id_penyakit` int(11) NOT NULL,
  `menu` varchar(10000) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `makanan`
--

INSERT INTO `makanan` (`id_makanan`, `id_penyakit`, `menu`) VALUES
(1, 1, 'Konsumsi karbohidrat 6 hingga 8 porsi sehari. Lalu konsumsi protein yang bisa diperoleh  dari susu rendah lemak, tempe, unggas, ikan. Konsumsi sayuran dan buah untuk melengkapi kebutuhan vitamin, dengan takaran 100 gram/saji. Kalsium juga dapat diperoleh dari susu  rendah lemak. Hindari konsumsi teh dan kopi. Untuk konsumsi lemak, cukup konsumsi lemak baik saja, itupun harus dikonsumsi dalam takaran minim. Selain itu dianjurkan konsumsi kacang-kacangan, namun cukup 2 sendok makan saja sekali makan'),
(2, 2, 'Konsumsi makanan yang mengandung jahe, sayuran berupa bayam yang banyak mengandung vitamin E, kacang almond memiliki kandungan vitamin A, B, dan E yang cukup banyak, kuning telur asupan vitamin D, cuka apel dan madu memperlancar aliran darah ke otak, dan tuna juga mengandung vitamin B6'),
(3, 3, 'Konsumsi makanan yang disarankan seperti: ikan, kacang kedelai, dan buah tinggi vitamin C. Hindari makanan atau minuman bergula, pasien dapat mengganti pemanis dengan gula tetapi tetap tidak boleh berlebihan.Selain itu, makanan karbohidrat olahan seperti nasi putih, keripik kentang, roti putih dapat memicu nyeri sendi.Hindari makanan yang mengandung banyak garam, makanan tinggi lemak jenuh seperti yang terdapat dalam junk food, dan kurangi minum susu karena dapat meningkatkan peradangan. Konsumsi makanan yang mengandung asam lemak omega 6 akan tetapi tetap tidak boleh berlebihan'),
(4, 4, 'Konsumsi makanan sehat untuk jantung seperti : ikan salmon, oatmeal, biji chia, buah beri, kokoa, buah jeruk, kentang, tomat, kacang-kacangan, biji-bijian utuh, zaitun, buah alpukat, buah delima, brokoli, bayam, kale, buah apel, buah bit, bawang merah bawang putih, makanan yang diperkaya dengan sterol misal margarin, susu kedelai, susu almond dan jus jeruk., anggur hijau, dan edamame. Hindari makanan dengan lemak jenuh tinggi seperti : jeroan, kulit ayam, lemak pada daging sapi. Kurangi konsumsi minuman kemasan yang biasanya memiliki kandungan gula, garam, dan pengawet yang tinggi');

-- --------------------------------------------------------

--
-- Table structure for table `model`
--

CREATE TABLE `model` (
  `id_model` int(11) NOT NULL,
  `id_penyakit` int(11) NOT NULL,
  `id_kriteria` int(11) NOT NULL,
  `bobot` varchar(5) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `model`
--

INSERT INTO `model` (`id_model`, `id_penyakit`, `id_kriteria`, `bobot`) VALUES
(1, 1, 1, '0.25'),
(2, 1, 2, '0.25'),
(3, 1, 3, '0.5'),
(4, 2, 4, '0.25'),
(5, 2, 5, '0.25'),
(6, 2, 6, '0.5'),
(7, 3, 7, '0.25'),
(8, 3, 8, '0.25'),
(9, 3, 9, '0.5'),
(10, 4, 10, '0.25'),
(11, 4, 11, '0.25'),
(12, 4, 12, '0.5');

-- --------------------------------------------------------

--
-- Table structure for table `nilai`
--

CREATE TABLE `nilai` (
  `id_nilai` int(11) NOT NULL,
  `id_penyakit` int(11) DEFAULT NULL,
  `id_kriteria` int(11) NOT NULL,
  `id_pasien` int(11) NOT NULL,
  `nilai` float DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `nilai`
--

INSERT INTO `nilai` (`id_nilai`, `id_penyakit`, `id_kriteria`, `id_pasien`, `nilai`) VALUES
(1, 1, 1, 1, 2),
(2, 1, 2, 1, 2),
(3, 1, 3, 1, 1),
(4, 2, 4, 2, 3),
(5, 2, 5, 2, 2),
(6, 2, 6, 2, 1),
(7, 3, 7, 3, 3),
(8, 3, 8, 3, 1),
(9, 3, 9, 3, 2),
(10, 4, 10, 4, 2),
(11, 4, 11, 4, 1),
(12, 4, 12, 4, 3),
(20, 2, 4, 1, 1),
(21, 2, 5, 1, 1),
(22, 2, 6, 1, 1),
(23, 1, 1, 2, 2),
(24, 1, 2, 2, 2),
(25, 1, 3, 2, 1),
(26, 1, 1, 4, 2),
(27, 1, 2, 4, 2),
(28, 1, 3, 4, 2),
(29, 4, 10, 3, 1),
(30, 4, 11, 3, 2),
(31, 4, 12, 3, 2),
(32, 3, 7, 4, 1),
(33, 3, 8, 4, 2),
(34, 3, 9, 4, 3),
(35, 1, 1, 3, 2),
(36, 1, 2, 3, 2),
(37, 1, 3, 3, 2),
(38, 2, 4, 3, 1),
(39, 2, 5, 3, 1),
(40, 2, 6, 3, 3),
(41, 3, 7, 1, 1),
(42, 3, 8, 1, 2),
(43, 3, 9, 1, 2),
(44, 4, 10, 1, 1),
(45, 4, 11, 1, 2),
(46, 4, 12, 1, 2),
(47, 4, 10, 2, 1),
(48, 4, 11, 2, 1),
(49, 4, 12, 2, 3),
(50, 2, 4, 4, 1),
(51, 2, 5, 4, 1),
(52, 2, 6, 4, 3),
(53, 3, 7, 2, 2),
(54, 3, 8, 2, 2),
(55, 3, 9, 2, 3);

-- --------------------------------------------------------

--
-- Table structure for table `pasien`
--

CREATE TABLE `pasien` (
  `id_pasien` int(11) NOT NULL,
  `nama` varchar(50) NOT NULL,
  `tanggal_lahir` date DEFAULT NULL,
  `jenis_kelamin` enum('laki-laki','perempuan') DEFAULT NULL,
  `usia` int(3) NOT NULL,
  `alamat` varchar(80) NOT NULL,
  `riwayat_penyakit` varchar(80) NOT NULL,
  `olahraga` varchar(80) NOT NULL,
  `keluhan` varchar(80) NOT NULL,
  `berat_badan` int(5) NOT NULL,
  `tekanan_darah` int(7) NOT NULL,
  `bulan_periksa` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `pasien`
--

INSERT INTO `pasien` (`id_pasien`, `nama`, `tanggal_lahir`, `jenis_kelamin`, `usia`, `alamat`, `riwayat_penyakit`, `olahraga`, `keluhan`, `berat_badan`, `tekanan_darah`, `bulan_periksa`) VALUES
(1, 'Aniroh Susilowati', '1950-11-05', 'perempuan', 70, 'Bimomartani', 'Maag', 'Tidak Pernah', 'Pusing', 55, 120, 'Maret'),
(2, 'Santi Puspita', '1949-03-05', 'perempuan', 71, 'Bimomartani', 'Maag', 'Tidak Pernah', 'Muntah dan diare', 60, 100, 'Maret'),
(3, 'Lina Sasmita', '1950-08-26', 'perempuan', 70, 'Bimomartani', ' Tidak Ada', '2 minggu 1x', 'Muntah dan pusing berat', 54, 110, 'Maret'),
(4, 'Alfi Susanti', '1952-05-09', 'perempuan', 68, 'Bimomartani', 'Tidak Ada', '1 minggu 2x', 'Demam dan pusing', 60, 120, 'Maret');

-- --------------------------------------------------------

--
-- Table structure for table `pengguna`
--

CREATE TABLE `pengguna` (
  `id_pengguna` int(11) NOT NULL,
  `username` varchar(30) NOT NULL,
  `password` varchar(60) NOT NULL,
  `status` enum('admin','kader') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `pengguna`
--

INSERT INTO `pengguna` (`id_pengguna`, `username`, `password`, `status`) VALUES
(1, 'petugas', 'afb91ef692fd08c445e8cb1bab2ccf9c', ''),
(2, 'puket', 'b679a71646e932b7c4647a081ee2a148', '');

-- --------------------------------------------------------

--
-- Table structure for table `penilaian`
--

CREATE TABLE `penilaian` (
  `id_penilaian` int(11) NOT NULL,
  `id_penyakit` int(11) DEFAULT NULL,
  `id_kriteria` int(11) NOT NULL,
  `keterangan` varchar(20) NOT NULL,
  `bobot` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `penilaian`
--

INSERT INTO `penilaian` (`id_penilaian`, `id_penyakit`, `id_kriteria`, `keterangan`, `bobot`) VALUES
(1, 1, 1, 'Tidak Ada', 1),
(2, 1, 1, 'Penyakit Ringan', 2),
(3, 1, 1, 'Penyakit Berat', 3),
(4, 1, 2, 'Tidak Ada', 1),
(5, 1, 2, 'Keluhan Sedikit', 2),
(6, 1, 2, 'Keluhan Banyak', 3),
(7, 1, 3, 'Tidak Pernah', 1),
(8, 1, 3, '2 minggu 1x', 2),
(9, 1, 3, '1 minggu 2x', 3),
(10, 2, 4, 'Tidak Ada', 1),
(11, 2, 4, 'Penyakit Ringan', 2),
(12, 2, 4, 'Penyakit Berat', 3),
(13, 2, 5, 'Tidak Ada', 1),
(14, 2, 5, 'Keluhan Sedikit', 2),
(15, 2, 5, 'Keluhan Banyak', 3),
(16, 2, 6, 'Tidak Pernah', 1),
(17, 2, 6, '2 minggu 1x', 2),
(18, 2, 6, '1 minggu 2x', 3),
(19, 3, 7, 'Tidak Ada', 1),
(20, 3, 7, 'Penyakit Ringan', 2),
(21, 3, 7, 'Penyakit Berat', 3),
(22, 3, 8, 'Tidak Ada', 1),
(23, 3, 8, 'Keluhan Sedikit', 2),
(24, 3, 8, 'Keluhan Banyak', 3),
(25, 3, 9, 'Tidak Pernah', 1),
(26, 3, 9, '2 minggu 1x', 2),
(27, 3, 9, '1 minggu 2x', 3),
(28, 4, 10, 'Tidak Ada', 1),
(29, 4, 10, 'Penyakit Ringan', 2),
(30, 4, 10, 'Penyakit Berat', 3),
(31, 4, 11, 'Tidak Ada', 1),
(32, 4, 11, 'Keluhan Sedikit', 2),
(33, 4, 11, 'Keluhan Banyak', 3),
(34, 4, 12, 'Tidak Pernah', 1),
(35, 4, 12, '2 minggu 1x', 2),
(36, 4, 12, '1 minggu 2x', 3);

-- --------------------------------------------------------

--
-- Table structure for table `penyakit`
--

CREATE TABLE `penyakit` (
  `id_penyakit` int(11) NOT NULL,
  `nama` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `penyakit`
--

INSERT INTO `penyakit` (`id_penyakit`, `nama`) VALUES
(1, 'Hipertensi'),
(2, 'Vertigo'),
(3, 'Arthritis'),
(4, 'Jantung');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `hasil`
--
ALTER TABLE `hasil`
  ADD PRIMARY KEY (`id_hasil`),
  ADD KEY `fk_pasien` (`id_pasien`),
  ADD KEY `fk_penyakit` (`id_penyakit`);

--
-- Indexes for table `kriteria`
--
ALTER TABLE `kriteria`
  ADD PRIMARY KEY (`id_kriteria`),
  ADD KEY `id_penyakit` (`id_penyakit`),
  ADD KEY `id_penyakit_2` (`id_penyakit`);

--
-- Indexes for table `makanan`
--
ALTER TABLE `makanan`
  ADD PRIMARY KEY (`id_makanan`),
  ADD KEY `fk_penyakit` (`id_penyakit`);

--
-- Indexes for table `model`
--
ALTER TABLE `model`
  ADD PRIMARY KEY (`id_model`),
  ADD KEY `fk_kriteria` (`id_kriteria`),
  ADD KEY `fk_penyakit` (`id_penyakit`);

--
-- Indexes for table `nilai`
--
ALTER TABLE `nilai`
  ADD PRIMARY KEY (`id_nilai`),
  ADD KEY `fk_kriteria` (`id_kriteria`),
  ADD KEY `fk_pasien` (`id_pasien`),
  ADD KEY `fk_penyakit` (`id_penyakit`);

--
-- Indexes for table `pasien`
--
ALTER TABLE `pasien`
  ADD PRIMARY KEY (`id_pasien`),
  ADD KEY `id_pasien` (`id_pasien`);

--
-- Indexes for table `pengguna`
--
ALTER TABLE `pengguna`
  ADD PRIMARY KEY (`id_pengguna`);

--
-- Indexes for table `penilaian`
--
ALTER TABLE `penilaian`
  ADD PRIMARY KEY (`id_penilaian`),
  ADD KEY `fk_kriteria` (`id_kriteria`),
  ADD KEY `fk_penyakit` (`id_penyakit`);

--
-- Indexes for table `penyakit`
--
ALTER TABLE `penyakit`
  ADD PRIMARY KEY (`id_penyakit`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `hasil`
--
ALTER TABLE `hasil`
  MODIFY `id_hasil` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `kriteria`
--
ALTER TABLE `kriteria`
  MODIFY `id_kriteria` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `makanan`
--
ALTER TABLE `makanan`
  MODIFY `id_makanan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `model`
--
ALTER TABLE `model`
  MODIFY `id_model` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `nilai`
--
ALTER TABLE `nilai`
  MODIFY `id_nilai` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=56;

--
-- AUTO_INCREMENT for table `pengguna`
--
ALTER TABLE `pengguna`
  MODIFY `id_pengguna` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `penilaian`
--
ALTER TABLE `penilaian`
  MODIFY `id_penilaian` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `penyakit`
--
ALTER TABLE `penyakit`
  MODIFY `id_penyakit` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `hasil`
--
ALTER TABLE `hasil`
  ADD CONSTRAINT `hasil_ibfk_1` FOREIGN KEY (`id_pasien`) REFERENCES `pasien` (`id_pasien`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `hasil_ibfk_2` FOREIGN KEY (`id_penyakit`) REFERENCES `penyakit` (`id_penyakit`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `kriteria`
--
ALTER TABLE `kriteria`
  ADD CONSTRAINT `fk_penyakit` FOREIGN KEY (`id_penyakit`) REFERENCES `penyakit` (`id_penyakit`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `model`
--
ALTER TABLE `model`
  ADD CONSTRAINT `model_ibfk_1` FOREIGN KEY (`id_kriteria`) REFERENCES `kriteria` (`id_kriteria`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `model_ibfk_2` FOREIGN KEY (`id_penyakit`) REFERENCES `penyakit` (`id_penyakit`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `nilai`
--
ALTER TABLE `nilai`
  ADD CONSTRAINT `nilai_ibfk_1` FOREIGN KEY (`id_kriteria`) REFERENCES `kriteria` (`id_kriteria`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `nilai_ibfk_2` FOREIGN KEY (`id_pasien`) REFERENCES `pasien` (`id_pasien`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `nilai_ibfk_3` FOREIGN KEY (`id_penyakit`) REFERENCES `penyakit` (`id_penyakit`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `penilaian`
--
ALTER TABLE `penilaian`
  ADD CONSTRAINT `penilaian_ibfk_1` FOREIGN KEY (`id_kriteria`) REFERENCES `kriteria` (`id_kriteria`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `penilaian_ibfk_2` FOREIGN KEY (`id_penyakit`) REFERENCES `penyakit` (`id_penyakit`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
