-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 19 Nov 2024 pada 20.25
-- Versi server: 10.4.24-MariaDB
-- Versi PHP: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `mytbk_asli`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `cbt_ljk`
--

CREATE TABLE `cbt_ljk` (
  `id` int(11) NOT NULL,
  `urut` int(3) NOT NULL,
  `user_jawab` varchar(50) NOT NULL,
  `token` varchar(10) NOT NULL,
  `kd_soal` varchar(20) NOT NULL,
  `no_soal` int(3) NOT NULL,
  `jns_soal` enum('G','E') NOT NULL,
  `kd_mapel` varchar(20) NOT NULL,
  `kd_kls` varchar(20) NOT NULL,
  `kd_jur` varchar(20) NOT NULL,
  `A` enum('1','2','3','4','5','N') NOT NULL,
  `B` enum('1','2','3','4','5','N') NOT NULL,
  `C` enum('1','2','3','4','5','N') NOT NULL,
  `D` enum('1','2','3','4','5','N') NOT NULL,
  `E` enum('1','2','3','4','5','N') NOT NULL,
  `jwbn` enum('A','B','C','D','E','N','R') NOT NULL DEFAULT 'N',
  `nil_jwb` enum('1','2','3','4','5','0','9') NOT NULL DEFAULT '0',
  `knci_jwbn` enum('1','2','3','4','5','N') NOT NULL DEFAULT 'N',
  `nil_pg` int(1) NOT NULL DEFAULT 0,
  `es_jwb` mediumtext NOT NULL,
  `nil_esai` int(3) NOT NULL DEFAULT 0,
  `tgl` date NOT NULL DEFAULT current_timestamp(),
  `jam` time NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struktur dari tabel `cbt_peserta`
--

CREATE TABLE `cbt_peserta` (
  `id_peserta` int(11) NOT NULL,
  `ip_sv` varchar(35) NOT NULL,
  `nm` varchar(50) NOT NULL,
  `tmp_lahir` varchar(50) NOT NULL,
  `tgl_lahir` date NOT NULL,
  `nis` varchar(20) NOT NULL,
  `kd_kls` varchar(20) NOT NULL,
  `jns_kel` enum('L','P') NOT NULL,
  `ft` varchar(30) NOT NULL DEFAULT 'noavatar.png',
  `user` varchar(50) NOT NULL,
  `pass` varchar(50) NOT NULL,
  `sesi` varchar(1) NOT NULL,
  `ruang` varchar(15) NOT NULL,
  `sts` enum('Y','N') NOT NULL DEFAULT 'Y'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `cbt_peserta`
--

INSERT INTO `cbt_peserta` (`id_peserta`, `ip_sv`, `nm`, `tmp_lahir`, `tgl_lahir`, `nis`, `kd_kls`, `jns_kel`, `ft`, `user`, `pass`, `sesi`, `ruang`, `sts`) VALUES
(1, '', 'Peserta 1', 'Sungai Tabuk', '2008-11-18', '123-1', 'M1', 'L', 'noavatar.png', '123-1', '123', '1', '1', 'Y'),
(3, '', 'Peserta 2', 'Sungai Tabuk', '2008-11-19', '123-2', 'M1', 'P', 'noavatar.png', '123-2', '123', '1', '1', 'Y'),
(4, '', 'Peserta 3', 'Sungai Tabuk', '2008-11-20', '123-3', 'M1', 'L', 'noavatar.png', '123-3', '123', '1', '1', 'Y'),
(5, '', 'Peserta 4', 'Sungai Tabuk', '2008-11-21', '123-4', 'M1', 'P', 'noavatar.png', '123-4', '123', '1', '1', 'Y'),
(6, '', 'Peserta 5', 'Sungai Tabuk', '2008-11-22', '123-5', 'M1', 'L', 'noavatar.png', '123-5', '123', '1', '1', 'Y'),
(7, '', 'Peserta 6', 'Sungai Tabuk', '2008-11-23', '123-6', 'M1', 'P', 'noavatar.png', '123-6', '123', '1', '1', 'Y'),
(8, '', 'Peserta 7', 'Sungai Tabuk', '2008-11-24', '123-7', 'M1', 'L', 'noavatar.png', '123-7', '123', '1', '1', 'Y'),
(9, '', 'Peserta 8', 'Sungai Tabuk', '2008-11-25', '123-8', 'M1', 'P', 'noavatar.png', '123-8', '123', '1', '1', 'Y'),
(10, '', 'Peserta 9', 'Sungai Tabuk', '2008-11-26', '123-9', 'M1', 'L', 'noavatar.png', '123-9', '123', '1', '1', 'Y'),
(11, '', 'Peserta 10', 'Sungai Tabuk', '2008-11-27', '123-10', 'M1', 'P', 'noavatar.png', '123-10', '123', '1', '1', 'Y'),
(12, '', 'Peserta 11', 'Sungai Tabuk', '2008-11-28', '123-11', 'M1', 'L', 'noavatar.png', '123-11', '123', '1', '1', 'Y'),
(13, '', 'Peserta 12', 'Sungai Tabuk', '2008-11-29', '123-12', 'M1', 'P', 'noavatar.png', '123-12', '123', '1', '1', 'Y'),
(14, '', 'Peserta 13', 'Sungai Tabuk', '2008-11-30', '123-13', 'M1', 'L', 'noavatar.png', '123-13', '123', '1', '1', 'Y'),
(15, '', 'Peserta 14', 'Sungai Tabuk', '2008-12-01', '123-14', 'M1', 'P', 'noavatar.png', '123-14', '123', '1', '1', 'Y'),
(16, '', 'Peserta 15', 'Sungai Tabuk', '2008-12-02', '123-15', 'M1', 'L', 'noavatar.png', '123-15', '123', '1', '1', 'Y'),
(17, '', 'Peserta 16', 'Sungai Tabuk', '2008-12-03', '123-16', 'M1', 'P', 'noavatar.png', '123-16', '123', '1', '1', 'Y'),
(18, '', 'Peserta 17', 'Sungai Tabuk', '2008-12-04', '123-17', 'M1', 'L', 'noavatar.png', '123-17', '123', '1', '1', 'Y'),
(19, '', 'Peserta 18', 'Sungai Tabuk', '2008-12-05', '123-18', 'M1', 'P', 'noavatar.png', '123-18', '123', '1', '1', 'Y'),
(20, '', 'Peserta 19', 'Sungai Tabuk', '2008-12-06', '123-19', 'M1', 'L', 'noavatar.png', '123-19', '123', '1', '1', 'Y'),
(21, '', 'Peserta 20', 'Sungai Tabuk', '2008-12-07', '123-20', 'M1', 'P', 'noavatar.png', '123-20', '123', '1', '1', 'Y'),
(22, '', 'Peserta 21', 'Sungai Tabuk', '2008-12-08', '123-21', 'M1', 'L', 'noavatar.png', '123-21', '123', '1', '1', 'Y'),
(23, '', 'Peserta 22', 'Sungai Tabuk', '2008-12-09', '123-22', 'M1', 'P', 'noavatar.png', '123-22', '123', '1', '1', 'Y'),
(24, '', 'Peserta 23', 'Sungai Tabuk', '2008-12-10', '123-23', 'M1', 'L', 'noavatar.png', '123-23', '123', '1', '1', 'Y'),
(25, '', 'Peserta 24', 'Sungai Tabuk', '2008-12-11', '123-24', 'M1', 'P', 'noavatar.png', '123-24', '123', '1', '1', 'Y'),
(26, '', 'Peserta 25', 'Sungai Tabuk', '2008-12-12', '123-25', 'M1', 'L', 'noavatar.png', '123-25', '123', '1', '1', 'Y'),
(27, '', 'Peserta 26', 'Sungai Tabuk', '2008-12-13', '123-26', 'M1', 'P', 'noavatar.png', '123-26', '123', '1', '1', 'Y'),
(28, '', 'Peserta 27', 'Sungai Tabuk', '2008-12-14', '123-27', 'M1', 'L', 'noavatar.png', '123-27', '123', '1', '1', 'Y'),
(29, '', 'Peserta 28', 'Sungai Tabuk', '2008-12-15', '123-28', 'M1', 'P', 'noavatar.png', '123-28', '123', '1', '1', 'Y'),
(30, '', 'Peserta 29', 'Sungai Tabuk', '2008-12-16', '123-29', 'M1', 'L', 'noavatar.png', '123-29', '123', '1', '1', 'Y'),
(31, '', 'Peserta 30', 'Sungai Tabuk', '2008-12-17', '123-30', 'M1', 'P', 'noavatar.png', '123-30', '123', '1', '1', 'Y'),
(32, '', 'Peserta 31', 'Sungai Tabuk', '2008-12-18', '123-31', 'M1', 'L', 'noavatar.png', '123-31', '123', '1', '1', 'Y'),
(33, '', 'Peserta 32', 'Sungai Tabuk', '2008-12-19', '123-32', 'M1', 'P', 'noavatar.png', '123-32', '123', '1', '1', 'Y'),
(34, '', 'Peserta 33', 'Sungai Tabuk', '2008-12-20', '123-33', 'M1', 'L', 'noavatar.png', '123-33', '123', '1', '1', 'Y'),
(35, '', 'Peserta 34', 'Sungai Tabuk', '2008-12-21', '123-34', 'M1', 'P', 'noavatar.png', '123-34', '123', '1', '1', 'Y'),
(36, '', 'Peserta 35', 'Sungai Tabuk', '2008-12-22', '123-35', 'M1', 'L', 'noavatar.png', '123-35', '123', '1', '1', 'Y'),
(37, '', 'Peserta 36', 'Sungai Tabuk', '2008-12-23', '123-36', 'M1', 'P', 'noavatar.png', '123-36', '123', '1', '1', 'Y'),
(38, '', 'Peserta 37', 'Sungai Tabuk', '2008-12-24', '123-37', 'M1', 'L', 'noavatar.png', '123-37', '123', '1', '1', 'Y'),
(39, '', 'Peserta 38', 'Sungai Tabuk', '2008-12-25', '123-38', 'M1', 'P', 'noavatar.png', '123-38', '123', '1', '1', 'Y'),
(40, '', 'Peserta 39', 'Sungai Tabuk', '2008-12-26', '123-39', 'M1', 'L', 'noavatar.png', '123-39', '123', '1', '1', 'Y'),
(41, '', 'Peserta 40', 'Sungai Tabuk', '2008-12-27', '123-40', 'M1', 'P', 'noavatar.png', '123-40', '123', '1', '1', 'Y');

-- --------------------------------------------------------

--
-- Struktur dari tabel `cbt_pktsoal`
--

CREATE TABLE `cbt_pktsoal` (
  `id_pktsoal` int(11) NOT NULL,
  `kd_kls` varchar(15) NOT NULL,
  `kls` varchar(10) NOT NULL,
  `jur` varchar(45) NOT NULL,
  `kd_mpel` varchar(15) NOT NULL,
  `kd_soal` varchar(20) NOT NULL,
  `sesi` int(1) NOT NULL,
  `pilgan` int(3) NOT NULL,
  `prsen_pilgan` int(3) NOT NULL,
  `esai` int(3) NOT NULL,
  `prsen_esai` int(3) NOT NULL,
  `jum_soal` int(3) NOT NULL,
  `kkm` int(2) NOT NULL,
  `tgl` date NOT NULL DEFAULT current_timestamp(),
  `author` varchar(30) NOT NULL,
  `sts` enum('Y','N') NOT NULL DEFAULT 'N'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `cbt_pktsoal`
--

INSERT INTO `cbt_pktsoal` (`id_pktsoal`, `kd_kls`, `kls`, `jur`, `kd_mpel`, `kd_soal`, `sesi`, `pilgan`, `prsen_pilgan`, `esai`, `prsen_esai`, `jum_soal`, `kkm`, `tgl`, `author`, `sts`) VALUES
(1, '1', '1', '1', 'COBA', 'TES', 1, 15, 60, 5, 40, 20, 70, '2024-08-13', 'Triyono', 'Y');

-- --------------------------------------------------------

--
-- Struktur dari tabel `cbt_soal`
--

CREATE TABLE `cbt_soal` (
  `id_soal` int(11) NOT NULL,
  `kd_soal` varchar(20) NOT NULL,
  `kd_mapel` varchar(20) NOT NULL,
  `jns_soal` enum('E','G') NOT NULL,
  `lev_soal` enum('1','2','3') NOT NULL,
  `no_soal` int(3) NOT NULL,
  `cerita` longtext NOT NULL,
  `kd_crta` int(3) DEFAULT NULL,
  `tanya` longtext NOT NULL,
  `img` varchar(50) NOT NULL,
  `audio` varchar(50) NOT NULL,
  `vid` varchar(50) NOT NULL,
  `jwb1` mediumtext NOT NULL,
  `jwb2` mediumtext NOT NULL,
  `jwb3` mediumtext NOT NULL,
  `jwb4` mediumtext NOT NULL,
  `jwb5` mediumtext NOT NULL,
  `img1` varchar(50) NOT NULL,
  `img2` varchar(50) NOT NULL,
  `img3` varchar(50) NOT NULL,
  `img4` varchar(50) NOT NULL,
  `img5` varchar(50) NOT NULL,
  `knci_pilgan` enum('1','2','3','4','5') NOT NULL,
  `ack_soal` enum('Y','N') NOT NULL DEFAULT 'Y',
  `ack_opsi` enum('Y','N') NOT NULL DEFAULT 'Y'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `cbt_soal`
--

INSERT INTO `cbt_soal` (`id_soal`, `kd_soal`, `kd_mapel`, `jns_soal`, `lev_soal`, `no_soal`, `cerita`, `kd_crta`, `tanya`, `img`, `audio`, `vid`, `jwb1`, `jwb2`, `jwb3`, `jwb4`, `jwb5`, `img1`, `img2`, `img3`, `img4`, `img5`, `knci_pilgan`, `ack_soal`, `ack_opsi`) VALUES
(1, 'TES', 'COBA', 'G', '1', 1, '<p style=\"text-align:justify;\">&nbsp; &nbsp; &nbsp; Indonesia adalah negara kepulauan terbesar di dunia yang memiliki lebih dari 17.000 pulau. Beragam suku, bahasa, dan budaya tersebar di seluruh nusantara. Kekayaan alam Indonesia, baik yang terdapat di darat maupun di laut, menjadi potensi besar bagi kesejahteraan masyarakat. Namun, tantangan yang dihadapi dalam mengelola kekayaan ini tidaklah mudah. Salah satu tantangan utama adalah ketimpangan pembangunan antara wilayah barat dan timur Indonesia. Selain itu, kerusakan lingkungan yang diakibatkan oleh aktivitas manusia seperti penebangan hutan liar dan pencemaran laut juga menjadi isu penting.</p>', 0, '<p>Berapa jumlah pulau yang ada di Indonesia?</p>', 'TES_1.png', '', '', '<p>10.000</p>', '<p>17.000</p>', '<p>20.000</p>', '<p>30.000</p>', '<p>35.000</p>', '', '', '', '', '', '2', 'Y', 'Y'),
(2, 'TES', 'COBA', 'G', '1', 2, '', 1, '<p>Apa tantangan utama dalam mengelola kekayaan alam Indonesia?</p>', '', '', '', '<p>Ketimpangan pembangunan</p>', '<p>Kekurangan sumber daya manusia</p>', '<p>Kemiskinan</p>', '<p>Kurangnya infrastruktur</p>', '<p>Inflasi</p>', '', '', '', '', '', '1', 'Y', 'Y'),
(3, 'TES', 'COBA', 'G', '1', 3, '', 1, '<p>Salah satu kerusakan lingkungan yang disebabkan oleh aktivitas manusia adalah...</p>', '', '', '', '<p>Penebangan hutan liar</p>', '<p>Penurunan ekonomi</p>', '<p>Pengangguran</p>', '<p>Kesenjangan sosial</p>', '<p>Urbanisasi</p>', '', '', '', '', '', '1', 'Y', 'Y'),
(4, 'TES', 'COBA', 'E', '1', 4, '', 1, '<p>Berdasarkan teks, apa saja kekayaan alam yang dimiliki Indonesia, dan bagaimana cara yang tepat untuk mengelolanya secara berkelanjutan?</p>', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 'Y', ''),
(5, 'TES', 'COBA', 'E', '1', 5, '', 1, '<p>Jelaskan apa yang dimaksud dengan ketimpangan pembangunan antara wilayah barat dan timur Indonesia, serta langkah apa yang dapat diambil untuk mengatasinya?</p>', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 'Y', ''),
(6, 'TES', 'COBA', 'G', '1', 6, '', 0, '<p>Siapa presiden pertama Indonesia?</p>', '', '', '', '<p>Soeharto</p>', '<p>Habibie</p>', '<p>Sukarno</p>', '<p>Abdurrahman Wahid</p>', '<p>Megawati Soekarnoputri</p>', '', '', '', '', '', '3', 'Y', 'Y'),
(7, 'TES', 'COBA', 'G', '1', 7, '', 0, '<p>Di mana letak Candi Borobudur?</p>', '', '', '', '<p>Jawa Timur</p>', '<p>Jawa Tengah</p>', '<p>Jawa Barat</p>', '<p>Bali</p>', '<p><span style=\"background-color:rgb(255,255,255);color:rgb(0,29,53);\">Yogyakarta</span></p>', '', '', '', '', '', '2', 'Y', 'Y'),
(8, 'TES', 'COBA', 'G', '1', 8, '', 0, '<p>Siapa penemu bola lampu?</p>', '', '', '', '<p>Nikola Tesla</p>', '<p>Thomas Edison</p>', '<p>Alexander Graham Bell</p>', '<p>Isaac Newton</p>', '<p>Albert Einstein</p>', '', '', '', '', '', '2', 'Y', 'Y'),
(9, 'TES', 'COBA', 'G', '1', 9, '', 0, '<p>Ibu kota Australia adalah...</p>', '', '', '', '<p>Sydney</p>', '<p>Melbourne</p>', '<p>Perth</p>', '<p>Canberra</p>', '<p>Brisbane</p>', '', '', '', '', '', '4', 'Y', 'Y'),
(10, 'TES', 'COBA', 'G', '1', 10, '', 0, '<p>Manakah planet terbesar di tata surya?</p>', '', '', '', '<p>Bumi</p>', '<p>Mars</p>', '<p>Jupiter</p>', '<p>Venus</p>', '<p>Saturnus</p>', '', '', '', '', '', '3', 'Y', 'Y'),
(11, 'TES', 'COBA', 'G', '1', 11, '', 0, '<p>Bahasa resmi Brasil adalah...</p>', '', '', '', '<p>Spanyol</p>', '<p>Inggris</p>', '<p>Prancis</p>', '<p>Portugis</p>', '<p>Italia</p>', '', '', '', '', '', '4', 'Y', 'Y'),
(12, 'TES', 'COBA', 'G', '1', 12, '', 0, '<p>Tahun berapakah Indonesia merdeka?</p>', '', '', '', '<p>1941</p>', '<p>1942</p>', '<p>1943</p>', '<p>1944</p>', '<p>1945</p>', '', '', '', '', '', '5', 'Y', 'Y'),
(13, 'TES', 'COBA', 'G', '1', 13, '', 0, '<p>Siapa yang menciptakan Teori Relativitas?</p>', '', '', '', '<p>Galileo Galilei</p>', '<p>Stephen Hawking</p>', '<p>Albert Einstein</p>', '<p>Marie Curie</p>', '<p>James Clerk Maxwell</p>', '', '', '', '', '', '3', 'Y', 'Y'),
(14, 'TES', 'COBA', 'G', '1', 14, '', 0, '<p>Hewan nasional India adalah...</p>', '', '', '', '<p>Gajah</p>', '<p>Harimau</p>', '<p>Singa</p>', '<p>Rusa</p>', '<p>Panda</p>', '', '', '', '', '', '2', 'Y', 'Y'),
(15, 'TES', 'COBA', 'G', '1', 15, '', 0, '<p>Laut yang terletak di antara Eropa dan Afrika adalah...</p>', '', '', '', '<p>Laut Kaspia</p>', '<p>Laut Hitam</p>', '<p>Laut Tengah</p>', '<p>Laut Merah</p>', '<p>Laut Utara</p>', '', '', '', '', '', '3', 'Y', 'Y'),
(16, 'TES', 'COBA', 'G', '1', 16, '', 0, '<p>Berapakah jumlah provinsi di Indonesia saat ini?</p>', '', '', '', '<p>33</p>', '<p>34</p>', '<p>35</p>', '<p>36</p>', '<p>37</p>', '', '', '', '', '', '2', 'Y', 'Y'),
(17, 'TES', 'COBA', 'G', '1', 17, '', 0, '<p>Pulau Komodo terletak di provinsi...</p>', '', '', '', '<p>Bali</p>', '<p>Nusa Tenggara Timur</p>', '<p>Sulawesi Selatan</p>', '<p>Kalimantan Timur</p>', '<p>Papua</p>', '', '', '', '', '', '2', 'Y', 'Y'),
(18, 'TES', 'COBA', 'G', '1', 18, '', 0, '<p>Siapa penulis novel <i>Laskar Pelangi</i>?</p>', '', '', '', '<p>Pramoedya Ananta Toer</p>', '<p>Tere Liye</p>', '<p>Andrea Hirata</p>', '<p>Ahmad Tohari</p>', '<p>Dewi Lestari</p>', '', '', '', '', '', '3', 'Y', 'Y'),
(19, 'TES', 'COBA', 'G', '1', 19, '', 0, '<p>Negara mana yang terkenal dengan Eiffel Tower?</p>', '', '', '', '<p>Italia</p>', '<p>Inggris</p>', '<p>Spanyol</p>', '<p>Prancis</p>', '<p>Jerman</p>', '', '', '', '', '', '4', 'Y', 'Y'),
(20, 'TES', 'COBA', 'G', '1', 20, '', 0, '<p>Di bawah ini yang merupakan provinsi paling barat di Indonesia adalah...</p>', '', '', '', '<p>Sumatra Selatan</p>', '<p>Sumatra Barat</p>', '<p>Aceh</p>', '<p>Riau</p>', '<p>Bengkulu</p>', '', '', '', '', '', '3', 'Y', 'Y'),
(21, 'TES', 'COBA', 'G', '1', 21, '', 0, '<p>Perhatikan gambar berikut, kemudian jawab pertanyaannya:</p><p>Jika jari-jari lingkaran adalah 5 cm, berapakah luas lingkaran?</p>', 'TES_21.png', '', '', '<p>25 cm²</p>', '<p>50 cm²</p>', '<p>78,5 cm²</p>', '<p>100 cm²</p>', '<p>125 cm²</p>', '', '', '', '', '', '3', 'Y', 'Y'),
(22, 'TES', 'COBA', 'G', '1', 22, '', 0, '<p>Perhatikan gambar peta berikut. Berapa total jumlah negara yang berada di benua Afrika?</p>', 'TES_22.png', '', '', '<p>45</p>', '<p>48</p>', '<p>54</p>', '<p>60</p>', '<p>70</p>', '', '', '', '', '', '3', 'Y', 'Y'),
(23, 'TES', 'COBA', 'E', '1', 23, '', 0, '<p>Apa saja langkah-langkah yang harus dilakukan untuk menjaga kelestarian hutan di Indonesia?</p>', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 'Y', ''),
(24, 'TES', 'COBA', 'E', '1', 24, '', 0, '<p>Uraikan sejarah perjuangan bangsa Indonesia hingga mencapai kemerdekaan pada tanggal 17 Agustus 1945!</p>', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 'Y', ''),
(25, 'TES', 'COBA', 'E', '1', 25, '', 0, '<p>Hitung luas segitiga dengan alas 8 cm dan tinggi 12 cm!</p>', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 'Y', '');

-- --------------------------------------------------------

--
-- Struktur dari tabel `info`
--

CREATE TABLE `info` (
  `id` int(11) NOT NULL,
  `id_sv` varchar(25) NOT NULL,
  `idpt` char(20) NOT NULL,
  `nmpt` char(80) NOT NULL,
  `almtpt` varchar(300) NOT NULL,
  `nmkpt` char(50) NOT NULL,
  `nmpnpt` varchar(50) NOT NULL,
  `fav` varchar(20) NOT NULL,
  `lg_dinas` varchar(20) NOT NULL,
  `ft_adm` varchar(20) NOT NULL,
  `ft_sis` varchar(20) NOT NULL,
  `head` varchar(300) NOT NULL,
  `head2` varchar(300) NOT NULL,
  `kel` varchar(100) NOT NULL,
  `kec` varchar(100) NOT NULL,
  `kab` varchar(100) NOT NULL,
  `prov` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `info`
--

INSERT INTO `info` (`id`, `id_sv`, `idpt`, `nmpt`, `almtpt`, `nmkpt`, `nmpnpt`, `fav`, `lg_dinas`, `ft_adm`, `ft_sis`, `head`, `head2`, `kel`, `kec`, `kab`, `prov`) VALUES
(1, '1', '123', 'Keperluan Kita Bersama', 'Jl. alamat yang di tuju lh gitu lah lh', 'Muhammad', 'Triyono', 'fav.png', '', '', '', '', '', '', '', '', '');

-- --------------------------------------------------------

--
-- Struktur dari tabel `jdwl`
--

CREATE TABLE `jdwl` (
  `id_ujian` int(11) NOT NULL,
  `kd_ujian` enum('UH','UTS','UAS','US','Uji') NOT NULL,
  `smt` enum('1','2','3','4','5','6') NOT NULL,
  `kls` varchar(10) NOT NULL,
  `kd_kls` varchar(15) NOT NULL,
  `jur` varchar(45) NOT NULL,
  `nm_kls` varchar(45) NOT NULL,
  `kd_mpel` varchar(15) NOT NULL,
  `kd_soal` varchar(20) NOT NULL,
  `jm_login` time NOT NULL,
  `tgl_uji` date NOT NULL,
  `jm_uji` time NOT NULL,
  `slsai_uji` time NOT NULL,
  `bts_login` time NOT NULL,
  `lm_uji` time NOT NULL,
  `jm_tmbh` time NOT NULL DEFAULT '00:00:00',
  `token` varchar(10) NOT NULL,
  `author` varchar(30) NOT NULL,
  `thn_ajr` varchar(9) NOT NULL,
  `user` varchar(50) NOT NULL,
  `sesi` varchar(1) NOT NULL,
  `md_uji` enum('0','1') NOT NULL DEFAULT '0',
  `sts` enum('Y','N','H') NOT NULL,
  `sts_token` enum('Y','T') NOT NULL DEFAULT 'T',
  `sts_nilai` enum('Y','T') NOT NULL DEFAULT 'T'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struktur dari tabel `kelas`
--

CREATE TABLE `kelas` (
  `id_kls` int(11) NOT NULL,
  `kd_kls` varchar(15) NOT NULL,
  `nm_kls` varchar(45) NOT NULL,
  `kls` varchar(10) NOT NULL,
  `jur` varchar(45) NOT NULL,
  `kls_minat` varchar(70) NOT NULL,
  `sts` enum('Y','N') NOT NULL DEFAULT 'Y'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `kelas`
--

INSERT INTO `kelas` (`id_kls`, `kd_kls`, `nm_kls`, `kls`, `jur`, `kls_minat`, `sts`) VALUES
(1, 'M1', 'X Merdeka 1', 'X', 'Merdeka', '', 'Y'),
(2, 'XA', 'X A', 'X', 'MERDEKA', '', 'Y'),
(3, 'XB', 'X B', 'X', 'MERDEKA', '', 'Y'),
(4, 'XC', 'X C', 'X', 'MERDEKA', '', 'Y'),
(5, 'XD', 'X D', 'X', 'MERDEKA', '', 'Y'),
(6, 'XE', 'X E', 'X', 'MERDEKA', '', 'Y'),
(7, 'XF', 'X F', 'X', 'MERDEKA', '', 'Y'),
(8, 'XIA', 'XI A', 'XI', 'MERDEKA', '', 'Y'),
(9, 'XIB', 'XI B', 'XI', 'MERDEKA', '', 'Y'),
(10, 'XIC', 'XI C', 'XI', 'MERDEKA', '', 'Y'),
(11, 'XID', 'XI D', 'XI', 'MERDEKA', '', 'Y'),
(14, 'XIE', 'XI E', 'XI', 'MERDEKA', '', 'Y'),
(15, 'XIIA', 'XII A', 'XII', 'MERDEKA', '', 'Y'),
(16, 'XIIB', 'XII B', 'XII', 'MERDEKA', '', 'Y'),
(17, 'XIIC', 'XII C', 'XII', 'MERDEKA', '', 'Y'),
(18, 'XIID', 'XII D', 'XII', 'MERDEKA', '', 'Y'),
(19, 'XIIE', 'XII E', 'XII', 'MERDEKA', '', 'Y'),
(20, 'XIIF', 'XII F', 'XII', 'MERDEKA', '', 'Y');

-- --------------------------------------------------------

--
-- Struktur dari tabel `mapel`
--

CREATE TABLE `mapel` (
  `id_mpel` int(11) NOT NULL,
  `kd_mpel` varchar(15) NOT NULL,
  `nm_mpel` varchar(60) NOT NULL,
  `kkm` int(2) NOT NULL,
  `kls` varchar(10) NOT NULL,
  `jur` varchar(45) NOT NULL,
  `kls_minat` varchar(70) NOT NULL,
  `sts` enum('Y','N') NOT NULL DEFAULT 'Y'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `mapel`
--

INSERT INTO `mapel` (`id_mpel`, `kd_mpel`, `nm_mpel`, `kkm`, `kls`, `jur`, `kls_minat`, `sts`) VALUES
(7, 'COBA', 'Percobaan', 0, '', '', '', 'Y');

-- --------------------------------------------------------

--
-- Struktur dari tabel `nilai`
--

CREATE TABLE `nilai` (
  `id_hasil` int(11) NOT NULL,
  `user` varchar(50) NOT NULL,
  `kd_mpel` varchar(15) NOT NULL,
  `kd_soal` varchar(20) NOT NULL,
  `token` varchar(10) NOT NULL,
  `jum_soal` int(3) NOT NULL,
  `kkm` int(3) NOT NULL,
  `no_soal` varchar(100) NOT NULL,
  `jwb` varchar(100) NOT NULL,
  `skor` varchar(100) NOT NULL,
  `nil_pg` int(3) NOT NULL,
  `nil_es` int(3) NOT NULL,
  `nilai` int(3) NOT NULL,
  `tgl_tes` date NOT NULL,
  `tgl` datetime NOT NULL DEFAULT current_timestamp(),
  `adm` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struktur dari tabel `peserta_tes`
--

CREATE TABLE `peserta_tes` (
  `id_tes` int(11) NOT NULL,
  `id_ujian` int(11) NOT NULL,
  `kd_soal` varchar(20) NOT NULL,
  `user` varchar(50) NOT NULL,
  `sesi` varchar(1) NOT NULL,
  `ruang` varchar(15) NOT NULL,
  `nis` varchar(20) NOT NULL,
  `kd_kls` varchar(15) NOT NULL,
  `kd_mpel` varchar(15) NOT NULL,
  `pilgan` int(3) NOT NULL,
  `esai` int(3) NOT NULL,
  `jum_soal` int(3) NOT NULL,
  `tgl_uji` date NOT NULL,
  `jm_uji` time NOT NULL,
  `jm_lg` time NOT NULL,
  `jm_out` time NOT NULL,
  `lm_uji` time NOT NULL,
  `token` varchar(10) NOT NULL,
  `ip` varchar(15) NOT NULL,
  `rq_rst` enum('Y','N') NOT NULL DEFAULT 'N',
  `sts` enum('S','U') NOT NULL,
  `dt_on` enum('0','1') NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struktur dari tabel `qr_lg`
--

CREATE TABLE `qr_lg` (
  `id_qr` int(11) NOT NULL,
  `kd_qr` varchar(30) NOT NULL,
  `id_usr` int(11) NOT NULL,
  `user` varchar(50) NOT NULL,
  `pass` varchar(50) NOT NULL,
  `lev` enum('A','U','X','S') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struktur dari tabel `svr`
--

CREATE TABLE `svr` (
  `id_sv` int(11) NOT NULL,
  `ip_sv` varchar(15) NOT NULL,
  `nm_sv` varchar(50) NOT NULL,
  `fdr` varchar(20) NOT NULL,
  `sts` enum('Y','N') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `svr`
--

INSERT INTO `svr` (`id_sv`, `ip_sv`, `nm_sv`, `fdr`, `sts`) VALUES
(1, '192.168.100.172', 'Master_Server', 'tbk', 'Y');

-- --------------------------------------------------------

--
-- Struktur dari tabel `user`
--

CREATE TABLE `user` (
  `id_usr` int(11) NOT NULL,
  `kd_usr` varchar(3) NOT NULL,
  `nm_user` varchar(50) NOT NULL,
  `username` varchar(35) NOT NULL,
  `pass` varchar(35) NOT NULL,
  `tlp` varchar(18) NOT NULL,
  `lvl` enum('A','U','X') NOT NULL,
  `sts` enum('Y','N') NOT NULL DEFAULT 'Y'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `user`
--

INSERT INTO `user` (`id_usr`, `kd_usr`, `nm_user`, `username`, `pass`, `tlp`, `lvl`, `sts`) VALUES
(1, 'A01', 'Administator', 'admin', '21232f297a57a5a743894a0e4a801fc3', '0234234', 'A', 'Y'),
(2, 'U01', 'User', 'user', '202cb962ac59075b964b07152d234b70', '023423423', 'U', 'Y'),
(3, '', 'Pengawas Ruang 1', 'pengawas1', '123', '', 'X', 'Y');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `cbt_ljk`
--
ALTER TABLE `cbt_ljk`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `cbt_peserta`
--
ALTER TABLE `cbt_peserta`
  ADD PRIMARY KEY (`id_peserta`),
  ADD UNIQUE KEY `user` (`user`),
  ADD UNIQUE KEY `nis` (`nis`),
  ADD KEY `kd_kls` (`kd_kls`);

--
-- Indeks untuk tabel `cbt_pktsoal`
--
ALTER TABLE `cbt_pktsoal`
  ADD PRIMARY KEY (`id_pktsoal`),
  ADD UNIQUE KEY `kd_soal` (`kd_soal`),
  ADD KEY `kd_kls` (`kd_kls`);

--
-- Indeks untuk tabel `cbt_soal`
--
ALTER TABLE `cbt_soal`
  ADD PRIMARY KEY (`id_soal`),
  ADD KEY `kd_soal` (`kd_soal`),
  ADD KEY `kd_mapel` (`kd_mapel`),
  ADD KEY `no_soal` (`no_soal`);

--
-- Indeks untuk tabel `info`
--
ALTER TABLE `info`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idpt` (`idpt`);

--
-- Indeks untuk tabel `jdwl`
--
ALTER TABLE `jdwl`
  ADD PRIMARY KEY (`id_ujian`);

--
-- Indeks untuk tabel `kelas`
--
ALTER TABLE `kelas`
  ADD PRIMARY KEY (`id_kls`),
  ADD UNIQUE KEY `kd_kls` (`kd_kls`);

--
-- Indeks untuk tabel `mapel`
--
ALTER TABLE `mapel`
  ADD PRIMARY KEY (`id_mpel`),
  ADD UNIQUE KEY `kd_mpel` (`kd_mpel`);

--
-- Indeks untuk tabel `nilai`
--
ALTER TABLE `nilai`
  ADD PRIMARY KEY (`id_hasil`);

--
-- Indeks untuk tabel `peserta_tes`
--
ALTER TABLE `peserta_tes`
  ADD PRIMARY KEY (`id_tes`);

--
-- Indeks untuk tabel `qr_lg`
--
ALTER TABLE `qr_lg`
  ADD PRIMARY KEY (`id_qr`);

--
-- Indeks untuk tabel `svr`
--
ALTER TABLE `svr`
  ADD PRIMARY KEY (`id_sv`);

--
-- Indeks untuk tabel `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id_usr`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `cbt_ljk`
--
ALTER TABLE `cbt_ljk`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `cbt_peserta`
--
ALTER TABLE `cbt_peserta`
  MODIFY `id_peserta` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT untuk tabel `cbt_pktsoal`
--
ALTER TABLE `cbt_pktsoal`
  MODIFY `id_pktsoal` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT untuk tabel `cbt_soal`
--
ALTER TABLE `cbt_soal`
  MODIFY `id_soal` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT untuk tabel `info`
--
ALTER TABLE `info`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `jdwl`
--
ALTER TABLE `jdwl`
  MODIFY `id_ujian` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `kelas`
--
ALTER TABLE `kelas`
  MODIFY `id_kls` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT untuk tabel `mapel`
--
ALTER TABLE `mapel`
  MODIFY `id_mpel` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT untuk tabel `nilai`
--
ALTER TABLE `nilai`
  MODIFY `id_hasil` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `peserta_tes`
--
ALTER TABLE `peserta_tes`
  MODIFY `id_tes` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `qr_lg`
--
ALTER TABLE `qr_lg`
  MODIFY `id_qr` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `svr`
--
ALTER TABLE `svr`
  MODIFY `id_sv` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `user`
--
ALTER TABLE `user`
  MODIFY `id_usr` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=72;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
