-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Хост: Mysql_db
-- Время создания: Ноя 26 2022 г., 21:50
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
-- Структура таблицы `topic`
--

CREATE TABLE `topic` (
  `topicId` int(11) NOT NULL,
  `idUserCreator` int(11) NOT NULL COMMENT 'Создатель топика',
  `idUnit` int(11) NOT NULL COMMENT 'Материнский раздел',
  `createDate` date NOT NULL,
  `topicName` varchar(70) NOT NULL COMMENT 'Название',
  `type` int(11) NOT NULL,
  `viewAllTime` int(11) NOT NULL COMMENT 'Просмотры топика'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `unit`
--

CREATE TABLE `unit` (
  `unitId` int(11) NOT NULL,
  `unitUrl` varchar(40) NOT NULL COMMENT 'Название в адресной строке',
  `name` varchar(20) NOT NULL,
  `descr` text NOT NULL COMMENT 'Описание',
  `addDate` date NOT NULL COMMENT 'Дата создания',
  `icon` varchar(70) NOT NULL COMMENT 'Иконка'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `userId` int(11) NOT NULL,
  `login` varchar(20) NOT NULL COMMENT 'Имя используемое везде, исключительно уникальное',
  `status` int(11) NOT NULL COMMENT 'Статус доступа',
  `name` varchar(30) NOT NULL COMMENT 'Имя',
  `email` varchar(40) NOT NULL,
  `pass` varchar(70) NOT NULL COMMENT 'Пароль',
  `photo` int(11) NOT NULL DEFAULT 0 COMMENT 'Аватарка',
  `regdate` date NOT NULL COMMENT 'Дата регистрации',
  `userRating` int(11) NOT NULL DEFAULT 0 COMMENT 'Рейтинг пользователя'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`userId`, `login`, `status`, `name`, `email`, `pass`, `photo`, `regdate`, `userRating`) VALUES
(1, 'AndreyErr', 2, 'Андрей', 'a9165185808@gmail.com', '$2y$10$n2hIZg6B45U8FYzqzrcsKe.IlJMHvpGcuUXL83PsZ0eEc6CI9JHzS', -1, '2022-11-27', 0); -- pass: qwerty123#

-- --------------------------------------------------------

--
-- Структура таблицы `usersBanOnSite`
--

CREATE TABLE `usersBanOnSite` (
  `banUserId` int(11) NOT NULL,
  `loginUser` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `topic`
--
ALTER TABLE `topic`
  ADD PRIMARY KEY (`topicId`);

--
-- Индексы таблицы `unit`
--
ALTER TABLE `unit`
  ADD PRIMARY KEY (`unitId`),
  ADD UNIQUE KEY `topicName` (`unitUrl`),
  ADD UNIQUE KEY `topicName_2` (`unitUrl`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`userId`),
  ADD UNIQUE KEY `login` (`login`);

--
-- Индексы таблицы `usersBanOnSite`
--
ALTER TABLE `usersBanOnSite`
  ADD PRIMARY KEY (`banUserId`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `topic`
--
ALTER TABLE `topic`
  MODIFY `topicId` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `unit`
--
ALTER TABLE `unit`
  MODIFY `unitId` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `userId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT для таблицы `usersBanOnSite`
--
ALTER TABLE `usersBanOnSite`
  MODIFY `banUserId` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
