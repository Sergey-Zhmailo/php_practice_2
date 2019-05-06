-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Май 07 2019 г., 00:48
-- Версия сервера: 5.6.41-log
-- Версия PHP: 7.0.32

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `lesson_12`
--

-- --------------------------------------------------------

--
-- Структура таблицы `posts`
--

CREATE TABLE `posts` (
  `post_id` int(11) NOT NULL,
  `author_id` int(11) NOT NULL,
  `post_title` varchar(250) NOT NULL,
  `post_text` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `posts`
--

INSERT INTO `posts` (`post_id`, `author_id`, `post_title`, `post_text`) VALUES
(1, 28, 'Post1', 'text text text'),
(2, 28, 'Как редактировать записи', 'Ффыв фывфыв фывфывфыв фывфыв. РОывдвлыв лврдыраыд'),
(4, 28, 'Post1-3', 'text text text 3'),
(6, 28, 'Post6', 'aasd adasd ada adasdasd adasdasd'),
(7, 27, 'Post-1 user 16', 'asd asda asdg dg dg sdf dgf sdg');

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `user_name` varchar(250) NOT NULL,
  `user_email` varchar(250) NOT NULL,
  `user_password` varchar(250) NOT NULL,
  `user_gender` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`user_id`, `user_name`, `user_email`, `user_password`, `user_gender`) VALUES
(1, 'user1', 'user1', 'user1', ''),
(2, 'user1', 'user1', 'user1', ''),
(3, 'user1', 'user1', 'user1', ''),
(4, 'user1', 'user1', 'user1', ''),
(5, 'user1', 'user1', 'user1', ''),
(6, 'user1', 'user1', 'user1', ''),
(7, 'user1', 'user1', 'user1', ''),
(8, 'user2', 'user2', 'user2', ''),
(9, 'user2', 'user2', 'user2', ''),
(10, 'user3', 'user3', 'user3', ''),
(11, 'user3', 'user3', 'user3', ''),
(12, 'user4', 'user4', 'user4', ''),
(13, 'user4', 'user4', 'user4', ''),
(14, 'user5', 'user5', 'user5', ''),
(15, 'user5', 'user5', 'user5', ''),
(16, 'user6', 'user6', 'user6', ''),
(17, 'user7', 'user7', 'user7', ''),
(18, 'user7', 'user7', 'user7', ''),
(19, 'user8', 'user8@mail.com', 'user8', ''),
(20, 'user9', '9@mail.com', 'user9', ''),
(21, 'user10', '10@mail.com', '123456q', ''),
(22, 'user11', '11@mail.com', '123456q', '1'),
(23, 'user12', '12@mail.com', '123456q', '2'),
(24, 'user13', '13@mail.com', '123456q', '2'),
(25, 'user14', '14@mail.com', '123456q', '2'),
(26, 'user15', '15@mail.com', '123456', '2'),
(27, 'user16_new3', '16@mail.com', '$2y$10$uw.TSBuJp6T7kAmT0ONDE.XwdSZlSW9GDrFHMt0rTIUjBS4yjtyPK', '1'),
(28, 'User17', '124@mail.com', '$2y$10$6c3/Kz8BEgp6A.96AuqlsO7GjELheUVAaFJXSYQkRdEfdrdEtsa2.', '2');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`post_id`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `posts`
--
ALTER TABLE `posts`
  MODIFY `post_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
