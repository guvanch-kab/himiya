-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Фев 26 2025 г., 19:01
-- Версия сервера: 8.0.30
-- Версия PHP: 8.1.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `himiya_tdmi`
--

-- --------------------------------------------------------

--
-- Структура таблицы `exam_result`
--

CREATE TABLE `exam_result` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `student_name` varchar(100) NOT NULL,
  `exam_date` date NOT NULL,
  `result` varchar(10) NOT NULL,
  `correct_count` int NOT NULL,
  `incorrect_count` int NOT NULL,
  `caryek` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `exam_result`
--

INSERT INTO `exam_result` (`id`, `user_id`, `student_name`, `exam_date`, `result`, `correct_count`, `incorrect_count`, `caryek`) VALUES
(45, 19, 'gul', '2025-02-12', '0', 0, 1, '2.Caryek'),
(48, 13, 'guvanch', '2025-02-22', '25', 1, 3, '4.caryek'),
(49, 13, 'guvanch', '2025-02-22', '50', 1, 1, '2.Caryek');

-- --------------------------------------------------------

--
-- Структура таблицы `nazary_data`
--

CREATE TABLE `nazary_data` (
  `id` int NOT NULL,
  `Bolum_belgi` varchar(100) NOT NULL,
  `Bolum_ady` varchar(100) DEFAULT NULL,
  `Paragraf_no` varchar(10) NOT NULL,
  `Paragraf_ady` varchar(250) NOT NULL,
  `Tema` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci,
  `PDF_file_ady` text,
  `Surat` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `nazary_data`
--

INSERT INTO `nazary_data` (`id`, `Bolum_belgi`, `Bolum_ady`, `Paragraf_no`, `Paragraf_ady`, `Tema`, `PDF_file_ady`, `Surat`) VALUES
(53, '1.Bolum', 'MADDANYŇ GURLUŞYNYŇ ESASLARY', '1.1', 'Atomlar we molekulalar', NULL, '67a8417db3172-traffic monitoring system.pdf', ''),
(54, '1.Bolum', 'MADDANYŇ GURLUŞYNYŇ ESASLARY', '1.2', 'Otnositel atom we molekulýar massa', NULL, '2- Enpara Hesap Hareketleri.pdf', ''),
(55, '2.Bolum', 'MADDALARYŇ gregat ýagdaýy.', '3.1', 'Kristallar', NULL, '0147-jquery-notes-course-tutorial.pdf', '');

-- --------------------------------------------------------

--
-- Структура таблицы `nazary_data_bolumler`
--

CREATE TABLE `nazary_data_bolumler` (
  `id` int NOT NULL,
  `bolumler` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `nazary_data_bolumler`
--

INSERT INTO `nazary_data_bolumler` (`id`, `bolumler`) VALUES
(3, '1.Bolum'),
(4, '2.Bolum'),
(8, '3.Bolum'),
(9, '4.Bölüm');

-- --------------------------------------------------------

--
-- Структура таблицы `nazary_data_caryekler`
--

CREATE TABLE `nazary_data_caryekler` (
  `id` int NOT NULL,
  `caryekler` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `nazary_data_caryekler`
--

INSERT INTO `nazary_data_caryekler` (`id`, `caryekler`) VALUES
(8, '1.Caryek'),
(9, '2.Caryek'),
(10, '3.Caryek'),
(11, '4.caryek');

-- --------------------------------------------------------

--
-- Структура таблицы `questions`
--

CREATE TABLE `questions` (
  `id` int NOT NULL,
  `question_text` text NOT NULL,
  `options` json NOT NULL,
  `correct_answer` int NOT NULL,
  `caryek` varchar(100) NOT NULL,
  `type` enum('text','image') NOT NULL,
  `image_path` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `questions`
--

INSERT INTO `questions` (`id`, `question_text`, `options`, `correct_answer`, `caryek`, `type`, `image_path`) VALUES
(7, 'Suw formulasy?', '[\"H2SO4\", \"H20\", \"Na2SO4\"]', 2, '1.caryek', 'text', NULL),
(24, 'bu ada', '[\"2\", \"3\"]', 2, '2.Caryek', 'text', NULL),
(25, 'this is the island...', '[\"yes\", \"no\", \"may be\"]', 3, '4.caryek', 'text', NULL),
(26, 'IP adresleme isini yerine yetiryan confugration haysi', '[\"IP \", \"TCP/IP\", \"DHCP\"]', 3, '5.Caryek', 'text', NULL),
(27, 'Zynhary sahyryn yasan yerleri', '[\"Mary welayaty, Turkmenagala\", \"Lebap welayaty, Halac\", \"Eyran, Turkmensahra\"]', 2, '3.Caryek', 'text', NULL),
(28, 'Donmenem begler gosgusy kime degidli?', '[\"Zynhary sahyr\", \"Zelili sahyr\", \"Seydi sahry\"]', 3, '3.Caryek', 'text', NULL),
(29, 'Fizikada tizligin formulasy asakdakylardan haysi?', '[\"s=v/t\", \"t=v/t\", \"v=s/t\"]', 3, '3.Caryek', 'text', NULL),
(30, 'The correct formula for aluminum nitrate is', '[\"Al3N2\", \"Al3(NO3)\", \"Al(NO2)3\", \"Al(NO3)3\"]', 1, '4.caryek', 'text', NULL),
(31, 'Given the balanced equation: 2H2(g) + O2(g) --> 2H2O(l) How many grams of H2O are formed if 9.00 mol H2(g) reacts completely with an excess of O2(g)?  The molar mass of H2O is 18.0g/mol.', '[\"a) 18.0g\", \"b) 36.0g\", \"c) 81.0g\", \"d) 162g\"]', 2, '4.caryek', 'text', NULL),
(32, 'Which element has exactly five electrons in the highest principal energy level (the outer shell)?', '[\"Se\", \"Ba\", \"P\", \"Ge\"]', 3, '4.caryek', 'text', NULL),
(33, 'KTU haysi saherde', '[\"Ankara\", \"Trabzon\", \"Antalya\"]', 2, '2.Caryek', 'text', NULL);

-- --------------------------------------------------------

--
-- Структура таблицы `students`
--

CREATE TABLE `students` (
  `id` int NOT NULL,
  `username` varchar(200) NOT NULL,
  `phone_number` varchar(15) NOT NULL,
  `user_password` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `students`
--

INSERT INTO `students` (`id`, `username`, `phone_number`, `user_password`) VALUES
(12, 'Han', '63718035', '$2y$10$UE7xy55izISwtXpiR.ccG.5rL4OxG.TFB4EsDi3x4lVNeqLdMsw9C'),
(13, 'guvanch', '61864959', '$2y$10$n2dhnxcH8SdglpZSr0jHjOFYqyoqG2rmtCXnGZP4STEVl7.KA8Guq'),
(15, 'Kabulov', '65864959', '$2y$10$B7cQbsATpbKJYWJhCjcy6u2jBLaZzREH4Ji3yGppBjM7T34hq3Lxq'),
(16, 'Babamyrat', '65865881', '$2y$10$3WdZ8c7VZil.DmkXDQ3bzO1CCrV4mszxOIuaosHuQPuF7tl.Mi1Ai'),
(17, 'Hakan bey', '65202020', '$2y$10$KOPvT8ZYKDYURekErp5Xk.3LW48uAFNY7Oitft9Q9b6p/iv6zY5jm'),
(18, 'Bilgisayar', '65020202', '$2y$10$BPg5jUCX8rlPaYVyB4uZa.Ebjc290BpGwmuo.OKF5v6DRxFxe8d0a'),
(19, 'gul', '65981487', '$2y$10$MEKLglVfohqJuuARcGFmT.u9UJ.T4d5cszJNVt6jkKkfj3UyEnTNq');

-- --------------------------------------------------------

--
-- Структура таблицы `user_answers`
--

CREATE TABLE `user_answers` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `question_id` int NOT NULL,
  `selected_answer` int NOT NULL,
  `senesi` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `user_answers`
--

INSERT INTO `user_answers` (`id`, `user_id`, `question_id`, `selected_answer`, `senesi`) VALUES
(393, 13, 27, 2, '2025-01-26 15:11:06'),
(394, 13, 28, 3, '2025-01-26 15:11:11'),
(395, 17, 27, 2, '2025-01-26 21:55:23'),
(396, 17, 28, 2, '2025-01-26 21:55:45'),
(397, 13, 28, 3, '2025-02-01 10:06:26'),
(398, 13, 27, 2, '2025-02-01 10:06:30'),
(399, 13, 28, 3, '2025-02-01 10:50:56'),
(400, 13, 27, 2, '2025-02-01 10:51:00'),
(401, 13, 28, 1, '2025-02-03 16:57:55'),
(402, 13, 27, 3, '2025-02-03 16:57:57'),
(403, 18, 27, 2, '2025-02-07 09:22:54'),
(404, 18, 28, 2, '2025-02-07 09:22:57'),
(405, 15, 28, 3, '2025-02-07 09:39:14'),
(406, 15, 27, 2, '2025-02-07 09:39:20'),
(407, 15, 25, 2, '2025-02-07 09:49:40'),
(408, 15, 27, 2, '2025-02-07 09:50:54'),
(409, 15, 28, 3, '2025-02-07 09:50:58'),
(410, 18, 24, 1, '2025-02-07 09:51:54'),
(411, 15, 32, 3, '2025-02-08 09:29:18'),
(412, 15, 31, 2, '2025-02-08 09:29:24'),
(413, 15, 30, 4, '2025-02-08 09:29:29'),
(414, 15, 25, 3, '2025-02-08 09:29:36'),
(415, 15, 28, 3, '2025-02-10 21:13:27'),
(416, 15, 27, 1, '2025-02-10 21:13:47'),
(417, 15, 29, 3, '2025-02-10 21:14:41'),
(418, 15, 29, 3, '2025-02-12 09:37:54'),
(419, 15, 28, 3, '2025-02-12 09:37:57'),
(420, 15, 27, 2, '2025-02-12 09:37:59'),
(421, 13, 25, 1, '2025-02-12 09:39:22'),
(422, 13, 31, 3, '2025-02-12 09:39:26'),
(423, 13, 30, 2, '2025-02-12 09:39:30'),
(424, 13, 32, 3, '2025-02-12 09:39:35'),
(425, 19, 32, 3, '2025-02-12 09:45:55'),
(426, 19, 31, 4, '2025-02-12 09:45:58'),
(427, 19, 25, 1, '2025-02-12 09:46:00'),
(428, 19, 30, 2, '2025-02-12 09:46:03'),
(429, 19, 31, 1, '2025-02-12 09:46:50'),
(430, 19, 25, 3, '2025-02-12 09:46:54'),
(431, 19, 30, 3, '2025-02-12 09:46:56'),
(432, 19, 32, 3, '2025-02-12 09:46:58'),
(433, 19, 25, 3, '2025-02-12 09:47:52'),
(434, 19, 30, 3, '2025-02-12 09:47:55'),
(435, 19, 31, 2, '2025-02-12 09:47:59'),
(436, 19, 32, 3, '2025-02-12 09:48:00'),
(437, 19, 27, 2, '2025-02-12 09:48:27'),
(438, 19, 28, 3, '2025-02-12 09:48:28'),
(439, 19, 29, 2, '2025-02-12 09:48:30'),
(440, 15, 25, 3, '2025-02-12 09:48:54'),
(441, 15, 30, 4, '2025-02-12 09:48:57'),
(442, 15, 32, 3, '2025-02-12 09:48:58'),
(443, 15, 31, 2, '2025-02-12 09:49:01'),
(444, 19, 28, 1, '2025-02-12 10:00:55'),
(445, 19, 29, 1, '2025-02-12 10:00:57'),
(446, 19, 27, 1, '2025-02-12 10:00:59'),
(447, 19, 24, 1, '2025-02-12 10:01:35'),
(448, 15, 28, 2, '2025-02-12 10:02:06'),
(449, 15, 27, 2, '2025-02-12 10:02:08'),
(450, 15, 29, 2, '2025-02-12 10:02:10'),
(451, 15, 30, 3, '2025-02-20 20:50:34'),
(452, 15, 32, 3, '2025-02-20 20:51:00'),
(453, 15, 31, 2, '2025-02-20 20:51:02'),
(454, 15, 25, 3, '2025-02-20 20:51:07'),
(455, 13, 32, 2, '2025-02-22 08:59:21'),
(456, 13, 25, 3, '2025-02-22 08:59:23'),
(457, 13, 30, 2, '2025-02-22 08:59:25'),
(458, 13, 31, 3, '2025-02-22 08:59:26'),
(459, 13, 33, 2, '2025-02-22 09:18:18'),
(460, 13, 24, 1, '2025-02-22 09:18:23');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `exam_result`
--
ALTER TABLE `exam_result`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `nazary_data`
--
ALTER TABLE `nazary_data`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `nazary_data_bolumler`
--
ALTER TABLE `nazary_data_bolumler`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `nazary_data_caryekler`
--
ALTER TABLE `nazary_data_caryekler`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `questions`
--
ALTER TABLE `questions`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `user_answers`
--
ALTER TABLE `user_answers`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `exam_result`
--
ALTER TABLE `exam_result`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- AUTO_INCREMENT для таблицы `nazary_data`
--
ALTER TABLE `nazary_data`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=56;

--
-- AUTO_INCREMENT для таблицы `nazary_data_bolumler`
--
ALTER TABLE `nazary_data_bolumler`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT для таблицы `nazary_data_caryekler`
--
ALTER TABLE `nazary_data_caryekler`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT для таблицы `questions`
--
ALTER TABLE `questions`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT для таблицы `students`
--
ALTER TABLE `students`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT для таблицы `user_answers`
--
ALTER TABLE `user_answers`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=461;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
