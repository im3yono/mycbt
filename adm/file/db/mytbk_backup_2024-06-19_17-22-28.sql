CREATE DATABASE IF NOT EXISTS `mytbk` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci; 
 USE `mytbk`; 

DROP TABLE IF EXISTS cbt_ljk;
CREATE TABLE `cbt_ljk` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
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
  `knci_jwbn` enum('1','2','3','4','5','N') NOT NULL,
  `nil_pg` int(1) NOT NULL DEFAULT 0,
  `es_jwb` mediumtext NOT NULL,
  `nil_esai` int(3) NOT NULL DEFAULT 0,
  `tgl` date NOT NULL DEFAULT current_timestamp(),
  `jam` time NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


DROP TABLE IF EXISTS cbt_peserta;
CREATE TABLE `cbt_peserta` (
  `id_peserta` int(11) NOT NULL AUTO_INCREMENT,
  `ip_sv` varchar(35) NOT NULL,
  `nm` varchar(50) NOT NULL,
  `tmp_lahir` varchar(50) NOT NULL,
  `tgl_lahir` date NOT NULL,
  `nis` int(20) NOT NULL,
  `kd_kls` varchar(20) NOT NULL,
  `jns_kel` enum('L','P') NOT NULL,
  `ft` varchar(30) NOT NULL DEFAULT 'noavatar.png',
  `user` varchar(50) NOT NULL,
  `pass` varchar(50) NOT NULL,
  `sesi` varchar(1) NOT NULL,
  `ruang` varchar(15) NOT NULL,
  `sts` enum('Y','N') NOT NULL DEFAULT 'Y',
  PRIMARY KEY (`id_peserta`),
  UNIQUE KEY `user` (`user`),
  KEY `kd_kls` (`kd_kls`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


DROP TABLE IF EXISTS cbt_pktsoal;
CREATE TABLE `cbt_pktsoal` (
  `id_pktsoal` int(11) NOT NULL AUTO_INCREMENT,
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
  `sts` enum('Y','N') NOT NULL DEFAULT 'N',
  PRIMARY KEY (`id_pktsoal`),
  UNIQUE KEY `kd_soal` (`kd_soal`),
  KEY `kd_kls` (`kd_kls`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


DROP TABLE IF EXISTS cbt_soal;
CREATE TABLE `cbt_soal` (
  `id_soal` int(11) NOT NULL AUTO_INCREMENT,
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
  `ack_opsi` enum('Y','N') NOT NULL DEFAULT 'Y',
  PRIMARY KEY (`id_soal`),
  KEY `kd_soal` (`kd_soal`),
  KEY `kd_mapel` (`kd_mapel`),
  KEY `no_soal` (`no_soal`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


DROP TABLE IF EXISTS info;
CREATE TABLE `info` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
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
  `prov` varchar(100) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `idpt` (`idpt`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4;

INSERT INTO info VALUES(1,1,123,'SMAN 1 Kita Bersama','Jl. alamat yang di tuju lh gitu lah lh','Muhammad','Triyono','','','ttd-pimpinan.png','','','','','','','');

DROP TABLE IF EXISTS jdwl;
CREATE TABLE `jdwl` (
  `id_ujian` int(11) NOT NULL AUTO_INCREMENT,
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
  `sts` enum('Y','N','H') NOT NULL,
  `sts_token` enum('Y','T') NOT NULL DEFAULT 'T',
  `sts_nilai` enum('Y','T') NOT NULL DEFAULT 'T',
  PRIMARY KEY (`id_ujian`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


DROP TABLE IF EXISTS kelas;
CREATE TABLE `kelas` (
  `id_kls` int(11) NOT NULL AUTO_INCREMENT,
  `kd_kls` varchar(15) NOT NULL,
  `nm_kls` varchar(45) NOT NULL,
  `kls` varchar(10) NOT NULL,
  `jur` varchar(45) NOT NULL,
  `kls_minat` varchar(70) NOT NULL,
  `sts` enum('Y','N') NOT NULL DEFAULT 'Y',
  PRIMARY KEY (`id_kls`),
  UNIQUE KEY `kd_kls` (`kd_kls`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


DROP TABLE IF EXISTS mapel;
CREATE TABLE `mapel` (
  `id_mpel` int(11) NOT NULL AUTO_INCREMENT,
  `kd_mpel` varchar(15) NOT NULL,
  `nm_mpel` varchar(60) NOT NULL,
  `kkm` int(2) NOT NULL,
  `kls` varchar(10) NOT NULL,
  `jur` varchar(45) NOT NULL,
  `kls_minat` varchar(70) NOT NULL,
  `sts` enum('Y','N') NOT NULL DEFAULT 'Y',
  PRIMARY KEY (`id_mpel`),
  UNIQUE KEY `kd_mpel` (`kd_mpel`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


DROP TABLE IF EXISTS nilai;
CREATE TABLE `nilai` (
  `id_hasil` int(11) NOT NULL AUTO_INCREMENT,
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
  `adm` varchar(50) NOT NULL,
  PRIMARY KEY (`id_hasil`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


DROP TABLE IF EXISTS peserta_tes;
CREATE TABLE `peserta_tes` (
  `id_tes` int(11) NOT NULL AUTO_INCREMENT,
  `id_ujian` int(11) NOT NULL,
  `kd_soal` varchar(20) NOT NULL,
  `user` varchar(50) NOT NULL,
  `sesi` varchar(1) NOT NULL,
  `ruang` varchar(15) NOT NULL,
  `nis` int(20) NOT NULL,
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
  PRIMARY KEY (`id_tes`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


DROP TABLE IF EXISTS qr_lg;
CREATE TABLE `qr_lg` (
  `id_qr` int(11) NOT NULL AUTO_INCREMENT,
  `kd_qr` varchar(30) NOT NULL,
  `id_usr` int(11) NOT NULL,
  `user` varchar(50) NOT NULL,
  `pass` varchar(50) NOT NULL,
  `lev` enum('A','U','X','S') NOT NULL,
  PRIMARY KEY (`id_qr`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


DROP TABLE IF EXISTS svr;
CREATE TABLE `svr` (
  `id_sv` int(11) NOT NULL AUTO_INCREMENT,
  `ip_sv` varchar(15) NOT NULL,
  `nm_sv` varchar(50) NOT NULL,
  `fdr` varchar(20) NOT NULL,
  `sts` enum('Y','N') NOT NULL,
  PRIMARY KEY (`id_sv`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4;

INSERT INTO svr VALUES(1,'192.168.100.172','Master_Server','tbk','Y');

DROP TABLE IF EXISTS user;
CREATE TABLE `user` (
  `id_usr` int(11) NOT NULL AUTO_INCREMENT,
  `kd_usr` varchar(3) NOT NULL,
  `nm_user` varchar(50) NOT NULL,
  `username` varchar(35) NOT NULL,
  `pass` varchar(35) NOT NULL,
  `tlp` varchar(18) NOT NULL,
  `lvl` enum('A','U','X') NOT NULL,
  `sts` enum('Y','N') NOT NULL DEFAULT 'Y',
  PRIMARY KEY (`id_usr`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=70 DEFAULT CHARSET=utf8mb4;

INSERT INTO user VALUES(1,'A01','Administator','Admin','21232f297a57a5a743894a0e4a801fc3',0234234,'A','Y'),
(2,'U01','User','user','d41d8cd98f00b204e9800998ecf8427e',023423423,'U','Y'),
(69,'','Pengawas 1','pengawas1',123,08,'X','Y');

