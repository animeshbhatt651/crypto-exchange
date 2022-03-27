-- phpMyAdmin SQL Dump
-- version 4.9.5
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Aug 20, 2020 at 01:59 AM
-- Server version: 5.7.31
-- PHP Version: 7.3.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `changeor_excash`
--

-- --------------------------------------------------------

--
-- Table structure for table `access_token_pool`
--

CREATE TABLE `access_token_pool` (
  `access_token` varchar(32) NOT NULL,
  `expire_in` varchar(50) NOT NULL,
  `access_pages` varchar(200) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `access_token_pool`
--

INSERT INTO `access_token_pool` (`access_token`, `expire_in`, `access_pages`) VALUES
('3c6db9bb9ffc28cee9c5fd690433fa61', '2020/08/15 10:59:22', 'signup'),
('0671274565275ab727316ff01ca01662', '2020/08/15 10:59:31', 'login'),
('cc18a8eed0ecb51118b25397042d73d2', '2020/08/15 11:30:55', 'login'),
('64b5789266b51becb5df55eb820715a6', '2020/08/15 11:31:18', 'mainexchange'),
('5a73ded4dd25503cb89cbc3c020648e0', '2020/08/15 14:05:33', 'mainexchange'),
('61f86c734e665a8247c00977a1331f13', '2020/08/16 01:39:47', 'login'),
('e1a212eb3bd281297f0430a17d801f65', '2020/08/16 01:45:57', 'mainexchange'),
('a2cc3989b438d8b4ab97740abb59fe66', '2020/08/16 02:09:10', 'mainexchange'),
('6219f18e7d2ebcdec6b0df913faefe51', '2020/08/16 02:23:53', 'login'),
('72c3845fa874aca1eedaa83b765bb3cd', '2020/08/16 03:19:27', 'mainexchange'),
('de44c08b5c263244479044bb6dcb7edf', '2020/08/16 03:19:35', 'mainexchange'),
('bfedf3126271b7de0bd08019641055a3', '2020/08/16 03:19:58', 'login'),
('989e222a6939f8dd855b7300621e8c45', '2020/08/16 12:12:21', 'mainexchange'),
('7cb74282cb90ca237f01eaf81c52f179', '2020/08/16 12:12:23', 'mainexchange'),
('7ba921d16f0c82180d0fdfacd1acce77', '2020/08/16 12:12:23', 'mainexchange'),
('ce4ff2724679f8bafde16b42ec32108d', '2020/08/16 12:12:28', 'mainexchange'),
('0d58b99b8ebee49f9f0588fd279db8b6', '2020/08/16 12:12:29', 'mainexchange'),
('15795ee9761843bb7c9c71253acae557', '2020/08/16 12:12:30', 'mainexchange'),
('ff09b1224c33ca11f322dcacf2d1f390', '2020/08/16 12:12:34', 'mainexchange'),
('24c3874b3b248b41d2dab4225533a184', '2020/08/16 12:12:35', 'mainexchange'),
('73fb4653be0e85daac306020c50c0d91', '2020/08/16 12:12:35', 'mainexchange'),
('faada6530d21ed8c4c92dc0cf09a0333', '2020/08/16 12:12:36', 'mainexchange'),
('69ee39f94040959fd3ef329c97f1002e', '2020/08/16 12:12:56', 'mainexchange'),
('97871a89eb088ba5f3e1c9def888126a', '2020/08/16 12:13:15', 'login'),
('a4ed7e6451149366203ff93037a2a98f', '2020/08/16 12:17:50', 'signup'),
('b24a5f58697c905f95e452338747643b', '2020/08/16 12:18:03', 'login'),
('0c0182620094dad0c6f0c868e2a2f2fe', '2020/08/16 12:18:42', 'mainexchange'),
('5c0445851e448a7bf9294fc304b3da6e', '2020/08/18 09:00:29', 'login'),
('d59256d219141d77e7dd50465200b079', '2020/08/18 10:17:08', 'login'),
('7e1a89b4cdc80d809cf38b476410b1e6', '2020/08/18 13:02', 'login'),
('cf174c5af43975c7f410e45fd3709fd6', '2020/08/18 17:35', 'signup'),
('6f911d62a0a50ae90566678aafb13fa1', '2020/08/18 17:35', 'login'),
('3900514758d9b80c5eb4bc23aaadbf11', '2020/08/18 17:35', 'login'),
('f7ebee3a9971969b11b482a77d923390', '2020/08/18 17:59', 'mainexchange'),
('730a87475cfa38eee22d745cbef8c026', '2020/08/18 18:00', 'mainexchange'),
('e82fe4f85ca076fef78825d9bac9e6be', 'expired', 'login'),
('5286577a81f8bf3e635c383ea4771ba5', '2020/08/18 19:06', 'login'),
('01594cb73298f3f6238fd52e281b0ed1', '2020/08/18 19:21', 'signup'),
('d775f9479a3439b729acccefc1315578', 'expired', 'signup'),
('2711f06777f4064c1f166395f30ae2cd', '2020/08/18 19:23', 'login'),
('2dc719df8a770e20ef737024c46ff05b', '2020/08/18 19:24', 'login'),
('ae4ebe3c39b67993632f61a723809dff', '2020/08/18 19:26', 'login'),
('992331fca71d220f72e753768cac7560', '2020/08/18 19:30', 'login'),
('54bc8cc1a917e6cd3b52978332d8c004', '2020/08/18 19:30', 'login'),
('1efade41cc120a8557976cc2d8aecd37', '2020/08/18 19:31', 'login'),
('9284529f99e98eab32b4904c010201dd', '2020/08/18 19:33', 'login'),
('7ddfc33ca51f689b41f6aaf6eff383e7', '2020/08/18 19:34', 'login'),
('e2195cef31007d3c74432c53456edfef', '2020/08/18 19:35', 'login'),
('6833b64d2bfaff6a0cc7f9006ef04aaa', '2020/08/19 01:11', 'login'),
('e307f1d1b9820e724fb357340ca2766d', '2020/08/19 01:13', 'login'),
('794e019fd7aa3415b33cec1906ed8163', '2020/08/19 01:14', 'login'),
('7be418157499c6789617da9f8c7d5007', '2020/08/19 01:15', 'login'),
('52957afdaa8b571b2f2bbebc190d6183', '2020/08/19 01:16', 'login'),
('4bb049a6b6e4c6814705a70994329c52', '2020/08/19 01:17', 'login'),
('101078c43042bd4c1c5544e86bf11462', '2020/08/19 01:18', 'login'),
('00922672c8c255585cdc8d5a214fd38d', '2020/08/18 21:47', 'login'),
('0264ab037d00c84ab8e5dc5b380c7d2c', '2020/08/18 21:49', 'login'),
('4f4ca3eca89ff7c0c5bea211b12f2625', '2020/08/18 21:50', 'login'),
('e9dbd771666a9a4b3296e66c3efd4ab6', '2020/08/18 21:50', 'login'),
('5ecf5cad5000747b71d5a938ef7b84f1', '2020/08/18 21:51', 'login'),
('af26408fef342418b342f4dbcb77fb06', '2020/08/18 21:52', 'login'),
('61bbe25d64e713c3ceafe1d6a057d857', '2020/08/18 21:53', 'login'),
('3720902e32c202ae69d439684575de4d', '2020/08/18 21:53', 'login'),
('6718ed26c2d9f600ba3d4bbea0dc062f', '2020/08/18 21:53', 'login'),
('4022b61151b56b7e191ab7c46e210ffb', '2020/08/18 21:54', 'login'),
('4a27babc287ae9552f7ae827e6e3207e', '2020/08/18 21:54', 'login'),
('2fd93d02a91e79d97a165e235340b818', '2020/08/18 21:55', 'login'),
('5afb59bc69d0d4b2bd50e4f2150e422c', '2020/08/18 22:04', 'login'),
('97f2a6a35e76592caeb6fc7451fe6d67', '2020/08/18 22:13', 'login'),
('ed76ac7942fffd9be9add7d0fcbd7ac9', '2020/08/18 22:16', 'login'),
('006a8b2e8a324f4daa581cef39ce644f', '2020/08/18 22:19', 'login'),
('971f8df3df9ffbc2a596be306050c656', '2020/08/18 22:33', 'login'),
('b9e546ee4e1d834128dfc2f42e3a6697', '2020/08/18 22:43', 'login'),
('90cc885caa73f4dd26587ed409edebbd', '2020/08/18 22:46', 'login'),
('bcce646992bed70284d675b96f7ed4b0', '2020/08/18 22:49', 'login'),
('88a9e36ec0550ecdfc88196a7f38a52c', '2020/08/18 23:07', 'login'),
('feee3d93cbed3d0434bdb1fd4498e954', '2020/08/18 23:09', 'mainexchange'),
('dc682ac7a3369a5f615d629fd880f4e4', '2020/08/18 23:10', 'mainexchange'),
('83592bcef3257cb74adedb9e8e9672bb', '2020/08/18 23:11', 'mainexchange'),
('a3b36ed97ecd93adb45211e6f4e7b96e', '2020/08/18 23:58', 'mainexchange'),
('becf77d4e3c2067774c2062cace4493e', '2020/08/19 00:10', 'login'),
('105ca31335390a36d68b4255c562d136', '2020/08/19 00:10', 'mainexchange'),
('0fd8705db7a160beb8664bfafb91ddc4', '2020/08/19 00:47', 'login'),
('de4792aff02f4898e16885b82c2e177d', '2020/08/19 00:48', 'login'),
('e80da6c667bfffd70ad5a6b11314488d', '2020/08/19 00:50', 'login'),
('c311aa4c44f4c74652df8532c80fddee', '2020/08/19 00:52', 'login'),
('3788a8f1020b056ccbafdb5ae04122ae', '2020/08/19 00:53', 'login'),
('9093b9b21a228b7aa749386a84c0d3ed', '2020/08/19 00:56', 'signup'),
('85b64595747452c198c5d8f72eb7d10d', '2020/08/19 00:57', 'signup'),
('46541bfdd4f27eee8c8aaf6e7ef9dd72', '2020/08/19 01:18', 'login'),
('8d43451de35e4d9f29e5e0a64d94043f', '2020/08/19 01:29', 'signup'),
('18294c064d163364d88360a259654a36', '2020/08/19 01:29', 'login'),
('771ff418ebaa5cd2cc02e251b2570114', '2020/08/19 01:42', 'login'),
('8e258bc14cc0249e8a8a7495b1011a06', '2020/08/19 01:42', 'mainexchange'),
('e9f24cd11ff3351b9d29f96c9b372b77', '2020/08/19 01:45', 'mainexchange'),
('a7b422f910b97484a0775eb556ca615b', '2020/08/19 16:45', 'login'),
('15942b23e7d7f86b06c5ebad56c8204c', '2020/08/19 16:46', 'mainexchange'),
('d575daeb2061847d5f2cde826d4f2ed1', '2020/08/19 16:46', 'mainexchange'),
('b081f8e119c1453b502d93da5408c6ba', '2020/08/19 16:49', 'mainexchange'),
('e7a9d42f08904ecb8e581beeb79c610d', '2020/08/19 16:50', 'mainexchange'),
('77bdc07ce9564405e3591cd4f31f7990', '2020/08/19 16:50', 'mainexchange'),
('8d87ab189331ac6ab4ddae56c2841bc9', '2020/08/19 16:50', 'mainexchange'),
('db65d479142f338cc377a466254ce14e', '2020/08/19 22:10', 'signup'),
('b43218e0651330df2a5d0144175cf4dc', '2020/08/19 22:10', 'login'),
('b0ec6b59a0fb4df2e5286a01d0cd3465', '2020/08/19 23:23', 'login'),
('578337e8444ee8adb534c643e330577b', '2020/08/20 05:15', 'login');

-- --------------------------------------------------------

--
-- Table structure for table `bills_pool`
--

CREATE TABLE `bills_pool` (
  `from_sign` varchar(50) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `to_sign` varchar(50) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `from_amount` varchar(50) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `to_amount` varchar(50) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `created_time` varchar(50) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `owner_email` varchar(100) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `bill_id` varchar(50) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `ip_address` varchar(50) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `otp_code` varchar(10) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `bills_pool`
--

INSERT INTO `bills_pool` (`from_sign`, `to_sign`, `from_amount`, `to_amount`, `created_time`, `owner_email`, `bill_id`, `ip_address`, `otp_code`) VALUES
('BTC', 'ETH', '145', '3956.00076', '2020/08/15 11:28:51', 'mehdidox@gmail.com', '1001', '89.198.15.216', '91497'),
('BTC', 'LTC', '13', '2473.26717', '2020/08/16 01:43:28', 'mehdidox@gmail.com', '1002', '5.211.135.34', '88534'),
('BTC', 'LTC', '13', '2475.90852', '2020/08/16 02:06:41', 'mehdidox@gmail.com', '1003', '5.211.135.34', '30752'),
('DGB', 'BTC', '35540.30303', '0.10086', '2020/08/16 12:16:13', 'mhsalatin@gmail.com', '1004', '46.196.6.154', '40917'),
('BTC', 'ETH', '1', '28.3267', '2020/08/18 17:57:40', 'Matingolmakani@gmail.com', '1005', '5.125.81.156', '99272'),
('BTC', 'ETH', '0.32', '9.06623', '2020/08/18 17:58:13', 'Matingolmakani@gmail.com', '1006', '5.125.81.156', '10331'),
('BNB', 'ETH', '0451', '24.4316', '2020/08/18 21:10:02', 'mehdidox@gmail.com', '1007', '198.16.66.155', '08580'),
('BTC', 'ETH', '0.32', '9.0204', '2020/08/18 21:11:30', 'mehdidox@gmail.com', '1008', '198.16.66.155', '60174'),
('BTC', 'ETH', '13', '367.2893', '2020/08/18 22:11:00', 'mehdidox@gmail.com', '1009', '74.119.145.52', '09748'),
('BTC', 'XRP', '0.32', '12674.68339', '2020/08/18 23:42:47', 'mehdidox@gmail.com', '1010', '74.119.145.52', '65284'),
('BTC', 'ETH', '13', '368.30403', '2020/08/18 23:45:15', 'mehdidox@gmail.com', '1011', '74.119.145.52', '60618'),
('BTC', 'ETH', '0.32', '9.18984', '2020/08/19 14:46:17', 'mehdidox@gmail.com', '1012', '50.7.93.85', '70961'),
('BTC', 'ETH', '0.32', '9.19275', '2020/08/19 14:46:54', 'mehdidox@gmail.com', '1013', '50.7.93.85', '54445'),
('BTC', 'ETH', '0.32', '9.18292', '2020/08/19 14:50:00', 'mehdidox@gmail.com', '1014', '50.7.93.85', '28031'),
('BTC', 'ETH', '0.32', '9.18174', '2020/08/19 14:50:01', 'mehdidox@gmail.com', '1015', '50.7.93.85', '26711');

-- --------------------------------------------------------

--
-- Table structure for table `crypto_prices_pool`
--

CREATE TABLE `crypto_prices_pool` (
  `crypto_name` varchar(50) NOT NULL,
  `crypto_last_price` varchar(50) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `reset_pool`
--

CREATE TABLE `reset_pool` (
  `owner_email` varchar(150) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `vr_key` varchar(300) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `reset_pool`
--

INSERT INTO `reset_pool` (`owner_email`, `vr_key`) VALUES
('ph09nixom@gmail.com', 'b6468804b7b53deb75835c75b8ba09db'),
('ph09nixom@gmail.com', 'b6468804b7b53deb75835c75b8ba09db');

-- --------------------------------------------------------

--
-- Table structure for table `tickets_pool`
--

CREATE TABLE `tickets_pool` (
  `subject` varchar(200) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `status` varchar(150) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `type` varchar(200) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `priority` varchar(200) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `text` varchar(5000) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `time` varchar(200) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `answer` varchar(1500) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `owner_email` varchar(200) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tickets_pool`
--

INSERT INTO `tickets_pool` (`subject`, `status`, `type`, `priority`, `text`, `time`, `answer`, `owner_email`) VALUES
('bgfbggggggggg', 'Pending', 'technical', 'low', 'gbgfbgggggggggbgfbgggggggggbgfbggggggggg', '2020/08/18 10:35', 'There is no answer', 'mehdidox@gmail.com'),
('salam shayan janam', 'Pending', 'technical', 'high', 'koskesha ridid be mola', '10:44', 'There is no answer', 'mehdidox@gmail.com');

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE `transactions` (
  `owner_email` varchar(100) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `url` varchar(200) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `from_sign` varchar(150) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `to_sign` varchar(150) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `from_amount` varchar(150) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `to_amount` varchar(150) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `wallet` varchar(200) NOT NULL,
  `bill_id` varchar(100) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `status` varchar(100) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `users_pool`
--

CREATE TABLE `users_pool` (
  `email` varchar(150) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `password` varchar(150) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `first_name` varchar(150) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `last_name` varchar(150) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `join_time` varchar(50) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `transactions_count` int(20) NOT NULL,
  `last_login` varchar(100) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users_pool`
--

INSERT INTO `users_pool` (`email`, `password`, `first_name`, `last_name`, `join_time`, `transactions_count`, `last_login`) VALUES
('mehdidox@gmail.com', 'mehdidox@gmail.com', 'mehdi', 'dox', '2020/08/15 10:56:55', 0, '0ff01f8ef02037dd5b774f37ba59066f'),
('mhsalatin@gmail.com', 'MohammadSalatin123!', 'D0X4', '', '2020/08/16 12:15:20', 0, 'ca0fb6701a14c041ae05400a7a277dae'),
('Matingolmakani@gmail.com', 'MARTINgLmK', 'Dr.Martin', '', '2020/08/18 17:33:06', 0, '29d7041d0c10e8ca732b7968009c7de9'),
('BAEBETAG@GMAIL.COM', 'VRQ3RVAWGV', 'wrvWRV', '', '2020/08/18 19:19:38', 0, ''),
('MartinGolmakani@gmail.com', 'martingol', 'wrvWRV', '', '2020/08/18 19:21:00', 0, ''),
('ph09nixom@gmail.com', 'KosmikhamBemola', 'ph09nix', '', '2020/08/18 22:56:38', 0, '2685c4a7596a55bf60e78da0c7b9661d'),
('johnsql051@gmail.com', '88106017', 'MAHDI', '', '2020/08/18 22:57:03', 0, ''),
('kirkhar@gmail.com', 'kirkhar@gmail.com', '', '', '2020/08/18 23:29:37', 0, '693a589b0b18fd86b73b85ecfcaa6cb5'),
('test@gmail.com', 'test@gmail.com', '', '', '2020/08/19 20:10:08', 0, 'ee1e4a63190ee679b4e6697bd8ee7740');

-- --------------------------------------------------------

--
-- Table structure for table `wallets_pool`
--

CREATE TABLE `wallets_pool` (
  `name` varchar(50) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `address` varchar(50) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `owner_email` varchar(50) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `created_time` varchar(50) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `wallets_pool`
--

INSERT INTO `wallets_pool` (`name`, `address`, `owner_email`, `created_time`) VALUES
('test', 'wrbrbavestdbhagtgenywhumrtnyrbtevrwc', 'mehdidox@gmail.com', '2020/08/19 14:46:43'),
('ffvvf', 'fdvdfvfdvfdvfdv', 'mehdidox@gmail.com', '2020/08/19 14:49:48');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
