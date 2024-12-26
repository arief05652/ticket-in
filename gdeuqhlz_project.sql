-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Dec 26, 2024 at 02:56 AM
-- Server version: 8.0.30
-- PHP Version: 8.3.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `gdeuqhlz_project`
--
CREATE DATABASE IF NOT EXISTS `gdeuqhlz_project` DEFAULT CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci;
USE `gdeuqhlz_project`;

-- --------------------------------------------------------

--
-- Table structure for table `balance`
--

CREATE TABLE `balance` (
  `balance_id` int NOT NULL,
  `user_id` int NOT NULL,
  `balance` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `balance`
--

INSERT INTO `balance` (`balance_id`, `user_id`, `balance`) VALUES
(9, 9, '35000.00'),
(10, 10, '35000.00');

-- --------------------------------------------------------

--
-- Table structure for table `bis`
--

CREATE TABLE `bis` (
  `bis_id` int NOT NULL,
  `merk` varchar(20) NOT NULL,
  `kapasitas` int NOT NULL,
  `plat_nomor` varchar(15) NOT NULL,
  `status` enum('tidak','aktif') NOT NULL DEFAULT 'tidak'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `bis`
--

INSERT INTO `bis` (`bis_id`, `merk`, `kapasitas`, `plat_nomor`, `status`) VALUES
(4, 'Hyundai', 31, 'AD 7263 B', 'aktif'),
(6, 'Nissan', 20, 'ES 1382 T', 'tidak'),
(7, 'Nissan', 20, 'FR 1382 T', 'aktif');

-- --------------------------------------------------------

--
-- Stand-in structure for view `cek_balance_user`
-- (See below for the actual view)
--
CREATE TABLE `cek_balance_user` (
`user_id` int
,`email` varchar(255)
,`nama_lengkap` varchar(101)
,`balance` decimal(10,2)
);

-- --------------------------------------------------------

--
-- Table structure for table `history_topup`
--

CREATE TABLE `history_topup` (
  `ht_id` int NOT NULL,
  `user_id` int NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `status` enum('berhasil','cancel','tolak') DEFAULT NULL,
  `waktu` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `history_topup`
--

INSERT INTO `history_topup` (`ht_id`, `user_id`, `amount`, `status`, `waktu`) VALUES
(4, 10, '20000.00', 'berhasil', '2024-12-08 09:58:04'),
(5, 10, '5000.00', 'berhasil', '2024-12-08 10:58:48'),
(6, 10, '5000.00', 'tolak', '2024-12-08 12:04:18'),
(7, 10, '5000.00', 'berhasil', '2024-12-09 03:12:07'),
(8, 10, '30000.00', 'berhasil', '2024-12-14 01:40:32');

-- --------------------------------------------------------

--
-- Table structure for table `jadwal`
--

CREATE TABLE `jadwal` (
  `jadwal_id` int NOT NULL,
  `rute_id` int NOT NULL,
  `bis_id` int NOT NULL,
  `jam_berangkat` datetime NOT NULL,
  `status` enum('tidak','aktif') NOT NULL DEFAULT 'tidak'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `jadwal`
--

INSERT INTO `jadwal` (`jadwal_id`, `rute_id`, `bis_id`, `jam_berangkat`, `status`) VALUES
(11, 7, 6, '2024-12-11 13:01:00', 'aktif'),
(12, 8, 4, '2024-12-10 09:30:00', 'aktif'),
(13, 8, 7, '2024-12-19 08:37:00', 'aktif'),
(14, 8, 7, '2024-12-19 08:37:00', 'tidak'),
(15, 8, 7, '2024-12-19 08:37:00', 'tidak');

--
-- Triggers `jadwal`
--
DELIMITER $$
CREATE TRIGGER `jadwal_AFTER_DELETE_1` AFTER DELETE ON `jadwal` FOR EACH ROW BEGIN
	UPDATE bis
    SET status = 'tidak'
    WHERE bis_id = OLD.bis_id;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `jadwal_AFTER_INSERT_1` AFTER INSERT ON `jadwal` FOR EACH ROW BEGIN
	UPDATE bis 
    SET status = 'aktif'
    WHERE bis_id = NEW.bis_id;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `pesanan`
--

CREATE TABLE `pesanan` (
  `pesanan_id` int NOT NULL,
  `tiket_id` int NOT NULL,
  `user_id` int NOT NULL,
  `jumlah` int NOT NULL DEFAULT '1',
  `waktu_pesanan` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `pesanan`
--

INSERT INTO `pesanan` (`pesanan_id`, `tiket_id`, `user_id`, `jumlah`, `waktu_pesanan`) VALUES
(29, 11, 10, 1, '2024-12-14 01:37:17');

--
-- Triggers `pesanan`
--
DELIMITER $$
CREATE TRIGGER `pesanan_AFTER_INSERT_1` AFTER INSERT ON `pesanan` FOR EACH ROW BEGIN
    INSERT INTO user_pesanan (pesanan_id, status)
    VALUES (NEW.pesanan_id, 'berhasil');
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Stand-in structure for view `pesanan_tiket_user`
-- (See below for the actual view)
--
CREATE TABLE `pesanan_tiket_user` (
`user_id` int
,`email` varchar(255)
,`tujuan` varchar(45)
,`keberangkatan` datetime
,`harga_satuan` int
,`jumlah_tiket` int
,`total_harga` bigint
,`status_pesanan` enum('berhasil','cancel')
,`pemesanan` timestamp
);

-- --------------------------------------------------------

--
-- Table structure for table `rute`
--

CREATE TABLE `rute` (
  `rute_id` int NOT NULL,
  `tujuan` varchar(45) NOT NULL,
  `titik_penjemputan` text NOT NULL,
  `titik_penurunan` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `rute`
--

INSERT INTO `rute` (`rute_id`, `tujuan`, `titik_penjemputan`, `titik_penurunan`) VALUES
(7, 'Karawang - Bandung', 'Terminal klari', 'Terminal gedung sate'),
(8, 'Jakarta - Surabaya', '...', '...');

-- --------------------------------------------------------

--
-- Table structure for table `status_topup`
--

CREATE TABLE `status_topup` (
  `st_id` int NOT NULL,
  `tb_id` int NOT NULL,
  `status` enum('cancel','proses','berhasil','tolak') DEFAULT 'proses'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Triggers `status_topup`
--
DELIMITER $$
CREATE TRIGGER `status_topup_AFTER_UPDATE_1` AFTER UPDATE ON `status_topup` FOR EACH ROW BEGIN
    -- user id & balance terakhir --
	DECLARE user_id INT;
    DECLARE balance DECIMAL(10, 2);
    DECLARE amount DECIMAL(10, 2);
    DECLARE total DECIMAL(10, 2);
    DECLARE waktu TIMESTAMP;
    
    -- ambil user id -- 
    SELECT tb.user_id, b.balance, tb.amount, tb.waktu 
    INTO user_id, balance, amount, waktu
    FROM topup_balance tb
    JOIN balance b ON b.balance_id = tb.balance_id
    LIMIT 1;
    
    SET total = balance + amount;
    
    IF NEW.status IN ('tolak', 'cancel') THEN
		-- insert to history topup --
		INSERT INTO history_topup (user_id, amount, status, waktu)
        VALUES (user_id, amount, NEW.status, waktu);
        -- delete row --
        DELETE FROM topup_balance tb
        WHERE tb_id = NEW.tb_id;
    END IF;
    
	IF NEW.status = 'berhasil' THEN
		-- insert to history topup --
		INSERT INTO history_topup (user_id, amount, status, waktu)
        VALUES (user_id, amount, NEW.status, waktu);
        -- update balance --
        UPDATE balance
        SET balance = balance + amount
        WHERE user_id = user_id;
        -- delete row --
        DELETE FROM topup_balance tb
        WHERE tb_id = NEW.tb_id;
    END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `tiket`
--

CREATE TABLE `tiket` (
  `tiket_id` int NOT NULL,
  `jadwal_id` int NOT NULL,
  `harga` int NOT NULL,
  `stok` int NOT NULL,
  `status` enum('draft','public') NOT NULL DEFAULT 'draft'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `tiket`
--

INSERT INTO `tiket` (`tiket_id`, `jadwal_id`, `harga`, `stok`, `status`) VALUES
(10, 11, 20000, 14, 'public'),
(11, 12, 25000, 18, 'draft'),
(12, 11, 25000, 31, 'draft'),
(13, 13, 25000, 31, 'draft');

--
-- Triggers `tiket`
--
DELIMITER $$
CREATE TRIGGER `tiket_AFTER_DELETE_1` AFTER DELETE ON `tiket` FOR EACH ROW BEGIN
	UPDATE jadwal 
    SET status = 'tidak'
    WHERE jadwal_id = OLD.jadwal_id;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `tiket_AFTER_INSERT_1` AFTER INSERT ON `tiket` FOR EACH ROW BEGIN
	UPDATE jadwal 
    SET status = 'aktif'
    WHERE jadwal_id = NEW.jadwal_id;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `topup_balance`
--

CREATE TABLE `topup_balance` (
  `tb_id` int NOT NULL,
  `user_id` int NOT NULL,
  `balance_id` int NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `waktu` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Triggers `topup_balance`
--
DELIMITER $$
CREATE TRIGGER `topup_balance_AFTER_INSERT_1` AFTER INSERT ON `topup_balance` FOR EACH ROW BEGIN
	INSERT INTO status_topup (tb_id, status)
    VALUES (NEW.tb_id, 'proses');
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `nama_dpn` varchar(50) NOT NULL,
  `nama_blkg` varchar(50) NOT NULL,
  `no_hp` varchar(30) DEFAULT NULL,
  `role` enum('pelanggan','admin') NOT NULL DEFAULT 'pelanggan',
  `join_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `email`, `password`, `nama_dpn`, `nama_blkg`, `no_hp`, `role`, `join_at`) VALUES
(9, 'arief@gmail.com', '$2y$10$S4Xh6H1F5wR.YLUfQnq4TOzYVaEjQ3DNEtmoyWU14i2U1MUtbcxky', 'arief', 'minardi', NULL, 'admin', '2024-11-30 13:05:23'),
(10, 'ariefminardi1928@gmail.com', '$2y$10$/gLeQwtpKLqavOvBtzq8He5nkZUZ39V1/G7Y1dUZtXYuGqT.n9Qa.', 'arief', 'minardi', NULL, 'pelanggan', '2024-12-01 12:27:04');

--
-- Triggers `users`
--
DELIMITER $$
CREATE TRIGGER `users_AFTER_INSERT_1` AFTER INSERT ON `users` FOR EACH ROW BEGIN
	INSERT INTO balance (user_id, balance)
    VALUES (NEW.user_id, 0);
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `user_pesanan`
--

CREATE TABLE `user_pesanan` (
  `up_id` int NOT NULL,
  `pesanan_id` int NOT NULL,
  `status` enum('berhasil','cancel') DEFAULT 'berhasil'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `user_pesanan`
--

INSERT INTO `user_pesanan` (`up_id`, `pesanan_id`, `status`) VALUES
(27, 29, 'berhasil');

--
-- Triggers `user_pesanan`
--
DELIMITER $$
CREATE TRIGGER `user_pesanan_AFTER_UPDATE_1` AFTER UPDATE ON `user_pesanan` FOR EACH ROW BEGIN 
	DECLARE user_id INT; 
    DECLARE tiket_id INT;
    DECLARE jumlah INT;
    DECLARE total DECIMAL(10, 2);
    DECLARE harga INT;
    
    -- get total di tiket --
    SELECT t.harga INTO harga 
    FROM tiket t
    JOIN pesanan p ON p.tiket_id = t.tiket_id
    LIMIT 1;
    
    -- mengambil id user dari pesanan --
	SELECT p.user_id, p.tiket_id, p.jumlah INTO user_id, tiket_id, jumlah
    FROM pesanan p
    JOIN tiket t ON t.tiket_id = p.tiket_id
    WHERE p.pesanan_id = NEW.pesanan_id
    LIMIT 1;
    
    -- set total harga --
    SET total = harga * jumlah;
    
    IF NEW.status = 'cancel' THEN
		-- update balance user --
		UPDATE balance
        SET balance = balance + total
        WHERE user_id = user_id;
	END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Structure for view `cek_balance_user`
--
DROP TABLE IF EXISTS `cek_balance_user`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `cek_balance_user`  AS SELECT `us`.`user_id` AS `user_id`, `us`.`email` AS `email`, concat(`us`.`nama_dpn`,' ',`us`.`nama_blkg`) AS `nama_lengkap`, `bl`.`balance` AS `balance` FROM (`users` `us` join `balance` `bl` on((`bl`.`user_id` = `us`.`user_id`)))  ;

-- --------------------------------------------------------

--
-- Structure for view `pesanan_tiket_user`
--
DROP TABLE IF EXISTS `pesanan_tiket_user`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `pesanan_tiket_user`  AS SELECT `u`.`user_id` AS `user_id`, `u`.`email` AS `email`, `r`.`tujuan` AS `tujuan`, `j`.`jam_berangkat` AS `keberangkatan`, `t`.`harga` AS `harga_satuan`, `p`.`jumlah` AS `jumlah_tiket`, (`t`.`harga` * `p`.`jumlah`) AS `total_harga`, `up`.`status` AS `status_pesanan`, `p`.`waktu_pesanan` AS `pemesanan` FROM (((((`pesanan` `p` join `users` `u` on((`u`.`user_id` = `p`.`user_id`))) join `user_pesanan` `up` on((`p`.`pesanan_id` = `up`.`pesanan_id`))) join `tiket` `t` on((`t`.`tiket_id` = `p`.`tiket_id`))) join `jadwal` `j` on((`j`.`jadwal_id` = `t`.`jadwal_id`))) join `rute` `r` on((`r`.`rute_id` = `j`.`rute_id`)))  ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `balance`
--
ALTER TABLE `balance`
  ADD PRIMARY KEY (`balance_id`),
  ADD KEY `fk_balance_users1_idx` (`user_id`);

--
-- Indexes for table `bis`
--
ALTER TABLE `bis`
  ADD PRIMARY KEY (`bis_id`);

--
-- Indexes for table `history_topup`
--
ALTER TABLE `history_topup`
  ADD PRIMARY KEY (`ht_id`),
  ADD KEY `fk_history_topup_users1_idx` (`user_id`);

--
-- Indexes for table `jadwal`
--
ALTER TABLE `jadwal`
  ADD PRIMARY KEY (`jadwal_id`),
  ADD KEY `fk_jadwal_rute1_idx` (`rute_id`),
  ADD KEY `fk_jadwal_bis1_idx` (`bis_id`);

--
-- Indexes for table `pesanan`
--
ALTER TABLE `pesanan`
  ADD PRIMARY KEY (`pesanan_id`),
  ADD KEY `fk_pesanan_users_idx` (`user_id`),
  ADD KEY `fk_pesanan_tiket1_idx` (`tiket_id`);

--
-- Indexes for table `rute`
--
ALTER TABLE `rute`
  ADD PRIMARY KEY (`rute_id`);

--
-- Indexes for table `status_topup`
--
ALTER TABLE `status_topup`
  ADD PRIMARY KEY (`st_id`),
  ADD KEY `fk_status_topup_topup_balance1_idx` (`tb_id`);

--
-- Indexes for table `tiket`
--
ALTER TABLE `tiket`
  ADD PRIMARY KEY (`tiket_id`),
  ADD KEY `fk_tiket_jadwal1_idx` (`jadwal_id`);

--
-- Indexes for table `topup_balance`
--
ALTER TABLE `topup_balance`
  ADD PRIMARY KEY (`tb_id`),
  ADD KEY `fk_topup_balance_users1_idx` (`user_id`),
  ADD KEY `fk_topup_balance_balance1_idx` (`balance_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `user_pesanan`
--
ALTER TABLE `user_pesanan`
  ADD PRIMARY KEY (`up_id`),
  ADD KEY `fk_user_pesanan_pesanan1_idx` (`pesanan_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `balance`
--
ALTER TABLE `balance`
  MODIFY `balance_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `bis`
--
ALTER TABLE `bis`
  MODIFY `bis_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `history_topup`
--
ALTER TABLE `history_topup`
  MODIFY `ht_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `jadwal`
--
ALTER TABLE `jadwal`
  MODIFY `jadwal_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `pesanan`
--
ALTER TABLE `pesanan`
  MODIFY `pesanan_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `rute`
--
ALTER TABLE `rute`
  MODIFY `rute_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `status_topup`
--
ALTER TABLE `status_topup`
  MODIFY `st_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `tiket`
--
ALTER TABLE `tiket`
  MODIFY `tiket_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `topup_balance`
--
ALTER TABLE `topup_balance`
  MODIFY `tb_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `user_pesanan`
--
ALTER TABLE `user_pesanan`
  MODIFY `up_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `balance`
--
ALTER TABLE `balance`
  ADD CONSTRAINT `fk_balance_users1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `history_topup`
--
ALTER TABLE `history_topup`
  ADD CONSTRAINT `fk_history_topup_users1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `jadwal`
--
ALTER TABLE `jadwal`
  ADD CONSTRAINT `fk_jadwal_bis1` FOREIGN KEY (`bis_id`) REFERENCES `bis` (`bis_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_jadwal_rute1` FOREIGN KEY (`rute_id`) REFERENCES `rute` (`rute_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `pesanan`
--
ALTER TABLE `pesanan`
  ADD CONSTRAINT `fk_pesanan_tiket1` FOREIGN KEY (`tiket_id`) REFERENCES `tiket` (`tiket_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_pesanan_users` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `status_topup`
--
ALTER TABLE `status_topup`
  ADD CONSTRAINT `fk_status_topup_topup_balance1` FOREIGN KEY (`tb_id`) REFERENCES `topup_balance` (`tb_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tiket`
--
ALTER TABLE `tiket`
  ADD CONSTRAINT `fk_tiket_jadwal1` FOREIGN KEY (`jadwal_id`) REFERENCES `jadwal` (`jadwal_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `topup_balance`
--
ALTER TABLE `topup_balance`
  ADD CONSTRAINT `fk_topup_balance_balance1` FOREIGN KEY (`balance_id`) REFERENCES `balance` (`balance_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_topup_balance_users1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `user_pesanan`
--
ALTER TABLE `user_pesanan`
  ADD CONSTRAINT `fk_user_pesanan_pesanan1` FOREIGN KEY (`pesanan_id`) REFERENCES `pesanan` (`pesanan_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
