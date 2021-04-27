-- phpMyAdmin SQL Dump
-- version 3.2.0.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Nov 26, 2019 at 03:19 PM
-- Server version: 5.1.37
-- PHP Version: 5.3.0

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `dbtenda`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbladmin`
--

CREATE TABLE IF NOT EXISTS `tbladmin` (
  `username` char(4) NOT NULL,
  `password` varchar(15) NOT NULL,
  PRIMARY KEY (`username`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbladmin`
--

INSERT INTO `tbladmin` (`username`, `password`) VALUES
('admi', 'admin');

-- --------------------------------------------------------

--
-- Table structure for table `tblpemesan`
--

CREATE TABLE IF NOT EXISTS `tblpemesan` (
  `id_pemesan` char(10) NOT NULL,
  `nama_pemesan` varchar(50) NOT NULL,
  `jenis_kel` char(1) NOT NULL,
  `no_hp` varchar(15) NOT NULL,
  `alamat_pemesan` varchar(100) NOT NULL,
  PRIMARY KEY (`id_pemesan`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tblpemesan`
--

INSERT INTO `tblpemesan` (`id_pemesan`, `nama_pemesan`, `jenis_kel`, `no_hp`, `alamat_pemesan`) VALUES
('aed', 'asdasd', 'a', '12', 'asda'),
('12', 'aa', 'a', 'aa', 'aaa'),
('xxx', 'xx', 'x', 'xxx', 'xx'),
('zzz', 'zzz', 'z', 'zzzzzzzz', 'z');

-- --------------------------------------------------------

--
-- Table structure for table `tblpemesanan`
--

CREATE TABLE IF NOT EXISTS `tblpemesanan` (
  `nomor` int(10) NOT NULL AUTO_INCREMENT,
  `kode_tenda` char(5) NOT NULL,
  `id_pemesan` char(10) NOT NULL,
  `id_petugas` char(10) NOT NULL,
  `tgl_pinjam` varchar(25) NOT NULL,
  `tgl_kembali` varchar(25) NOT NULL,
  `total_biaya` double NOT NULL,
  `jml_pinjam` smallint(5) NOT NULL,
  PRIMARY KEY (`nomor`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `tblpemesanan`
--

INSERT INTO `tblpemesanan` (`nomor`, `kode_tenda`, `id_pemesan`, `id_petugas`, `tgl_pinjam`, `tgl_kembali`, `total_biaya`, `jml_pinjam`) VALUES
(1, 'sdfsd', 'ww', 'wefwef', '4', '5', 12, 9),
(2, 'sdfsd', 'ww', 'wefwef', '4', '5', 12, 9),
(6, 'Athen', 'zzz', 'aaa', '11', '15', 1223333, 16);

-- --------------------------------------------------------

--
-- Table structure for table `tblpetugas`
--

CREATE TABLE IF NOT EXISTS `tblpetugas` (
  `id_petugas` char(10) NOT NULL,
  `nama_petugas` varchar(50) NOT NULL,
  `jenis_kel` char(1) NOT NULL,
  `no_hp` varchar(15) NOT NULL,
  `alamat_petugas` varchar(100) NOT NULL,
  PRIMARY KEY (`id_petugas`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tblpetugas`
--

INSERT INTO `tblpetugas` (`id_petugas`, `nama_petugas`, `jenis_kel`, `no_hp`, `alamat_petugas`) VALUES
('aaa', 'aaa', 'a', 'aaa', 'aaa'),
('aaass', 'wefwef', 'a', 'efewfwefwefwef', 'wefwefwefwefew'),
('ccc', 'aa', 'a', 'aaa', 'aaa');

-- --------------------------------------------------------

--
-- Table structure for table `tbltenda`
--

CREATE TABLE IF NOT EXISTS `tbltenda` (
  `kode_tenda` char(5) NOT NULL,
  `merk_tenda` varchar(50) NOT NULL,
  `stok` smallint(5) NOT NULL,
  `harga` double NOT NULL,
  `gambar` varchar(100) NOT NULL,
  PRIMARY KEY (`kode_tenda`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbltenda`
--

INSERT INTO `tbltenda` (`kode_tenda`, `merk_tenda`, `stok`, `harga`, `gambar`) VALUES
('223', 'Athena', 12, 100000, 'Gaming shop.PNG');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
