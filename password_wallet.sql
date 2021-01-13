-- phpMyAdmin SQL Dump
-- version 5.0.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Czas generowania: 13 Sty 2021, 08:34
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
-- Struktura tabeli dla tabeli `action_type`
--

CREATE TABLE `action_type` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(30) NOT NULL,
  `description` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Zrzut danych tabeli `action_type`
--

INSERT INTO `action_type` (`id`, `title`, `description`) VALUES
(1, 'create', 'creating or adding new information'),
(2, 'read', 'reading or displaying existing information'),
(3, 'update', 'modifying or editing existing information'),
(4, 'delete', 'removal of existing information');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `data_change`
--

CREATE TABLE `data_change` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `id_user` int(11) NOT NULL,
  `table_name` varchar(30) NOT NULL,
  `id_message_record` int(11) NOT NULL,
  `previous_value_of_record` text DEFAULT NULL,
  `present_value_of_record` text DEFAULT NULL,
  `time` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `id_action_type` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Zrzut danych tabeli `data_change`
--

INSERT INTO `data_change` (`id`, `id_user`, `table_name`, `id_message_record`, `previous_value_of_record`, `present_value_of_record`, `time`, `id_action_type`) VALUES
(52, 42, 'password', 122, '', 'UGSj3AFYCBgYQzVAI6vYHg==|42|admin.pl|admin page|adminLogin', '2020-12-31 13:21:53', 1),
(53, 42, 'password', 52, 'UGSj3AFYCBgYQzVAI6vYHg==|42|admin.pl|admin page|admin|0', 'UGSj3AFYCBgYQzVAI6vYHg==|42|admin.pl|admin page|adminLogin|1', '2020-12-31 13:23:15', 3),
(54, 42, 'password', 122, 'UGSj3AFYCBgYQzVAI6vYHg==|42|admin.pl|admin page|adminLogin|0', 'arcUHN3Mh+vpg0x6KhHkK5HxxpoBJ9+f0o+nymn/zmM=|42|admin.pl|admin page|adminLogin-updated|0', '2020-12-31 13:23:39', 3),
(55, 42, 'password', 122, 'arcUHN3Mh+vpg0x6KhHkK5HxxpoBJ9+f0o+nymn/zmM=|42|admin.pl|admin page|adminLogin-updated|0', 'arcUHN3Mh+vpg0x6KhHkK5HxxpoBJ9+f0o+nymn/zmM=|42|admin.pl|admin page|adminLogin-updated|0', '2020-12-31 13:27:34', 3),
(56, 42, 'password', 122, 'arcUHN3Mh+vpg0x6KhHkK5HxxpoBJ9+f0o+nymn/zmM=|42|admin.pl|admin page|adminLogin-updated|0', 'arcUHN3Mh+vpg0x6KhHkK5HxxpoBJ9+f0o+nymn/zmM=|42|admin.pl|admin page|adminLogin-updated|0', '2020-12-31 13:27:50', 3),
(57, 42, 'password', 122, 'arcUHN3Mh+vpg0x6KhHkK5HxxpoBJ9+f0o+nymn/zmM=|42|admin.pl|admin page|adminLogin-updated|0', 'arcUHN3Mh+vpg0x6KhHkK5HxxpoBJ9+f0o+nymn/zmM=|42|admin.pl|admin page|adminLogin-updated|0', '2020-12-31 13:29:17', 3),
(58, 42, 'password', 122, 'arcUHN3Mh+vpg0x6KhHkK5HxxpoBJ9+f0o+nymn/zmM=|42|admin.pl|admin page|adminLogin-updated|0', 'arcUHN3Mh+vpg0x6KhHkK5HxxpoBJ9+f0o+nymn/zmM=|42|admin.pl|admin page|adminLogin-updated|0', '2020-12-31 13:29:51', 3),
(59, 42, 'password', 122, 'arcUHN3Mh+vpg0x6KhHkK5HxxpoBJ9+f0o+nymn/zmM=|42|admin.pl|admin page|adminLogin-updated|0', 'arcUHN3Mh+vpg0x6KhHkK5HxxpoBJ9+f0o+nymn/zmM=|42|admin.pl|admin page|adminLogin-updated|0', '2020-12-31 13:30:42', 3),
(60, 42, 'password', 122, 'arcUHN3Mh+vpg0x6KhHkK5HxxpoBJ9+f0o+nymn/zmM=|42|admin.pl|admin page|adminLogin-updated|0', 'arcUHN3Mh+vpg0x6KhHkK5HxxpoBJ9+f0o+nymn/zmM=|42|admin.pl|admin page|adminLogin-updated|0', '2020-12-31 13:31:02', 3),
(61, 42, 'password', 122, 'arcUHN3Mh+vpg0x6KhHkK5HxxpoBJ9+f0o+nymn/zmM=|42|admin.pl|admin page|adminLogin-updated|0', 'arcUHN3Mh+vpg0x6KhHkK5HxxpoBJ9+f0o+nymn/zmM=|42|admin.pl|admin page|adminLogin-updated|0', '2020-12-31 13:32:40', 3),
(62, 42, 'password', 122, 'arcUHN3Mh+vpg0x6KhHkK5HxxpoBJ9+f0o+nymn/zmM=|42|admin.pl|admin page|adminLogin-updated|0', 'arcUHN3Mh+vpg0x6KhHkK5HxxpoBJ9+f0o+nymn/zmM=|42|admin.pl|admin page|adminLogin-updated|0', '2020-12-31 13:33:42', 3),
(63, 42, 'password', 122, 'arcUHN3Mh+vpg0x6KhHkK5HxxpoBJ9+f0o+nymn/zmM=|42|admin.pl|admin page|adminLogin-updated|0', 'arcUHN3Mh+vpg0x6KhHkK5HxxpoBJ9+f0o+nymn/zmM=|42|admin.pl|admin page|adminLogin-updated|0', '2020-12-31 13:35:36', 3),
(64, 42, 'password', 122, 'arcUHN3Mh+vpg0x6KhHkK5HxxpoBJ9+f0o+nymn/zmM=|42|admin.pl|admin page|adminLogin-updated|0', 'arcUHN3Mh+vpg0x6KhHkK5HxxpoBJ9+f0o+nymn/zmM=|42|admin.pl|admin page|adminLogin-updated|0', '2020-12-31 13:37:21', 3),
(65, 42, 'password', 122, 'arcUHN3Mh+vpg0x6KhHkK5HxxpoBJ9+f0o+nymn/zmM=|42|admin.pl|admin page|adminLogin-updated|0', 'arcUHN3Mh+vpg0x6KhHkK5HxxpoBJ9+f0o+nymn/zmM=|42|admin.pl|admin page|adminLogin-updated|0', '2020-12-31 13:38:19', 3),
(66, 42, 'password', 123, '', 'NtHeGEOxRCrpIn3cbm0ETQ==|42|page.com|page blablabla|page', '2020-12-31 13:51:00', 1),
(67, 42, 'password', 52, 'arcUHN3Mh+vpg0x6KhHkK5HxxpoBJ9+f0o+nymn/zmM=|42|admin.pl|admin page|admin|0', 'UGSj3AFYCBgYQzVAI6vYHg==|42|admin.pl|admin page|adminLogin|1', '2020-12-31 13:51:31', 3),
(68, 40, 'password', 124, '', '5WXHPy544clP70UeDIAE1w==|40|test.com|test desc|test', '2020-12-31 13:53:33', 1),
(69, 42, 'password', 122, 'UGSj3AFYCBgYQzVAI6vYHg==|42|admin.pl|admin page|admin|0', 'deleted', '2020-12-31 13:53:55', 4),
(70, 42, 'password', 122, 'UGSj3AFYCBgYQzVAI6vYHg==|42|admin.pl|admin page|admin|0', 'deleted', '2020-12-31 13:54:02', 4),
(71, 42, 'password', 122, 'deleted', 'UGSj3AFYCBgYQzVAI6vYHg==|42|admin.pl|admin page|admin|0', '2020-12-31 13:56:34', 1),
(72, 42, 'password', 122, 'UGSj3AFYCBgYQzVAI6vYHg==|42|admin.pl|admin page|admin|0', 'deleted', '2020-12-31 13:56:38', 4),
(73, 42, 'password', 122, 'deleted', 'UGSj3AFYCBgYQzVAI6vYHg==|42|admin.pl|admin page|admin|0', '2020-12-31 13:57:05', 1),
(74, 42, 'password', 122, 'UGSj3AFYCBgYQzVAI6vYHg==|42|admin.pl|admin page|admin|0', 'deleted', '2020-12-31 13:59:45', 4),
(75, 42, 'password', 122, 'UGSj3AFYCBgYQzVAI6vYHg==|42|admin.pl|admin page|admin|0', 'arcUHN3Mh+vpg0x6KhHkK5HxxpoBJ9+f0o+nymn/zmM=|42|admin.pl|admin page|adminLogin-updated|0', '2020-12-31 14:00:22', 3),
(76, 42, 'password', 122, 'deleted', 'arcUHN3Mh+vpg0x6KhHkK5HxxpoBJ9+f0o+nymn/zmM=|42|admin.pl|admin page|admin|0', '2020-12-31 14:00:33', 1),
(77, 42, 'password', 122, 'arcUHN3Mh+vpg0x6KhHkK5HxxpoBJ9+f0o+nymn/zmM=|42|admin.pl|admin page|adminLogin-updated|0', 'srRyuo9tcpVE2T0Qc4DDVg==|42|cycha.pl|admin page|cycha|0', '2020-12-31 14:01:02', 3),
(78, 42, 'password', 122, 'srRyuo9tcpVE2T0Qc4DDVg==|42|cycha.pl|admin page|admin|0', 'arcUHN3Mh+vpg0x6KhHkK5HxxpoBJ9+f0o+nymn/zmM=|42|admin.pl|admin page|adminLogin-updated|0', '2020-12-31 14:01:16', 3),
(79, 42, 'password', 122, 'arcUHN3Mh+vpg0x6KhHkK5HxxpoBJ9+f0o+nymn/zmM=|42|admin.pl|admin page|admin|0', 'deleted', '2020-12-31 14:02:45', 4),
(80, 42, 'password', 122, 'arcUHN3Mh+vpg0x6KhHkK5HxxpoBJ9+f0o+nymn/zmM=|42|admin.pl|admin page|admin|0', 'srRyuo9tcpVE2T0Qc4DDVg==|42|cycha.pl|admin page|admin|0', '2020-12-31 14:02:57', 3),
(81, 42, 'password', 122, 'srRyuo9tcpVE2T0Qc4DDVg==|42|cycha.pl|admin page|admin|0', 'arcUHN3Mh+vpg0x6KhHkK5HxxpoBJ9+f0o+nymn/zmM=|42|admin.pl|admin page|adminLogin-updated|0', '2020-12-31 14:04:18', 3),
(82, 42, 'password', 123, 'NtHeGEOxRCrpIn3cbm0ETQ==|42|page.com|page blablabla|page|0', 'NtHeGEOxRCrpIn3cbm0ETQ==|42|page.com|page blablabla|pagepage|0', '2021-01-13 07:31:17', 3),
(83, 42, 'password', 123, 'NtHeGEOxRCrpIn3cbm0ETQ==|42|page.com|page blablabla|admin|0', 'NtHeGEOxRCrpIn3cbm0ETQ==|42|page.com|page blablabla|page|0', '2021-01-13 07:31:54', 3);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `function`
--

CREATE TABLE `function` (
  `id` int(11) NOT NULL,
  `function_name` varchar(30) NOT NULL,
  `description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Zrzut danych tabeli `function`
--

INSERT INTO `function` (`id`, `function_name`, `description`) VALUES
(1, 'getPartition', 'Get the appropriate partition. Argument: the user id'),
(2, 'editPartition', 'Function to edit partition. \r\n\r\nArgument: \r\n-password id\r\n-password login \r\n-user password\r\n-description\r\n-web address\r\n-user id'),
(3, 'createPartition', 'Function to create partition\r\n\r\nArguments:\r\n-password login \r\n-user password\r\n-description\r\n-web address\r\n-user id'),
(4, 'deletePosition', 'Function that removes a record from the \"password\" table with the given id. Item id.\r\n\r\nArguments:\r\n-password id'),
(5, 'checkifuserisowner', 'Check if user is password owner\r\n\r\nArguments:\r\n-password id');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `function_run`
--

CREATE TABLE `function_run` (
  `id` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `time` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `id_function` int(11) NOT NULL,
  `id_action_type` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Zrzut danych tabeli `function_run`
--

INSERT INTO `function_run` (`id`, `id_user`, `time`, `id_function`, `id_action_type`) VALUES
(407, 42, '2020-12-31 13:22:47', 1, 2),
(408, 42, '2020-12-31 13:22:56', 1, 2),
(409, 42, '2020-12-31 13:23:15', 1, 2),
(410, 42, '2020-12-31 13:23:15', 1, 2),
(411, 42, '2020-12-31 13:23:39', 2, 3),
(412, 42, '2020-12-31 13:23:39', 1, 2),
(413, 42, '2020-12-31 13:27:34', 2, 3),
(414, 42, '2020-12-31 13:27:34', 1, 2),
(415, 42, '2020-12-31 13:27:50', 2, 3),
(416, 42, '2020-12-31 13:27:50', 1, 2),
(417, 42, '2020-12-31 13:29:17', 2, 3),
(418, 42, '2020-12-31 13:29:17', 1, 2),
(419, 42, '2020-12-31 13:29:51', 2, 3),
(420, 42, '2020-12-31 13:29:51', 1, 2),
(421, 42, '2020-12-31 13:30:42', 2, 3),
(422, 42, '2020-12-31 13:30:42', 1, 2),
(423, 42, '2020-12-31 13:31:02', 2, 3),
(424, 42, '2020-12-31 13:31:02', 1, 2),
(425, 42, '2020-12-31 13:32:40', 2, 3),
(426, 42, '2020-12-31 13:32:40', 1, 2),
(427, 42, '2020-12-31 13:33:42', 2, 3),
(428, 42, '2020-12-31 13:33:42', 1, 2),
(429, 42, '2020-12-31 13:35:36', 2, 3),
(430, 42, '2020-12-31 13:35:36', 1, 2),
(431, 42, '2020-12-31 13:37:21', 2, 3),
(432, 42, '2020-12-31 13:37:21', 1, 2),
(433, 42, '2020-12-31 13:38:19', 2, 3),
(434, 42, '2020-12-31 13:38:19', 1, 2),
(435, 42, '2020-12-31 13:38:29', 1, 2),
(436, 42, '2020-12-31 13:38:32', 1, 2),
(437, 42, '2020-12-31 13:38:34', 1, 2),
(438, 42, '2020-12-31 13:38:56', 1, 2),
(439, 42, '2020-12-31 13:38:57', 1, 2),
(440, 42, '2020-12-31 13:39:00', 1, 2),
(441, 42, '2020-12-31 13:40:07', 1, 2),
(442, 42, '2020-12-31 13:40:09', 1, 2),
(443, 42, '2020-12-31 13:40:12', 1, 2),
(444, 42, '2020-12-31 13:40:32', 1, 2),
(445, 42, '2020-12-31 13:41:36', 1, 2),
(446, 42, '2020-12-31 13:42:21', 1, 2),
(447, 42, '2020-12-31 13:42:45', 1, 2),
(448, 42, '2020-12-31 13:43:54', 1, 2),
(449, 42, '2020-12-31 13:44:22', 1, 2),
(450, 42, '2020-12-31 13:44:51', 1, 2),
(451, 42, '2020-12-31 13:45:20', 1, 2),
(452, 42, '2020-12-31 13:45:41', 1, 2),
(453, 42, '2020-12-31 13:46:12', 1, 2),
(454, 42, '2020-12-31 13:46:35', 1, 2),
(455, 42, '2020-12-31 13:46:42', 1, 2),
(456, 42, '2020-12-31 13:49:01', 1, 2),
(457, 42, '2020-12-31 13:49:05', 1, 2),
(458, 42, '2020-12-31 13:49:24', 1, 2),
(459, 42, '2020-12-31 13:49:45', 1, 2),
(460, 42, '2020-12-31 13:50:22', 1, 2),
(461, 42, '2020-12-31 13:50:43', 1, 2),
(462, 42, '2020-12-31 13:51:00', 3, 1),
(463, 42, '2020-12-31 13:51:00', 1, 2),
(464, 42, '2020-12-31 13:51:00', 1, 2),
(465, 42, '2020-12-31 13:51:06', 1, 2),
(466, 42, '2020-12-31 13:51:07', 1, 2),
(467, 42, '2020-12-31 13:51:13', 1, 2),
(468, 42, '2020-12-31 13:51:31', 1, 2),
(469, 42, '2020-12-31 13:51:31', 1, 2),
(470, 42, '2020-12-31 13:52:43', 1, 2),
(471, 42, '2020-12-31 13:52:53', 1, 2),
(472, 40, '2020-12-31 13:52:55', 1, 2),
(473, 40, '2020-12-31 13:53:03', 1, 2),
(474, 40, '2020-12-31 13:53:06', 1, 2),
(475, 40, '2020-12-31 13:53:14', 1, 2),
(476, 40, '2020-12-31 13:53:33', 3, 1),
(477, 40, '2020-12-31 13:53:33', 1, 2),
(478, 40, '2020-12-31 13:53:33', 1, 2),
(479, 40, '2020-12-31 13:53:41', 1, 2),
(480, 42, '2020-12-31 13:53:44', 1, 2),
(481, 42, '2020-12-31 13:53:53', 1, 2),
(482, 42, '2020-12-31 13:53:55', 4, 3),
(483, 42, '2020-12-31 13:53:55', 4, 4),
(484, 42, '2020-12-31 13:53:55', 5, 2),
(485, 42, '2020-12-31 13:53:55', 1, 2),
(486, 42, '2020-12-31 13:53:55', 1, 2),
(487, 42, '2020-12-31 13:54:02', 4, 3),
(488, 42, '2020-12-31 13:54:02', 4, 4),
(489, 42, '2020-12-31 13:54:02', 5, 2),
(490, 42, '2020-12-31 13:54:02', 1, 2),
(491, 42, '2020-12-31 13:54:02', 1, 2),
(492, 42, '2020-12-31 13:54:48', 1, 2),
(493, 42, '2020-12-31 13:55:04', 1, 2),
(494, 42, '2020-12-31 13:56:23', 1, 2),
(495, 42, '2020-12-31 13:56:28', 1, 2),
(496, 42, '2020-12-31 13:56:34', 1, 2),
(497, 42, '2020-12-31 13:56:34', 1, 2),
(498, 42, '2020-12-31 13:56:38', 4, 3),
(499, 42, '2020-12-31 13:56:38', 4, 4),
(500, 42, '2020-12-31 13:56:38', 5, 2),
(501, 42, '2020-12-31 13:56:38', 1, 2),
(502, 42, '2020-12-31 13:56:38', 1, 2),
(503, 42, '2020-12-31 13:56:45', 1, 2),
(504, 40, '2020-12-31 13:56:49', 1, 2),
(505, 40, '2020-12-31 13:56:54', 1, 2),
(506, 42, '2020-12-31 13:56:57', 1, 2),
(507, 42, '2020-12-31 13:57:05', 1, 2),
(508, 42, '2020-12-31 13:57:05', 1, 2),
(509, 42, '2020-12-31 13:57:07', 1, 2),
(510, 40, '2020-12-31 13:57:09', 1, 2),
(511, 40, '2020-12-31 13:58:50', 1, 2),
(512, 42, '2020-12-31 13:58:57', 1, 2),
(513, 42, '2020-12-31 13:59:14', 1, 2),
(514, 42, '2020-12-31 13:59:45', 4, 3),
(515, 42, '2020-12-31 13:59:45', 4, 4),
(516, 42, '2020-12-31 13:59:45', 5, 2),
(517, 42, '2020-12-31 13:59:45', 1, 2),
(518, 42, '2020-12-31 13:59:45', 1, 2),
(519, 42, '2020-12-31 14:00:22', 1, 2),
(520, 42, '2020-12-31 14:00:22', 1, 2),
(521, 42, '2020-12-31 14:00:33', 1, 2),
(522, 42, '2020-12-31 14:00:33', 1, 2),
(523, 42, '2020-12-31 14:01:02', 2, 3),
(524, 42, '2020-12-31 14:01:02', 1, 2),
(525, 42, '2020-12-31 14:01:16', 1, 2),
(526, 42, '2020-12-31 14:01:16', 1, 2),
(527, 42, '2020-12-31 14:02:41', 1, 2),
(528, 42, '2020-12-31 14:02:45', 4, 3),
(529, 42, '2020-12-31 14:02:45', 4, 4),
(530, 42, '2020-12-31 14:02:45', 5, 2),
(531, 42, '2020-12-31 14:02:45', 1, 2),
(532, 42, '2020-12-31 14:02:45', 1, 2),
(533, 42, '2020-12-31 14:02:57', 1, 2),
(534, 42, '2020-12-31 14:02:57', 1, 2),
(535, 42, '2020-12-31 14:04:12', 1, 2),
(536, 42, '2020-12-31 14:04:18', 1, 2),
(537, 42, '2020-12-31 14:04:18', 1, 2),
(538, 42, '2020-12-31 14:04:26', 1, 2),
(539, 42, '2021-01-13 07:30:45', 1, 2),
(540, 42, '2021-01-13 07:30:57', 1, 2),
(541, 42, '2021-01-13 07:31:17', 2, 3),
(542, 42, '2021-01-13 07:31:17', 1, 2),
(543, 42, '2021-01-13 07:31:54', 1, 2),
(544, 42, '2021-01-13 07:31:54', 1, 2);

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
(10, '::1', 0, 'unlock'),
(11, '127.0.0.1', 0, 'unlock');

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
(183, 42, '2020-12-09 09:23:22', 'successful', '::1'),
(184, 42, '2020-12-28 19:48:18', 'successful', '::1'),
(185, 42, '2020-12-28 20:59:02', 'successful', '127.0.0.1'),
(186, 42, '2020-12-29 14:26:04', 'successful', '::1'),
(187, 42, '2020-12-30 20:11:00', 'successful', '::1'),
(188, 42, '2020-12-30 21:26:35', 'successful', '::1'),
(189, 42, '2020-12-30 21:49:44', 'successful', '::1'),
(190, 42, '2020-12-31 14:05:10', 'successful', '::1'),
(191, 42, '2020-12-31 14:21:26', 'successful', '::1'),
(192, 40, '2020-12-31 14:52:55', 'successful', '::1'),
(193, 42, '2020-12-31 14:53:44', 'successful', '::1'),
(194, 40, '2020-12-31 14:56:49', 'successful', '::1'),
(195, 42, '2020-12-31 14:56:57', 'successful', '::1'),
(196, 40, '2020-12-31 14:57:09', 'successful', '::1'),
(197, 42, '2020-12-31 14:58:57', 'successful', '::1'),
(198, 42, '2021-01-13 08:30:45', 'successful', '::1');

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
  `login` varchar(30) COLLATE utf8_polish_ci NOT NULL,
  `deleted` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `password`
--

INSERT INTO `password` (`id`, `password`, `id_user`, `web_address`, `description`, `login`, `deleted`) VALUES
(122, 'arcUHN3Mh+vpg0x6KhHkK5HxxpoBJ9+f0o+nymn/zmM=', 42, 'admin.pl', 'admin page', 'adminLogin-updated', 0),
(123, 'NtHeGEOxRCrpIn3cbm0ETQ==', 42, 'page.com', 'page blablabla', 'page', 0),
(124, '5WXHPy544clP70UeDIAE1w==', 40, 'test.com', 'test desc', 'test', 0);

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
(26, 42, 40, 122);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `login` varchar(30) COLLATE utf8_polish_ci NOT NULL,
  `password_hash` varchar(512) COLLATE utf8_polish_ci NOT NULL,
  `salt` varchar(20) COLLATE utf8_polish_ci NOT NULL,
  `isPasswordKeptAsHash` tinyint(1) NOT NULL,
  `deleted` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `user`
--

INSERT INTO `user` (`id`, `login`, `password_hash`, `salt`, `isPasswordKeptAsHash`, `deleted`) VALUES
(40, 'Test', '795d08f0f8b31407e0e5f21a684aac039d5bf8589892f51bd8e1b75b5ac1157d2078fcbdb94d626b079eb066564a2573d6df24673aa6fe08e04fa0c67d765fdf', '21393807795f9ecce161', 1, 0),
(41, 'test2', 'c360d7cc0454b121bc4bd276b844090316ff7281aff1c4dc45265d643145d64180029647303513e0b44a4535f5d563e276f6ec104b77f7e0a3cf2edb1c0e901e', '8317323075f9ecd1edcc', 0, 0),
(42, 'admin', 'cfe8c250cbc8b99056b8f55c2eced7660fa7d82f3173f7f626a940d56847b643bcc6191ca516b0bc33a1421a65f5eb0654a38480437c7ed268eec9649b4edfb4', '11107377625fcfb870da', 1, 0);

--
-- Indeksy dla zrzutów tabel
--

--
-- Indeksy dla tabeli `action_type`
--
ALTER TABLE `action_type`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`);

--
-- Indeksy dla tabeli `data_change`
--
ALTER TABLE `data_change`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`);

--
-- Indeksy dla tabeli `function`
--
ALTER TABLE `function`
  ADD PRIMARY KEY (`id`);

--
-- Indeksy dla tabeli `function_run`
--
ALTER TABLE `function_run`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_user` (`id_user`),
  ADD KEY `id_function` (`id_function`),
  ADD KEY `id_action_type` (`id_action_type`);

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
-- AUTO_INCREMENT dla tabeli `action_type`
--
ALTER TABLE `action_type`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT dla tabeli `data_change`
--
ALTER TABLE `data_change`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=84;

--
-- AUTO_INCREMENT dla tabeli `function`
--
ALTER TABLE `function`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT dla tabeli `function_run`
--
ALTER TABLE `function_run`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=545;

--
-- AUTO_INCREMENT dla tabeli `ips`
--
ALTER TABLE `ips`
  MODIFY `id_ips` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT dla tabeli `logs`
--
ALTER TABLE `logs`
  MODIFY `id_log` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=199;

--
-- AUTO_INCREMENT dla tabeli `password`
--
ALTER TABLE `password`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=125;

--
-- AUTO_INCREMENT dla tabeli `sharing`
--
ALTER TABLE `sharing`
  MODIFY `id_sharing` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT dla tabeli `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
