-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Хост: Mysql_db
-- Время создания: Ноя 25 2022 г., 17:56
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
-- Структура таблицы `banForTopicId25`
--

CREATE TABLE `banForTopicId25` (
  `id` int(11) NOT NULL,
  `IdUser` int(11) NOT NULL,
  `dateTime` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `banSite`
--

CREATE TABLE `banSite` (
  `id` int(11) NOT NULL,
  `loginUser` varchar(20) NOT NULL,
  `dateTime` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `banSite`
--

INSERT INTO `banSite` (`id`, `loginUser`, `dateTime`) VALUES
(10, 'adsf', '2022-11-21');

-- --------------------------------------------------------

--
-- Структура таблицы `filesForTopicId25`
--

CREATE TABLE `filesForTopicId25` (
  `id` int(11) NOT NULL,
  `idMessage` int(11) NOT NULL,
  `type` varchar(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `filesForTopicId25`
--

INSERT INTO `filesForTopicId25` (`id`, `idMessage`, `type`) VALUES
(1, 1, 'jpeg');

-- --------------------------------------------------------

--
-- Структура таблицы `maintopic`
--

CREATE TABLE `maintopic` (
  `id` int(11) NOT NULL,
  `topicName` varchar(40) NOT NULL,
  `name` varchar(20) NOT NULL,
  `descr` text NOT NULL,
  `addDate` date NOT NULL,
  `icon` varchar(70) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `maintopic`
--

INSERT INTO `maintopic` (`id`, `topicName`, `name`, `descr`, `addDate`, `icon`) VALUES
(16, 'ruka-boga', 'Рука бога', 'Рука бога', '2022-11-24', '<i class=\"fa-solid fa-eye\"></i>');

-- --------------------------------------------------------

--
-- Структура таблицы `messagesForTopicId25`
--

CREATE TABLE `messagesForTopicId25` (
  `id` int(11) NOT NULL,
  `idUser` int(11) NOT NULL,
  `idUserRef` int(11) NOT NULL,
  `message` text NOT NULL,
  `datatime` datetime NOT NULL,
  `rating` int(11) NOT NULL,
  `atribute` int(11) NOT NULL,
  `photo` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `messagesForTopicId25`
--

INSERT INTO `messagesForTopicId25` (`id`, `idUser`, `idUserRef`, `message`, `datatime`, `rating`, `atribute`, `photo`) VALUES
(1, 19, 0, '## zxcvbfcdcvb', '2022-11-25 15:03:32', 0, 0, 1),
(2, 19, 0, 'tdhg;oguryrkhg ieih gilrhe glirh gth tg rg;hoer ', '2022-11-25 16:58:43', 1, 0, 0);

-- --------------------------------------------------------

--
-- Структура таблицы `topic`
--

CREATE TABLE `topic` (
  `topic_id` int(11) NOT NULL,
  `idUserCreator` int(11) NOT NULL,
  `idMainTopic` int(11) NOT NULL,
  `createDate` date NOT NULL,
  `topic_name` varchar(70) NOT NULL,
  `type` int(11) NOT NULL,
  `viewAllTime` int(11) NOT NULL,
  `viewLastTime` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `topic`
--

INSERT INTO `topic` (`topic_id`, `idUserCreator`, `idMainTopic`, `createDate`, `topic_name`, `type`, `viewAllTime`, `viewLastTime`) VALUES
(25, 19, 16, '2022-11-25', 'Андрей тема 1', 2, 106, 106);

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `login` varchar(20) NOT NULL,
  `status` int(11) NOT NULL,
  `name` varchar(30) NOT NULL,
  `email` varchar(40) NOT NULL,
  `pass` varchar(70) NOT NULL,
  `photo` int(11) NOT NULL DEFAULT 0,
  `regdate` date NOT NULL,
  `descr` text NOT NULL,
  `user_rating` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`user_id`, `login`, `status`, `name`, `email`, `pass`, `photo`, `regdate`, `descr`, `user_rating`) VALUES
(5, 'adsf', 0, 'asdf', 'sdf@sdf.df', 'egsrhd4654', 1, '2020-08-01', '', 0),
(8, 'AndreyErr1', 0, 'asdf', 'sdf@sdf.df', 'egsrhd4654', 1, '2020-08-01', '', 0),
(9, 'AndreyErr2', 0, 'Андрей', 'a9165185808@gmail.com', '$2y$10$MMZ2GiTiJmV0HgBUrd7pY..qK2X.L9VK4tCqjXQFbtJFTs8iXZaba', 1, '2022-11-18', '', 0),
(11, 'AndreyErr3', 1, 'Андрей', 'a9165185808@gmail.com', '$2y$10$xgFPBYo0QWFN.Id6jzppVOVqj.bE0zuS.NdsiWzdM.JCJt4UKc74m', 1, '2022-11-18', '', 0),
(12, 'AndreyErr8', 0, 'Андрей', 'a9165185808@gmail.com', '$2y$10$FX26IX4YTaS/DsjAuhXisuv0juyI2z6K0CBidoA/ZGI18qy1JEDB2', 1, '2022-11-18', '', 0),
(14, 'AndreyErr10', 0, 'Андрей', 'a9165185808@gmail.com', '$2y$10$hl.nuUTCru32DUhzh05BiO16eec49P/Xx/ARIVR6LZwUVenQBMnXS', 1, '2022-11-20', '', 0),
(15, 'AndreyErr11', 1, 'аНдРей', 'a9165185808@gmail.com', '$2y$10$rnU2bwZteYin2lBlHUJsc.93Cmx1ABBeL7u3nOuJB.vy66uSY/9pK', 1, '2022-11-20', '', 0),
(16, 'AndreyErr12', 0, 'Андрей', 'a9165185808@gmail.com', '$2y$10$M4qinnYXe64qxUqKyV2EoecWZ3dhZsxDn3lVPUNiqF9ksyOHI1qdi', 1, '2022-11-20', '', 0),
(17, 'AndreyErr14', 0, 'Андрей', 'a9165185808@gmail.com', '$2y$10$dDCSSGnH/VpV7ehfJKzl4u3SNaJsa.A6Cg5SfEt4/u5I/uaP07ptC', 1, '2022-11-20', '', 0),
(19, 'AndreyErr', 2, 'Андрей', 'a9165185808@gmail.com', '$2y$10$S1GhPLcB3cptp3mOV7UhO.hOxiLpwOaK6n.VGC.qnk21X5V566dGu', 0, '2022-11-20', '', 0);

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `banForTopicId25`
--
ALTER TABLE `banForTopicId25`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `banSite`
--
ALTER TABLE `banSite`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `filesForTopicId25`
--
ALTER TABLE `filesForTopicId25`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `maintopic`
--
ALTER TABLE `maintopic`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `topicName` (`topicName`),
  ADD UNIQUE KEY `topicName_2` (`topicName`);

--
-- Индексы таблицы `messagesForTopicId25`
--
ALTER TABLE `messagesForTopicId25`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `topic`
--
ALTER TABLE `topic`
  ADD PRIMARY KEY (`topic_id`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `login` (`login`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `banForTopicId25`
--
ALTER TABLE `banForTopicId25`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `banSite`
--
ALTER TABLE `banSite`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT для таблицы `filesForTopicId25`
--
ALTER TABLE `filesForTopicId25`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT для таблицы `maintopic`
--
ALTER TABLE `maintopic`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT для таблицы `messagesForTopicId25`
--
ALTER TABLE `messagesForTopicId25`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT для таблицы `topic`
--
ALTER TABLE `topic`
  MODIFY `topic_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=56;

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
