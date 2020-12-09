-- phpMyAdmin SQL Dump
-- version 5.0.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Czas generowania: 09 Gru 2020, 09:28
-- Wersja serwera: 10.4.14-MariaDB
-- Wersja PHP: 7.4.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Baza danych: `password_wallet`
--

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `ips`
--

CREATE TABLE `ips` (
  `id_ips` int(11) NOT NULL,
  `ip` varchar(20) NOT NULL,
  `count_of_failed` int(1) NOT NULL,
  `block` varchar(8) NOT NULL DEFAULT 'unlock'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Zrzut danych tabeli `ips`
--

INSERT INTO `ips` (`id_ips`, `ip`, `count_of_failed`, `block`) VALUES
(10, '::1', 0, 'unlock');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `logs`
--

CREATE TABLE `logs` (
  `id_log` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `time` datetime NOT NULL,
  `result` varchar(12) NOT NULL,
  `ip` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Zrzut danych tabeli `logs`
--

INSERT INTO `logs` (`id_log`, `id_user`, `time`, `result`, `ip`) VALUES
(16, 40, '2020-11-23 16:09:33', 'successful', '::1'),
(17, 40, '2020-11-23 16:26:36', 'failed', '::1'),
(18, 40, '2020-11-23 16:26:43', 'failed', '::1'),
(19, 40, '2020-11-23 16:26:50', 'failed', '::1'),
(20, 40, '2020-11-23 16:26:53', 'failed', '::1'),
(21, 40, '2020-11-23 16:27:13', 'failed', '::1'),
(22, 40, '2020-11-23 16:27:19', 'failed', '::1'),
(23, 40, '2020-11-23 16:30:54', 'failed', '::1'),
(24, 40, '2020-11-23 16:31:19', 'failed', '::1'),
(25, 40, '2020-11-23 16:32:05', 'failed', '::1'),
(26, 40, '2020-11-23 16:33:47', 'failed', '::1'),
(27, 40, '2020-11-23 16:33:55', 'failed', '::1'),
(28, 40, '2020-11-23 16:34:20', 'failed', '::1'),
(29, 40, '2020-11-23 16:34:31', 'failed', '::1'),
(30, 40, '2020-11-23 16:34:39', 'failed', '::1'),
(31, 40, '2020-11-23 16:35:21', 'failed', '::1'),
(32, 40, '2020-11-23 16:35:36', 'failed', '::1'),
(33, 40, '2020-11-23 16:36:59', 'failed', '::1'),
(34, 40, '2020-11-23 16:37:00', 'failed', '::1'),
(35, 40, '2020-11-23 16:37:03', 'failed', '::1'),
(36, 40, '2020-11-23 16:37:31', 'failed', '::1'),
(37, 40, '2020-11-23 16:37:37', 'failed', '::1'),
(38, 40, '2020-11-23 16:37:41', 'failed', '::1'),
(39, 40, '2020-11-23 16:38:12', 'failed', '::1'),
(40, 40, '2020-11-23 16:38:20', 'failed', '::1'),
(41, 40, '2020-11-23 16:39:13', 'failed', '::1'),
(42, 40, '2020-11-23 16:39:17', 'failed', '::1'),
(43, 40, '2020-11-23 16:39:22', 'failed', '::1'),
(44, 40, '2020-11-23 16:39:27', 'failed', '::1'),
(45, 40, '2020-11-23 16:39:32', 'failed', '::1'),
(46, 40, '2020-11-23 16:39:57', 'successful', '::1'),
(47, 40, '2020-11-23 16:40:06', 'failed', '::1'),
(48, 40, '2020-11-23 16:40:09', 'failed', '::1'),
(49, 40, '2020-11-23 16:40:44', 'failed', '::1'),
(50, 40, '2020-11-23 16:40:49', 'failed', '::1'),
(51, 40, '2020-11-23 16:40:52', 'failed', '::1'),
(52, 40, '2020-11-23 16:40:54', 'failed', '::1'),
(53, 40, '2020-11-23 16:40:57', 'failed', '::1'),
(54, 40, '2020-11-23 16:42:11', 'failed', '::1'),
(55, 40, '2020-11-23 16:44:39', 'failed', '::1'),
(56, 40, '2020-11-23 16:45:33', 'failed', '::1'),
(57, 40, '2020-11-23 16:45:50', 'failed', '::1'),
(58, 40, '2020-11-23 16:46:02', 'failed', '::1'),
(59, 40, '2020-11-23 16:46:06', 'failed', '::1'),
(60, 40, '2020-11-23 16:46:26', 'failed', '::1'),
(61, 40, '2020-11-23 16:46:33', 'failed', '::1'),
(62, 40, '2020-11-23 16:50:50', 'failed', '::1'),
(63, 40, '2020-11-23 16:50:55', 'failed', '::1'),
(64, 40, '2020-11-23 16:51:01', 'failed', '::1'),
(65, 40, '2020-11-23 16:51:52', 'failed', '::1'),
(66, 40, '2020-11-23 16:52:07', 'failed', '::1'),
(67, 40, '2020-11-23 16:52:27', 'failed', '::1'),
(68, 40, '2020-11-23 16:52:31', 'failed', '::1'),
(69, 40, '2020-11-23 16:55:30', 'failed', '::1'),
(70, 40, '2020-11-23 20:14:44', 'failed', '::1'),
(71, 40, '2020-11-23 20:14:49', 'failed', '::1'),
(72, 40, '2020-11-24 11:42:11', 'failed', '::1'),
(73, 40, '2020-11-24 11:42:57', 'failed', '::1'),
(74, 40, '2020-11-24 11:43:05', 'failed', '::1'),
(75, 40, '2020-11-24 11:45:00', 'failed', '::1'),
(76, 40, '2020-11-24 11:45:04', 'failed', '::1'),
(77, 40, '2020-11-24 12:07:33', 'failed', '::1'),
(78, 40, '2020-11-24 12:10:09', 'successful', '::1'),
(79, 40, '2020-11-24 12:14:35', 'successful', '::1'),
(80, 40, '2020-11-24 12:14:43', 'successful', '::1'),
(81, 40, '2020-11-24 12:56:35', 'successful', '::1'),
(82, 40, '2020-11-24 12:58:13', 'successful', '::1'),
(83, 40, '2020-11-24 12:58:33', 'successful', '::1'),
(84, 40, '2020-11-24 13:00:05', 'successful', '::1'),
(85, 40, '2020-11-24 13:00:17', 'failed', '::1'),
(86, 40, '2020-11-24 14:04:25', 'successful', '::1'),
(87, 40, '2020-11-24 14:04:45', 'failed', '::1'),
(88, 41, '2020-11-24 14:10:27', 'successful', '::1'),
(89, 40, '2020-11-24 14:10:47', 'failed', '::1'),
(90, 40, '2020-11-24 14:11:54', 'failed', '::1'),
(91, 40, '2020-11-24 14:12:02', 'successful', '::1'),
(92, 40, '2020-11-24 14:13:08', 'failed', '::1'),
(93, 40, '2020-11-24 14:13:41', 'failed', '::1'),
(94, 41, '2020-11-24 14:15:07', 'failed', '::1'),
(95, 40, '2020-11-24 14:16:31', 'failed', '::1'),
(96, 40, '2020-11-24 14:17:22', 'successful', '::1'),
(97, 40, '2020-11-24 14:41:15', 'failed', '::1'),
(98, 40, '2020-11-24 14:41:34', 'successful', '::1'),
(99, 40, '2020-11-24 14:41:42', 'failed', '::1'),
(100, 40, '2020-11-24 14:42:06', 'failed', '::1'),
(101, 40, '2020-11-24 14:42:14', 'successful', '::1'),
(102, 40, '2020-11-24 14:42:19', 'failed', '::1'),
(103, 40, '2020-11-24 14:42:22', 'failed', '::1'),
(104, 40, '2020-11-24 14:42:35', 'failed', '::1'),
(105, 40, '2020-11-25 08:21:16', 'failed', '::1'),
(106, 40, '2020-11-25 08:21:39', 'successful', '::1'),
(107, 40, '2020-11-25 08:27:18', 'failed', '::1'),
(108, 40, '2020-11-25 08:27:45', 'failed', '::1'),
(109, 40, '2020-11-25 08:27:59', 'failed', '::1'),
(110, 40, '2020-11-25 08:28:16', 'failed', '::1'),
(111, 40, '2020-11-25 08:29:31', 'successful', '::1'),
(112, 40, '2020-11-25 08:30:06', 'successful', '::1'),
(113, 40, '2020-11-25 08:33:42', 'successful', '::1'),
(114, 40, '2020-11-25 08:33:50', 'failed', '::1'),
(115, 40, '2020-11-25 08:34:00', 'failed', '::1'),
(116, 40, '2020-11-25 08:34:18', 'failed', '::1'),
(117, 40, '2020-11-25 08:34:34', 'failed', '::1'),
(118, 40, '2020-11-25 08:42:42', 'failed', '::1'),
(119, 40, '2020-11-25 08:42:46', 'failed', '::1'),
(120, 40, '2020-11-25 08:42:58', 'failed', '::1'),
(121, 40, '2020-11-25 08:43:14', 'failed', '::1'),
(122, 40, '2020-11-25 08:48:30', 'failed', '::1'),
(123, 40, '2020-11-25 08:50:21', 'failed', '::1'),
(124, 40, '2020-11-25 08:50:32', 'failed', '::1'),
(125, 40, '2020-11-25 08:50:48', 'failed', '::1'),
(126, 40, '2020-11-25 08:54:19', 'failed', '::1'),
(127, 40, '2020-11-25 08:55:10', 'failed', '::1'),
(128, 40, '2020-11-25 08:55:18', 'failed', '::1'),
(129, 40, '2020-11-25 08:55:32', 'failed', '::1'),
(130, 40, '2020-11-25 09:00:06', 'failed', '::1'),
(131, 40, '2020-11-25 09:00:10', 'failed', '::1'),
(132, 40, '2020-11-25 09:00:16', 'failed', '::1'),
(133, 40, '2020-11-25 09:00:27', 'failed', '::1'),
(134, 40, '2020-11-25 09:03:42', 'failed', '::1'),
(135, 40, '2020-11-25 09:03:53', 'failed', '::1'),
(136, 40, '2020-11-25 09:04:04', 'failed', '::1'),
(137, 40, '2020-11-25 09:09:24', 'failed', '::1'),
(138, 40, '2020-11-25 09:09:29', 'failed', '::1'),
(139, 40, '2020-11-25 09:09:35', 'failed', '::1'),
(140, 40, '2020-11-25 09:09:46', 'failed', '::1'),
(141, 40, '2020-11-25 09:10:37', 'failed', '::1'),
(142, 40, '2020-11-25 09:10:45', 'failed', '::1'),
(143, 40, '2020-11-25 09:10:51', 'successful', '::1'),
(144, 40, '2020-11-25 09:20:09', 'failed', '::1'),
(145, 40, '2020-11-25 09:20:16', 'failed', '::1'),
(146, 40, '2020-11-25 09:20:25', 'failed', '::1'),
(147, 40, '2020-11-25 09:20:36', 'failed', '::1'),
(148, 40, '2020-11-25 09:21:36', 'failed', '::1'),
(149, 40, '2020-11-25 09:21:43', 'successful', '::1'),
(150, 40, '2020-11-29 16:50:43', 'failed', '::1'),
(151, 40, '2020-11-29 16:50:45', 'failed', '::1'),
(152, 40, '2020-11-29 16:50:51', 'failed', '::1'),
(153, 40, '2020-11-29 16:51:04', 'failed', '::1'),
(154, 40, '2020-12-07 19:39:47', 'successful', '::1'),
(155, 40, '2020-12-07 19:41:56', 'successful', '::1'),
(156, 40, '2020-12-07 20:01:55', 'successful', '::1'),
(157, 40, '2020-12-07 20:43:45', 'successful', '::1'),
(158, 40, '2020-12-07 20:45:34', 'successful', '::1'),
(159, 40, '2020-12-07 20:47:27', 'successful', '::1'),
(160, 40, '2020-12-08 12:13:17', 'successful', '::1'),
(161, 40, '2020-12-08 14:03:01', 'successful', '::1'),
(162, 40, '2020-12-08 19:01:35', 'successful', '::1'),
(163, 42, '2020-12-08 19:12:49', 'successful', '::1'),
(164, 40, '2020-12-08 19:14:18', 'successful', '::1'),
(165, 40, '2020-12-08 19:15:42', 'successful', '::1'),
(166, 40, '2020-12-08 19:16:16', 'successful', '::1'),
(167, 42, '2020-12-08 19:21:21', 'successful', '::1'),
(168, 40, '2020-12-08 19:32:43', 'successful', '::1'),
(169, 42, '2020-12-08 19:33:17', 'successful', '::1'),
(170, 42, '2020-12-08 19:54:55', 'successful', '::1'),
(171, 40, '2020-12-08 19:55:21', 'successful', '::1'),
(172, 42, '2020-12-08 19:55:48', 'successful', '::1'),
(173, 40, '2020-12-08 19:55:54', 'successful', '::1'),
(174, 42, '2020-12-08 19:56:09', 'successful', '::1'),
(175, 40, '2020-12-08 19:56:26', 'successful', '::1'),
(176, 42, '2020-12-08 19:59:51', 'successful', '::1'),
(177, 41, '2020-12-09 08:29:48', 'successful', '::1'),
(178, 42, '2020-12-09 08:31:51', 'successful', '::1'),
(179, 42, '2020-12-09 08:52:18', 'successful', '::1'),
(180, 40, '2020-12-09 09:06:21', 'successful', '::1'),
(181, 41, '2020-12-09 09:07:18', 'successful', '::1'),
(182, 40, '2020-12-09 09:19:10', 'successful', '::1'),
(183, 42, '2020-12-09 09:23:22', 'successful', '::1');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `password`
--

CREATE TABLE `password` (
  `id` int(11) NOT NULL,
  `password` varchar(256) COLLATE utf8_polish_ci NOT NULL,
  `id_user` int(11) NOT NULL,
  `web_address` varchar(256) COLLATE utf8_polish_ci NOT NULL,
  `description` varchar(256) COLLATE utf8_polish_ci NOT NULL,
  `login` varchar(30) COLLATE utf8_polish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `password`
--

INSERT INTO `password` (`id`, `password`, `id_user`, `web_address`, `description`, `login`) VALUES
(105, '5WXHPy544clP70UeDIAE1w==', 41, 'test2.pl', 'test2.pl', 'test222'),
(106, '5WXHPy544clP70UeDIAE1w==', 40, 'test.pl', 'test', 'testtest');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `sharing`
--

CREATE TABLE `sharing` (
  `id_sharing` int(11) NOT NULL,
  `id_user_giving` int(11) NOT NULL,
  `id_user_taking` int(11) NOT NULL,
  `id_password` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Zrzut danych tabeli `sharing`
--

INSERT INTO `sharing` (`id_sharing`, `id_user_giving`, `id_user_taking`, `id_password`) VALUES
(23, 41, 42, 105),
(24, 41, 40, 105),
(25, 40, 42, 106);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `login` varchar(30) COLLATE utf8_polish_ci NOT NULL,
  `password_hash` varchar(512) COLLATE utf8_polish_ci NOT NULL,
  `salt` varchar(20) COLLATE utf8_polish_ci NOT NULL,
  `isPasswordKeptAsHash` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `user`
--

INSERT INTO `user` (`id`, `login`, `password_hash`, `salt`, `isPasswordKeptAsHash`) VALUES
(40, 'Test', '795d08f0f8b31407e0e5f21a684aac039d5bf8589892f51bd8e1b75b5ac1157d2078fcbdb94d626b079eb066564a2573d6df24673aa6fe08e04fa0c67d765fdf', '21393807795f9ecce161', 1),
(41, 'test2', 'c360d7cc0454b121bc4bd276b844090316ff7281aff1c4dc45265d643145d64180029647303513e0b44a4535f5d563e276f6ec104b77f7e0a3cf2edb1c0e901e', '8317323075f9ecd1edcc', 0),
(42, 'admin', 'cfe8c250cbc8b99056b8f55c2eced7660fa7d82f3173f7f626a940d56847b643bcc6191ca516b0bc33a1421a65f5eb0654a38480437c7ed268eec9649b4edfb4', '11107377625fcfb870da', 1);

--
-- Indeksy dla zrzutów tabel
--

--
-- Indeksy dla tabeli `ips`
--
ALTER TABLE `ips`
  ADD PRIMARY KEY (`id_ips`);

--
-- Indeksy dla tabeli `logs`
--
ALTER TABLE `logs`
  ADD PRIMARY KEY (`id_log`);

--
-- Indeksy dla tabeli `password`
--
ALTER TABLE `password`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_user` (`id_user`);

--
-- Indeksy dla tabeli `sharing`
--
ALTER TABLE `sharing`
  ADD PRIMARY KEY (`id_sharing`);

--
-- Indeksy dla tabeli `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT dla zrzuconych tabel
--

--
-- AUTO_INCREMENT dla tabeli `ips`
--
ALTER TABLE `ips`
  MODIFY `id_ips` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT dla tabeli `logs`
--
ALTER TABLE `logs`
  MODIFY `id_log` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=184;

--
-- AUTO_INCREMENT dla tabeli `password`
--
ALTER TABLE `password`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=107;

--
-- AUTO_INCREMENT dla tabeli `sharing`
--
ALTER TABLE `sharing`
  MODIFY `id_sharing` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT dla tabeli `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
