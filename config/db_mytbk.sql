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
  `jns_soal` enum('E','G','J','X','P') NOT NULL,
  `kd_mapel` varchar(20) NOT NULL,
  `pl_a` int(1) NOT NULL DEFAULT 0,
  `pl_v` int(1) NOT NULL DEFAULT 0,
  `kd_kls` varchar(20) NOT NULL,
  `kd_jur` varchar(20) NOT NULL,
  `A` enum('1','2','3','4','5','N') NOT NULL,
  `B` enum('1','2','3','4','5','N') NOT NULL,
  `C` enum('1','2','3','4','5','N') NOT NULL,
  `D` enum('1','2','3','4','5','N') NOT NULL,
  `E` enum('1','2','3','4','5','N') NOT NULL,
  `jwbn` varchar(15) NOT NULL DEFAULT 'N',
  `nil_jwb` enum('1','2','3','4','5','0','9') NOT NULL DEFAULT '0',
  `knci_jwbn` enum('1','2','3','4','5','N') NOT NULL DEFAULT 'N',
  `nil_pg` int(1) NOT NULL DEFAULT 0,
  `es_jwb` mediumtext NOT NULL,
  `nil_esai` int(3) NOT NULL DEFAULT 0,
  `tgl` date NOT NULL DEFAULT current_timestamp(),
  `jam` time NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
  `jdh` int(3) NOT NULL,
  `prsn_jdh` int(3) NOT NULL,
  `bs` int(3) NOT NULL,
  `prsn_bs` int(3) NOT NULL,
  `plh` int(3) NOT NULL,
  `prsn_plh` int(3) NOT NULL,
  `jum_soal` int(3) NOT NULL,
  `kkm` int(2) NOT NULL,
  `tgl` date NOT NULL DEFAULT current_timestamp(),
  `author` varchar(30) NOT NULL,
  `sts` enum('Y','N') NOT NULL DEFAULT 'N'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `cbt_soal`
--

CREATE TABLE `cbt_soal` (
  `id_soal` int(11) NOT NULL,
  `kd_soal` varchar(20) NOT NULL,
  `kd_mapel` varchar(20) NOT NULL,
  `jns_soal` enum('E','G','J','X','P') NOT NULL,
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `info`
--

CREATE TABLE `info` (
  `id` int(11) NOT NULL,
  `id_sv` varchar(25) NOT NULL,
  `idpt` varchar(20) NOT NULL,
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `info`
--

INSERT INTO `info` (`id`, `id_sv`, `idpt`, `nmpt`, `almtpt`, `nmkpt`, `nmpnpt`, `fav`, `lg_dinas`, `ft_adm`, `ft_sis`, `head`, `head2`, `kel`, `kec`, `kab`, `prov`) VALUES
(1, '1', '123', 'SMAN Kita Bersama', 'Jl. alamat yang di tuju lh gitu lah lh', 'Kepsek', 'Ketua', 'fav.png', '', '', '', '', '', '', '', '', '');

-- --------------------------------------------------------

--
-- Struktur dari tabel `jdwl`
--

CREATE TABLE `jdwl` (
  `id_ujian` int(11) NOT NULL,
  `kd_ujian` varchar(4) NOT NULL,
  `smt` enum('1','2','3','4','5','6') NOT NULL,
  `kd_kls` varchar(15) NOT NULL,
  `kls` varchar(10) NOT NULL,
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
  `pl_m` enum('0','1','2','3','4','5') NOT NULL DEFAULT '0',
  `md_uji` enum('0','1') NOT NULL DEFAULT '0',
  `sts` enum('Y','N','H') NOT NULL,
  `sts_token` enum('Y','T') NOT NULL DEFAULT 'T',
  `sts_nilai` enum('Y','T') NOT NULL DEFAULT 'T'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
  `no_soal` varchar(1000) NOT NULL,
  `jwb` varchar(1000) NOT NULL,
  `skor` varchar(100) NOT NULL,
  `nil_pg` int(3) NOT NULL,
  `nil_es` int(3) NOT NULL,
  `nilai` int(3) NOT NULL,
  `tgl_tes` date NOT NULL,
  `tgl` datetime NOT NULL DEFAULT current_timestamp(),
  `adm` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
  `sts` enum('S','U','N') NOT NULL,
  `dt_on` enum('0','1') NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `svr`
--

CREATE TABLE `svr` (
  `id_sv` int(11) NOT NULL,
  `idpt` varchar(50) NOT NULL,
  `ip_sv` varchar(15) NOT NULL,
  `lev_svr` enum('M','C') NOT NULL DEFAULT 'C',
  `db_svr` varchar(30) NOT NULL,
  `nm_sv` varchar(50) NOT NULL,
  `fdr` varchar(20) NOT NULL,
  `sync` varchar(2) NOT NULL,
  `sts` enum('Y','N') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `svr`
--

INSERT INTO `svr` (`id_sv`, `idpt`, `ip_sv`, `lev_svr`, `db_svr`, `nm_sv`, `fdr`, `sync`, `sts`) VALUES
(0, '', '', 'M', '', 'Master_Server', 'tbk', '', 'Y'),
(1, '11', '192.168.100.172', 'C', 'mytbk', 'Client_Server', 'tbk', '', 'Y'),
(3, '123', '192.168.100.1', 'C', '', '123', '', '', 'Y');

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `user`
--

INSERT INTO `user` (`id_usr`, `kd_usr`, `nm_user`, `username`, `pass`, `tlp`, `lvl`, `sts`) VALUES
(1, 'A01', 'Administator', 'admin', '21232f297a57a5a743894a0e4a801fc3', '0234234', 'A', 'Y'),
(2, 'U01', 'User', 'user', '202cb962ac59075b964b07152d234b70', '023423423', 'U', 'Y'),
(3, '', 'Pengawas Ruang 1', 'pengawas1', '202cb962ac59075b964b07152d234b70', '', 'X', 'Y');

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
  MODIFY `id_peserta` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `cbt_pktsoal`
--
ALTER TABLE `cbt_pktsoal`
  MODIFY `id_pktsoal` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `cbt_soal`
--
ALTER TABLE `cbt_soal`
  MODIFY `id_soal` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `info`
--
ALTER TABLE `info`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `jdwl`
--
ALTER TABLE `jdwl`
  MODIFY `id_ujian` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `kelas`
--
ALTER TABLE `kelas`
  MODIFY `id_kls` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `mapel`
--
ALTER TABLE `mapel`
  MODIFY `id_mpel` int(11) NOT NULL AUTO_INCREMENT;

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
  MODIFY `id_sv` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `user`
--
ALTER TABLE `user`
  MODIFY `id_usr` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
