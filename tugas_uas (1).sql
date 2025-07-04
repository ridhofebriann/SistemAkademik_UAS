-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 04 Jul 2025 pada 04.17
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
-- Database: `tugas_uas`
--

DELIMITER $$
--
-- Fungsi
--
CREATE DEFINER=`root`@`localhost` FUNCTION `FORMAT_NAMA_DOSEN` (`nama_dosen` VARCHAR(255)) RETURNS VARCHAR(260) CHARSET utf8mb4 COLLATE utf8mb4_general_ci DETERMINISTIC BEGIN
    -- Karena tabel dosen Anda tidak memiliki kolom jenis_kelamin, kita gunakan awalan generik
    RETURN CONCAT('Bpk./Ibu. ', nama_dosen);
END$$

CREATE DEFINER=`root`@`localhost` FUNCTION `HITUNG_SKS_TOTAL_MAHASISWA` (`input_nim` VARCHAR(10)) RETURNS INT(11) DETERMINISTIC BEGIN
    DECLARE total_sks INT;
    SELECT SUM(mk.sks) INTO total_sks
    FROM KRSMahasiswa krs
    JOIN JadwalMengajar jm ON krs.kd_mk = jm.kd_mk AND krs.kd_ds = jm.kd_ds
    JOIN MataKuliah mk ON jm.kd_mk = mk.kd_mk
    WHERE krs.nim = input_nim;

    IF total_sks IS NULL THEN
        SET total_sks = 0;
    END IF;

    RETURN total_sks;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Struktur dari tabel `dosen`
--

CREATE TABLE `dosen` (
  `kd_ds` varchar(10) NOT NULL,
  `nama` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `dosen`
--

INSERT INTO `dosen` (`kd_ds`, `nama`) VALUES
('DS001', 'Nofal Arianto'),
('DS002', 'Ario Talib'),
('DS003', 'Ayu Rahmadina'),
('DS004', 'Ratna Kumala'),
('DS005', 'Vika Prasetyo'),
('DS006', 'SANTI'),
('DS007', 'supri'),
('DS008', 'budi sutomo');

-- --------------------------------------------------------

--
-- Struktur dari tabel `jadwalmengajar`
--

CREATE TABLE `jadwalmengajar` (
  `kd_mk` varchar(10) NOT NULL,
  `kd_ds` varchar(10) NOT NULL,
  `hari` varchar(20) NOT NULL,
  `jam` time NOT NULL,
  `ruang` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `jadwalmengajar`
--

INSERT INTO `jadwalmengajar` (`kd_mk`, `kd_ds`, `hari`, `jam`, `ruang`) VALUES
('MK001', 'DS002', 'Senin', '10:00:00', '102'),
('MK002', 'DS002', 'Senin', '13:00:00', 'Lab. 01'),
('MK003', 'DS001', 'Selasa', '08:00:00', '201'),
('MK004', 'DS001', 'Rabu', '10:00:00', 'Lab. 02'),
('MK005', 'DS003', 'Selasa', '10:00:00', 'Lab. 01'),
('MK006', 'DS004', 'Kamis', '09:00:00', 'Lab. 03'),
('MK007', 'DS005', 'Rabu', '08:00:00', '102'),
('MK008', 'DS005', 'Kamis', '13:00:00', '201'),
('MK009', 'DS006', 'Senin', '10:00:00', '102'),
('MK010', 'DS007', 'Selasa', '13:00:00', 'Lab.01');

-- --------------------------------------------------------

--
-- Struktur dari tabel `krsmahasiswa`
--

CREATE TABLE `krsmahasiswa` (
  `nim` varchar(10) NOT NULL,
  `kd_mk` varchar(10) NOT NULL,
  `kd_ds` varchar(10) NOT NULL,
  `semester` int(11) DEFAULT NULL,
  `nilai` varchar(5) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `krsmahasiswa`
--

INSERT INTO `krsmahasiswa` (`nim`, `kd_mk`, `kd_ds`, `semester`, `nilai`) VALUES
('1823456', 'MK001', 'DS002', 3, NULL),
('1823456', 'MK002', 'DS002', 1, NULL),
('1823456', 'MK003', 'DS001', 3, NULL),
('1823456', 'MK004', 'DS001', 3, NULL),
('1823456', 'MK007', 'DS005', 3, NULL),
('1823456', 'MK008', 'DS005', 3, NULL),
('1823456', 'MK009', 'DS006', 2, NULL),
('1823456', 'MK010', 'DS007', 2, NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `mahasiswa`
--

CREATE TABLE `mahasiswa` (
  `nim` varchar(10) NOT NULL,
  `nama` varchar(100) DEFAULT NULL,
  `jk` char(1) DEFAULT NULL,
  `tgl_lahir` date DEFAULT NULL,
  `jalan` varchar(255) DEFAULT NULL,
  `kota` varchar(100) DEFAULT NULL,
  `kodepos` varchar(10) DEFAULT NULL,
  `no_hp` varchar(20) DEFAULT NULL,
  `kd_ds` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `mahasiswa`
--

INSERT INTO `mahasiswa` (`nim`, `nama`, `jk`, `tgl_lahir`, `jalan`, `kota`, `kodepos`, `no_hp`, `kd_ds`) VALUES
('1809878', 'rizki', 'L', '2006-02-01', NULL, 'bekasi', NULL, NULL, NULL),
('1812345', 'icha', 'P', '2006-10-11', NULL, 'Bekasi', NULL, NULL, 'DS002'),
('1823456', 'ridho', 'L', '2006-11-20', NULL, 'Jakarta', NULL, NULL, NULL),
('1834567', 'ibnu', 'L', '2006-05-10', NULL, 'Bekasi', NULL, NULL, NULL),
('1845678', 'richie', 'L', '2005-10-19', NULL, 'Cikarang', NULL, NULL, NULL),
('1856784', 'razy', 'L', '2006-08-22', NULL, 'cikarang', NULL, NULL, NULL),
('1856789', 'tiara', 'P', '2005-02-15', NULL, 'Karawang', NULL, NULL, NULL),
('1857876', 'fahmi', 'L', '2006-02-22', NULL, 'tambelang', NULL, NULL, NULL),
('1867890', 'afnan', 'L', '2006-06-22', NULL, 'Bekasi', NULL, NULL, NULL),
('1898787', 'arkham', 'L', '2005-04-22', NULL, 'cikarang', NULL, NULL, NULL),
('1912345', 'leni', 'P', '2005-10-23', NULL, 'Jakarta', NULL, NULL, NULL),
('1923456', 'gefi', 'P', '2006-01-24', NULL, 'Karawang', NULL, NULL, 'DS004'),
('1934567', 'bagus', 'L', '2005-04-14', NULL, 'Cikarang', NULL, NULL, NULL),
('1945678', 'nisa', 'P', '2006-05-10', NULL, 'Cikarang', NULL, NULL, NULL),
('1956789', 'sayyid', 'L', '2004-08-29', NULL, 'Bekasi', NULL, NULL, 'DS005'),
('1967890', 'irfan', 'L', '2006-07-22', NULL, 'Cikarang', NULL, NULL, 'DS004');

-- --------------------------------------------------------

--
-- Struktur dari tabel `matakuliah`
--

CREATE TABLE `matakuliah` (
  `kd_mk` varchar(10) NOT NULL,
  `nama` varchar(255) DEFAULT NULL,
  `sks` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `matakuliah`
--

INSERT INTO `matakuliah` (`kd_mk`, `nama`, `sks`) VALUES
('MK001', 'Algoritma Dan Pemrograman', 3),
('MK002', 'Basis Data', 1),
('MK003', 'fisika', 3),
('MK004', 'kalkulus', 1),
('MK005', 'matematika terapan', 3),
('MK006', 'bahasa inggris', 3),
('MK007', 'bahasa indonesia', 3),
('MK008', 'Arsitektur Komputer', 2),
('MK009', 'agama', 2),
('MK010', 'Logika informatika', 3);

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `dosen`
--
ALTER TABLE `dosen`
  ADD PRIMARY KEY (`kd_ds`);

--
-- Indeks untuk tabel `jadwalmengajar`
--
ALTER TABLE `jadwalmengajar`
  ADD PRIMARY KEY (`kd_mk`,`kd_ds`,`hari`,`jam`),
  ADD KEY `kd_ds` (`kd_ds`);

--
-- Indeks untuk tabel `krsmahasiswa`
--
ALTER TABLE `krsmahasiswa`
  ADD PRIMARY KEY (`nim`,`kd_mk`,`kd_ds`),
  ADD KEY `kd_mk` (`kd_mk`),
  ADD KEY `kd_ds` (`kd_ds`);

--
-- Indeks untuk tabel `mahasiswa`
--
ALTER TABLE `mahasiswa`
  ADD PRIMARY KEY (`nim`);

--
-- Indeks untuk tabel `matakuliah`
--
ALTER TABLE `matakuliah`
  ADD PRIMARY KEY (`kd_mk`);

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `jadwalmengajar`
--
ALTER TABLE `jadwalmengajar`
  ADD CONSTRAINT `jadwalmengajar_ibfk_1` FOREIGN KEY (`kd_mk`) REFERENCES `matakuliah` (`kd_mk`),
  ADD CONSTRAINT `jadwalmengajar_ibfk_2` FOREIGN KEY (`kd_ds`) REFERENCES `dosen` (`kd_ds`);

--
-- Ketidakleluasaan untuk tabel `krsmahasiswa`
--
ALTER TABLE `krsmahasiswa`
  ADD CONSTRAINT `krsmahasiswa_ibfk_1` FOREIGN KEY (`nim`) REFERENCES `mahasiswa` (`nim`) ON UPDATE CASCADE,
  ADD CONSTRAINT `krsmahasiswa_ibfk_2` FOREIGN KEY (`kd_mk`) REFERENCES `matakuliah` (`kd_mk`),
  ADD CONSTRAINT `krsmahasiswa_ibfk_3` FOREIGN KEY (`kd_ds`) REFERENCES `dosen` (`kd_ds`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
