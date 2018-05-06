-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: 06 Mei 2018 pada 03.19
-- Versi Server: 10.1.28-MariaDB
-- PHP Version: 7.1.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `e-salary`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `absensi`
--

CREATE TABLE `absensi` (
  `nip` varchar(4) NOT NULL,
  `tanggal` date NOT NULL,
  `jam` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `absensi`
--

INSERT INTO `absensi` (`nip`, `tanggal`, `jam`) VALUES
('0001', '2017-04-27', '08:26:58'),
('0002', '2017-04-27', '08:27:34'),
('0003', '2017-04-27', '12:39:35'),
('0001', '2017-04-28', '07:38:59'),
('0001', '2017-03-01', '07:00:00'),
('0001', '2017-03-02', '07:00:00'),
('0001', '2017-03-03', '07:00:00'),
('0001', '2017-03-04', '07:00:00'),
('0001', '2017-03-05', '07:00:00'),
('0001', '2017-03-06', '07:00:00'),
('0001', '2017-03-07', '07:00:00'),
('0001', '2017-03-08', '07:00:00'),
('0001', '2017-03-09', '07:00:00'),
('0001', '2017-03-10', '07:00:00'),
('0001', '2017-03-11', '07:00:00'),
('0001', '2017-03-12', '07:00:00'),
('0001', '2017-03-13', '07:00:00'),
('0001', '2017-03-14', '07:00:00'),
('0001', '2017-03-15', '07:00:00'),
('0001', '2017-03-17', '07:00:00'),
('0001', '2017-03-19', '07:00:00'),
('0001', '2017-03-20', '07:00:00'),
('0001', '2017-03-21', '07:00:00'),
('0001', '2017-03-22', '07:00:00'),
('0001', '2017-03-23', '07:00:00'),
('0001', '2017-03-24', '07:00:00'),
('0001', '2017-03-28', '07:00:00'),
('0001', '2017-03-29', '07:00:00'),
('0004', '2017-04-28', '08:19:39'),
('0001', '2017-03-31', '08:26:21'),
('0002', '2017-03-31', '08:26:40'),
('0003', '2017-03-31', '08:28:42'),
('0004', '2017-03-31', '08:28:44'),
('0001', '2016-03-31', '09:01:36'),
('0002', '2016-03-31', '09:01:39'),
('0003', '2016-03-31', '09:01:44'),
('0001', '2017-03-30', '09:18:50'),
('0002', '2017-03-30', '09:19:01'),
('0002', '2017-04-30', '18:41:35'),
('0001', '2018-05-06', '08:17:39');

-- --------------------------------------------------------

--
-- Struktur dari tabel `it_user`
--

CREATE TABLE `it_user` (
  `nip` varchar(4) NOT NULL,
  `password` varchar(25) NOT NULL,
  `level` varchar(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `it_user`
--

INSERT INTO `it_user` (`nip`, `password`, `level`) VALUES
('0000', 'admin', 'ROOT'),
('0003', 'tigabang', 'IT'),
('0004', 'empatbang', 'IT');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pegawai`
--

CREATE TABLE `pegawai` (
  `nip` varchar(4) NOT NULL,
  `nama` varchar(30) NOT NULL,
  `tempat` varchar(10) NOT NULL,
  `tanggal` date NOT NULL,
  `telp` int(11) NOT NULL,
  `alamat` varchar(65) NOT NULL,
  `tmasuk` date NOT NULL,
  `jabatan` varchar(7) NOT NULL,
  `potongan` int(8) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `pegawai`
--

INSERT INTO `pegawai` (`nip`, `nama`, `tempat`, `tanggal`, `telp`, `alamat`, `tmasuk`, `jabatan`, `potongan`) VALUES
('0000', 'ROOT', '', '0000-00-00', 0, '', '0000-00-00', 'ROOT', 0),
('0001', 'Dina', 'Kahuripan', '1997-04-03', 9218774, 'Jl Kahuripan', '2017-04-26', 'Manager', 0),
('0002', 'Samin', 'Angka Lima', '1997-03-12', 89380284, 'Jl Angka Lima', '2017-04-26', 'Staf', 0),
('0003', 'Jalei', 'Ieakde Dad', '1993-03-05', 83230183, 'Jl Owoad Siwla', '2017-04-27', 'IT', 10000),
('0004', 'Gilang', 'Surabaya', '1989-12-02', 2147483647, 'Jl. Sumedang', '2017-04-27', 'IT', 0);

-- --------------------------------------------------------

--
-- Struktur dari tabel `penggajian`
--

CREATE TABLE `penggajian` (
  `jabatan` varchar(7) NOT NULL,
  `gajiPokok` int(11) NOT NULL,
  `gajiPresensi` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `penggajian`
--

INSERT INTO `penggajian` (`jabatan`, `gajiPokok`, `gajiPresensi`) VALUES
('IT', 3000000, 100000),
('Manager', 4000000, 10000),
('Staf', 2500000, 100000);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `absensi`
--
ALTER TABLE `absensi`
  ADD KEY `nip` (`nip`);

--
-- Indexes for table `it_user`
--
ALTER TABLE `it_user`
  ADD KEY `nip` (`nip`);

--
-- Indexes for table `pegawai`
--
ALTER TABLE `pegawai`
  ADD PRIMARY KEY (`nip`);

--
-- Indexes for table `penggajian`
--
ALTER TABLE `penggajian`
  ADD PRIMARY KEY (`jabatan`);

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `absensi`
--
ALTER TABLE `absensi`
  ADD CONSTRAINT `absensi_ibfk_1` FOREIGN KEY (`nip`) REFERENCES `pegawai` (`nip`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `it_user`
--
ALTER TABLE `it_user`
  ADD CONSTRAINT `it_user_ibfk_1` FOREIGN KEY (`nip`) REFERENCES `pegawai` (`nip`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
