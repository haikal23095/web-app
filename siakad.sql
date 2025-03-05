-- phpMyAdmin SQL Dump
-- version 4.4.15.10
-- https://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: 26 Des 2024 pada 03.30
-- Versi Server: 5.5.68-MariaDB
-- PHP Version: 7.3.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `siakad`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `Dekan`
--

CREATE TABLE IF NOT EXISTS `Dekan` (
  `ID_Dekan` int(11) NOT NULL,
  `Nama_Dekan` varchar(100) NOT NULL,
  `ID_Fakultas` int(11) NOT NULL,
  `Jenis_Kelamin_Dekan` enum('L','P') DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=70008 DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `Dekan`
--

INSERT INTO `Dekan` (`ID_Dekan`, `Nama_Dekan`, `ID_Fakultas`, `Jenis_Kelamin_Dekan`) VALUES
(10001, 'Prof. Dr. Faikhul Umam', 1, 'L'),
(20002, 'Dr. Sutikno, S.E., M.E.', 2, 'L'),
(30003, 'Dr. Erma Rusdiana, SH., MH.', 3, 'P'),
(40004, 'Dr. Dinara Maya Julijanti, S.Sos., M.Si.', 4, 'P'),
(50005, 'Dr. Moh. Fuad Fauzul Mu''tamar S.TP, M.SI', 5, 'L'),
(60006, 'Dr. Hani’ah, S.Pd., M.Pd.', 6, 'P'),
(70007, 'Shofiyun Nahidloh, S.Ag., M.H.I\r\n', 7, 'P');

-- --------------------------------------------------------

--
-- Struktur dari tabel `Diskusi`
--

CREATE TABLE IF NOT EXISTS `Diskusi` (
  `ID_Diskusi` int(11) NOT NULL,
  `Judul_Diskusi` varchar(50) NOT NULL,
  `Isi_Diskusi` varchar(255) NOT NULL,
  `Tanggal_Diskusi` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `Dosen`
--

CREATE TABLE IF NOT EXISTS `Dosen` (
  `NIP` int(10) NOT NULL,
  `Nama_Dosen` text NOT NULL,
  `Alamat_Dosen` text NOT NULL,
  `Jenis_Kelamin_Dosen` enum('L','P') NOT NULL,
  `ID_Prodi` int(11) NOT NULL,
  `ID_User` int(11) NOT NULL,
  `ttl` varchar(50) NOT NULL,
  `agama` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `telp` char(12) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `Dosen`
--

INSERT INTO `Dosen` (`NIP`, `Nama_Dosen`, `Alamat_Dosen`, `Jenis_Kelamin_Dosen`, `ID_Prodi`, `ID_User`, `ttl`, `agama`, `email`, `telp`) VALUES
(1902986678, 'Syafiq', 'Bangkalan', 'L', 2, 36, '2024-12-25', 'Islam', 'yoyoyo@gmail.com', '089525656775'),
(1974061021, 'Firdaus Sholihin', 'Jl ccc ddd yyy', 'L', 1, 3, '', '', '', ''),
(1978031720, '	Dr. Noor Ifada, S.T., MISD.', 'jl telang indah 9', 'P', 2, 7, '', '', '', ''),
(1979051020, 'Dr. Meidya Koeshardianto, S.Si., M.T.', 'jl telang indah no 4', 'L', 3, 8, '', '', '', ''),
(1980021320, 'Yonathan Ferry Hendrawan, S.T.MIT.', 'jl telang indah 7', 'L', 4, 9, '', '', '', ''),
(1984071620, 'Dr. Eka Mala Sari Rochman, S.Kom.M.Kom.', 'jl telang indah no 3', 'P', 4, 11, '', '', '', ''),
(1984110420, 'Devie Rosa Anamisa, S.Kom.M.Kom.', 'jl telang indah no 1, bangkalan', 'P', 5, 10, 'Surabaya, 18 Juni 1992', 'Islam', 'devie12@gmail.com', '085766630242');

-- --------------------------------------------------------

--
-- Struktur dari tabel `Fakultas`
--

CREATE TABLE IF NOT EXISTS `Fakultas` (
  `ID_Fakultas` int(11) NOT NULL,
  `Nama_Fakultas` varchar(50) NOT NULL,
  `ID_Dekan` int(11) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `Fakultas`
--

INSERT INTO `Fakultas` (`ID_Fakultas`, `Nama_Fakultas`, `ID_Dekan`) VALUES
(1, 'fakultas teknik', 10001),
(2, 'fakultas Ekonomi dan Bisnis', 20002),
(3, 'fakultas hukum', 30003),
(4, 'fakultas ilmu sosial dan budaya', 40004),
(5, 'fakultas pertanian', 50005),
(6, 'fakultas ilmu pendidikan', 60006),
(7, 'fakultas keislaman', 70007),
(8, 'fakultas Kedokteran', 8);

-- --------------------------------------------------------

--
-- Struktur dari tabel `FAQ`
--

CREATE TABLE IF NOT EXISTS `FAQ` (
  `ID_FAQ` int(11) NOT NULL,
  `Kategori_FAQ` varchar(50) NOT NULL,
  `Isi_FAQ` varchar(255) NOT NULL,
  `ID_User` int(11) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `FAQ`
--

INSERT INTO `FAQ` (`ID_FAQ`, `Kategori_FAQ`, `Isi_FAQ`, `ID_User`) VALUES
(1, 'Akademik', 'Kapan yudisium dilaksanakan', NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `Jurusan`
--

CREATE TABLE IF NOT EXISTS `Jurusan` (
  `ID_Jurusan` int(11) NOT NULL,
  `Nama_Jurusan` varchar(50) NOT NULL,
  `ID_Fakultas` int(11) NOT NULL,
  `ID_Kajur` int(11) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=1024 DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `Jurusan`
--

INSERT INTO `Jurusan` (`ID_Jurusan`, `Nama_Jurusan`, `ID_Fakultas`, `ID_Kajur`) VALUES
(1, 'Informatika', 1, 10211),
(2, 'Elektro', 1, 10212),
(3, 'Mesin', 1, 10213),
(6, 'Manajemen', 2, 206),
(7, 'Akuntansi', 2, 207),
(8, 'Ilmu Hukum', 3, 208),
(9, 'Pendidikan Matematika', 6, 209),
(10, 'Pendidikan Bahasa Inggris', 6, 210),
(11, 'Kedokteran', 6, 211),
(12, 'Keperawatan', 8, 212);

-- --------------------------------------------------------

--
-- Struktur dari tabel `Kajur`
--

CREATE TABLE IF NOT EXISTS `Kajur` (
  `ID_Kajur` int(11) NOT NULL,
  `Nama_Kajur` varchar(100) NOT NULL,
  `ID_Jurusan` int(11) NOT NULL,
  `Jenis_Kelamin_Kajur` enum('Laki - Laki','Perempuan','','') NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=10214 DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `Kajur`
--

INSERT INTO `Kajur` (`ID_Kajur`, `Nama_Kajur`, `ID_Jurusan`, `Jenis_Kelamin_Kajur`) VALUES
(10211, 'Dr. Yeni Kustiyahningsih, S.Kom., M.Kom.', 1, 'Perempuan'),
(10212, 'Ir. Sri Wahyuni, S.Kom., MT', 2, 'Perempuan'),
(10213, 'Dr. Kukuh Winarso, S. Si., M.T.', 3, 'Laki - Laki');

-- --------------------------------------------------------

--
-- Struktur dari tabel `Kalender`
--

CREATE TABLE IF NOT EXISTS `Kalender` (
  `ID_Kalender` int(11) NOT NULL,
  `Nama_Kalender` varchar(50) NOT NULL,
  `Date_Time` date NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `KHS`
--

CREATE TABLE IF NOT EXISTS `KHS` (
  `ID_KHS` int(11) NOT NULL,
  `NIM` int(11) NOT NULL,
  `Semester_KHS` int(11) NOT NULL,
  `Tahun_Akademik` enum('2023/2024','2024/2025','2025/2026','2026/2027') NOT NULL,
  `IP_Semester` float NOT NULL,
  `Jumlah_Matakuliah_Diambil` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `KHS`
--

INSERT INTO `KHS` (`ID_KHS`, `NIM`, `Semester_KHS`, `Tahun_Akademik`, `IP_Semester`, `Jumlah_Matakuliah_Diambil`) VALUES
(1, 23041017, 1, '2023/2024', 3.5, 7),
(2, 23041017, 2, '2023/2024', 3.5, 7),
(4, 23041047, 1, '2023/2024', 3.5, 7),
(5, 23041047, 2, '2023/2024', 3.5, 7);

-- --------------------------------------------------------

--
-- Struktur dari tabel `KHS_Detail`
--

CREATE TABLE IF NOT EXISTS `KHS_Detail` (
  `ID_KHS` int(11) NOT NULL,
  `ID_Matakuliah` int(11) NOT NULL,
  `Nilai` enum('A','B+','B','C+','C','D+','D','E') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `KHS_Detail`
--

INSERT INTO `KHS_Detail` (`ID_KHS`, `ID_Matakuliah`, `Nilai`) VALUES
(1, 3, 'B'),
(1, 2, 'B'),
(1, 1, 'A');

-- --------------------------------------------------------

--
-- Struktur dari tabel `KoorProdi`
--

CREATE TABLE IF NOT EXISTS `KoorProdi` (
  `ID_KoorProdi` int(11) NOT NULL,
  `Nama_KoorProdi` varchar(100) NOT NULL,
  `ID_Prodi` int(11) NOT NULL,
  `Jenis_Kelamin_Koorprodi` enum('Laki - Laki','Perempuan','','') NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=10237 DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `KoorProdi`
--

INSERT INTO `KoorProdi` (`ID_KoorProdi`, `Nama_KoorProdi`, `ID_Prodi`, `Jenis_Kelamin_Koorprodi`) VALUES
(101, 'xxxxx', 1, 'Laki - Laki'),
(102, 'yyyyy', 2, 'Perempuan'),
(103, 'zzzzz', 3, 'Laki - Laki'),
(105, 'aaaaa', 4, 'Laki - Laki'),
(106, 'bbbbbb', 5, 'Perempuan'),
(107, 'ccccc', 6, 'Laki - Laki'),
(108, 'ddddd', 7, 'Perempuan'),
(109, 'eeeee', 8, 'Laki - Laki'),
(110, 'fffff', 9, 'Perempuan'),
(111, 'ggggg', 10, 'Laki - Laki');

-- --------------------------------------------------------

--
-- Struktur dari tabel `KRS`
--

CREATE TABLE IF NOT EXISTS `KRS` (
  `ID_KRS` int(11) NOT NULL,
  `Semester_KRS` int(11) NOT NULL,
  `NIM` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `KRS`
--

INSERT INTO `KRS` (`ID_KRS`, `Semester_KRS`, `NIM`) VALUES
(1, 1, 23041017),
(2, 2, 23041017),
(3, 3, 23041017),
(4, 1, 23041047),
(5, 2, 23041047),
(6, 3, 23041047);

-- --------------------------------------------------------

--
-- Struktur dari tabel `KRS_Detail`
--

CREATE TABLE IF NOT EXISTS `KRS_Detail` (
  `ID_Matakuliah_KRS` varchar(11) NOT NULL,
  `ID_KRS` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `KRS_Detail`
--

INSERT INTO `KRS_Detail` (`ID_Matakuliah_KRS`, `ID_KRS`) VALUES
('1003', 5),
('1002', 6),
('1003', 6);

-- --------------------------------------------------------

--
-- Struktur dari tabel `Mahasiswa`
--

CREATE TABLE IF NOT EXISTS `Mahasiswa` (
  `NIM` int(12) NOT NULL,
  `Nama_Mahasiswa` varchar(50) NOT NULL,
  `Alamat_Mahasiswa` varchar(64) NOT NULL,
  `Jenis_Kelamin_Mahasiswa` enum('L','P') NOT NULL,
  `ID_Mahasiswa_Perwalian` int(11) DEFAULT NULL,
  `ID_User` int(11) DEFAULT NULL,
  `ID_UKT` int(11) DEFAULT NULL,
  `SEMESTER_Mahasiswa` int(11) DEFAULT NULL,
  `ID_Prodi` int(11) DEFAULT NULL,
  `IPK` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `Mahasiswa`
--

INSERT INTO `Mahasiswa` (`NIM`, `Nama_Mahasiswa`, `Alamat_Mahasiswa`, `Jenis_Kelamin_Mahasiswa`, `ID_Mahasiswa_Perwalian`, `ID_User`, `ID_UKT`, `SEMESTER_Mahasiswa`, `ID_Prodi`, `IPK`) VALUES
(23041017, 'Wiwik Ainun Janah', 'Nganjuk', 'P', 1, 4, 1, 3, 1, 3.5),
(23041047, 'Yunika Lestari', 'Lamongan', 'P', 2, 2, 5, 3, 1, 3.5);

-- --------------------------------------------------------

--
-- Struktur dari tabel `Mahasiswa_Bimbingan`
--

CREATE TABLE IF NOT EXISTS `Mahasiswa_Bimbingan` (
  `ID_Mahasiswa_Bimbingan` int(11) NOT NULL,
  `Nama_Mahasiswa_Bimbingan` varchar(100) DEFAULT NULL,
  `Judul_Skripsi` varchar(100) DEFAULT NULL,
  `NIP` int(11) DEFAULT NULL,
  `NIM` int(12) NOT NULL,
  `status_judul` enum('Accept','Tolak') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `Mahasiswa_Bimbingan`
--

INSERT INTO `Mahasiswa_Bimbingan` (`ID_Mahasiswa_Bimbingan`, `Nama_Mahasiswa_Bimbingan`, `Judul_Skripsi`, `NIP`, `NIM`, `status_judul`) VALUES
(1, 'Yunika Lestari', 'Aplikasi SMS Untuk Pelayanan Informasi Akademik Menggunakan Visual Basic dan Oracle', 1984110420, 23041047, 'Accept'),
(2, 'Wiwik Ainun Janah', 'Sistem Pengaman Rumah Berbasis GPRS dan Image Capturing menggunakan Visual Basic 6', 1984110420, 23041017, 'Tolak');

-- --------------------------------------------------------

--
-- Struktur dari tabel `Mahasiswa_Perwalian`
--

CREATE TABLE IF NOT EXISTS `Mahasiswa_Perwalian` (
  `ID_Mahasiswa_Perwalian` int(11) NOT NULL,
  `NIM` int(11) NOT NULL,
  `Nama_Mahasiswa_Perwalian` varchar(100) NOT NULL,
  `NIP` int(10) NOT NULL,
  `Semester` int(11) NOT NULL,
  `Status_KRS` enum('valid','unvalid') NOT NULL DEFAULT 'unvalid'
) ENGINE=InnoDB AUTO_INCREMENT=230160 DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `Mahasiswa_Perwalian`
--

INSERT INTO `Mahasiswa_Perwalian` (`ID_Mahasiswa_Perwalian`, `NIM`, `Nama_Mahasiswa_Perwalian`, `NIP`, `Semester`, `Status_KRS`) VALUES
(1, 23041017, 'Wiwik Ainun Janah', 1984110420, 3, 'unvalid'),
(2, 23041047, 'Yunika Lestari', 1984110420, 3, 'unvalid');

-- --------------------------------------------------------

--
-- Struktur dari tabel `Matakuliah`
--

CREATE TABLE IF NOT EXISTS `Matakuliah` (
  `ID_Matakuliah` int(11) NOT NULL,
  `Kode_Matakuliah` varchar(10) NOT NULL,
  `Nama_Matakuliah` varchar(50) NOT NULL,
  `Prasyarat_Matakuliah` int(11) DEFAULT NULL,
  `Semester_Matakuliah` int(11) NOT NULL,
  `SKS_Matakuliah` int(11) NOT NULL,
  `ID_Prodi` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `Matakuliah`
--

INSERT INTO `Matakuliah` (`ID_Matakuliah`, `Kode_Matakuliah`, `Nama_Matakuliah`, `Prasyarat_Matakuliah`, `Semester_Matakuliah`, `SKS_Matakuliah`, `ID_Prodi`) VALUES
(1, 'MK001', 'Matematika Dasar', NULL, 1, 3, 1),
(2, 'MK002', 'Fisika Dasar', NULL, 1, 3, 1),
(3, 'MK003', 'Pemrograman Dasar', NULL, 1, 3, 1),
(4, 'MK004', 'Pengantar Teknologi Informasi', NULL, 1, 2, 1),
(5, 'MK005', 'Sistem Operasi', 0, 2, 3, 1),
(6, 'MK006', 'Algoritma dan Struktur Data', 0, 2, 3, 1),
(7, 'MK007', 'Basis Data', 0, 3, 3, 1),
(8, 'MK008', 'Rekayasa Perangkat Lunak', 0, 3, 3, 1),
(9, 'MK009', 'Jaringan Komputer', NULL, 3, 3, 1),
(10, 'MK010', 'Matematika Diskrit', 0, 2, 3, 1),
(11, 'MK011', 'Pemrograman Web', 0, 4, 3, 1),
(12, 'MK012', 'Kecerdasan Buatan', 0, 5, 3, 1),
(13, 'MK013', 'Pemrograman Berorientasi Objek', 0, 3, 3, 1),
(14, 'MK014', 'Analisis Data', 0, 5, 3, 1),
(15, 'MK015', 'Machine Learning', 0, 6, 3, 1),
(16, 'MK016', 'Manajemen Proyek', NULL, 6, 3, 2),
(17, 'MK017', 'Komputer Grafik', 0, 4, 3, 1),
(18, 'MK018', 'Sistem Pakar', 0, 6, 3, 2),
(19, 'MK019', 'Big Data', 0, 6, 3, 1),
(20, 'MK020', 'Keamanan Sistem Informasi', 0, 5, 3, 2),
(21, 'MK021', 'Pemrograman Mobile', 0, 5, 3, 1),
(22, 'MK022', 'Cloud Computing', NULL, 7, 3, 1),
(23, 'MK023', 'Analisis dan Desain Sistem', 0, 4, 3, 2),
(24, 'MK024', 'Kriptografi', 0, 6, 3, 1),
(25, 'MK025', 'Pemrograman Game', 0, 6, 3, 1),
(30, 'if46', 'Pendidikan Agama', NULL, 1, 3, 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `Matakuliah_KRS`
--

CREATE TABLE IF NOT EXISTS `Matakuliah_KRS` (
  `ID_Matakuliah_KRS` varchar(11) NOT NULL,
  `NIP` int(10) NOT NULL,
  `ID_Matakuliah` int(10) NOT NULL,
  `ID_Ruangan` int(10) NOT NULL,
  `Nama_Matakuliah_KRS` text NOT NULL,
  `Jadwal_Matakuliah` time NOT NULL,
  `Kuota_Matakuliah_KRS` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `Matakuliah_KRS`
--

INSERT INTO `Matakuliah_KRS` (`ID_Matakuliah_KRS`, `NIP`, `ID_Matakuliah`, `ID_Ruangan`, `Nama_Matakuliah_KRS`, `Jadwal_Matakuliah`, `Kuota_Matakuliah_KRS`) VALUES
('1001', 1979051020, 3, 8, 'Pemrograman Dasar A\r\n', '07:00:00', 100),
('1002', 1984071620, 2, 12, 'Fisika Dasar A', '09:00:00', 100),
('1003', 1984110420, 1, 6, 'Matematika Dasar A\r\n', '16:00:00', 100),
('1004', 1974061021, 4, 9, 'pengantar Teknologi Informasi A\n', '07:00:00', 100);

-- --------------------------------------------------------

--
-- Struktur dari tabel `Mengajar`
--

CREATE TABLE IF NOT EXISTS `Mengajar` (
  `NIP` int(11) NOT NULL DEFAULT '0',
  `NIM` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `Mengambil`
--

CREATE TABLE IF NOT EXISTS `Mengambil` (
  `NIM` int(11) NOT NULL DEFAULT '0',
  `ID_Matakuliah_KRS` varchar(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `Metode_Pembayaran`
--

CREATE TABLE IF NOT EXISTS `Metode_Pembayaran` (
  `ID_Metode_Pembayaran` int(11) NOT NULL DEFAULT '0',
  `Nama_MetodePembayaran` enum('Qris','Transfer Bank','Card','') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `Metode_Pembayaran`
--

INSERT INTO `Metode_Pembayaran` (`ID_Metode_Pembayaran`, `Nama_MetodePembayaran`) VALUES
(1, 'Transfer Bank');

-- --------------------------------------------------------

--
-- Struktur dari tabel `Pembayaran_UKT`
--

CREATE TABLE IF NOT EXISTS `Pembayaran_UKT` (
  `ID_Pembayaran` int(11) NOT NULL,
  `NIM` int(12) NOT NULL,
  `Jumlah_Pembayaran` int(11) NOT NULL,
  `Tanggal_Pembayaran` date NOT NULL,
  `ID_Metode_Pembayaran` int(11) NOT NULL,
  `Status_Pembayaran` enum('Success','Failed','Pending','') NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `Pembayaran_UKT`
--

INSERT INTO `Pembayaran_UKT` (`ID_Pembayaran`, `NIM`, `Jumlah_Pembayaran`, `Tanggal_Pembayaran`, `ID_Metode_Pembayaran`, `Status_Pembayaran`) VALUES
(1, 23041017, 20, '2024-12-29', 1, 'Success'),
(2, 23041047, 50, '2024-12-25', 1, 'Success');

-- --------------------------------------------------------

--
-- Struktur dari tabel `Pengumuman`
--

CREATE TABLE IF NOT EXISTS `Pengumuman` (
  `ID_Pengumuman` int(11) NOT NULL,
  `Judul_Pengumuman` varchar(50) NOT NULL,
  `Isi_Pengumuman` varchar(255) NOT NULL,
  `Tanggal_Pengumuman` date NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `Pengumuman`
--

INSERT INTO `Pengumuman` (`ID_Pengumuman`, `Judul_Pengumuman`, `Isi_Pengumuman`, `Tanggal_Pengumuman`) VALUES
(1, 'Beasiswa Djarum 2025', 'Beasiswa Djarum 2025 akan mulai dibuka pada bulan Maret', '2024-12-17');

-- --------------------------------------------------------

--
-- Struktur dari tabel `Pesan_Masuk`
--

CREATE TABLE IF NOT EXISTS `Pesan_Masuk` (
  `ID_Pesan_Masuk` int(11) NOT NULL,
  `Judul_Pesan_Masuk` varchar(50) NOT NULL,
  `Isi_Pesan_Masuk` varchar(255) NOT NULL,
  `Tanggal_Pesan_Masuk` datetime NOT NULL,
  `ID_User` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `Pesan_Masuk`
--

INSERT INTO `Pesan_Masuk` (`ID_Pesan_Masuk`, `Judul_Pesan_Masuk`, `Isi_Pesan_Masuk`, `Tanggal_Pesan_Masuk`, `ID_User`) VALUES
(1, 'Email Kampus', 'Email : 21476532\r\nPassword : 12345', '2024-12-17 00:00:00', 3);

-- --------------------------------------------------------

--
-- Struktur dari tabel `Pesan_Terkirim`
--

CREATE TABLE IF NOT EXISTS `Pesan_Terkirim` (
  `ID_Pesan_Terkirim` int(11) NOT NULL,
  `Judul_Pesan_Terkirim` varchar(50) NOT NULL,
  `Isi_Pesan_Terkirim` varchar(255) NOT NULL,
  `Tanggal_Pesan_Terkirim` datetime NOT NULL,
  `ID_User` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `Pesan_Terkirim`
--

INSERT INTO `Pesan_Terkirim` (`ID_Pesan_Terkirim`, `Judul_Pesan_Terkirim`, `Isi_Pesan_Terkirim`, `Tanggal_Pesan_Terkirim`, `ID_User`) VALUES
(1, 'Email Kampus', 'Email : 21476525\r\nPassword : 123456', '2024-12-17 00:00:00', 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `Prodi`
--

CREATE TABLE IF NOT EXISTS `Prodi` (
  `ID_Prodi` int(11) NOT NULL,
  `Nama_Prodi` varchar(50) NOT NULL,
  `ID_Jurusan` int(11) NOT NULL,
  `ID_Fakultas` int(11) NOT NULL,
  `ID_KoorProdi` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `Prodi`
--

INSERT INTO `Prodi` (`ID_Prodi`, `Nama_Prodi`, `ID_Jurusan`, `ID_Fakultas`, `ID_KoorProdi`) VALUES
(1, 'Teknik Informatika', 1, 1, 101),
(2, 'Sistem Informasi', 1, 1, 102),
(3, 'Teknik Elektro', 2, 2, 103),
(4, 'Teknik Mesin', 3, 2, 105),
(5, 'Teknik Informatika', 1, 1, 106),
(6, 'Akuntansi', 6, 3, 107),
(7, 'Ilmu Hukum', 8, 4, 108),
(8, 'Pendidikan Matematika', 9, 5, 109),
(9, 'Pendidikan Bahasa Inggris', 10, 5, 110),
(10, 'Kedokteran', 11, 6, 111);

-- --------------------------------------------------------

--
-- Struktur dari tabel `Ruangan`
--

CREATE TABLE IF NOT EXISTS `Ruangan` (
  `ID_Ruangan` int(10) NOT NULL,
  `Nama_Ruangan` text NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `Ruangan`
--

INSERT INTO `Ruangan` (`ID_Ruangan`, `Nama_Ruangan`) VALUES
(5, 'RKBF 307'),
(6, 'LAB CC'),
(7, 'LAB TIA'),
(8, 'LAB TMJ'),
(9, 'LAB TMJ'),
(10, 'RKBF 203'),
(12, 'RKBF 407'),
(13, 'RKBF 304');

-- --------------------------------------------------------

--
-- Struktur dari tabel `Skripsi_Mahasiswa`
--

CREATE TABLE IF NOT EXISTS `Skripsi_Mahasiswa` (
  `ID_Skripsi` int(11) NOT NULL,
  `Judul_Skripsi` varchar(255) NOT NULL,
  `NIM` int(11) NOT NULL,
  `NIP` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `Transkip_nilai`
--

CREATE TABLE IF NOT EXISTS `Transkip_nilai` (
  `ID_Transkip_Nilai` int(11) NOT NULL,
  `NIM` int(11) NOT NULL,
  `ID_Matakuliah` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `Transkip_nilai`
--

INSERT INTO `Transkip_nilai` (`ID_Transkip_Nilai`, `NIM`, `ID_Matakuliah`) VALUES
(1, 23041017, 3),
(4, 23041017, 1),
(5, 23041017, 2);

-- --------------------------------------------------------

--
-- Struktur dari tabel `UKT_Mahasiswa`
--

CREATE TABLE IF NOT EXISTS `UKT_Mahasiswa` (
  `ID_UKT` int(11) NOT NULL,
  `Besaran_Ukt` int(11) NOT NULL,
  `NIM` int(11) DEFAULT NULL,
  `Golongan_UKT` enum('1','2','3','4','5') DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `UKT_Mahasiswa`
--

INSERT INTO `UKT_Mahasiswa` (`ID_UKT`, `Besaran_Ukt`, `NIM`, `Golongan_UKT`) VALUES
(1, 30, 23041017, '1'),
(5, 50, 23041047, '1');

-- --------------------------------------------------------

--
-- Struktur dari tabel `User`
--

CREATE TABLE IF NOT EXISTS `User` (
  `ID_User` int(11) NOT NULL,
  `Nama_User` varchar(255) NOT NULL,
  `Username` varchar(255) NOT NULL,
  `Password` varchar(255) NOT NULL,
  `Level` enum('admin','dosen','mahasiswa','') NOT NULL,
  `No_Hp` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=37 DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `User`
--

INSERT INTO `User` (`ID_User`, `Nama_User`, `Username`, `Password`, `Level`, `No_Hp`) VALUES
(1, 'admin', 'admin', '5994471abb01112afcc18159f6cc74b4f511b99806da59b3caf5a9c173cacfc5', 'admin', 81234567),
(2, 'yunika', 'yunika', '5994471abb01112afcc18159f6cc74b4f511b99806da59b3caf5a9c173cacfc5', 'mahasiswa', 87648473),
(3, 'Firdaus Sholihin', 'firdaus86', '5994471abb01112afcc18159f6cc74b4f511b99806da59b3caf5a9c173cacfc5', 'dosen', 9876543),
(4, 'ainun', 'ainun', 'a665a45920422f9d417e4867efdc4fb8a04a1f3fff1fa07e998e86f7f7a27ae3', 'mahasiswa', 2147483647),
(6, 'Basuki', 'basuki', '5994471abb01112afcc18159f6cc74b4f511b99806da59b3caf5a9c173cacfc5', 'dosen', 9876541),
(7, 'Nor Ifada', 'ifada', '5994471abb01112afcc18159f6cc74b4f511b99806da59b3caf5a9c173cacfc5', 'dosen', 9876542),
(8, 'Meidya', 'meidya', '5994471abb01112afcc18159f6cc74b4f511b99806da59b3caf5a9c173cacfc5', 'dosen', 81234566),
(9, 'Yonathan', 'yonathan', '5994471abb01112afcc18159f6cc74b4f511b99806da59b3caf5a9c173cacfc5', 'dosen', 9876540),
(10, 'Devie Rosa', 'devierosa', '5994471abb01112afcc18159f6cc74b4f511b99806da59b3caf5a9c173cacfc5', 'dosen', 81234565),
(11, 'Eka Mala Sari ', 'eka', '5994471abb01112afcc18159f6cc74b4f511b99806da59b3caf5a9c173cacfc5', 'dosen', 98765410),
(12, '', '', '$2y$12$e/cIdZVnfYlTsLhV0brFMeF3cUrz04QzppohluCmkLzz4dcRrf9Oi', 'dosen', 0),
(13, '', '', '$2y$12$lS0rPVQnQ9wukWsO3.R.N.yBDt4hayvArpr9vXi5fX7rlvIcyIZDW', 'dosen', 0),
(14, '', 'syafiq', '$2y$12$tAIPdQyM68zGzXbiRKwoLuBhSU8pO7eBRjd1sLsmADDIZyYWxqZtC', 'dosen', 2147483647),
(17, 'Rossi', 'Rossi''rossi', 'ec4312b95be55405334e6237b052994840e403f1c5d45d51dd70ceb31dbb6b77', 'dosen', 2147483647),
(18, 'Haikal', 'Haikal''haikal', '15e2b0d3c33891ebb0f1ef609ec419420c20e320ce94c65fbc8c3312448eb225', 'dosen', 2147483647),
(19, 'Syafiq', 'Syafiq''syafiq', '15e2b0d3c33891ebb0f1ef609ec419420c20e320ce94c65fbc8c3312448eb225', 'dosen', 2147483647),
(20, 'Syafiq', 'Syafiq''syafiq', '15e2b0d3c33891ebb0f1ef609ec419420c20e320ce94c65fbc8c3312448eb225', 'dosen', 2147483647),
(21, 'Rossi', 'Rossi''rossi', '15e2b0d3c33891ebb0f1ef609ec419420c20e320ce94c65fbc8c3312448eb225', 'dosen', 2147483647),
(22, 'Syafiq', 'Syafiq''syafiq', '15e2b0d3c33891ebb0f1ef609ec419420c20e320ce94c65fbc8c3312448eb225', 'dosen', 2147483647),
(23, 'Syafiq', 'Syafiq''syafiq', '15e2b0d3c33891ebb0f1ef609ec419420c20e320ce94c65fbc8c3312448eb225', 'dosen', 2147483647),
(24, 'Syafiq', 'Syafiq''syafiq', '15e2b0d3c33891ebb0f1ef609ec419420c20e320ce94c65fbc8c3312448eb225', 'dosen', 2147483647),
(25, 'Syafiq', 'Syafiq''syafiq', '15e2b0d3c33891ebb0f1ef609ec419420c20e320ce94c65fbc8c3312448eb225', 'dosen', 2147483647),
(26, 'Syafiq', 'Syafiq''syafiq', '15e2b0d3c33891ebb0f1ef609ec419420c20e320ce94c65fbc8c3312448eb225', 'dosen', 2147483647),
(27, 'Syafiq', 'Syafiq''syafiq', '15e2b0d3c33891ebb0f1ef609ec419420c20e320ce94c65fbc8c3312448eb225', 'dosen', 2147483647),
(28, '', '''', '15e2b0d3c33891ebb0f1ef609ec419420c20e320ce94c65fbc8c3312448eb225', 'dosen', 2147483647),
(30, 'janah', 'janah', '5994471abb01112afcc18159f6cc74b4f511b99806da59b3caf5a9c173cacfc5', 'admin', 2147483647),
(36, 'Syafiq', 'Syafiq''syafiq', '5994471abb01112afcc18159f6cc74b4f511b99806da59b3caf5a9c173cacfc5', 'dosen', 2147483647);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `Dekan`
--
ALTER TABLE `Dekan`
  ADD PRIMARY KEY (`ID_Dekan`),
  ADD KEY `ID_Fakultas` (`ID_Fakultas`);

--
-- Indexes for table `Diskusi`
--
ALTER TABLE `Diskusi`
  ADD PRIMARY KEY (`ID_Diskusi`);

--
-- Indexes for table `Dosen`
--
ALTER TABLE `Dosen`
  ADD PRIMARY KEY (`NIP`),
  ADD KEY `ID_Prodi` (`ID_Prodi`),
  ADD KEY `ID_User` (`ID_User`);

--
-- Indexes for table `Fakultas`
--
ALTER TABLE `Fakultas`
  ADD PRIMARY KEY (`ID_Fakultas`),
  ADD KEY `ID_Dekan` (`ID_Dekan`);

--
-- Indexes for table `FAQ`
--
ALTER TABLE `FAQ`
  ADD PRIMARY KEY (`ID_FAQ`),
  ADD KEY `ID_User` (`ID_User`);

--
-- Indexes for table `Jurusan`
--
ALTER TABLE `Jurusan`
  ADD PRIMARY KEY (`ID_Jurusan`),
  ADD KEY `ID_Fakultas` (`ID_Fakultas`),
  ADD KEY `Jurusan_ibfk_2` (`ID_Kajur`);

--
-- Indexes for table `Kajur`
--
ALTER TABLE `Kajur`
  ADD PRIMARY KEY (`ID_Kajur`),
  ADD KEY `Kajur_ibfk_1` (`ID_Jurusan`);

--
-- Indexes for table `Kalender`
--
ALTER TABLE `Kalender`
  ADD PRIMARY KEY (`ID_Kalender`);

--
-- Indexes for table `KHS`
--
ALTER TABLE `KHS`
  ADD PRIMARY KEY (`ID_KHS`),
  ADD KEY `NIM` (`NIM`);

--
-- Indexes for table `KHS_Detail`
--
ALTER TABLE `KHS_Detail`
  ADD KEY `ID_KHS` (`ID_KHS`),
  ADD KEY `ID_Matakuliah` (`ID_Matakuliah`);

--
-- Indexes for table `KoorProdi`
--
ALTER TABLE `KoorProdi`
  ADD PRIMARY KEY (`ID_KoorProdi`),
  ADD KEY `KoorProdi_ibfk_1` (`ID_Prodi`);

--
-- Indexes for table `KRS`
--
ALTER TABLE `KRS`
  ADD PRIMARY KEY (`ID_KRS`),
  ADD KEY `NIM` (`NIM`);

--
-- Indexes for table `KRS_Detail`
--
ALTER TABLE `KRS_Detail`
  ADD KEY `ID_Matakuliah_KRS` (`ID_Matakuliah_KRS`),
  ADD KEY `ID_KRS` (`ID_KRS`);

--
-- Indexes for table `Mahasiswa`
--
ALTER TABLE `Mahasiswa`
  ADD PRIMARY KEY (`NIM`),
  ADD UNIQUE KEY `ID_UKT` (`ID_UKT`),
  ADD KEY `ID_User` (`ID_User`),
  ADD KEY `ID_Prodi` (`ID_Prodi`),
  ADD KEY `ID_Mahasiswa_Perwalian` (`ID_Mahasiswa_Perwalian`);

--
-- Indexes for table `Mahasiswa_Bimbingan`
--
ALTER TABLE `Mahasiswa_Bimbingan`
  ADD PRIMARY KEY (`ID_Mahasiswa_Bimbingan`),
  ADD UNIQUE KEY `NIM` (`NIM`),
  ADD KEY `Mahasiswa_Bimbingan_ibfk_4` (`NIP`);

--
-- Indexes for table `Mahasiswa_Perwalian`
--
ALTER TABLE `Mahasiswa_Perwalian`
  ADD PRIMARY KEY (`ID_Mahasiswa_Perwalian`),
  ADD KEY `NIP` (`NIP`),
  ADD KEY `Mahasiswa_Perwalian_ibfk_2` (`NIM`);

--
-- Indexes for table `Matakuliah`
--
ALTER TABLE `Matakuliah`
  ADD PRIMARY KEY (`ID_Matakuliah`),
  ADD KEY `fk_ID_Prodi` (`ID_Prodi`);

--
-- Indexes for table `Matakuliah_KRS`
--
ALTER TABLE `Matakuliah_KRS`
  ADD PRIMARY KEY (`ID_Matakuliah_KRS`),
  ADD UNIQUE KEY `nip` (`NIP`),
  ADD UNIQUE KEY `ID_Ruangan` (`ID_Ruangan`),
  ADD UNIQUE KEY `ID_Matakuliah` (`ID_Matakuliah`);

--
-- Indexes for table `Mengajar`
--
ALTER TABLE `Mengajar`
  ADD PRIMARY KEY (`NIP`),
  ADD KEY `NIM` (`NIM`);

--
-- Indexes for table `Mengambil`
--
ALTER TABLE `Mengambil`
  ADD PRIMARY KEY (`NIM`),
  ADD KEY `Matakuliah_ibfk_1` (`ID_Matakuliah_KRS`);

--
-- Indexes for table `Metode_Pembayaran`
--
ALTER TABLE `Metode_Pembayaran`
  ADD PRIMARY KEY (`ID_Metode_Pembayaran`);

--
-- Indexes for table `Pembayaran_UKT`
--
ALTER TABLE `Pembayaran_UKT`
  ADD PRIMARY KEY (`ID_Pembayaran`),
  ADD UNIQUE KEY `NIM` (`NIM`),
  ADD UNIQUE KEY `Tanggal_Pembayaran` (`Tanggal_Pembayaran`),
  ADD KEY `Pembayaran_UKT_ibfk_2` (`ID_Metode_Pembayaran`);

--
-- Indexes for table `Pengumuman`
--
ALTER TABLE `Pengumuman`
  ADD PRIMARY KEY (`ID_Pengumuman`);

--
-- Indexes for table `Pesan_Masuk`
--
ALTER TABLE `Pesan_Masuk`
  ADD PRIMARY KEY (`ID_Pesan_Masuk`),
  ADD KEY `ID_User` (`ID_User`);

--
-- Indexes for table `Pesan_Terkirim`
--
ALTER TABLE `Pesan_Terkirim`
  ADD PRIMARY KEY (`ID_Pesan_Terkirim`),
  ADD KEY `ID_User` (`ID_User`);

--
-- Indexes for table `Prodi`
--
ALTER TABLE `Prodi`
  ADD PRIMARY KEY (`ID_Prodi`),
  ADD KEY `ID_Jurusan` (`ID_Jurusan`),
  ADD KEY `Prodi_ibfk_2` (`ID_Fakultas`),
  ADD KEY `Prodi_ibfk_3` (`ID_KoorProdi`);

--
-- Indexes for table `Ruangan`
--
ALTER TABLE `Ruangan`
  ADD PRIMARY KEY (`ID_Ruangan`);

--
-- Indexes for table `Skripsi_Mahasiswa`
--
ALTER TABLE `Skripsi_Mahasiswa`
  ADD PRIMARY KEY (`ID_Skripsi`),
  ADD KEY `NIM` (`NIM`),
  ADD KEY `NIP` (`NIP`);

--
-- Indexes for table `Transkip_nilai`
--
ALTER TABLE `Transkip_nilai`
  ADD PRIMARY KEY (`ID_Transkip_Nilai`),
  ADD KEY `NIM` (`NIM`),
  ADD KEY `fk_matakuliah` (`ID_Matakuliah`);

--
-- Indexes for table `UKT_Mahasiswa`
--
ALTER TABLE `UKT_Mahasiswa`
  ADD PRIMARY KEY (`ID_UKT`),
  ADD UNIQUE KEY `NIM` (`NIM`);

--
-- Indexes for table `User`
--
ALTER TABLE `User`
  ADD PRIMARY KEY (`ID_User`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `Dekan`
--
ALTER TABLE `Dekan`
  MODIFY `ID_Dekan` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=70008;
--
-- AUTO_INCREMENT for table `Diskusi`
--
ALTER TABLE `Diskusi`
  MODIFY `ID_Diskusi` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `Fakultas`
--
ALTER TABLE `Fakultas`
  MODIFY `ID_Fakultas` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `FAQ`
--
ALTER TABLE `FAQ`
  MODIFY `ID_FAQ` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `Jurusan`
--
ALTER TABLE `Jurusan`
  MODIFY `ID_Jurusan` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=1024;
--
-- AUTO_INCREMENT for table `Kajur`
--
ALTER TABLE `Kajur`
  MODIFY `ID_Kajur` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=10214;
--
-- AUTO_INCREMENT for table `Kalender`
--
ALTER TABLE `Kalender`
  MODIFY `ID_Kalender` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT for table `KHS`
--
ALTER TABLE `KHS`
  MODIFY `ID_KHS` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `KoorProdi`
--
ALTER TABLE `KoorProdi`
  MODIFY `ID_KoorProdi` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=10237;
--
-- AUTO_INCREMENT for table `KRS`
--
ALTER TABLE `KRS`
  MODIFY `ID_KRS` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT for table `Mahasiswa_Perwalian`
--
ALTER TABLE `Mahasiswa_Perwalian`
  MODIFY `ID_Mahasiswa_Perwalian` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=230160;
--
-- AUTO_INCREMENT for table `Matakuliah`
--
ALTER TABLE `Matakuliah`
  MODIFY `ID_Matakuliah` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=31;
--
-- AUTO_INCREMENT for table `Pembayaran_UKT`
--
ALTER TABLE `Pembayaran_UKT`
  MODIFY `ID_Pembayaran` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `Pengumuman`
--
ALTER TABLE `Pengumuman`
  MODIFY `ID_Pengumuman` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `Pesan_Masuk`
--
ALTER TABLE `Pesan_Masuk`
  MODIFY `ID_Pesan_Masuk` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `Pesan_Terkirim`
--
ALTER TABLE `Pesan_Terkirim`
  MODIFY `ID_Pesan_Terkirim` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `Ruangan`
--
ALTER TABLE `Ruangan`
  MODIFY `ID_Ruangan` int(10) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=14;
--
-- AUTO_INCREMENT for table `Transkip_nilai`
--
ALTER TABLE `Transkip_nilai`
  MODIFY `ID_Transkip_Nilai` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `UKT_Mahasiswa`
--
ALTER TABLE `UKT_Mahasiswa`
  MODIFY `ID_UKT` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `User`
--
ALTER TABLE `User`
  MODIFY `ID_User` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=37;
--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `Dekan`
--
ALTER TABLE `Dekan`
  ADD CONSTRAINT `Dekan_ibfk_1` FOREIGN KEY (`ID_Fakultas`) REFERENCES `Fakultas` (`ID_Fakultas`);

--
-- Ketidakleluasaan untuk tabel `Dosen`
--
ALTER TABLE `Dosen`
  ADD CONSTRAINT `Dosen_ibfk_2` FOREIGN KEY (`ID_User`) REFERENCES `User` (`ID_User`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `Dosen_ibfk_1` FOREIGN KEY (`ID_Prodi`) REFERENCES `Prodi` (`ID_Prodi`);

--
-- Ketidakleluasaan untuk tabel `FAQ`
--
ALTER TABLE `FAQ`
  ADD CONSTRAINT `FAQ_ibfk_1` FOREIGN KEY (`ID_User`) REFERENCES `User` (`ID_User`);

--
-- Ketidakleluasaan untuk tabel `Jurusan`
--
ALTER TABLE `Jurusan`
  ADD CONSTRAINT `Jurusan_ibfk_1` FOREIGN KEY (`ID_Fakultas`) REFERENCES `Fakultas` (`ID_Fakultas`);

--
-- Ketidakleluasaan untuk tabel `Kajur`
--
ALTER TABLE `Kajur`
  ADD CONSTRAINT `Kajur_ibfk_1` FOREIGN KEY (`ID_Jurusan`) REFERENCES `Jurusan` (`ID_Jurusan`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `KHS`
--
ALTER TABLE `KHS`
  ADD CONSTRAINT `KHS_ibfk_1` FOREIGN KEY (`NIM`) REFERENCES `Mahasiswa` (`NIM`);

--
-- Ketidakleluasaan untuk tabel `KHS_Detail`
--
ALTER TABLE `KHS_Detail`
  ADD CONSTRAINT `KHS_Detail_ibfk_2` FOREIGN KEY (`ID_Matakuliah`) REFERENCES `Matakuliah` (`ID_Matakuliah`),
  ADD CONSTRAINT `KHS_Detail_ibfk_1` FOREIGN KEY (`ID_KHS`) REFERENCES `KHS` (`ID_KHS`);

--
-- Ketidakleluasaan untuk tabel `KoorProdi`
--
ALTER TABLE `KoorProdi`
  ADD CONSTRAINT `KoorProdi_ibfk_1` FOREIGN KEY (`ID_Prodi`) REFERENCES `Prodi` (`ID_Prodi`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `KRS`
--
ALTER TABLE `KRS`
  ADD CONSTRAINT `KRS_ibfk_1` FOREIGN KEY (`NIM`) REFERENCES `Mahasiswa` (`NIM`);

--
-- Ketidakleluasaan untuk tabel `KRS_Detail`
--
ALTER TABLE `KRS_Detail`
  ADD CONSTRAINT `KRS_Detail_ibfk_2` FOREIGN KEY (`ID_KRS`) REFERENCES `KRS` (`ID_KRS`),
  ADD CONSTRAINT `KRS_Detail_ibfk_1` FOREIGN KEY (`ID_Matakuliah_KRS`) REFERENCES `Matakuliah_KRS` (`ID_Matakuliah_KRS`);

--
-- Ketidakleluasaan untuk tabel `Mahasiswa`
--
ALTER TABLE `Mahasiswa`
  ADD CONSTRAINT `Mahasiswa_ibfk_1` FOREIGN KEY (`ID_User`) REFERENCES `User` (`ID_User`),
  ADD CONSTRAINT `Mahasiswa_ibfk_2` FOREIGN KEY (`ID_Prodi`) REFERENCES `Prodi` (`ID_Prodi`),
  ADD CONSTRAINT `Mahasiswa_ibfk_3` FOREIGN KEY (`ID_Mahasiswa_Perwalian`) REFERENCES `Mahasiswa_Perwalian` (`ID_Mahasiswa_Perwalian`),
  ADD CONSTRAINT `Mahasiswa_ibfk_4` FOREIGN KEY (`ID_UKT`) REFERENCES `UKT_Mahasiswa` (`ID_UKT`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `Mahasiswa_ibfk_5` FOREIGN KEY (`ID_UKT`) REFERENCES `UKT_Mahasiswa` (`ID_UKT`);

--
-- Ketidakleluasaan untuk tabel `Mahasiswa_Bimbingan`
--
ALTER TABLE `Mahasiswa_Bimbingan`
  ADD CONSTRAINT `Mahasiswa_Bimbingan_ibfk_3` FOREIGN KEY (`NIM`) REFERENCES `Mahasiswa` (`NIM`),
  ADD CONSTRAINT `Mahasiswa_Bimbingan_ibfk_4` FOREIGN KEY (`NIP`) REFERENCES `Dosen` (`NIP`);

--
-- Ketidakleluasaan untuk tabel `Mahasiswa_Perwalian`
--
ALTER TABLE `Mahasiswa_Perwalian`
  ADD CONSTRAINT `Mahasiswa_Perwalian_ibfk_2` FOREIGN KEY (`NIM`) REFERENCES `Mahasiswa` (`NIM`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `Mahasiswa_Perwalian_ibfk_1` FOREIGN KEY (`NIP`) REFERENCES `Dosen` (`NIP`);

--
-- Ketidakleluasaan untuk tabel `Matakuliah`
--
ALTER TABLE `Matakuliah`
  ADD CONSTRAINT `fk_ID_Prodi` FOREIGN KEY (`ID_Prodi`) REFERENCES `Prodi` (`ID_Prodi`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `Matakuliah_KRS`
--
ALTER TABLE `Matakuliah_KRS`
  ADD CONSTRAINT `matakuliah_krs_ibfk_1` FOREIGN KEY (`ID_Ruangan`) REFERENCES `Ruangan` (`id_ruangan`),
  ADD CONSTRAINT `matakuliah_krs_ibfk_2` FOREIGN KEY (`ID_Matakuliah`) REFERENCES `Matakuliah` (`ID_Matakuliah`),
  ADD CONSTRAINT `matakuliah_krs_ibfk_3` FOREIGN KEY (`NIP`) REFERENCES `Dosen` (`NIP`);

--
-- Ketidakleluasaan untuk tabel `Mengajar`
--
ALTER TABLE `Mengajar`
  ADD CONSTRAINT `Mengajar_ibfk_5` FOREIGN KEY (`NIP`) REFERENCES `Dosen` (`NIP`),
  ADD CONSTRAINT `Mengajar_ibfk_4` FOREIGN KEY (`NIM`) REFERENCES `Mahasiswa` (`NIM`);

--
-- Ketidakleluasaan untuk tabel `Mengambil`
--
ALTER TABLE `Mengambil`
  ADD CONSTRAINT `Matakuliah_ibfk_1` FOREIGN KEY (`ID_Matakuliah_KRS`) REFERENCES `Matakuliah_KRS` (`ID_Matakuliah_KRS`),
  ADD CONSTRAINT `Mengambil_ibfk_1` FOREIGN KEY (`NIM`) REFERENCES `Mahasiswa` (`NIM`);

--
-- Ketidakleluasaan untuk tabel `Pembayaran_UKT`
--
ALTER TABLE `Pembayaran_UKT`
  ADD CONSTRAINT `Pembayaran_UKT_ibfk_1` FOREIGN KEY (`NIM`) REFERENCES `Mahasiswa` (`NIM`),
  ADD CONSTRAINT `Pembayaran_UKT_ibfk_2` FOREIGN KEY (`ID_Metode_Pembayaran`) REFERENCES `Metode_Pembayaran` (`ID_Metode_Pembayaran`);

--
-- Ketidakleluasaan untuk tabel `Pesan_Masuk`
--
ALTER TABLE `Pesan_Masuk`
  ADD CONSTRAINT `Pesan_Masuk_ibfk_1` FOREIGN KEY (`ID_User`) REFERENCES `User` (`ID_User`);

--
-- Ketidakleluasaan untuk tabel `Pesan_Terkirim`
--
ALTER TABLE `Pesan_Terkirim`
  ADD CONSTRAINT `Pesan_Terkirim_ibfk_1` FOREIGN KEY (`ID_User`) REFERENCES `User` (`ID_User`);

--
-- Ketidakleluasaan untuk tabel `Prodi`
--
ALTER TABLE `Prodi`
  ADD CONSTRAINT `Prodi_ibfk_1` FOREIGN KEY (`ID_Jurusan`) REFERENCES `Jurusan` (`ID_Jurusan`),
  ADD CONSTRAINT `Prodi_ibfk_2` FOREIGN KEY (`ID_Fakultas`) REFERENCES `Fakultas` (`ID_Fakultas`);

--
-- Ketidakleluasaan untuk tabel `Skripsi_Mahasiswa`
--
ALTER TABLE `Skripsi_Mahasiswa`
  ADD CONSTRAINT `Skripsi_Mahasiswa_ibfk_2` FOREIGN KEY (`NIP`) REFERENCES `Dosen` (`NIP`),
  ADD CONSTRAINT `Skripsi_Mahasiswa_ibfk_1` FOREIGN KEY (`NIM`) REFERENCES `Mahasiswa` (`NIM`);

--
-- Ketidakleluasaan untuk tabel `Transkip_nilai`
--
ALTER TABLE `Transkip_nilai`
  ADD CONSTRAINT `fk_matakuliah` FOREIGN KEY (`ID_Matakuliah`) REFERENCES `Matakuliah` (`ID_Matakuliah`),
  ADD CONSTRAINT `Transkip_nilai_ibfk_1` FOREIGN KEY (`NIM`) REFERENCES `Mahasiswa` (`NIM`);

--
-- Ketidakleluasaan untuk tabel `UKT_Mahasiswa`
--
ALTER TABLE `UKT_Mahasiswa`
  ADD CONSTRAINT `UKT_Mahasiswa_ibfk_1` FOREIGN KEY (`NIM`) REFERENCES `Mahasiswa` (`NIM`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
