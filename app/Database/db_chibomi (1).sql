-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 04, 2025 at 06:12 PM
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
-- Database: `db_chibomi`
--

-- --------------------------------------------------------

--
-- Table structure for table `accounts`
--

CREATE TABLE `accounts` (
  `id_account` varchar(36) NOT NULL,
  `email` varchar(255) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `status_akun` enum('Aktif','Blokir','EmailVerif') NOT NULL DEFAULT 'EmailVerif',
  `telepon` varchar(20) NOT NULL,
  `foto_profil` varchar(255) DEFAULT NULL,
  `role` enum('Pemilik','Admin','Pelanggan') NOT NULL DEFAULT 'Pelanggan',
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `accounts`
--

INSERT INTO `accounts` (`id_account`, `email`, `nama`, `status_akun`, `telepon`, `foto_profil`, `role`, `password`) VALUES
('75805e87-989f-4094-9249-462c2c7cfc8f', 'ganylagi@gmail.com', 'Gany (Pelanggan)', 'Aktif', '098765445678', NULL, 'Pelanggan', '$2y$10$DZ/wQ3AUUvxxFXQTKmQoe.aQks/UNgvNTV53QwcJrIb.0kHsHi5o.'),
('bbb18f1a-74d3-4b68-b33b-1e65a2f5109c', 'tugasgany@gmail.com', 'Gany (Admin)', 'Aktif', '087654321099', NULL, 'Admin', '$2y$10$s1ujygEqFsaMPYBEwUyJdun61ZO0qjTs7EGd5v6dmjVsC/4eDskn.'),
('f208fcc2-2160-44e1-9bf2-7b1b5c0a618d', 'ganyandisa11@gmail.com', 'Gany Andisa', 'Aktif', '087654321099', NULL, 'Pemilik', '$2y$10$sl0t1RtV1Zax68rh2spwReN43SWslD8SNQoOdw2pdqZwqgXBwmozW');

-- --------------------------------------------------------

--
-- Table structure for table `addresses`
--

CREATE TABLE `addresses` (
  `id_address` varchar(36) NOT NULL,
  `id_account` varchar(36) NOT NULL,
  `nama_penerima` varchar(255) NOT NULL,
  `telp_penerima` varchar(20) NOT NULL,
  `alamat_lengkap` text NOT NULL,
  `provinsi` varchar(255) NOT NULL,
  `kota_kabupaten` varchar(255) NOT NULL,
  `kecamatan` varchar(255) NOT NULL,
  `kelurahan` varchar(255) NOT NULL,
  `kode_pos` varchar(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `addresses`
--

INSERT INTO `addresses` (`id_address`, `id_account`, `nama_penerima`, `telp_penerima`, `alamat_lengkap`, `provinsi`, `kota_kabupaten`, `kecamatan`, `kelurahan`, `kode_pos`) VALUES
('333b5d7d-51a5-428d-93e8-86e2c256e1e5', '75805e87-989f-4094-9249-462c2c7cfc8f', 'Gany Andisa', '087654321099', 'Alamat 2', 'DKI JAKARTA', 'JAKARTA BARAT', 'PALMERAH', 'SLIPI', '11410'),
('7a0ef41f-f95d-41bd-8f23-3343e92c62a1', '75805e87-989f-4094-9249-462c2c7cfc8f', 'Gany Andisa', '087654321099', 'Alamat 3', 'DKI JAKARTA', 'JAKARTA BARAT', 'PALMERAH', 'SLIPI', '11410');

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `id_cart` varchar(36) NOT NULL,
  `id_account` varchar(36) NOT NULL,
  `id_product` varchar(36) NOT NULL,
  `qty` int(11) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `comment_portofolio`
--

CREATE TABLE `comment_portofolio` (
  `id_comment_portofolio` varchar(36) NOT NULL,
  `id_portofolio` varchar(36) NOT NULL,
  `komentar` varchar(255) DEFAULT NULL,
  `rating` int(1) DEFAULT NULL,
  `id_account` varchar(36) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `comment_portofolio`
--

INSERT INTO `comment_portofolio` (`id_comment_portofolio`, `id_portofolio`, `komentar`, `rating`, `id_account`) VALUES
('18a4bccc-27bc-415f-ac4c-58b37a3b4805', '350cb53a-40b2-480b-9681-1909cb8cb347', 'Wowww', 5, '75805e87-989f-4094-9249-462c2c7cfc8f');

-- --------------------------------------------------------

--
-- Table structure for table `delivery_service`
--

CREATE TABLE `delivery_service` (
  `id_delivery_service` varchar(36) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `kode` varchar(255) NOT NULL,
  `status` enum('Aktif','Pasif') NOT NULL DEFAULT 'Aktif'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `delivery_service`
--

INSERT INTO `delivery_service` (`id_delivery_service`, `nama`, `kode`, `status`) VALUES
('695cb56b-d347-4060-a880-91ea83e86f92', 'JNE', 'jne', 'Aktif'),
('86ac2046-68ee-4221-bd88-aef332cd5f26', 'JNT', 'jnt', 'Aktif');

-- --------------------------------------------------------

--
-- Table structure for table `dokumen_jasa`
--

CREATE TABLE `dokumen_jasa` (
  `id_dokumen_jasa` varchar(36) NOT NULL,
  `id_transaksi` varchar(36) NOT NULL,
  `url_dokumen` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `dokumen_jasa`
--

INSERT INTO `dokumen_jasa` (`id_dokumen_jasa`, `id_transaksi`, `url_dokumen`) VALUES
('c98356a9-64b4-4010-9ec2-06d693a79cde', '8f111465-a2f2-4f04-a763-cfccf2744f1a', 'http://localhost:8081/admin/transaksi/detail/8f111465-a2f2-4f04-a763-cfccf2744f1a');

-- --------------------------------------------------------

--
-- Table structure for table `hist_search`
--

CREATE TABLE `hist_search` (
  `id_hist_search` varchar(36) NOT NULL,
  `id_account` varchar(36) NOT NULL,
  `tanggal` datetime NOT NULL,
  `search` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `hist_search`
--

INSERT INTO `hist_search` (`id_hist_search`, `id_account`, `tanggal`, `search`) VALUES
('b6fa07da-ba5b-40b9-aa00-38d648ca9b21', '75805e87-989f-4094-9249-462c2c7cfc8f', '2025-05-03 16:09:46', 'barang');

-- --------------------------------------------------------

--
-- Table structure for table `images`
--

CREATE TABLE `images` (
  `id_images` varchar(36) NOT NULL,
  `id_product` varchar(36) NOT NULL,
  `file` varchar(255) NOT NULL,
  `alt` varchar(255) DEFAULT NULL,
  `keterangan` enum('Cover','Pendukung') NOT NULL DEFAULT 'Pendukung'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `images`
--

INSERT INTO `images` (`id_images`, `id_product`, `file`, `alt`, `keterangan`) VALUES
('09d971ca-4d69-4759-9718-ed36a5ba9013', '31e1ec26-a379-4bfb-9398-3f081dc0f68b', '31e1ec26-a379-4bfb-9398-3f081dc0f68b_1746246908.png', 'AAAAAAAAA', 'Cover'),
('109c9da2-856a-4f6c-99b2-16ecb463d60c', '9e2fdef8-039b-4aa1-bcaf-a46a8ba505db', '9e2fdef8-039b-4aa1-bcaf-a46a8ba505db_1746250677.png', 'Jasa 1', 'Pendukung'),
('1abdae0c-275e-4753-a79d-865c0ddd2fb0', '5fba1500-f980-454a-8d89-90a0297fdd9f', '5fba1500-f980-454a-8d89-90a0297fdd9f_1746247453.png', 'AA', 'Cover'),
('2542dfe8-6638-4139-9658-c521b29a8d09', '5fba1500-f980-454a-8d89-90a0297fdd9f', '5fba1500-f980-454a-8d89-90a0297fdd9f_1746250175.png', 'AA', 'Pendukung'),
('35513159-6b4b-4ee6-95c9-b492f84e6226', '5fba1500-f980-454a-8d89-90a0297fdd9f', '5fba1500-f980-454a-8d89-90a0297fdd9f_1746250175.png', 'AA', 'Pendukung'),
('3a6704aa-62a7-44d5-af48-91791b2cab38', 'bede9c83-6ac5-4f81-8f9c-95aa9591d865', 'bede9c83-6ac5-4f81-8f9c-95aa9591d865_1746247278.png', 'qqqqqq', 'Cover'),
('52725388-a2ff-40ba-8175-2af32f617f3e', '9e2fdef8-039b-4aa1-bcaf-a46a8ba505db', '9e2fdef8-039b-4aa1-bcaf-a46a8ba505db_1746250677.png', 'Jasa 1', 'Pendukung'),
('726c2036-6af7-4501-a156-cb22184eae5d', '5fba1500-f980-454a-8d89-90a0297fdd9f', '5fba1500-f980-454a-8d89-90a0297fdd9f_1746250175.png', 'AA', 'Pendukung'),
('7eaff27f-d173-4f8a-ad02-1dc6e4568158', '9e2fdef8-039b-4aa1-bcaf-a46a8ba505db', '9e2fdef8-039b-4aa1-bcaf-a46a8ba505db_1746250677.png', 'Jasa 1', 'Pendukung'),
('cad14c6c-b951-41a3-93a1-528b25ba26ad', 'ef9fcaeb-3400-4038-a515-225c756bd25d', 'ef9fcaeb-3400-4038-a515-225c756bd25d_1746109737.png', 'Barang 1', 'Cover'),
('ccd0e0cf-2c17-4ba4-9ae5-fc93f25ca082', '9e2fdef8-039b-4aa1-bcaf-a46a8ba505db', '9e2fdef8-039b-4aa1-bcaf-a46a8ba505db_1746250677.png', 'Jasa 1', 'Pendukung'),
('d54cb4eb-38dd-46f5-904e-63691fd0a708', '5fba1500-f980-454a-8d89-90a0297fdd9f', '5fba1500-f980-454a-8d89-90a0297fdd9f_1746250175.png', 'AA', 'Pendukung'),
('dbf75863-1dc3-43ac-abf5-13c17c4d0482', 'f528c7c5-39dc-44e9-928c-fe02457281b0', 'f528c7c5-39dc-44e9-928c-fe02457281b0_1746246488.png', 'Barang 3', 'Cover'),
('ec044e6f-d4d3-4e9a-b9d7-83215113c33b', 'f2d14b53-3909-4183-8390-7d225ab337db', 'f2d14b53-3909-4183-8390-7d225ab337db_1746109904.png', 'Barang 2', 'Cover'),
('f331b131-5919-47ef-9815-6a8e472cded3', '9e2fdef8-039b-4aa1-bcaf-a46a8ba505db', '9e2fdef8-039b-4aa1-bcaf-a46a8ba505db_1746250677.png', 'Jasa 1', 'Pendukung'),
('f697ef5c-b620-4c28-8ab6-9e9fcfbdc891', '5fba1500-f980-454a-8d89-90a0297fdd9f', '5fba1500-f980-454a-8d89-90a0297fdd9f_1746250175.png', 'AA', 'Pendukung');

-- --------------------------------------------------------

--
-- Table structure for table `images_portofolio`
--

CREATE TABLE `images_portofolio` (
  `id_images_portofolio` varchar(36) NOT NULL,
  `id_portofolio` varchar(36) NOT NULL,
  `file` varchar(255) NOT NULL,
  `alt` varchar(255) DEFAULT NULL,
  `keterangan` enum('Cover','Pendukung') NOT NULL DEFAULT 'Pendukung'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `images_portofolio`
--

INSERT INTO `images_portofolio` (`id_images_portofolio`, `id_portofolio`, `file`, `alt`, `keterangan`) VALUES
('10d74909-aba5-421a-ba1e-7fb2c25aa921', '350cb53a-40b2-480b-9681-1909cb8cb347', '350cb53a-40b2-480b-9681-1909cb8cb347_1745923007.png', 'aaaqqqqqqqqqqqq', 'Pendukung'),
('26e8f69c-f19d-4eef-bbce-9d891ed15d90', '5065c540-9ed2-4203-935d-54fe537248f3', '5065c540-9ed2-4203-935d-54fe537248f3_1745848174.png', 'AAAAAAAAAAAAAAAAssssssssssss sass\'s', 'Cover'),
('37bd07bc-c61d-4cc9-a193-64d533451ae0', '350cb53a-40b2-480b-9681-1909cb8cb347', '350cb53a-40b2-480b-9681-1909cb8cb347_1745923239.png', 'aaaqqqqqqqqqqqq', 'Pendukung'),
('47c69d02-a088-4acb-a4fa-671dd4acbdb4', '350cb53a-40b2-480b-9681-1909cb8cb347', '350cb53a-40b2-480b-9681-1909cb8cb347_1745923239.png', 'aaaqqqqqqqqqqqq', 'Pendukung'),
('71302619-ad8b-491d-bfa5-7082598522a0', '350cb53a-40b2-480b-9681-1909cb8cb347', '350cb53a-40b2-480b-9681-1909cb8cb347_1745923007.png', 'aaaqqqqqqqqqqqq', 'Pendukung'),
('ab6132ce-edc8-4eaa-837a-7c5a15524cbd', '350cb53a-40b2-480b-9681-1909cb8cb347', '350cb53a-40b2-480b-9681-1909cb8cb347_1745923239.png', 'aaaqqqqqqqqqqqq', 'Pendukung'),
('d5fc5bb0-9e6b-42d1-b404-6fde20e58134', '350cb53a-40b2-480b-9681-1909cb8cb347', '350cb53a-40b2-480b-9681-1909cb8cb347_1745923239.png', 'aaaqqqqqqqqqqqq', 'Pendukung'),
('d683469e-0779-4d5e-b4b6-8fcce0533fd8', '350cb53a-40b2-480b-9681-1909cb8cb347', '350cb53a-40b2-480b-9681-1909cb8cb347_1745923005.png', 'aaaqqqqqqqqqqqq', 'Pendukung'),
('da69e098-6b5b-4d14-a5f3-208b3ab5888d', '350cb53a-40b2-480b-9681-1909cb8cb347', '350cb53a-40b2-480b-9681-1909cb8cb347_1745921307.png', 'aaaqqqqqqqqqqqq', 'Cover');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `version` varchar(255) NOT NULL,
  `class` varchar(255) NOT NULL,
  `group` varchar(255) NOT NULL,
  `namespace` varchar(255) NOT NULL,
  `time` int(11) NOT NULL,
  `batch` int(11) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `version`, `class`, `group`, `namespace`, `time`, `batch`) VALUES
(6, '2025-03-03-070258', 'App\\Database\\Migrations\\CreateAccountsTable', 'default', 'App', 1741587632, 1),
(7, '2025-03-03-070856', 'App\\Database\\Migrations\\CreateAddressesTable', 'default', 'App', 1741587632, 1),
(8, '2025-03-03-071405', 'App\\Database\\Migrations\\CreatePortofolioTable', 'default', 'App', 1741587632, 1),
(9, '2025-03-03-072055', 'App\\Database\\Migrations\\CreateHistSearchTable', 'default', 'App', 1741587632, 1),
(10, '2025-03-10-063052', 'App\\Database\\Migrations\\CreateCommentPortofolioTable', 'default', 'App', 1741589056, 2),
(11, '2025-03-10-064106', 'App\\Database\\Migrations\\CreateDeliveryServiceTable', 'default', 'App', 1741589056, 2),
(12, '2025-03-10-064623', 'App\\Database\\Migrations\\CreateViewPortfolioTable', 'default', 'App', 1741589223, 3),
(13, '2025-03-10-065526', 'App\\Database\\Migrations\\CreateProductsTable', 'default', 'App', 1741589804, 4),
(14, '2025-03-10-065920', 'App\\Database\\Migrations\\Stock', 'default', 'App', 1741590020, 5),
(15, '2025-03-10-070536', 'App\\Database\\Migrations\\Transaksi', 'default', 'App', 1741590389, 6),
(16, '2025-03-10-070853', 'App\\Database\\Migrations\\ViewProduct', 'default', 'App', 1741590562, 7),
(17, '2025-03-10-071136', 'App\\Database\\Migrations\\ProductSize', 'default', 'App', 1741590733, 8),
(18, '2025-03-10-071423', 'App\\Database\\Migrations\\CreateProductPriceTable', 'default', 'App', 1741590935, 9),
(19, '2025-03-10-071629', 'App\\Database\\Migrations\\CreateProductOrderTable', 'default', 'App', 1741591039, 10),
(20, '2025-03-10-071838', 'App\\Database\\Migrations\\CreatePengirimanTable', 'default', 'App', 1741591223, 11),
(21, '2025-03-10-072142', 'App\\Database\\Migrations\\CreatePaymentsTable', 'default', 'App', 1741591366, 12),
(22, '2025-03-10-072428', 'App\\Database\\Migrations\\CreateImagesPortofolioTable', 'default', 'App', 1741591529, 13),
(23, '2025-03-10-072621', 'App\\Database\\Migrations\\CreateImagesTable', 'default', 'App', 1741591696, 14),
(24, '2025-03-10-072913', 'App\\Database\\Migrations\\CreateDokumenJasaTable', 'default', 'App', 1741591805, 15),
(25, '2025-03-10-073107', 'App\\Database\\Migrations\\CreateCartTable', 'default', 'App', 1741591933, 16);

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `id_payments` varchar(36) NOT NULL,
  `id_transaksi` varchar(36) NOT NULL,
  `midtrans_transaction_id` varchar(255) NOT NULL,
  `payment_method` varchar(255) NOT NULL,
  `status_pembayaran` varchar(255) NOT NULL,
  `amount` decimal(15,2) NOT NULL,
  `fee` decimal(15,2) NOT NULL,
  `paid_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pengiriman`
--

CREATE TABLE `pengiriman` (
  `id_pengiriman` varchar(36) NOT NULL,
  `id_delivery_service` varchar(36) NOT NULL,
  `id_transaksi` varchar(36) NOT NULL,
  `nama_tujuan` varchar(255) NOT NULL,
  `telepon` varchar(20) NOT NULL,
  `alamat` text NOT NULL,
  `shipping_cost` decimal(15,2) NOT NULL,
  `resi` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pengiriman`
--

INSERT INTO `pengiriman` (`id_pengiriman`, `id_delivery_service`, `id_transaksi`, `nama_tujuan`, `telepon`, `alamat`, `shipping_cost`, `resi`) VALUES
('0092a9ff-0d6c-4041-9a9f-0fe24985360c', '86ac2046-68ee-4221-bd88-aef332cd5f26', 'b1a410a8-8193-4b4e-bf4e-9eb70a061f94', 'Gany Andisa', '087654321099', 'Alamat 3, SLIPI, PALMERAH, JAKARTA BARAT, DKI JAKARTA 11410', 55000.00, NULL),
('26d6f7e0-a793-456a-a102-c8c379b4329c', '86ac2046-68ee-4221-bd88-aef332cd5f26', '5935d175-0877-44e1-98ab-f26968fe2edf', 'Gany Andisa', '087654321099', 'Alamat 3, SLIPI, PALMERAH, JAKARTA BARAT, DKI JAKARTA 11410', 52000.00, NULL),
('3f53f675-7d1e-4ef0-9823-a126607120c6', '86ac2046-68ee-4221-bd88-aef332cd5f26', 'fb2201f2-980d-4c14-a0cd-a8aee213462f', 'Gany Andisa', '087654321099', 'Alamat 3, SLIPI, PALMERAH, JAKARTA BARAT, DKI JAKARTA 11410', 52000.00, NULL),
('47905ab9-eb87-4530-a72c-3b6f26ceed81', '86ac2046-68ee-4221-bd88-aef332cd5f26', 'b0e0a925-73c5-4aee-8915-ccb87a23d626', 'Gany Andisa', '087654321099', 'Alamat 2, SLIPI, PALMERAH, JAKARTA BARAT, DKI JAKARTA 11410', 52000.00, NULL),
('4b887598-0e04-4122-9afc-88950d43c242', '86ac2046-68ee-4221-bd88-aef332cd5f26', '7b28155b-4dbc-441e-812d-e5f9583c41fa', 'Gany Andisa', '087654321099', 'Alamat 2, SLIPI, PALMERAH, JAKARTA BARAT, DKI JAKARTA 11410', 52000.00, NULL),
('9b5cdca8-9f7b-43a5-abd1-85e17e2e5da1', '86ac2046-68ee-4221-bd88-aef332cd5f26', '303c612e-4a46-4b58-aa58-0bc89c008558', 'Gany Andisa', '087654321099', 'Alamat 3, SLIPI, PALMERAH, JAKARTA BARAT, DKI JAKARTA 11410', 52000.00, NULL),
('a4ad2744-1bb6-45a8-948d-a6da3cc32153', '86ac2046-68ee-4221-bd88-aef332cd5f26', 'cd76b2eb-9d7a-4f4d-b9dc-164074a6dce5', 'Gany Andisa', '087654321099', 'Alamat 2, SLIPI, PALMERAH, JAKARTA BARAT, DKI JAKARTA 11410', 52000.00, NULL),
('a98e6ad9-be4c-4132-b5ce-d9bd2a7ecf95', '86ac2046-68ee-4221-bd88-aef332cd5f26', '2ae60696-057a-4bc1-83c6-b5aa477862a4', 'Gany Andisa', '087654321099', 'Alamat 3, SLIPI, PALMERAH, JAKARTA BARAT, DKI JAKARTA 11410', 52000.00, NULL),
('c02c99c2-4564-4940-afd4-8d3e023c7217', '86ac2046-68ee-4221-bd88-aef332cd5f26', '43989b90-b26a-4e40-bfb8-3f156ed5b3d7', 'Gany Andisa', '087654321099', 'Alamat 2, SLIPI, PALMERAH, JAKARTA BARAT, DKI JAKARTA 11410', 52000.00, NULL),
('c4396140-557d-4bd2-bbe7-beedcde1a3c1', '86ac2046-68ee-4221-bd88-aef332cd5f26', '35209c9d-14c0-474b-b460-251a00e4f65f', 'Gany Andisa', '087654321099', 'Alamat 2, SLIPI, PALMERAH, JAKARTA BARAT, DKI JAKARTA 11410', 52000.00, NULL),
('d029745a-9372-4071-8c09-924963546b77', '86ac2046-68ee-4221-bd88-aef332cd5f26', 'bf7dc49f-b4d8-4826-b77b-96b3c55ec267', 'Gany Andisa', '087654321099', 'Alamat 2, SLIPI, PALMERAH, JAKARTA BARAT, DKI JAKARTA 11410', 55000.00, NULL),
('d41b4d90-5162-4db9-9c3a-ce794fe31ccf', '86ac2046-68ee-4221-bd88-aef332cd5f26', '7f25a559-8d9f-4fbf-9e3c-847a61b6f215', 'Gany Andisa', '087654321099', 'Alamat 3, SLIPI, PALMERAH, JAKARTA BARAT, DKI JAKARTA 11410', 52000.00, 'JX3856903654'),
('d9f03857-ade3-4ca7-bcef-edee6990d166', '86ac2046-68ee-4221-bd88-aef332cd5f26', '322198d7-05be-42a1-8eaa-60a0f6e0ac0c', 'Gany Andisa', '087654321099', 'Alamat 3, SLIPI, PALMERAH, JAKARTA BARAT, DKI JAKARTA 11410', 52000.00, 'JX3856903654');

-- --------------------------------------------------------

--
-- Table structure for table `portofolio`
--

CREATE TABLE `portofolio` (
  `id_portofolio` varchar(36) NOT NULL,
  `deskripsi` text NOT NULL,
  `klien` varchar(255) DEFAULT NULL,
  `kategori` varchar(255) DEFAULT NULL,
  `tools` varchar(255) DEFAULT NULL,
  `slug` varchar(255) NOT NULL,
  `tanggal_selesai` date DEFAULT NULL,
  `tanggal_mulai` date DEFAULT NULL,
  `drafted_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `judul` varchar(255) NOT NULL,
  `url_proyek` varchar(255) DEFAULT NULL,
  `status` enum('Proses','Selesai') NOT NULL DEFAULT 'Proses',
  `tag` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `portofolio`
--

INSERT INTO `portofolio` (`id_portofolio`, `deskripsi`, `klien`, `kategori`, `tools`, `slug`, `tanggal_selesai`, `tanggal_mulai`, `drafted_at`, `deleted_at`, `judul`, `url_proyek`, `status`, `tag`) VALUES
('2ae4b526-b00b-45ab-b732-9b77f29a6ddc', 'deskripsi', NULL, NULL, NULL, 'aaaaaaa', NULL, NULL, NULL, NULL, 'aaaaaaa', NULL, 'Proses', NULL),
('350cb53a-40b2-480b-9681-1909cb8cb347', '<p>Gany</p>', 'ABC', 'Stiker', 'Ghi,Jkl', 'aaaqqqqqqqqqqqq', NULL, NULL, NULL, NULL, 'aaaqqqqqqqqqqqq', 'http://localhost:8081/portofolio/detail/aaaqqqqqqqqqqqq', 'Proses', 'Abc,Def'),
('438efcf9-d296-4635-95a0-ce344af686c0', '<p>aaaa</p>', 'aaa', 'aaa', 'aa,aaa', 'aaaaaaaeee', NULL, '2025-04-29', NULL, NULL, 'aaaaaaaeee', 'aaa', 'Selesai', 'aaaa'),
('5065c540-9ed2-4203-935d-54fe537248f3', '<p>aaaaaaaaaaaa</p>', '', '', '', 'aaaaaaaaaaaaaaaassssssssssss-sasss', NULL, NULL, NULL, NULL, 'AAAAAAAAAAAAAAAAssssssssssss sass\'s', '', 'Selesai', ''),
('53f666be-1d40-4b12-aaa9-eb0e10090634', 'deskripsi', '', '', '', 'aaaaaaaaaaaaaaaassssssssssss-sssss', NULL, NULL, NULL, NULL, 'AAAAAAAAAAAAAAAAssssssssssss sssss', '', 'Selesai', ''),
('9799ec09-e843-4591-b019-59208face2d1', '<p>aaaaaaaaaaaaaaa</p>', '', '', '', 'aaaaaaaeeeaaaaaaaaaaaaaaaaaaaa', NULL, NULL, '2025-04-28 14:01:57', '2025-04-28 14:02:01', 'aaaaaaaeeeaaaaaaaaaaaaaaaaaaaa', '', 'Selesai', ''),
('9984579d-42f5-4803-a900-9c314341d05b', 'deskripsi', '', '', '', 'bbbbbbbbbbbb', NULL, NULL, NULL, NULL, 'bbbbbbbbbbbb', '', 'Proses', ''),
('a052c3e5-d286-4a61-8916-31bb30d5e520', 'deskripsi', '', '', '', 'aaaaaaa', NULL, NULL, NULL, NULL, 'aaaaaaa', '', 'Proses', ''),
('f840e707-954a-4d24-a29b-a343f7314bd3', '<p>nnnnnnnnnnnnn</p>', '', '', '', 'aaa', NULL, NULL, NULL, NULL, 'aaa', '', 'Proses', '');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id_product` varchar(36) NOT NULL,
  `jenis` enum('Barang','Jasa') NOT NULL DEFAULT 'Barang',
  `kategori` varchar(255) NOT NULL,
  `nama_produk` varchar(255) NOT NULL,
  `deskripsi` text NOT NULL,
  `tag` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `drafted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id_product`, `jenis`, `kategori`, `nama_produk`, `deskripsi`, `tag`, `slug`, `deleted_at`, `drafted_at`) VALUES
('31e1ec26-a379-4bfb-9398-3f081dc0f68b', 'Barang', 'aaaaaa', 'AAAAAAAAA', '<p>aaaaaa</p>', 'a,aa', 'aaaaaaaaa', '2025-05-03 11:45:12', '2025-05-03 11:35:08'),
('5fba1500-f980-454a-8d89-90a0297fdd9f', 'Barang', 'aaaa- tambahn', 'AA', '<p>aa - tambahan</p>', 'aaa,tambahan', 'aa', NULL, NULL),
('9e2fdef8-039b-4aa1-bcaf-a46a8ba505db', 'Jasa', 'Jasa 1-aaaa', 'Jasa 1', '<p>Jasa 1</p>', 'Tag', 'jasa-1', NULL, NULL),
('bede9c83-6ac5-4f81-8f9c-95aa9591d865', 'Barang', 'aaa', 'qqqqqq', '<p>aaaaa</p>', 'aaaa', 'qqqqqq', '2025-05-03 11:45:07', '2025-05-03 11:41:18'),
('ef9fcaeb-3400-4038-a515-225c756bd25d', 'Barang', 'Barang 1', 'Barang 1', '<p>Barang 1</p>', 'Barang,1', 'barang-1', '2025-05-01 21:35:16', '2025-05-01 21:35:12'),
('f2d14b53-3909-4183-8390-7d225ab337db', 'Barang', 'Barang 1', 'Barang 2', '<p>Barang 1</p>', 'Barang,1', 'barang-2', '2025-05-03 11:45:29', '2025-05-03 11:45:23'),
('f528c7c5-39dc-44e9-928c-fe02457281b0', 'Barang', 'Barang 3', 'Barang 3', '<p>Barang 3</p>', 'Barang,3', 'barang-3', '2025-05-03 11:45:18', '2025-05-03 11:28:08');

-- --------------------------------------------------------

--
-- Table structure for table `product_order`
--

CREATE TABLE `product_order` (
  `id_product_order` varchar(36) NOT NULL,
  `id_product` varchar(36) NOT NULL,
  `id_transaksi` varchar(36) NOT NULL,
  `qty` int(11) NOT NULL,
  `total_price` decimal(15,2) NOT NULL,
  `rating` int(11) DEFAULT NULL,
  `ulasan` varchar(255) DEFAULT NULL,
  `hide_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product_order`
--

INSERT INTO `product_order` (`id_product_order`, `id_product`, `id_transaksi`, `qty`, `total_price`, `rating`, `ulasan`, `hide_at`) VALUES
('02cd25ea-011a-49a2-8d86-9ee56a8013f0', '9e2fdef8-039b-4aa1-bcaf-a46a8ba505db', '64a53f5a-59c5-4e33-8c2f-04e5d19dbf63', 1, 100.00, NULL, NULL, NULL),
('0cde1774-6011-46c8-8ec7-973036b791f6', '9e2fdef8-039b-4aa1-bcaf-a46a8ba505db', 'cf6bc028-761e-4038-8a19-bef97cc6850c', 1, 100.00, NULL, NULL, NULL),
('103ac892-668e-40f9-a3fb-f0b314815e1f', '9e2fdef8-039b-4aa1-bcaf-a46a8ba505db', '0c97bde9-8b37-4ad8-986c-eacc63297fe5', 1, 100.00, NULL, NULL, NULL),
('11c3a6e6-014a-46b6-9449-823e510bde50', '5fba1500-f980-454a-8d89-90a0297fdd9f', '7b28155b-4dbc-441e-812d-e5f9583c41fa', 1, 3333.00, NULL, NULL, NULL),
('23587277-5f57-40f1-be10-f83c651217cb', '5fba1500-f980-454a-8d89-90a0297fdd9f', '322198d7-05be-42a1-8eaa-60a0f6e0ac0c', 1, 3333.00, NULL, NULL, NULL),
('321eae98-bcde-4f09-9ab1-026ca614878c', '5fba1500-f980-454a-8d89-90a0297fdd9f', '35209c9d-14c0-474b-b460-251a00e4f65f', 1, 3333.00, NULL, NULL, NULL),
('4606b9eb-47c7-44a9-bb20-9260ee895c56', '9e2fdef8-039b-4aa1-bcaf-a46a8ba505db', '0a3a0a0d-e302-439a-a932-23ad9f29dee5', 1, 100.00, NULL, NULL, NULL),
('5a6a1709-defd-4dbe-ad06-20c690697ac9', '9e2fdef8-039b-4aa1-bcaf-a46a8ba505db', '8a70df63-b816-49da-92ca-8867dfd2d705', 1, 100.00, NULL, NULL, NULL),
('696134ec-4245-490c-a855-bf88c13d229d', '5fba1500-f980-454a-8d89-90a0297fdd9f', '2ae60696-057a-4bc1-83c6-b5aa477862a4', 1, 3333.00, NULL, NULL, NULL),
('6a370614-5a2b-408f-943d-7e62f2481590', '5fba1500-f980-454a-8d89-90a0297fdd9f', '5935d175-0877-44e1-98ab-f26968fe2edf', 1, 3333.00, NULL, NULL, NULL),
('75eaf1f4-30cd-4063-943e-38ba643c49a9', '9e2fdef8-039b-4aa1-bcaf-a46a8ba505db', '1dca42a5-6655-4a12-aca1-bef5f80a8678', 1, 100.00, NULL, NULL, NULL),
('7c092701-2523-40cc-a5dc-a8c48a051ca9', '9e2fdef8-039b-4aa1-bcaf-a46a8ba505db', 'e8e1fe3d-8fb4-4483-80f8-376b9449aca9', 1, 5000.00, NULL, NULL, NULL),
('7efe445b-a924-4b3d-9f96-b0259349365a', '9e2fdef8-039b-4aa1-bcaf-a46a8ba505db', '8f111465-a2f2-4f04-a763-cfccf2744f1a', 2, 40000.00, 5, 'Wow', '2025-05-04 17:08:57'),
('989e78ce-27ca-41ae-b1c8-9c85446d9f87', '5fba1500-f980-454a-8d89-90a0297fdd9f', 'bf7dc49f-b4d8-4826-b77b-96b3c55ec267', 2, 6666.00, NULL, NULL, NULL),
('9ac1ce0d-ddb8-46f4-a148-2012acc8b3e8', '5fba1500-f980-454a-8d89-90a0297fdd9f', 'b1a410a8-8193-4b4e-bf4e-9eb70a061f94', 2, 6666.00, NULL, NULL, NULL),
('9c2c4e4f-0849-4d48-8f14-52393b9e90df', '5fba1500-f980-454a-8d89-90a0297fdd9f', 'cd76b2eb-9d7a-4f4d-b9dc-164074a6dce5', 1, 3333.00, NULL, NULL, NULL),
('a1b7dd1c-6892-4519-a7aa-30c6a0feabb0', '9e2fdef8-039b-4aa1-bcaf-a46a8ba505db', 'c6b1be94-ad7f-46a1-81d0-84b21e543a8e', 1, 100.00, NULL, NULL, NULL),
('ab429a85-6889-4fed-9904-5f66004946bc', '5fba1500-f980-454a-8d89-90a0297fdd9f', 'b0e0a925-73c5-4aee-8915-ccb87a23d626', 1, 3333.00, NULL, NULL, NULL),
('c9f3f8bc-f9af-49cf-be3f-1f98e259bc14', '5fba1500-f980-454a-8d89-90a0297fdd9f', 'fb2201f2-980d-4c14-a0cd-a8aee213462f', 1, 3333.00, NULL, NULL, NULL),
('d550db30-d813-4783-a299-17ae94a4a2ec', '5fba1500-f980-454a-8d89-90a0297fdd9f', '7f25a559-8d9f-4fbf-9e3c-847a61b6f215', 1, 3333.00, NULL, NULL, NULL),
('df2420d5-b4ad-4966-8533-03cd6480c546', '9e2fdef8-039b-4aa1-bcaf-a46a8ba505db', '9b239749-ac86-4e5f-bed2-76914b550d6f', 1, 100.00, NULL, NULL, NULL),
('e3bbb280-e984-46b0-861e-e1c200f6029e', '5fba1500-f980-454a-8d89-90a0297fdd9f', '303c612e-4a46-4b58-aa58-0bc89c008558', 1, 3333.00, NULL, NULL, NULL),
('f0b58bcc-f6d9-4231-8745-2a40dac11346', '5fba1500-f980-454a-8d89-90a0297fdd9f', '43989b90-b26a-4e40-bfb8-3f156ed5b3d7', 1, 3333.00, NULL, NULL, NULL),
('f9e6c7d4-2d80-4e44-85dd-4f5d4a337672', '9e2fdef8-039b-4aa1-bcaf-a46a8ba505db', 'd05d2e5f-75ea-4cbc-b4e2-c0fa4a2c1e08', 2, 40000.00, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `product_price`
--

CREATE TABLE `product_price` (
  `id_product_price` varchar(36) NOT NULL,
  `id_product` varchar(36) NOT NULL,
  `tanggal_awal` datetime NOT NULL,
  `tanggal_berakhir` datetime DEFAULT NULL,
  `modal` decimal(15,2) NOT NULL,
  `price_unit` decimal(15,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product_price`
--

INSERT INTO `product_price` (`id_product_price`, `id_product`, `tanggal_awal`, `tanggal_berakhir`, `modal`, `price_unit`) VALUES
('2913021c-0ca6-4fe5-bc83-f029e0cbef17', 'f2d14b53-3909-4183-8390-7d225ab337db', '2025-05-01 21:31:44', NULL, 10000.00, 100000.00),
('40564fde-5b8a-4872-ac7f-6b2720637b83', '9e2fdef8-039b-4aa1-bcaf-a46a8ba505db', '2025-05-03 12:37:57', '2025-05-04 10:05:49', 20000.00, 20000.00),
('410ef23d-0c94-470f-beee-c2beab5926cf', '5fba1500-f980-454a-8d89-90a0297fdd9f', '2025-05-03 12:29:35', NULL, 3333.00, 3333.00),
('4df625c8-c53b-4269-9395-1da235c9489d', 'bede9c83-6ac5-4f81-8f9c-95aa9591d865', '2025-05-03 11:41:18', NULL, 3333.00, 3333.00),
('4f1ecef5-cef2-4c05-98b6-721e1739dfcc', 'f528c7c5-39dc-44e9-928c-fe02457281b0', '2025-05-03 11:28:08', NULL, 12.00, 14.00),
('6346d218-9f71-4372-8580-f6deae4f475d', '9e2fdef8-039b-4aa1-bcaf-a46a8ba505db', '2025-05-04 10:05:49', '2025-05-04 19:44:14', 100.00, 100.00),
('71ccd812-8727-467c-8e9f-7cbadba4c639', '9e2fdef8-039b-4aa1-bcaf-a46a8ba505db', '2025-05-03 12:37:24', '2025-05-03 12:37:57', 20000.00, 20000.00),
('7cb4964e-15a8-4ade-a271-09a20e7e38ac', '31e1ec26-a379-4bfb-9398-3f081dc0f68b', '2025-05-03 11:35:08', NULL, 23.00, 24.00),
('7cf29c80-8636-4a86-a9c9-6b6f79f941db', '5fba1500-f980-454a-8d89-90a0297fdd9f', '2025-05-03 12:29:09', '2025-05-03 12:29:35', 3333.00, 3333.00),
('7febd892-f95e-49d2-91f3-f0091d3966bc', '9e2fdef8-039b-4aa1-bcaf-a46a8ba505db', '2025-05-01 14:01:37', '2025-05-03 12:37:24', 20000.00, 20000.00),
('83083fef-6f11-4454-a6b0-208dd1a65398', '5fba1500-f980-454a-8d89-90a0297fdd9f', '2025-05-03 12:27:47', '2025-05-03 12:29:09', 3333.00, 3333.00),
('a6739979-48aa-4acc-a377-4652280b3411', '9e2fdef8-039b-4aa1-bcaf-a46a8ba505db', '2025-05-04 19:44:36', NULL, 5000.00, 5000.00),
('c0beaa87-0649-467a-9962-25052563fc45', 'ef9fcaeb-3400-4038-a515-225c756bd25d', '2025-05-01 21:28:57', NULL, 10000.00, 100000.00),
('f1147a25-7d0a-4a65-8a0d-17f30ba0870a', '5fba1500-f980-454a-8d89-90a0297fdd9f', '2025-05-03 11:44:13', '2025-05-03 12:27:47', 2222.00, 2222.00),
('f14dde57-6069-424f-b6bc-f2494802ede3', '9e2fdef8-039b-4aa1-bcaf-a46a8ba505db', '2025-05-04 19:44:14', '2025-05-04 19:44:36', 5000.00, 100.00);

-- --------------------------------------------------------

--
-- Table structure for table `product_size`
--

CREATE TABLE `product_size` (
  `id_product_size` varchar(36) NOT NULL,
  `id_product` varchar(36) NOT NULL,
  `panjang_cm` decimal(15,2) NOT NULL,
  `lebar_cm` decimal(15,2) NOT NULL,
  `tinggi_cm` decimal(15,2) NOT NULL,
  `berat_gram` decimal(15,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product_size`
--

INSERT INTO `product_size` (`id_product_size`, `id_product`, `panjang_cm`, `lebar_cm`, `tinggi_cm`, `berat_gram`) VALUES
('75f2ddbc-9c47-4cbf-bb70-75ed7e241564', '5fba1500-f980-454a-8d89-90a0297fdd9f', 3333.00, 3333.00, 3333.00, 3333.00);

-- --------------------------------------------------------

--
-- Table structure for table `stock`
--

CREATE TABLE `stock` (
  `id_stock` varchar(36) NOT NULL,
  `id_product` varchar(36) NOT NULL,
  `perubahan_stock` int(11) NOT NULL,
  `tanggal` datetime NOT NULL,
  `keterangan` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `stock`
--

INSERT INTO `stock` (`id_stock`, `id_product`, `perubahan_stock`, `tanggal`, `keterangan`) VALUES
('02fa7189-4df1-40e0-8b43-db9c86a8931e', '5fba1500-f980-454a-8d89-90a0297fdd9f', 2222, '2025-05-03 11:44:13', 'Stok Awal'),
('034fa2f9-5e02-4fc2-822b-12bd8f81fdc9', '5fba1500-f980-454a-8d89-90a0297fdd9f', -1, '2025-05-04 18:41:08', 'Transaksi 303c612e-4a46-4b58-aa58-0bc89c008558'),
('073f9f27-e1ff-479d-8b2c-45e19d6b4fb4', '5fba1500-f980-454a-8d89-90a0297fdd9f', 9999, '2025-05-03 12:29:35', 'Penambahan Awal'),
('1a6b6920-ec00-48ca-b7aa-e05a98540e11', '5fba1500-f980-454a-8d89-90a0297fdd9f', -2, '2025-05-03 23:15:10', 'Transaksi bf7dc49f-b4d8-4826-b77b-96b3c55ec267'),
('1b6f3e14-cb49-4d30-bb0d-b3b9bdeaf422', '5fba1500-f980-454a-8d89-90a0297fdd9f', -1, '2025-05-04 19:11:38', 'Transaksi 35209c9d-14c0-474b-b460-251a00e4f65f'),
('3243194e-a034-4f8f-a4f2-b818780ccc1e', '31e1ec26-a379-4bfb-9398-3f081dc0f68b', 25, '2025-05-03 11:35:08', 'Stok Awal'),
('437a17d9-e3d1-41d6-8b59-9aa2c66eab24', '5fba1500-f980-454a-8d89-90a0297fdd9f', -2, '2025-05-03 23:21:02', 'Transaksi b1a410a8-8193-4b4e-bf4e-9eb70a061f94'),
('512b9cd4-e1d4-42b2-a40e-f36f4b25fd73', '5fba1500-f980-454a-8d89-90a0297fdd9f', -1, '2025-05-04 10:15:36', 'Transaksi 322198d7-05be-42a1-8eaa-60a0f6e0ac0c'),
('5b148912-a0f2-4110-89f1-50cda737e751', '5fba1500-f980-454a-8d89-90a0297fdd9f', 9999, '2025-05-03 12:27:47', 'Penambahan Awal'),
('6e5f555b-1c62-41f4-9662-58428ff73914', 'bede9c83-6ac5-4f81-8f9c-95aa9591d865', 44, '2025-05-03 11:41:18', 'Stok Awal'),
('84ab728d-a007-4953-87fd-3f5acccbf7a4', '5fba1500-f980-454a-8d89-90a0297fdd9f', 9999, '2025-05-03 12:29:09', 'Penambahan Awal'),
('8d7f34f8-c71e-42e4-8051-e78cdbce011b', '5fba1500-f980-454a-8d89-90a0297fdd9f', -1, '2025-05-04 10:24:54', 'Transaksi 7f25a559-8d9f-4fbf-9e3c-847a61b6f215'),
('c0f1cbf8-3aac-4470-89aa-d70f895556e8', '5fba1500-f980-454a-8d89-90a0297fdd9f', -1, '2025-05-04 10:16:16', 'Transaksi 2ae60696-057a-4bc1-83c6-b5aa477862a4'),
('c71724b9-823f-48d9-bbc3-1ff4d3586266', 'f2d14b53-3909-4183-8390-7d225ab337db', 2222, '2025-05-01 21:31:44', 'Stok Awal'),
('d36f529a-1a7d-4ed2-9005-9d5bb3503bd9', '5fba1500-f980-454a-8d89-90a0297fdd9f', -1, '2025-05-04 18:41:27', 'Transaksi 5935d175-0877-44e1-98ab-f26968fe2edf'),
('deb3318c-9baf-4579-9970-2a138eea018a', '5fba1500-f980-454a-8d89-90a0297fdd9f', -1, '2025-05-04 19:27:01', 'Transaksi fb2201f2-980d-4c14-a0cd-a8aee213462f'),
('e226e258-9ccc-4df4-a2c4-007f082d5df5', '5fba1500-f980-454a-8d89-90a0297fdd9f', -1, '2025-05-04 19:11:12', 'Transaksi 7b28155b-4dbc-441e-812d-e5f9583c41fa'),
('e3e409f4-44c8-43fe-b6b0-5ce10bb4c131', '5fba1500-f980-454a-8d89-90a0297fdd9f', -1, '2025-05-04 19:26:07', 'Transaksi b0e0a925-73c5-4aee-8915-ccb87a23d626'),
('eeb44b8a-5035-47d5-b6df-751ebc432840', 'f528c7c5-39dc-44e9-928c-fe02457281b0', 10, '2025-05-03 11:28:08', 'Stok Awal'),
('f0416220-2754-44ce-846f-7b31d435a0b7', '5fba1500-f980-454a-8d89-90a0297fdd9f', -1, '2025-05-04 19:11:12', 'Transaksi 43989b90-b26a-4e40-bfb8-3f156ed5b3d7'),
('f7407b9b-6150-43ec-b469-3ea890fd5935', '5fba1500-f980-454a-8d89-90a0297fdd9f', -1, '2025-05-04 15:54:29', 'Transaksi cd76b2eb-9d7a-4f4d-b9dc-164074a6dce5');

-- --------------------------------------------------------

--
-- Table structure for table `transaksi`
--

CREATE TABLE `transaksi` (
  `id_transaksi` varchar(36) NOT NULL,
  `id_account` varchar(36) NOT NULL,
  `invoice_number` varchar(255) NOT NULL,
  `status` enum('Pending','Proses','Kirim','Selesai','Batal') NOT NULL DEFAULT 'Pending',
  `jenis` enum('Barang','Jasa') NOT NULL DEFAULT 'Barang',
  `total_price_producta` decimal(15,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `transaksi`
--

INSERT INTO `transaksi` (`id_transaksi`, `id_account`, `invoice_number`, `status`, `jenis`, `total_price_producta`) VALUES
('0a3a0a0d-e302-439a-a932-23ad9f29dee5', '75805e87-989f-4094-9249-462c2c7cfc8f', 'INV-JSA-20250504184109-756', 'Pending', 'Jasa', 100.00),
('0c97bde9-8b37-4ad8-986c-eacc63297fe5', '75805e87-989f-4094-9249-462c2c7cfc8f', 'INV-JSA-20250504102454-547', 'Batal', 'Jasa', 100.00),
('1dca42a5-6655-4a12-aca1-bef5f80a8678', '75805e87-989f-4094-9249-462c2c7cfc8f', 'INV-JSA-20250504192607-401', 'Pending', 'Jasa', 100.00),
('2ae60696-057a-4bc1-83c6-b5aa477862a4', '75805e87-989f-4094-9249-462c2c7cfc8f', 'INV-BRG-20250504101616-212', 'Selesai', 'Barang', 55333.00),
('303c612e-4a46-4b58-aa58-0bc89c008558', '75805e87-989f-4094-9249-462c2c7cfc8f', 'INV-BRG-20250504184108-433', 'Pending', 'Barang', 55333.00),
('322198d7-05be-42a1-8eaa-60a0f6e0ac0c', '75805e87-989f-4094-9249-462c2c7cfc8f', 'INV-BRG-20250504101536-500', 'Selesai', 'Barang', 55333.00),
('35209c9d-14c0-474b-b460-251a00e4f65f', '75805e87-989f-4094-9249-462c2c7cfc8f', 'INV-BRG-20250504191138-239', 'Pending', 'Barang', 55333.00),
('43989b90-b26a-4e40-bfb8-3f156ed5b3d7', '75805e87-989f-4094-9249-462c2c7cfc8f', 'INV-BRG-20250504191112-998', 'Pending', 'Barang', 55333.00),
('5935d175-0877-44e1-98ab-f26968fe2edf', '75805e87-989f-4094-9249-462c2c7cfc8f', 'INV-BRG-20250504184127-616', 'Pending', 'Barang', 55333.00),
('64a53f5a-59c5-4e33-8c2f-04e5d19dbf63', '75805e87-989f-4094-9249-462c2c7cfc8f', 'INV-JSA-20250504191112-335', 'Pending', 'Jasa', 100.00),
('68c77c59-31a8-4cad-90f5-93a53e4e4f61', '75805e87-989f-4094-9249-462c2c7cfc8f', 'INV-BRG-20250504192657-231', 'Pending', 'Barang', 3333.00),
('7b28155b-4dbc-441e-812d-e5f9583c41fa', '75805e87-989f-4094-9249-462c2c7cfc8f', 'INV-BRG-20250504191112-160', 'Pending', 'Barang', 55333.00),
('7f25a559-8d9f-4fbf-9e3c-847a61b6f215', '75805e87-989f-4094-9249-462c2c7cfc8f', 'INV-BRG-20250504102454-294', 'Kirim', 'Barang', 55333.00),
('8a70df63-b816-49da-92ca-8867dfd2d705', '75805e87-989f-4094-9249-462c2c7cfc8f', 'INV-JSA-20250504101616-121', 'Proses', 'Jasa', 100.00),
('8f111465-a2f2-4f04-a763-cfccf2744f1a', '75805e87-989f-4094-9249-462c2c7cfc8f', 'INV-JSA-20250503232103', 'Selesai', 'Jasa', 40000.00),
('9b239749-ac86-4e5f-bed2-76914b550d6f', '75805e87-989f-4094-9249-462c2c7cfc8f', 'INV-JSA-20250504192524-776', 'Pending', 'Jasa', 100.00),
('b0e0a925-73c5-4aee-8915-ccb87a23d626', '75805e87-989f-4094-9249-462c2c7cfc8f', 'INV-BRG-20250504192607-112', 'Pending', 'Barang', 55333.00),
('b1a410a8-8193-4b4e-bf4e-9eb70a061f94', '75805e87-989f-4094-9249-462c2c7cfc8f', 'INV-BRG-20250503232103', 'Proses', 'Barang', 61666.00),
('bf7dc49f-b4d8-4826-b77b-96b3c55ec267', '75805e87-989f-4094-9249-462c2c7cfc8f', 'INV-BRG-20250503231510', 'Batal', 'Barang', 61666.00),
('c6b1be94-ad7f-46a1-81d0-84b21e543a8e', '75805e87-989f-4094-9249-462c2c7cfc8f', 'INV-JSA-20250504192537-352', 'Pending', 'Jasa', 100.00),
('cd76b2eb-9d7a-4f4d-b9dc-164074a6dce5', '75805e87-989f-4094-9249-462c2c7cfc8f', 'INV-BRG-20250504155429-251', 'Pending', 'Barang', 55333.00),
('cf6bc028-761e-4038-8a19-bef97cc6850c', '75805e87-989f-4094-9249-462c2c7cfc8f', 'INV-JSA-20250504191113-784', 'Pending', 'Jasa', 100.00),
('d05d2e5f-75ea-4cbc-b4e2-c0fa4a2c1e08', '75805e87-989f-4094-9249-462c2c7cfc8f', 'INV-JSA-20250503231510', 'Pending', 'Jasa', 40000.00),
('e8e1fe3d-8fb4-4483-80f8-376b9449aca9', '75805e87-989f-4094-9249-462c2c7cfc8f', 'INV-JSA-20250504194459-840', 'Pending', 'Jasa', 5000.00),
('fb2201f2-980d-4c14-a0cd-a8aee213462f', '75805e87-989f-4094-9249-462c2c7cfc8f', 'INV-BRG-20250504192701-752', 'Pending', 'Barang', 55333.00);

-- --------------------------------------------------------

--
-- Table structure for table `view_portfolio`
--

CREATE TABLE `view_portfolio` (
  `id_view_portfolio` varchar(36) NOT NULL,
  `tanggal` datetime NOT NULL,
  `id_portofolio` varchar(36) NOT NULL,
  `id_account` varchar(36) DEFAULT NULL,
  `ip_address` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `view_portfolio`
--

INSERT INTO `view_portfolio` (`id_view_portfolio`, `tanggal`, `id_portofolio`, `id_account`, `ip_address`) VALUES
('0164b60c-bfc1-448f-9ccf-b25002669802', '2025-05-01 07:30:04', '350cb53a-40b2-480b-9681-1909cb8cb347', '75805e87-989f-4094-9249-462c2c7cfc8f', '::1'),
('04d4a4fd-6320-49e9-9a5a-a8b0a63c26d5', '2025-05-01 07:35:55', '350cb53a-40b2-480b-9681-1909cb8cb347', '75805e87-989f-4094-9249-462c2c7cfc8f', '::1'),
('05309e2e-4de8-409f-be0c-fbf7b7dd29ff', '2025-05-01 08:02:40', '350cb53a-40b2-480b-9681-1909cb8cb347', 'f208fcc2-2160-44e1-9bf2-7b1b5c0a618d', '::1'),
('071ba256-f5c8-4818-aedf-0e06f46b925a', '2025-05-01 07:58:01', '350cb53a-40b2-480b-9681-1909cb8cb347', 'f208fcc2-2160-44e1-9bf2-7b1b5c0a618d', '::1'),
('0fb5a789-c53e-4bbc-9bd7-4546e391538e', '2025-05-01 07:47:46', '350cb53a-40b2-480b-9681-1909cb8cb347', 'f208fcc2-2160-44e1-9bf2-7b1b5c0a618d', '::1'),
('1a9fe274-9237-4b1c-90be-637a0bf7b411', '2025-05-01 08:02:32', '350cb53a-40b2-480b-9681-1909cb8cb347', 'f208fcc2-2160-44e1-9bf2-7b1b5c0a618d', '::1'),
('26c53aab-677b-426e-948f-f1c7dd3da57b', '2025-05-01 06:49:17', '350cb53a-40b2-480b-9681-1909cb8cb347', NULL, '::1'),
('26e0a578-41fa-48e2-bbf9-779542c44bcf', '2025-05-01 08:02:35', '350cb53a-40b2-480b-9681-1909cb8cb347', 'f208fcc2-2160-44e1-9bf2-7b1b5c0a618d', '::1'),
('2bf383a0-b9d9-4500-990d-b8c0f068b52b', '2025-05-01 06:54:29', '350cb53a-40b2-480b-9681-1909cb8cb347', NULL, '::1'),
('2d0844bb-ec16-4f76-b908-f41945086840', '2025-05-01 08:11:40', '350cb53a-40b2-480b-9681-1909cb8cb347', 'f208fcc2-2160-44e1-9bf2-7b1b5c0a618d', '::1'),
('30f1e138-4250-4b94-9a9b-9d7ab6bc15b3', '2025-05-01 08:11:49', '350cb53a-40b2-480b-9681-1909cb8cb347', 'f208fcc2-2160-44e1-9bf2-7b1b5c0a618d', '::1'),
('327d6774-1808-4d6d-ae31-41c6465507da', '2025-05-01 07:58:52', '350cb53a-40b2-480b-9681-1909cb8cb347', 'f208fcc2-2160-44e1-9bf2-7b1b5c0a618d', '::1'),
('32b0a2d6-0dc0-4512-9d0f-5f47f75992ff', '2025-05-01 07:43:03', '350cb53a-40b2-480b-9681-1909cb8cb347', '75805e87-989f-4094-9249-462c2c7cfc8f', '::1'),
('3328e90e-a2a4-4af1-abb4-c74dda14d824', '2025-05-01 06:41:48', '5065c540-9ed2-4203-935d-54fe537248f3', NULL, '::1'),
('3613db43-e0c9-4a58-98b0-b90a1d36fdca', '2025-05-01 08:11:18', '350cb53a-40b2-480b-9681-1909cb8cb347', '75805e87-989f-4094-9249-462c2c7cfc8f', '::1'),
('37e6c531-d312-4831-9c24-d09bfd1c40f4', '2025-05-01 06:43:32', '53f666be-1d40-4b12-aaa9-eb0e10090634', NULL, '::1'),
('3a82a976-1d3d-414e-aa5e-9b513aafb96c', '2025-05-01 08:08:21', '350cb53a-40b2-480b-9681-1909cb8cb347', 'f208fcc2-2160-44e1-9bf2-7b1b5c0a618d', '::1'),
('3d2d6574-3640-4508-91ef-972b2d5360a3', '2025-05-01 07:57:50', '350cb53a-40b2-480b-9681-1909cb8cb347', 'f208fcc2-2160-44e1-9bf2-7b1b5c0a618d', '::1'),
('473c3f28-ea46-4c40-a79c-33b206f8fc92', '2025-05-01 07:30:37', '350cb53a-40b2-480b-9681-1909cb8cb347', '75805e87-989f-4094-9249-462c2c7cfc8f', '::1'),
('4b8cbb5f-ef1b-4d51-a380-3de47fef7b14', '2025-05-01 10:29:25', '9984579d-42f5-4803-a900-9c314341d05b', '75805e87-989f-4094-9249-462c2c7cfc8f', '::1'),
('542adcb0-fe6b-4f36-8756-d40c94d3576f', '2025-05-01 08:00:38', '350cb53a-40b2-480b-9681-1909cb8cb347', 'f208fcc2-2160-44e1-9bf2-7b1b5c0a618d', '::1'),
('5955ffe8-e2b6-41ed-90f6-03eaec43b0e5', '2025-05-01 07:04:01', '350cb53a-40b2-480b-9681-1909cb8cb347', '75805e87-989f-4094-9249-462c2c7cfc8f', '::1'),
('5a75d494-9813-4400-b078-cb09ea985140', '2025-05-01 07:47:22', '350cb53a-40b2-480b-9681-1909cb8cb347', NULL, '::1'),
('5ccbf81b-2f34-44c6-99ae-19fbc6be6b31', '2025-05-01 08:10:47', '350cb53a-40b2-480b-9681-1909cb8cb347', 'f208fcc2-2160-44e1-9bf2-7b1b5c0a618d', '::1'),
('5e7cd016-47dd-4a44-90a3-369ca3c273fd', '2025-05-01 10:29:07', '350cb53a-40b2-480b-9681-1909cb8cb347', '75805e87-989f-4094-9249-462c2c7cfc8f', '::1'),
('638b2082-7812-40c8-90dd-37a7397af878', '2025-05-01 06:48:06', '350cb53a-40b2-480b-9681-1909cb8cb347', NULL, '::1'),
('66737908-bbc8-4a57-a087-673342111436', '2025-05-01 08:10:59', '350cb53a-40b2-480b-9681-1909cb8cb347', 'f208fcc2-2160-44e1-9bf2-7b1b5c0a618d', '::1'),
('68c3d3d9-cb00-4875-a57d-57a1fc001f07', '2025-05-01 07:49:51', '350cb53a-40b2-480b-9681-1909cb8cb347', 'f208fcc2-2160-44e1-9bf2-7b1b5c0a618d', '::1'),
('693ed3fc-079b-4d50-bbd6-50670eb3894b', '2025-05-01 07:02:38', '350cb53a-40b2-480b-9681-1909cb8cb347', '75805e87-989f-4094-9249-462c2c7cfc8f', '::1'),
('6989c4e4-0dae-46cb-bd60-59c01187b018', '2025-05-01 06:43:13', '5065c540-9ed2-4203-935d-54fe537248f3', NULL, '::1'),
('6b8c3a4f-8aae-4e2e-bbbf-780923e233bb', '2025-05-01 07:50:57', '350cb53a-40b2-480b-9681-1909cb8cb347', 'f208fcc2-2160-44e1-9bf2-7b1b5c0a618d', '::1'),
('6e0d6dae-29d4-4bbc-9f8e-c0d8809ac20f', '2025-05-01 07:57:07', '350cb53a-40b2-480b-9681-1909cb8cb347', 'f208fcc2-2160-44e1-9bf2-7b1b5c0a618d', '::1'),
('73153221-d526-4339-8697-501c3d860dcd', '2025-05-01 06:47:36', '350cb53a-40b2-480b-9681-1909cb8cb347', NULL, '::1'),
('74361ce8-f2c2-4c69-8803-e94a02bcd204', '2025-05-01 07:29:24', '350cb53a-40b2-480b-9681-1909cb8cb347', '75805e87-989f-4094-9249-462c2c7cfc8f', '::1'),
('75fb4eb4-1b00-45d6-9705-42eea2c87858', '2025-05-01 06:36:46', '5065c540-9ed2-4203-935d-54fe537248f3', NULL, '::1'),
('76ad4b29-94b0-4cdf-bca5-2b253b26fe11', '2025-05-01 06:15:26', '5065c540-9ed2-4203-935d-54fe537248f3', NULL, '::1'),
('77d6fbca-fbb3-4376-96bf-b26c2acbb79e', '2025-05-01 08:02:53', '350cb53a-40b2-480b-9681-1909cb8cb347', 'f208fcc2-2160-44e1-9bf2-7b1b5c0a618d', '::1'),
('7ae8bb9b-0a97-4e7b-af06-1961d7eb6418', '2025-05-01 06:43:42', '9984579d-42f5-4803-a900-9c314341d05b', NULL, '::1'),
('80dc5336-144a-4061-a014-a3c52c8bef6a', '2025-05-01 08:08:13', '350cb53a-40b2-480b-9681-1909cb8cb347', 'f208fcc2-2160-44e1-9bf2-7b1b5c0a618d', '::1'),
('820785ba-3260-4164-bdf8-e8ecbc5696f1', '2025-05-01 12:41:02', '5065c540-9ed2-4203-935d-54fe537248f3', '75805e87-989f-4094-9249-462c2c7cfc8f', '::1'),
('84a71e87-8e27-4883-bd11-25f2cdbaec3d', '2025-05-01 06:56:55', '350cb53a-40b2-480b-9681-1909cb8cb347', 'f208fcc2-2160-44e1-9bf2-7b1b5c0a618d', '::1'),
('8923c91d-23e2-4aea-9654-f3fa2d734f36', '2025-05-01 07:50:39', '350cb53a-40b2-480b-9681-1909cb8cb347', 'f208fcc2-2160-44e1-9bf2-7b1b5c0a618d', '::1'),
('8b31d11b-f45a-4e1f-80d1-4843617e4e2e', '2025-05-04 14:24:48', '5065c540-9ed2-4203-935d-54fe537248f3', '75805e87-989f-4094-9249-462c2c7cfc8f', '::1'),
('8e2ca49e-0b6c-48cf-b508-d8036aacba83', '2025-05-01 07:57:56', '350cb53a-40b2-480b-9681-1909cb8cb347', 'f208fcc2-2160-44e1-9bf2-7b1b5c0a618d', '::1'),
('906d99a2-f794-4b77-a14b-101266b28e27', '2025-05-01 06:37:38', '5065c540-9ed2-4203-935d-54fe537248f3', NULL, '::1'),
('9280a014-998b-49b5-a3ad-b286b4b56b22', '2025-05-01 07:00:47', '350cb53a-40b2-480b-9681-1909cb8cb347', 'f208fcc2-2160-44e1-9bf2-7b1b5c0a618d', '::1'),
('956fbb9d-9d37-49ab-b1b3-839653217e5a', '2025-05-01 06:44:08', '350cb53a-40b2-480b-9681-1909cb8cb347', NULL, '::1'),
('980e0c46-5d2c-4a9f-81f6-397822df3e57', '2025-05-01 07:02:10', '350cb53a-40b2-480b-9681-1909cb8cb347', '75805e87-989f-4094-9249-462c2c7cfc8f', '::1'),
('98bc32c7-60cf-4fc9-bc19-0108a40b3e2b', '2025-05-01 07:49:34', '350cb53a-40b2-480b-9681-1909cb8cb347', 'f208fcc2-2160-44e1-9bf2-7b1b5c0a618d', '::1'),
('98c33f19-5a4f-4a9d-8a9a-2adf85d7346d', '2025-05-01 07:36:05', '350cb53a-40b2-480b-9681-1909cb8cb347', '75805e87-989f-4094-9249-462c2c7cfc8f', '::1'),
('9f1f9c4d-18c8-41e9-820a-3e0f67226171', '2025-05-01 06:43:52', '2ae4b526-b00b-45ab-b732-9b77f29a6ddc', NULL, '::1'),
('a359c8d4-600b-4528-813c-90180f4ce840', '2025-05-01 07:33:02', '350cb53a-40b2-480b-9681-1909cb8cb347', '75805e87-989f-4094-9249-462c2c7cfc8f', '::1'),
('a4b89933-6eb7-4dc1-b9bf-ce82f34254aa', '2025-05-01 06:42:24', '5065c540-9ed2-4203-935d-54fe537248f3', NULL, '::1'),
('a60c286b-d976-4e99-b213-036a17d25273', '2025-05-01 06:45:36', '350cb53a-40b2-480b-9681-1909cb8cb347', NULL, '::1'),
('a67c66a2-cc24-40ae-ba10-28e732085b41', '2025-05-01 06:39:01', '5065c540-9ed2-4203-935d-54fe537248f3', NULL, '::1'),
('a6a3edd7-43cc-4bac-acff-60fa90494005', '2025-05-01 07:57:16', '350cb53a-40b2-480b-9681-1909cb8cb347', 'f208fcc2-2160-44e1-9bf2-7b1b5c0a618d', '::1'),
('a6a697ca-ea4e-49da-9ace-67cf6e213b28', '2025-05-01 06:44:03', '438efcf9-d296-4635-95a0-ce344af686c0', NULL, '::1'),
('b33ff56b-e150-4a88-95e2-d26a0522b786', '2025-05-01 08:00:32', '350cb53a-40b2-480b-9681-1909cb8cb347', 'f208fcc2-2160-44e1-9bf2-7b1b5c0a618d', '::1'),
('b5894797-7716-4df4-8cb8-80aa072b30ae', '2025-05-01 07:06:34', '350cb53a-40b2-480b-9681-1909cb8cb347', '75805e87-989f-4094-9249-462c2c7cfc8f', '::1'),
('ba5875d4-b307-448d-9e8c-5bc699f50b74', '2025-05-01 07:57:25', '350cb53a-40b2-480b-9681-1909cb8cb347', 'f208fcc2-2160-44e1-9bf2-7b1b5c0a618d', '::1'),
('ba682929-f59d-45f6-a7c5-27eda61968cd', '2025-05-01 07:59:02', '350cb53a-40b2-480b-9681-1909cb8cb347', 'f208fcc2-2160-44e1-9bf2-7b1b5c0a618d', '::1'),
('baa275fe-6450-43c7-8791-f02279917827', '2025-05-01 06:14:45', '5065c540-9ed2-4203-935d-54fe537248f3', NULL, '::1'),
('bfc6537c-ab13-4ede-a36b-aa3edd1abc6c', '2025-05-01 06:57:41', '350cb53a-40b2-480b-9681-1909cb8cb347', 'f208fcc2-2160-44e1-9bf2-7b1b5c0a618d', '::1'),
('dc5bb68b-0f10-4c7d-b1ae-2bba26de8c4c', '2025-05-01 07:49:31', '350cb53a-40b2-480b-9681-1909cb8cb347', '75805e87-989f-4094-9249-462c2c7cfc8f', '::1'),
('df9e8dbe-3f55-4985-9acb-ad919e8ccdf8', '2025-05-01 06:42:44', '5065c540-9ed2-4203-935d-54fe537248f3', NULL, '::1'),
('e0521147-0967-4948-91fe-37409461d08b', '2025-05-01 06:43:58', '2ae4b526-b00b-45ab-b732-9b77f29a6ddc', NULL, '::1'),
('e0586e2c-f0ed-4280-9562-29031fac58e9', '2025-05-01 07:06:53', '350cb53a-40b2-480b-9681-1909cb8cb347', '75805e87-989f-4094-9249-462c2c7cfc8f', '::1'),
('e0e73423-d95f-42a9-92fe-aeb5418fa13f', '2025-05-01 08:11:10', '350cb53a-40b2-480b-9681-1909cb8cb347', 'f208fcc2-2160-44e1-9bf2-7b1b5c0a618d', '::1'),
('e39ee37f-cec6-4cc8-912e-6e37e48a81dc', '2025-05-01 07:01:40', '350cb53a-40b2-480b-9681-1909cb8cb347', 'f208fcc2-2160-44e1-9bf2-7b1b5c0a618d', '::1'),
('e3eda703-2f2d-4bba-a65a-85f9c3e2752f', '2025-05-01 06:49:27', '350cb53a-40b2-480b-9681-1909cb8cb347', NULL, '::1'),
('e40846d1-6b65-4488-ac80-6bdbd6af2680', '2025-05-01 08:02:48', '350cb53a-40b2-480b-9681-1909cb8cb347', 'f208fcc2-2160-44e1-9bf2-7b1b5c0a618d', '::1'),
('e49a9034-76ef-448e-b166-f63b48b34451', '2025-05-01 07:30:09', '350cb53a-40b2-480b-9681-1909cb8cb347', '75805e87-989f-4094-9249-462c2c7cfc8f', '::1'),
('e8c2550c-b9f1-4743-853b-da0359a10b8e', '2025-05-01 07:58:58', '350cb53a-40b2-480b-9681-1909cb8cb347', 'f208fcc2-2160-44e1-9bf2-7b1b5c0a618d', '::1'),
('e8e4332d-84fd-4e68-a033-47c92fa105ea', '2025-05-01 08:11:35', '350cb53a-40b2-480b-9681-1909cb8cb347', '75805e87-989f-4094-9249-462c2c7cfc8f', '::1'),
('f6c4d218-1b92-4190-bc86-1cc3482d9812', '2025-05-02 20:53:15', '350cb53a-40b2-480b-9681-1909cb8cb347', NULL, '::1'),
('ffd4aa13-fc63-4c4b-baef-d6769ea3f032', '2025-05-01 06:43:47', 'f840e707-954a-4d24-a29b-a343f7314bd3', NULL, '::1'),
('ffdb2650-6ab3-4034-bafc-c65d7df33ba4', '2025-05-01 07:30:19', '350cb53a-40b2-480b-9681-1909cb8cb347', '75805e87-989f-4094-9249-462c2c7cfc8f', '::1');

-- --------------------------------------------------------

--
-- Table structure for table `view_product`
--

CREATE TABLE `view_product` (
  `id_view_product` varchar(36) NOT NULL,
  `id_account` varchar(36) DEFAULT NULL,
  `id_product` varchar(36) NOT NULL,
  `ip_address` varchar(255) DEFAULT NULL,
  `tanggal` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `view_product`
--

INSERT INTO `view_product` (`id_view_product`, `id_account`, `id_product`, `ip_address`, `tanggal`) VALUES
('008f7f91-b4b2-42f6-8e20-51dba1d712a7', '75805e87-989f-4094-9249-462c2c7cfc8f', '9e2fdef8-039b-4aa1-bcaf-a46a8ba505db', '::1', '2025-05-04 16:55:48'),
('025ade11-d446-4b53-8ae4-ad34fc413e10', '75805e87-989f-4094-9249-462c2c7cfc8f', '5fba1500-f980-454a-8d89-90a0297fdd9f', '::1', '2025-05-04 10:12:30'),
('03786e2a-4f5e-477c-8562-2105ee5cd7f4', '75805e87-989f-4094-9249-462c2c7cfc8f', '9e2fdef8-039b-4aa1-bcaf-a46a8ba505db', '::1', '2025-05-03 13:52:10'),
('039e8faf-1de7-4c5f-9f0d-a179b46988a7', '75805e87-989f-4094-9249-462c2c7cfc8f', 'f2d14b53-3909-4183-8390-7d225ab337db', '::1', '2025-05-02 21:19:10'),
('04e0b97e-9d9f-4798-875a-b9f3590de2c4', '75805e87-989f-4094-9249-462c2c7cfc8f', '5fba1500-f980-454a-8d89-90a0297fdd9f', '::1', '2025-05-04 18:40:57'),
('089d156e-2aef-466f-87b1-89d1aeff8ed2', NULL, '9e2fdef8-039b-4aa1-bcaf-a46a8ba505db', '::1', '2025-05-02 07:15:26'),
('08d6794f-652b-4ffa-a40f-c27fec3dde36', '75805e87-989f-4094-9249-462c2c7cfc8f', 'f2d14b53-3909-4183-8390-7d225ab337db', '::1', '2025-05-02 07:53:01'),
('0e5431b0-3472-4915-9099-9b952b766660', '75805e87-989f-4094-9249-462c2c7cfc8f', '9e2fdef8-039b-4aa1-bcaf-a46a8ba505db', '::1', '2025-05-04 16:54:45'),
('0ef9d38b-2ff7-416a-87ff-e5d0bc4dc177', '75805e87-989f-4094-9249-462c2c7cfc8f', '9e2fdef8-039b-4aa1-bcaf-a46a8ba505db', '::1', '2025-05-02 07:53:35'),
('0f1c568c-6e5a-4d60-ad08-d49670518c10', '75805e87-989f-4094-9249-462c2c7cfc8f', '9e2fdef8-039b-4aa1-bcaf-a46a8ba505db', '::1', '2025-05-04 10:35:16'),
('13b5e92b-bbd5-4c08-9709-41e2e5114a6b', '75805e87-989f-4094-9249-462c2c7cfc8f', 'f2d14b53-3909-4183-8390-7d225ab337db', '::1', '2025-05-02 20:57:52'),
('144de3c8-c31c-4261-9c2b-d9120982f972', '75805e87-989f-4094-9249-462c2c7cfc8f', '9e2fdef8-039b-4aa1-bcaf-a46a8ba505db', '::1', '2025-05-04 16:53:43'),
('1a590065-379f-438b-a4f5-cfe754f9cc28', NULL, '9e2fdef8-039b-4aa1-bcaf-a46a8ba505db', '::1', '2025-05-02 07:22:51'),
('1d9769cb-53b8-46c3-8a48-1faa1d5a84e3', '75805e87-989f-4094-9249-462c2c7cfc8f', '5fba1500-f980-454a-8d89-90a0297fdd9f', '::1', '2025-05-04 15:54:10'),
('1eddf2d5-794b-4402-be47-fdc380500416', '75805e87-989f-4094-9249-462c2c7cfc8f', '9e2fdef8-039b-4aa1-bcaf-a46a8ba505db', '::1', '2025-05-04 10:14:15'),
('211947a9-2016-4bcc-bbc3-6c26bf9b720e', '75805e87-989f-4094-9249-462c2c7cfc8f', '9e2fdef8-039b-4aa1-bcaf-a46a8ba505db', '::1', '2025-05-03 15:22:45'),
('21a2e35f-ed37-4586-8d63-2bd8c16253aa', '75805e87-989f-4094-9249-462c2c7cfc8f', '5fba1500-f980-454a-8d89-90a0297fdd9f', '::1', '2025-05-03 14:23:31'),
('27a021cc-926d-4af1-9239-f68025f921ca', '75805e87-989f-4094-9249-462c2c7cfc8f', 'f2d14b53-3909-4183-8390-7d225ab337db', '::1', '2025-05-02 21:20:23'),
('30f842a4-8526-46e2-bdc1-dff6cb9c63d0', '75805e87-989f-4094-9249-462c2c7cfc8f', '5fba1500-f980-454a-8d89-90a0297fdd9f', '::1', '2025-05-04 19:25:59'),
('377f7e10-641e-491e-b16b-8ef46c85f2de', '75805e87-989f-4094-9249-462c2c7cfc8f', '9e2fdef8-039b-4aa1-bcaf-a46a8ba505db', '::1', '2025-05-04 18:34:32'),
('3f9c2a96-9326-42b7-bbcf-2ed7c161f8b1', '75805e87-989f-4094-9249-462c2c7cfc8f', '5fba1500-f980-454a-8d89-90a0297fdd9f', '::1', '2025-05-04 19:09:16'),
('418b3aa9-7a2f-42e9-a096-828daeb02dbe', '75805e87-989f-4094-9249-462c2c7cfc8f', '5fba1500-f980-454a-8d89-90a0297fdd9f', '::1', '2025-05-04 18:41:19'),
('43b752a0-a63f-423e-b116-e0cc238fdea3', '75805e87-989f-4094-9249-462c2c7cfc8f', '9e2fdef8-039b-4aa1-bcaf-a46a8ba505db', '::1', '2025-05-04 19:21:01'),
('46c858a4-5169-4a62-9d45-f46d587c79af', '75805e87-989f-4094-9249-462c2c7cfc8f', '9e2fdef8-039b-4aa1-bcaf-a46a8ba505db', '::1', '2025-05-04 16:57:48'),
('537d2882-3dc1-437f-8a5e-c5da49cb14d3', NULL, '9e2fdef8-039b-4aa1-bcaf-a46a8ba505db', '::1', '2025-05-02 07:10:53'),
('577a7add-6ec7-4a32-ad61-428d260d3d88', '75805e87-989f-4094-9249-462c2c7cfc8f', '9e2fdef8-039b-4aa1-bcaf-a46a8ba505db', '::1', '2025-05-02 21:20:33'),
('589f2516-ee7a-4f57-adf9-df8cb5203523', 'f208fcc2-2160-44e1-9bf2-7b1b5c0a618d', '9e2fdef8-039b-4aa1-bcaf-a46a8ba505db', '::1', '2025-05-04 17:08:51'),
('5b4f4023-15c5-48c2-a4d3-12f3eb9bee6d', NULL, '9e2fdef8-039b-4aa1-bcaf-a46a8ba505db', '::1', '2025-05-02 07:10:10'),
('65e7dae3-7134-41e9-893a-5cba5b599a07', '75805e87-989f-4094-9249-462c2c7cfc8f', '5fba1500-f980-454a-8d89-90a0297fdd9f', '::1', '2025-05-04 10:15:26'),
('6748d497-2d2c-4e9d-af62-b3f4425af173', 'f208fcc2-2160-44e1-9bf2-7b1b5c0a618d', '9e2fdef8-039b-4aa1-bcaf-a46a8ba505db', '::1', '2025-05-04 17:02:30'),
('6d7698ec-3eb0-419d-80fa-905933566b81', '75805e87-989f-4094-9249-462c2c7cfc8f', '5fba1500-f980-454a-8d89-90a0297fdd9f', '::1', '2025-05-04 19:26:14'),
('764460a4-fa19-4964-b594-1b3b37e352b9', '75805e87-989f-4094-9249-462c2c7cfc8f', '9e2fdef8-039b-4aa1-bcaf-a46a8ba505db', '::1', '2025-05-04 10:16:27'),
('78f1def2-9442-4aea-9e1e-11be568594dc', 'f208fcc2-2160-44e1-9bf2-7b1b5c0a618d', '9e2fdef8-039b-4aa1-bcaf-a46a8ba505db', '::1', '2025-05-04 16:59:50'),
('78fed4c8-342d-4430-b7e5-bc3a30d709d4', '75805e87-989f-4094-9249-462c2c7cfc8f', '5fba1500-f980-454a-8d89-90a0297fdd9f', '::1', '2025-05-04 19:11:31'),
('8d4a5609-5ba3-4c51-8bfa-c533c59753f4', '75805e87-989f-4094-9249-462c2c7cfc8f', '5fba1500-f980-454a-8d89-90a0297fdd9f', '::1', '2025-05-03 12:38:16'),
('8dc63131-458a-4101-a85a-a7aed22f6959', NULL, '9e2fdef8-039b-4aa1-bcaf-a46a8ba505db', '::1', '2025-05-02 07:19:02'),
('92bfca53-9972-46fc-a034-c5cbc7e1ba6e', '75805e87-989f-4094-9249-462c2c7cfc8f', '9e2fdef8-039b-4aa1-bcaf-a46a8ba505db', '::1', '2025-05-04 19:44:53'),
('9e4d80c5-7b1f-4ea5-9f54-b3742958219f', '75805e87-989f-4094-9249-462c2c7cfc8f', '5fba1500-f980-454a-8d89-90a0297fdd9f', '::1', '2025-05-03 13:58:51'),
('a066d912-8691-4c84-adf6-687b3c3970d4', '75805e87-989f-4094-9249-462c2c7cfc8f', '5fba1500-f980-454a-8d89-90a0297fdd9f', '::1', '2025-05-03 13:59:01'),
('a1351581-5c75-4aca-a8ed-84ab2b9fa65d', NULL, '9e2fdef8-039b-4aa1-bcaf-a46a8ba505db', '::1', '2025-05-02 07:18:19'),
('a185f725-9895-475b-8b4f-04d9e5c319b4', '75805e87-989f-4094-9249-462c2c7cfc8f', '9e2fdef8-039b-4aa1-bcaf-a46a8ba505db', '::1', '2025-05-04 10:15:56'),
('a1c22e5d-bebc-4161-b305-c104facc658f', '75805e87-989f-4094-9249-462c2c7cfc8f', '5fba1500-f980-454a-8d89-90a0297fdd9f', '::1', '2025-05-04 10:16:05'),
('a8ec1512-8ba0-4dc5-b0dc-9408355e677b', 'f208fcc2-2160-44e1-9bf2-7b1b5c0a618d', '9e2fdef8-039b-4aa1-bcaf-a46a8ba505db', '::1', '2025-05-04 18:59:06'),
('a9b65c12-0fdc-4401-ab69-3bcd9deb1496', '75805e87-989f-4094-9249-462c2c7cfc8f', '9e2fdef8-039b-4aa1-bcaf-a46a8ba505db', '::1', '2025-05-03 12:38:23'),
('ac88646b-bbf4-42ea-993a-0931f38dd3ca', '75805e87-989f-4094-9249-462c2c7cfc8f', '9e2fdef8-039b-4aa1-bcaf-a46a8ba505db', '::1', '2025-05-04 19:25:30'),
('b4a3b5cd-f059-4e19-85c3-dab9b36b9e76', NULL, 'f2d14b53-3909-4183-8390-7d225ab337db', '::1', '2025-05-02 07:22:55'),
('b62c5f91-a0ed-4b19-9bbb-d9375cccc5aa', '75805e87-989f-4094-9249-462c2c7cfc8f', '5fba1500-f980-454a-8d89-90a0297fdd9f', '::1', '2025-05-03 14:15:49'),
('b6b14232-b8bb-4dee-afd2-df7661649ca0', '75805e87-989f-4094-9249-462c2c7cfc8f', '9e2fdef8-039b-4aa1-bcaf-a46a8ba505db', '::1', '2025-05-04 10:05:59'),
('bd447009-bd9e-49c6-87a5-cd7613109ea3', '75805e87-989f-4094-9249-462c2c7cfc8f', '9e2fdef8-039b-4aa1-bcaf-a46a8ba505db', '::1', '2025-05-04 18:42:21'),
('c1a09b9c-961c-49c3-8f1c-28b1977a7b7d', '75805e87-989f-4094-9249-462c2c7cfc8f', '9e2fdef8-039b-4aa1-bcaf-a46a8ba505db', '::1', '2025-05-03 13:58:09'),
('c91d362b-e981-4d8b-b628-e37165ffcd02', '75805e87-989f-4094-9249-462c2c7cfc8f', 'f2d14b53-3909-4183-8390-7d225ab337db', '::1', '2025-05-02 07:53:23'),
('d463e6d3-fa3b-4c10-b255-60a1992b2761', '75805e87-989f-4094-9249-462c2c7cfc8f', '5fba1500-f980-454a-8d89-90a0297fdd9f', '::1', '2025-05-04 14:33:20'),
('d4bbb92c-4cac-43ba-a90a-c07bc8013692', '75805e87-989f-4094-9249-462c2c7cfc8f', '5fba1500-f980-454a-8d89-90a0297fdd9f', '::1', '2025-05-03 12:31:22'),
('d74b7171-fa7a-4888-bb2b-fd5a5060a514', NULL, 'f2d14b53-3909-4183-8390-7d225ab337db', '::1', '2025-05-02 07:23:30'),
('d8599af8-395b-49b7-9533-2a91dfe91123', '75805e87-989f-4094-9249-462c2c7cfc8f', '9e2fdef8-039b-4aa1-bcaf-a46a8ba505db', '::1', '2025-05-03 13:57:56'),
('dba85b97-4806-4a40-b307-004cdf1e40df', '75805e87-989f-4094-9249-462c2c7cfc8f', '9e2fdef8-039b-4aa1-bcaf-a46a8ba505db', '::1', '2025-05-03 13:30:21'),
('dbb2d14d-2fa9-459d-9612-f025598219ce', '75805e87-989f-4094-9249-462c2c7cfc8f', '5fba1500-f980-454a-8d89-90a0297fdd9f', '::1', '2025-05-04 14:32:17'),
('dcb24585-df6f-4214-a9d5-2f1d984ecb19', '75805e87-989f-4094-9249-462c2c7cfc8f', 'f2d14b53-3909-4183-8390-7d225ab337db', '::1', '2025-05-02 20:56:33'),
('df7bb95f-cf7e-424d-bbc9-21002ca99e16', '75805e87-989f-4094-9249-462c2c7cfc8f', 'f2d14b53-3909-4183-8390-7d225ab337db', '::1', '2025-05-02 07:51:56'),
('e096d8c0-c7f5-46c4-94ea-891012df9271', 'f208fcc2-2160-44e1-9bf2-7b1b5c0a618d', '9e2fdef8-039b-4aa1-bcaf-a46a8ba505db', '::1', '2025-05-04 16:57:58'),
('e3a78be1-fd37-4959-b41e-2a85dd37a37a', '75805e87-989f-4094-9249-462c2c7cfc8f', '5fba1500-f980-454a-8d89-90a0297fdd9f', '::1', '2025-05-04 10:22:51'),
('e43a337c-a2ba-4210-ba22-b03d9664b637', '75805e87-989f-4094-9249-462c2c7cfc8f', '9e2fdef8-039b-4aa1-bcaf-a46a8ba505db', '::1', '2025-05-03 14:15:04'),
('eb2cf891-6a65-4b4c-ab05-5a10e01b029b', NULL, '9e2fdef8-039b-4aa1-bcaf-a46a8ba505db', '::1', '2025-05-02 07:22:13'),
('eedcde36-95cf-43c6-9b02-7e9569be4275', NULL, 'f2d14b53-3909-4183-8390-7d225ab337db', '::1', '2025-05-02 07:24:13'),
('efa84d29-a7be-4b84-9cd9-c4ff3f0231ac', '75805e87-989f-4094-9249-462c2c7cfc8f', 'f2d14b53-3909-4183-8390-7d225ab337db', '::1', '2025-05-02 07:51:22'),
('f00452ae-6319-4837-9752-a5694ffd42d4', '75805e87-989f-4094-9249-462c2c7cfc8f', '9e2fdef8-039b-4aa1-bcaf-a46a8ba505db', '::1', '2025-05-04 16:55:00'),
('f04d8dde-7d1d-4b5e-a313-2fbb21f33bcc', '75805e87-989f-4094-9249-462c2c7cfc8f', '9e2fdef8-039b-4aa1-bcaf-a46a8ba505db', '::1', '2025-05-02 10:47:45'),
('f0965d47-4633-46d0-879c-3a7eb4baa3c6', '75805e87-989f-4094-9249-462c2c7cfc8f', 'f2d14b53-3909-4183-8390-7d225ab337db', '::1', '2025-05-02 21:18:56'),
('fcfffea4-9ba7-4029-9b5a-6b60dc307629', 'f208fcc2-2160-44e1-9bf2-7b1b5c0a618d', '9e2fdef8-039b-4aa1-bcaf-a46a8ba505db', '::1', '2025-05-04 17:08:58'),
('fe47dbc0-79cf-469d-a6da-773a52f00d91', '75805e87-989f-4094-9249-462c2c7cfc8f', '9e2fdef8-039b-4aa1-bcaf-a46a8ba505db', '::1', '2025-05-04 19:25:44'),
('ff5c4f2f-7dd0-4d29-b3f5-3fba0cdeb3e3', '75805e87-989f-4094-9249-462c2c7cfc8f', '5fba1500-f980-454a-8d89-90a0297fdd9f', '::1', '2025-05-03 13:23:15');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `accounts`
--
ALTER TABLE `accounts`
  ADD PRIMARY KEY (`id_account`),
  ADD UNIQUE KEY `id_account` (`id_account`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `addresses`
--
ALTER TABLE `addresses`
  ADD PRIMARY KEY (`id_address`),
  ADD UNIQUE KEY `id_address` (`id_address`),
  ADD KEY `addresses_id_account_foreign` (`id_account`);

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id_cart`),
  ADD UNIQUE KEY `id_cart` (`id_cart`),
  ADD KEY `cart_id_account_foreign` (`id_account`),
  ADD KEY `cart_id_product_foreign` (`id_product`);

--
-- Indexes for table `comment_portofolio`
--
ALTER TABLE `comment_portofolio`
  ADD PRIMARY KEY (`id_comment_portofolio`),
  ADD UNIQUE KEY `id_comment_portofolio` (`id_comment_portofolio`),
  ADD KEY `comment_portofolio_id_portofolio_foreign` (`id_portofolio`),
  ADD KEY `comment_portofolio_id_account_foreign` (`id_account`);

--
-- Indexes for table `delivery_service`
--
ALTER TABLE `delivery_service`
  ADD PRIMARY KEY (`id_delivery_service`),
  ADD UNIQUE KEY `id_delivery_service` (`id_delivery_service`);

--
-- Indexes for table `dokumen_jasa`
--
ALTER TABLE `dokumen_jasa`
  ADD PRIMARY KEY (`id_dokumen_jasa`),
  ADD UNIQUE KEY `id_dokumen_jasa` (`id_dokumen_jasa`),
  ADD KEY `dokumen_jasa_id_transaksi_foreign` (`id_transaksi`);

--
-- Indexes for table `hist_search`
--
ALTER TABLE `hist_search`
  ADD PRIMARY KEY (`id_hist_search`),
  ADD UNIQUE KEY `id_hist_search` (`id_hist_search`),
  ADD KEY `hist_search_id_account_foreign` (`id_account`);

--
-- Indexes for table `images`
--
ALTER TABLE `images`
  ADD PRIMARY KEY (`id_images`),
  ADD UNIQUE KEY `id_images` (`id_images`),
  ADD KEY `images_id_product_foreign` (`id_product`);

--
-- Indexes for table `images_portofolio`
--
ALTER TABLE `images_portofolio`
  ADD PRIMARY KEY (`id_images_portofolio`),
  ADD UNIQUE KEY `id_images_portofolio` (`id_images_portofolio`),
  ADD KEY `images_portofolio_id_portofolio_foreign` (`id_portofolio`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`id_payments`),
  ADD UNIQUE KEY `id_payments` (`id_payments`),
  ADD KEY `payments_id_transaksi_foreign` (`id_transaksi`);

--
-- Indexes for table `pengiriman`
--
ALTER TABLE `pengiriman`
  ADD PRIMARY KEY (`id_pengiriman`),
  ADD UNIQUE KEY `id_pengiriman` (`id_pengiriman`),
  ADD KEY `pengiriman_id_delivery_service_foreign` (`id_delivery_service`),
  ADD KEY `pengiriman_id_transaksi_foreign` (`id_transaksi`);

--
-- Indexes for table `portofolio`
--
ALTER TABLE `portofolio`
  ADD PRIMARY KEY (`id_portofolio`),
  ADD UNIQUE KEY `id_portofolio` (`id_portofolio`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id_product`),
  ADD UNIQUE KEY `id_product` (`id_product`);

--
-- Indexes for table `product_order`
--
ALTER TABLE `product_order`
  ADD PRIMARY KEY (`id_product_order`),
  ADD UNIQUE KEY `id_product_order` (`id_product_order`),
  ADD KEY `product_order_id_product_foreign` (`id_product`),
  ADD KEY `product_order_id_transaksi_foreign` (`id_transaksi`);

--
-- Indexes for table `product_price`
--
ALTER TABLE `product_price`
  ADD PRIMARY KEY (`id_product_price`),
  ADD UNIQUE KEY `id_product_price` (`id_product_price`),
  ADD KEY `product_price_id_product_foreign` (`id_product`);

--
-- Indexes for table `product_size`
--
ALTER TABLE `product_size`
  ADD PRIMARY KEY (`id_product_size`),
  ADD UNIQUE KEY `id_product_size` (`id_product_size`),
  ADD KEY `product_size_id_product_foreign` (`id_product`);

--
-- Indexes for table `stock`
--
ALTER TABLE `stock`
  ADD PRIMARY KEY (`id_stock`),
  ADD UNIQUE KEY `id_stock` (`id_stock`),
  ADD KEY `stock_id_product_foreign` (`id_product`);

--
-- Indexes for table `transaksi`
--
ALTER TABLE `transaksi`
  ADD PRIMARY KEY (`id_transaksi`),
  ADD UNIQUE KEY `id_transaksi` (`id_transaksi`),
  ADD KEY `transaksi_id_account_foreign` (`id_account`);

--
-- Indexes for table `view_portfolio`
--
ALTER TABLE `view_portfolio`
  ADD PRIMARY KEY (`id_view_portfolio`),
  ADD UNIQUE KEY `id_view_portfolio` (`id_view_portfolio`),
  ADD KEY `view_portfolio_id_portofolio_foreign` (`id_portofolio`),
  ADD KEY `view_portfolio_id_account_foreign` (`id_account`);

--
-- Indexes for table `view_product`
--
ALTER TABLE `view_product`
  ADD PRIMARY KEY (`id_view_product`),
  ADD UNIQUE KEY `id_view_product` (`id_view_product`),
  ADD KEY `view_product_id_account_foreign` (`id_account`),
  ADD KEY `view_product_id_product_foreign` (`id_product`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `addresses`
--
ALTER TABLE `addresses`
  ADD CONSTRAINT `addresses_id_account_foreign` FOREIGN KEY (`id_account`) REFERENCES `accounts` (`id_account`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `cart_id_account_foreign` FOREIGN KEY (`id_account`) REFERENCES `accounts` (`id_account`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `cart_id_product_foreign` FOREIGN KEY (`id_product`) REFERENCES `products` (`id_product`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `comment_portofolio`
--
ALTER TABLE `comment_portofolio`
  ADD CONSTRAINT `comment_portofolio_id_account_foreign` FOREIGN KEY (`id_account`) REFERENCES `accounts` (`id_account`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `comment_portofolio_id_portofolio_foreign` FOREIGN KEY (`id_portofolio`) REFERENCES `portofolio` (`id_portofolio`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `dokumen_jasa`
--
ALTER TABLE `dokumen_jasa`
  ADD CONSTRAINT `dokumen_jasa_id_transaksi_foreign` FOREIGN KEY (`id_transaksi`) REFERENCES `transaksi` (`id_transaksi`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `hist_search`
--
ALTER TABLE `hist_search`
  ADD CONSTRAINT `hist_search_id_account_foreign` FOREIGN KEY (`id_account`) REFERENCES `accounts` (`id_account`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `images`
--
ALTER TABLE `images`
  ADD CONSTRAINT `images_id_product_foreign` FOREIGN KEY (`id_product`) REFERENCES `products` (`id_product`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `images_portofolio`
--
ALTER TABLE `images_portofolio`
  ADD CONSTRAINT `images_portofolio_id_portofolio_foreign` FOREIGN KEY (`id_portofolio`) REFERENCES `portofolio` (`id_portofolio`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `payments`
--
ALTER TABLE `payments`
  ADD CONSTRAINT `payments_id_transaksi_foreign` FOREIGN KEY (`id_transaksi`) REFERENCES `transaksi` (`id_transaksi`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `pengiriman`
--
ALTER TABLE `pengiriman`
  ADD CONSTRAINT `pengiriman_id_delivery_service_foreign` FOREIGN KEY (`id_delivery_service`) REFERENCES `delivery_service` (`id_delivery_service`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `pengiriman_id_transaksi_foreign` FOREIGN KEY (`id_transaksi`) REFERENCES `transaksi` (`id_transaksi`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `product_order`
--
ALTER TABLE `product_order`
  ADD CONSTRAINT `product_order_id_product_foreign` FOREIGN KEY (`id_product`) REFERENCES `products` (`id_product`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `product_order_id_transaksi_foreign` FOREIGN KEY (`id_transaksi`) REFERENCES `transaksi` (`id_transaksi`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `product_price`
--
ALTER TABLE `product_price`
  ADD CONSTRAINT `product_price_id_product_foreign` FOREIGN KEY (`id_product`) REFERENCES `products` (`id_product`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `product_size`
--
ALTER TABLE `product_size`
  ADD CONSTRAINT `product_size_id_product_foreign` FOREIGN KEY (`id_product`) REFERENCES `products` (`id_product`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `stock`
--
ALTER TABLE `stock`
  ADD CONSTRAINT `stock_id_product_foreign` FOREIGN KEY (`id_product`) REFERENCES `products` (`id_product`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `transaksi`
--
ALTER TABLE `transaksi`
  ADD CONSTRAINT `transaksi_id_account_foreign` FOREIGN KEY (`id_account`) REFERENCES `accounts` (`id_account`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `view_portfolio`
--
ALTER TABLE `view_portfolio`
  ADD CONSTRAINT `view_portfolio_id_account_foreign` FOREIGN KEY (`id_account`) REFERENCES `accounts` (`id_account`) ON DELETE CASCADE ON UPDATE SET NULL,
  ADD CONSTRAINT `view_portfolio_id_portofolio_foreign` FOREIGN KEY (`id_portofolio`) REFERENCES `portofolio` (`id_portofolio`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `view_product`
--
ALTER TABLE `view_product`
  ADD CONSTRAINT `view_product_id_account_foreign` FOREIGN KEY (`id_account`) REFERENCES `accounts` (`id_account`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `view_product_id_product_foreign` FOREIGN KEY (`id_product`) REFERENCES `products` (`id_product`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
