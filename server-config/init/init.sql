-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Хост: Mysql_db
-- Время создания: Ноя 18 2022 г., 18:23
-- Версия сервера: 10.9.4-MariaDB-1:10.9.4+maria~ubu2204
-- Версия PHP: 8.0.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `forum`
--
CREATE DATABASE IF NOT EXISTS `forum` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `forum`;

-- --------------------------------------------------------

--
-- Структура таблицы `banForTopic`
--

CREATE TABLE `banForTopic` (
  `id` int(11) NOT NULL,
  `IdUser` int(11) NOT NULL,
  `reason` varchar(40) NOT NULL,
  `dateTime` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `maintopic`
--

CREATE TABLE `maintopic` (
  `id` int(11) NOT NULL,
  `topicName` varchar(30) NOT NULL,
  `name` varchar(30) NOT NULL,
  `descr` text NOT NULL,
  `addDate` date NOT NULL,
  `icon` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `maintopic`
--

INSERT INTO `maintopic` (`id`, `topicName`, `name`, `descr`, `addDate`, `icon`) VALUES
(1, 'android', 'Андроид', 'Всё о андроид мире', '2022-11-15', '<i class=\"fa-brands fa-android\"></i>'),
(2, 'android2', 'Андроид2', 'Всё о андроид мире uwu', '2022-11-15', '<i class=\"fa-brands fa-android\"></i>');

-- --------------------------------------------------------

--
-- Структура таблицы `messagesForTopic`
--

CREATE TABLE `messagesForTopic` (
  `id` int(11) NOT NULL,
  `idUser` int(11) NOT NULL,
  `idUserRef` int(11) NOT NULL,
  `message` text NOT NULL,
  `datatime` datetime NOT NULL,
  `rating` int(11) NOT NULL,
  `atribute` int(11) NOT NULL COMMENT 'Для пометки как важного или что-то типа того'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `photoForTopic`
--

CREATE TABLE `photoForTopic` (
  `id` int(11) NOT NULL,
  `idMessage` int(11) NOT NULL,
  `src` varchar(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `topic`
--

CREATE TABLE `topic` (
  `id` int(11) NOT NULL,
  `idUserCreator` int(11) NOT NULL,
  `idMainTopic` int(11) NOT NULL,
  `createDate` date NOT NULL,
  `name` varchar(40) NOT NULL,
  `descr` text NOT NULL,
  `viewAllTime` int(11) NOT NULL,
  `viewLastTime` int(11) NOT NULL,
  `photo` int(11) NOT NULL COMMENT 'Мб надо'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `login` varchar(20) NOT NULL,
  `status` int(11) NOT NULL,
  `name` varchar(30) NOT NULL,
  `email` varchar(40) NOT NULL,
  `pass` varchar(70) NOT NULL,
  `photo` int(11) NOT NULL DEFAULT 0,
  `regdate` date NOT NULL,
  `descr` text NOT NULL,
  `rating` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `login`, `status`, `name`, `email`, `pass`, `photo`, `regdate`, `descr`, `rating`) VALUES
(1, 'AndreyErr', 0, 'Андрей', 'a9165185808@gmail.com', '$2y$10$MMZ2GiTiJmV0HgBUrd7pY..qK2X.L9VK4tCqjXQFbtJFTs8iXZaba', 0, '2022-11-18', '', 0),
-- Пароль: qwerty123#

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `maintopic`
--
ALTER TABLE `maintopic`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `photoForTopic`
--
ALTER TABLE `photoForTopic`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `login` (`login`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `maintopic`
--
ALTER TABLE `maintopic`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT для таблицы `photoForTopic`
--
ALTER TABLE `photoForTopic`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
