-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 14, 2024 at 04:00 AM
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
-- Database: `db_klipga`
--

-- --------------------------------------------------------

--
-- Table structure for table `data_input_pasien`
--

CREATE TABLE `data_input_pasien` (
  `dip_id` int(20) NOT NULL,
  `dip_dp_id` int(20) NOT NULL,
  `dip_tipe_diagnosis` enum('Terkonfirmasi bakteriologis','Terdiagnosis klinis') NOT NULL,
  `dip_klasifikasi_anatomi` enum('TBC Paru','TBC Ekstraparu') NOT NULL,
  `dip_ektraparu_lokasi` varchar(255) NOT NULL DEFAULT '-',
  `dip_klasifikasi_pengobatan_sebelumnya` enum('Baru','Diobati setelah gagal','Riwayat pengobatan sebelumnya tidak diketahui','kambuh','Diobati setelah putus berobat') NOT NULL,
  `dip_klasifikasi_icd10` varchar(255) NOT NULL,
  `dip_klasifikasi_hiv` enum('Positif','Negatif','Tidak diketahui') NOT NULL,
  `dip_dirujuk_oleh` varchar(255) NOT NULL,
  `dip_dirujuk_oleh_isian` varchar(255) NOT NULL,
  `dip_pindahan_nama_fasyankes` varchar(255) DEFAULT '-',
  `dip_pindahan_alamat_fasyankes` varchar(255) DEFAULT '-',
  `dip_pindahan_kota` varchar(255) DEFAULT '-',
  `dip_pindahan_provinsi` varchar(255) DEFAULT '-',
  `dip_investigasi_kontak` enum('Ya','Tidak') NOT NULL,
  `dip_jumlah_kontak_serumah` varchar(255) NOT NULL DEFAULT '-',
  `dip_jumlah_kontak_investigasi` varchar(255) NOT NULL DEFAULT '-',
  `dip_jumlah_kontak_tbc` varchar(255) NOT NULL DEFAULT '-',
  `dip_riwayat_dm` enum('Ya','Tidak') NOT NULL,
  `dip_tes_dm` enum('Positif','Negatif') NOT NULL,
  `dip_terapi_dm` enum('OHO','Insulin') NOT NULL,
  `dip_panduan_oat` enum('kategori-1','kategori-2','kategori anak') NOT NULL,
  `dip_panduan_oat_isian` varchar(255) NOT NULL,
  `dip_bentuk_oat` enum('KDT','Kombipak') NOT NULL,
  `dip_sumber_obat` enum('Program TBC','Bayar sendiri','Asuransi','Lain-lain') NOT NULL,
  `dip_sumber_obat_isian` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `data_pasien`
--

CREATE TABLE `data_pasien` (
  `dp_id` int(20) NOT NULL,
  `dp_nama` varchar(255) NOT NULL,
  `dp_panggilan` varchar(255) NOT NULL,
  `dp_nik` varchar(255) NOT NULL,
  `dp_bpjs` varchar(255) NOT NULL,
  `dp_alamat` text NOT NULL,
  `dp_pekerjaan` varchar(255) NOT NULL,
  `dp_kelamin` enum('Laki-Laki','Perempuan') NOT NULL,
  `dp_usia_subur` enum('Hamil','Tidak Hamil','-') NOT NULL DEFAULT '-',
  `dp_tgl_lahir` date NOT NULL,
  `dp_berat_badan` int(5) NOT NULL,
  `dp_tinggi_badan` int(5) NOT NULL,
  `dp_imun_bcg` enum('Ada','Tidak Ada') NOT NULL,
  `dp_skor_tb_anak` varchar(255) NOT NULL,
  `dp_nohp` varchar(255) NOT NULL,
  `dp_petugas_kes` enum('Ya','Tidak') NOT NULL,
  `dp_uji_tbc` varchar(255) NOT NULL,
  `dp_date_toraks` date NOT NULL,
  `dp_toraks_seri` varchar(255) NOT NULL,
  `dp_toraks_kesan` text NOT NULL,
  `dp_date_fnab` date NOT NULL,
  `dp_hasil_fnab` varchar(255) NOT NULL,
  `dp_uji_nondahak` enum('MTB','Bukan MTB','-') NOT NULL DEFAULT '-',
  `dp_nama_nonmtb` varchar(255) NOT NULL,
  `dp_tgl_input` date NOT NULL,
  `dp_status` int(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `data_pasien`
--

INSERT INTO `data_pasien` (`dp_id`, `dp_nama`, `dp_panggilan`, `dp_nik`, `dp_bpjs`, `dp_alamat`, `dp_pekerjaan`, `dp_kelamin`, `dp_usia_subur`, `dp_tgl_lahir`, `dp_berat_badan`, `dp_tinggi_badan`, `dp_imun_bcg`, `dp_skor_tb_anak`, `dp_nohp`, `dp_petugas_kes`, `dp_uji_tbc`, `dp_date_toraks`, `dp_toraks_seri`, `dp_toraks_kesan`, `dp_date_fnab`, `dp_hasil_fnab`, `dp_uji_nondahak`, `dp_nama_nonmtb`, `dp_tgl_input`, `dp_status`) VALUES
(1, 'Data Testing', 'Testing', '123456789', '1234', 'Jalan Testing', 'Testing', 'Perempuan', '-', '2024-05-28', 44, 168, 'Tidak Ada', '10', '123456789', 'Tidak', '22', '2024-05-28', '123/VM/XX/123', 'Testing', '2024-05-28', 'Testing', 'MTB', '-', '2024-06-11', 1),
(2, 'Anggara', 'angga', '1231231231231', '1232132131', 'Test', 'Tes', 'Laki-Laki', '-', '2024-05-28', 60, 180, 'Ada', '80', '123123123123', 'Tidak', '22', '2024-05-28', '123/VM/XX/123', 'Testing', '2024-05-28', 'Testing', 'Bukan MTB', 'Testing', '2024-05-28', 1),
(3, 'Budi', 'bud', '167101122003389', '123456789011', 'Testing', 'Testing', 'Laki-Laki', '-', '2024-05-28', 44, 165, 'Ada', '11', '11990092123218', 'Tidak', '24', '2024-05-28', 'Testing123', 'Testing', '2024-05-28', 'Testing', 'MTB', '-', '2024-05-28', 1),
(11, 'Yoga', 'Yoga', '12345', '123', 'Test', 'test', 'Laki-Laki', '-', '2005-06-11', 11, 11, 'Ada', '12', '1234', 'Tidak', '10', '2024-06-11', 'test', 'test', '2024-06-11', 'Test', 'Bukan MTB', 'Test', '2024-06-14', 1);

-- --------------------------------------------------------

--
-- Table structure for table `data_pmo`
--

CREATE TABLE `data_pmo` (
  `pmo_id` int(20) NOT NULL,
  `dp_id` int(20) NOT NULL,
  `pmo_nama` varchar(255) NOT NULL,
  `pmo_alamat` text NOT NULL,
  `pmo_fasyankes` varchar(255) NOT NULL,
  `pmo_kota` varchar(255) NOT NULL,
  `pmo_tbc3_faskes` varchar(5) NOT NULL DEFAULT '04',
  `pmo_tahun` year(4) NOT NULL,
  `pmo_provinsi` varchar(255) NOT NULL,
  `pmo_tbc3_kota` varchar(5) NOT NULL DEFAULT '05',
  `pmo_telpon` varchar(16) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `data_pmo`
--

INSERT INTO `data_pmo` (`pmo_id`, `dp_id`, `pmo_nama`, `pmo_alamat`, `pmo_fasyankes`, `pmo_kota`, `pmo_tbc3_faskes`, `pmo_tahun`, `pmo_provinsi`, `pmo_tbc3_kota`, `pmo_telpon`) VALUES
(1, 1, 'Testing PMO', 'PMO Alamat', 'UUwee', 'Testing Kota', 'Data ', '2020', 'Jakarda', 'Data ', '12345'),
(2, 2, 'Testing PMO', 'Jalan', 'Fasyankes', 'Kota', 'Test1', '2024', 'Sumsel', 'Test1', 'Sumsel'),
(3, 3, 'Testing', 'Testing Alamat PMO', 'Testing Fasyankes', 'Testing Kota PMO', 'Testi', '2024', 'Testing Provinsi', 'Testi', '12341231321'),
(11, 11, 'Test', 'Test', 'Test', 'Test', '04', '2000', 'Test', '05', 'Test');

-- --------------------------------------------------------

--
-- Table structure for table `data_user`
--

CREATE TABLE `data_user` (
  `id_user` int(20) NOT NULL,
  `nama_user` varchar(255) NOT NULL,
  `username_user` varchar(255) NOT NULL,
  `password_user` text NOT NULL,
  `role_user` enum('user','admin') NOT NULL,
  `status_user` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `data_user`
--

INSERT INTO `data_user` (`id_user`, `nama_user`, `username_user`, `password_user`, `role_user`, `status_user`) VALUES
(1, 'Herlina, S.Kep., Ners', 'herlina', '$2y$10$cEOgb.xmry/Kraq4TtqsdO7wnwS4wC1hHQdevQn1iZYc/6LQUApTi', 'user', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `data_input_pasien`
--
ALTER TABLE `data_input_pasien`
  ADD PRIMARY KEY (`dip_id`);

--
-- Indexes for table `data_pasien`
--
ALTER TABLE `data_pasien`
  ADD PRIMARY KEY (`dp_id`);

--
-- Indexes for table `data_pmo`
--
ALTER TABLE `data_pmo`
  ADD PRIMARY KEY (`pmo_id`);

--
-- Indexes for table `data_user`
--
ALTER TABLE `data_user`
  ADD PRIMARY KEY (`id_user`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `data_input_pasien`
--
ALTER TABLE `data_input_pasien`
  MODIFY `dip_id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `data_pasien`
--
ALTER TABLE `data_pasien`
  MODIFY `dp_id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `data_pmo`
--
ALTER TABLE `data_pmo`
  MODIFY `pmo_id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `data_user`
--
ALTER TABLE `data_user`
  MODIFY `id_user` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
